<?php
require_once __DIR__ . '/../DbConn.php';
require_once __DIR__ . '/../OM/Event.php';
require_once __DIR__ . '/RepVenue.php';
require_once __DIR__ . '/RepBand.php';
require_once __DIR__ . '/RepEventBand.php';

Class RepEvent{
  // Public Methods {{{
  public static function getList()
  {
    $conn=getConn();      
    if (!($res = $conn->query("CALL EventGetList()"))) {
      throw new Exception("CALL failed: (" . $conn->errno . ") " . $conn->error);
    }
    $ret=array();
    while($eventRow = $res->fetch_assoc())
    {
      $ret[]=self::eventFromRow($eventRow);
    }
    return $ret;
  }

  public static function getByDate($inDt)
  {
    // Check if this works
    $conn=getConn();
    $sel=$conn->prepare("CALL EventGetByDate(?)");
    $inDtDt = date_format(date_create($inDt),"Y-m-d");
    $sel->bind_param('s',$inDtDt);
    $sel->execute();
    $res=$sel->get_result();
    if ($res->num_rows>0)
    {
      $ret=array();
      while($eventRow = $res->fetch_assoc())
      {
        $iEvent = self::eventFromRow($eventRow);
        if($iEvent->statusId == 2)
          $ret[]=$iEvent;
      }
      return $ret;
    }
    return NULL;
  }

  public static function getById($id)
  {
    $eL = self::getList();
    foreach($eL as $e){
      if ($e->id == $id){
        return $e;
      }
    }
  }

  public static function getByFbId($fbId)
  {
    $conn=getConn();
    $sel=$conn->prepare("CALL EventGetByFbId(?)");
    $sel->bind_param('i',$fbId);
    $sel->execute();
    $res=$sel->get_result();
    if ($res->num_rows>0)
    {
      $loc=$res->fetch_assoc();
      return self::eventFromRow($loc); 
    }
    return NULL;
  }

  public static function getByName($name)
  {
    $conn=getConn();
    $sel=$conn->prepare("CALL EventGetByName(?)");
    $sel->bind_param('s',$name);
    $sel->execute();
    $res=$sel->get_result();
    if ($res->num_rows>0)
    {
      $loc=$res->fetch_assoc();
      return self::eventFromRow($loc); 
    }
    return NULL;
  }

  public static function add($event)
  {
    // Check if I already have the venue. If not, insert.
    if ($event->venue->fbId != NULL)
    {
      $v = RepVenue::getByFbId($event->venue->fbId);
    }
    if ($v == NULL && $event->venue->name != NULL)
    {
      $v = RepVenue::getByName($event->venue->name);
    }
    if ($v == NULL)
    {
      $vId=RepVenue::add($event->venue);
    }
    else
    {
      $vId=$v->id;
    }
    // Check if I already have each band. If not, insert. Save band ids in array;
    $band_ids_arr=array();
    if ($event->bands != NULL && count($event->bands)>0)
    {
      foreach($event->bands as $iBand)
      {
        $band_id=-1;
        if($iBand->fbId != NULL)
        {
          $tB = RepBand::getByFbId($iBand->fbId);
          if ($tB!=NULL)
          {
            $band_id=$tB->id;
          }
        }
        if($band_id == -1 && $iBand->name != NULL)
        {
          $tB=RepBand::getByName($iBand->name);
          if ($tB!=NULL)
          {
            $band_id=$tB->id;
          }
        }
        if($band_id==-1)
        {
          $band_id=RepBand::add($iBand);  
        }
        $band_ids_arr[]=$band_id;
      }
    }
    $conn=getConn();      
    $ins=$conn->prepare("CALL EventAdd(?,?,?,?,?,?,?,?,?,?,?,@newId)");
    $dateStartString=date_format($event->startTime,"Y-m-d H:i:s");
    $dateEndString= date_format($event->endTime,"Y-m-d H:i:s");
    $ins->bind_param('isssissssid',
      $event->fbId,
      $event->title,
      $dateStartString,
      $dateEndString,
      $vId,
      $event->link,
      $event->picture,
      $event->description,
      $event->html_description,
      $event->statusId,
      $event->cost
    );
    $ins->execute();

    $sel=$conn->query('SELECT @newId');
    $newId=$sel->fetch_assoc();
    $newId=(int)$newId["@newId"];
    // Insert EventBand now that I know the Event Id
    var_dump($newId);
    foreach($band_ids_arr as $band_id)
    {
      $iEb = new EventBand();
      $iEb->eventId=$newId; 
      $iEb->bandId=$band_id; 
      RepEventBand::add($iEb);
    }
    return $newId;
  }

  public static function mod()
  {
    throw new Exception("Not implemented.");
  }
  // }}}

  // Private Methods {{{
  private static function eventFromRow($row)
  {
    $ret = new Event();
    $ret->id=$row["id"];
    $ret->fbId=$row["fb_id"];
    $ret->title=$row["title"];
    $ret->startTime=$row["start_time"];
    $ret->endTime=$row["end_time"];
    $ret->link=$row["link"];
    $ret->picture=$row["picture"];
    $ret->description = self::processDesc($row["description"]);
    $ret->htmlDescription=$row["html_description"];
    $ret->statusId=$row["status_id"];
    $ret->cost=$row["cost"];
    $ret->venue=RepVenue::getById($row["venue_id"]);
    // Add bands
    $band_arr=array();
    $eventBands = RepEventBand::getByEventId($ret->id);
    foreach($eventBands as $iEb)
    {
      $band_arr[]=RepBand::getById($iEb->bandId);
    }
    $ret->bands=$band_arr;
    return $ret;
  }

 private static function processDesc($d): string {
    if(strpos($d,'<br')==false){
      // rimuovo tripli a capo
      $ret = preg_replace("((\r[\W]*|\n[\W]*|\r\n[\W]*|\n\r[\W]*){3,})","\n\n",$d);
      // converto \n to <br>
      $ret = nl2br($ret);
      // converto url in anchor
      $ret = preg_replace_callback("(\b[\S]{2,}[.](?![\d])[\w]{2,3}[^<\b\s]+\b)",
        function($matches){
          $m = $matches[0];
          if(!preg_match("(\bhttp[s]?:)",$m)){
            $u = "http://" . $m;
          }
          else{
            $u = $m;
          }
          $ret = sprintf("<a href='%s' target='_blank'>%s</a>",$u,$m);
          return $ret; },
            $ret);
    }
    else{
      $ret = $d;
    }
    return $ret;
  }

  // }}}
}
?>
