<?php
require_once __DIR__ . '/../DbConn.php';
require_once __DIR__ . '/../OM/Event.php';
require_once __DIR__ . '/RepVenue.php';
require_once __DIR__ . '/RepBand.php';

Class RepEvent{
  // Public Methods {{{
  public static function GetList()
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
    $inDtDt = date_create($inDt);
    $sel->bind_param('s',date_format($inDtDt,"Y-m-d H:i:s"));
    $sel->execute();
    $res=$sel->get_result();
    if ($res->num_rows>0)
    {
      $ret=array();
      while($eventRow = $res->fetch_assoc())
      {
        $ret[]=self::eventFromRow($eventRow);
      }
      return $ret;
    }
    return NULL;
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

    $conn=getConn();      
    $ins=$conn->prepare("CALL EventAdd(?,?,?,?,?,?,?,?,?,?,?,@newId)");
    $ins->bind_param('dsssissssid',
      $event->fbId,
      $event->title,
      date_format($event->startTime,"Y-m-d H:i:s"),
      date_format($event->endTime,"Y-m-d H:i:s"),
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
    return $newId["@newId"];
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
    $ret->description=$row["description"];
    $ret->htmlDescription=$row["html_description"];
    $ret->statusId=$row["statusId"];
    $ret->cost=$row["cost"];
    $ret->venue=RepVenue::getById($row["venue_id"]);
    // add bands
    return $ret;
  }
  // }}}
}
?>
