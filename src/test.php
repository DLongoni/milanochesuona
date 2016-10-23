<?php

require_once __DIR__ . '/OM/Location.php';
require_once __DIR__ . '/REP/RepVenue.php';
require_once __DIR__ . '/DbConn.php';

$conn = GetConn();
if (!($res = $conn->query("CALL VenueGetList()"))) {
    echo "CALL failed: (" . $conn->errno . ") " . $conn->error;
}
$rep=new RepVenue();
$l=$rep->getById(1);
var_dump($l);
?>
