<?php
function GetConn()
{
  if (!function_exists('mysqli_init') || !extension_loaded('mysqli')) {
    throw new Exception('Msqli not loaded.');
  }

  $conn = new mysqli("localhost","mcs_web","LANOCHESUONA","mcs_test");
  if ($conn->connect_errno) {
    throw new Exception("Failed to connect to MySQL: (" . $conn->connect_errno . ") " . $conn->connect_error);
  }
  $conn->query("SET NAMES utf8");
  $conn->query("SET CHARACTER SET utf8");
  return $conn;
}
?>
