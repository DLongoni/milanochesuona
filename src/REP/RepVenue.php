<?php
require_once __DIR__ . '/../DbConn.php';
require_once __DIR__ . '/../OM/Venue.php';

Class RepVenue{
  public static function GetList()
  {
    $conn=GetConn();      
    if (!($res = $conn->query("CALL VenueGetList()"))) {
      throw new Exception("CALL failed: (" . $conn->errno . ") " . $conn->error);
    }
    $VenueList=$res->fetch_assoc();
    var_dump($VenueList["id"]);
    foreach($VenueList as $VenueRow)
    {
      var_dump(gettype($VenueRow));
      var_dump($ConcRow[1]);
    }
  }

  public static function Add()
  {
  }
}
?>
