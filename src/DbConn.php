<?php
function GetConn()
{
    if (!function_exists('mysqli_init') || !extension_loaded('mysqli')) {
        throw new Exception('Msqli not loaded.');
    }

    $conn_config = parse_ini_file(__DIR__ . '/../../mcs_config.ini', true);
    $conn_config = $conn_config["DbConn"];

    $conn = new mysqli(
        $conn_config["host"],
        $conn_config["user"],
        $conn_config["password"],
        $conn_config["db"]
    );
    if ($conn->connect_errno) {
        throw new Exception(
            "Failed to connect to MySQL: (" . 
            $conn->connect_errno . ") " . $conn->connect_error
        );
    }
    $conn->query("SET NAMES utf8");
    $conn->query("SET CHARACTER SET utf8");
    return $conn;
}
?>
