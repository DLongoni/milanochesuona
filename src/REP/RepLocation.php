<?php
require_once __DIR__ . '/../DbConn.php';
require_once __DIR__ . '/../OM/Location.php';

Class RepLocation{
  public static function getList()
  {
    $conn=getConn();      
    if (!($res = $conn->query("CALL VenueGetList()"))) {
      throw new Exception("CALL failed: (" . $conn->errno . ") " . $conn->error);
    }
    $LocList=$res->fetch_assoc();
    var_dump($LocList["id"]);
    foreach($LocList as $LocRow)
    {
      var_dump(gettype($LocRow));
      var_dump($ConcRow[1]);
    }
  }

  public static function add($location)
  {
    $conn=getConn();      
    $ins=$conn->prepare($conn,"CALL LocationAdd(?,?,?,?,?,?,@newId)");
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
    return $newId["@newid"];
  }
}
?>
