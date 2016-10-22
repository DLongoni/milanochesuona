<?php
require_once __DIR__ . '/../DbConn.php';
require_once __DIR__ . '/../OM/Concert.php';

Class RepConcert{
  public static function GetList()
  {
    $conn=GetConn();      
    if (!($res = $conn->query("CALL BandGetList()"))) {
      throw new Exception("CALL failed: (" . $conn->errno . ") " . $conn->error);
    }
    $ConcList=$res->fetch_assoc();
    var_dump($ConcList["id"]);
    foreach($ConcList as $ConcRow)
    {
      var_dump(gettype($ConcRow));
      var_dump($ConcRow[1]);
    }
  }
}
?>
