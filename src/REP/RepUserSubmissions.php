<?php
require_once __DIR__ . '/../DbConn.php';

Class RepUserSubmissions{
  // {{{ REGION: Public Methods
  public static function getList($status=-1,$type=-1)
  {
    $conn=getConn();      
    if (!($res = $conn->query("CALL UserSubmissionsGetList()"))) {
      throw new Exception("CALL failed: (" . $conn->errno . ") " . $conn->error);
    }
    $ret=array();
    while($row = $res->fetch_assoc())
    {
      if (($status == -1 || ($row["status_id"] == $status)) &&
        ($type == -1 || ($row["type_id"] == $type))){
        $ret[]=$row;
      }
    }
    return $ret;
  }

  public static function add($link,$type)
  {
    $conn=getConn();      
    $ins=$conn->prepare("CALL UserSubmissionsAdd(?,?,0,@newId)");
    $ins->bind_param('si', 
      $link,
      $type
    );
    $ins->execute();

    $sel=$conn->query('SELECT @newId');
    $newId=$sel->fetch_assoc();
    return $newId["@newId"];
  }

  public static function approve($id) {
    self::setStatus($id,1);
  }

  public static function reject($id) {
    self::setStatus($id,2);
  }

  public static function exists($query,$type=-1) {
    $res = self::getByLink($query,$type);
    return $res != NULL;
  }
  // }}}

  // {{{ REGION: Private Methods
  private static function setStatus($id,$status)
  {
    $conn=getConn();      
    $ins=$conn->prepare("CALL UserSubmissionsSetStatus(?,?)");
    $ins->bind_param('ii', 
      $id,
      $status
    );
    $ins->execute();
  }

  private static function getByLink($link,$type=-1)
  {
    $conn=getConn();
    $sel=$conn->prepare("CALL UserSubmissionsGetByLink(?)");
    $sel->bind_param('s',$link);
    $sel->execute();
    $res=$sel->get_result();
    if ($res->num_rows>0)
    {
      $ret=array();
      while($row = $res->fetch_assoc())
      {
        if ($type==-1 || ($row["type_id"] == $type)){
          $ret[]=$row;
        }
      }
      return $ret;
    }
    return NULL;
  }
  //}}}
}
?>
