<?php
require_once __DIR__ . '/../DbConn.php';
require_once __DIR__ . '/../OM/Location.php';

Class RepLocation{
  public static function getList()
  {
    $conn=getConn();      
    if (!($res = $conn->query("CALL LocationGetList()"))) {
      throw new Exception("CALL failed: (" . $conn->errno . ") " . $conn->error);
    }
    $ret=array();
    while($locRow = $res->fetch_assoc())
    {
      $ret[]=self::locFromRow($locRow);
    }
    return $ret;
  }

  public static function add($location)
  {
    $conn=getConn();      
    $ins=$conn->prepare("CALL LocationAdd(?,?,?,?,?,?,@newId)");
    $ins->bind_param('ssddss', 
      $location->city,
      $location->country,
      $location->latitude,
      $location->longitude,
      $location->street,
      $location->zip
    );
    $ins->execute();

    $sel=$conn->query('SELECT @newId');
    $newId=$sel->fetch_assoc();
    return $newId["@newId"];
  }

  public static function getById($id)
  {
    $conn=getConn();
    $sel=$conn->prepare("CALL LocationGetById(?)");
    $sel->bind_param('i',$id);
    $sel->execute();
    $res=$sel->get_result();
    if ($res->num_rows>0)
    {
      $loc=$res->fetch_assoc();
      return self::locFromRow($loc); 
    }
    return NULL;
  }

  private static function locFromRow($row)
  {
    $loc = new Location();
    $loc->id=$row["id"];
    $loc->city=$row["city"];
    $loc->country=$row["country"];
    $loc->latitude=$row["latitude"];
    $loc->longitude=$row["longitude"];
    $loc->street=$row["street"];
    $loc->zip=$row["zip"];
    return $loc;
  }
}
?>
