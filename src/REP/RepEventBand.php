<?php
require_once __DIR__ . '/../DbConn.php';
require_once __DIR__ . '/../OM/EventBand.php';

Class RepEventBand{
  // Public Methods {{{
  public static function getList()
  {
    $conn=getConn();      
    if (!($res = $conn->query("CALL EventBandGetList()"))) {
      throw new Exception("CALL failed: (" . $conn->errno . ") " . $conn->error);
    }
    $ret=array();
    while($EventBandRow = $res->fetch_assoc())
    {
      $ret[]=self::EventBandFromRow($EventBandRow);
    }
    return $ret;
  }

  public static function getByEventId($id)
  {
    $conn=getConn();
    $sel=$conn->prepare("CALL EventBandGetByEventId(?)");
    $sel->bind_param('i',$id);
    $sel->execute();
    $res=$sel->get_result();
    $ret = array();
    while($EventBandRow = $res->fetch_assoc())
    {
      $ret[]=self::EventBandFromRow($EventBandRow);
    }
    return $ret;
  }

  public static function getByBandId($id)
  {
    $conn=getConn();
    $sel=$conn->prepare("CALL EventBandGetByBandId(?)");
    $sel->bind_param('i',$id);
    $sel->execute();
    $res=$sel->get_result();
    $ret = array();
    while($EventBandRow = $res->fetch_assoc())
    {
      $ret[]=self::EventBandFromRow($EventBandRow);
    }
  }

  public static function add($EventBand)
  {
    $conn=getConn();      
    $ins=$conn->prepare("CALL EventBandAdd(?,?)");
    $ins->bind_param('ii', 
      $EventBand->eventId,
      $EventBand->bandId
    );
    $ins->execute();
  }

  public static function mod()
  {
    throw new Exception("Not implemented.");
  }
  // }}}

  // Private Methods {{{
  private static function EventBandFromRow($row)
  {
    $ret = new EventBand();
    $ret->eventId=$row["event_id"];
    $ret->bandId=$row["band_id"];
    return $ret;
  }
  // }}}
}
?>
