<?php

require_once __DIR__ . '/OM/Location.php';
require_once __DIR__ . '/REP/RepLocation.php';
require_once __DIR__ . '/DbConn.php';

$conn = GetConn();
if (!($res = $conn->query("CALL BandGetList()"))) {
    echo "CALL failed: (" . $conn->errno . ") " . $conn->error;
}
var_dump($res->fetch_assoc());

$loc = new Location();

$rep=new RepLocation();
?>
