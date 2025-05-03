<?php
$serverName = "BELEH\\SQLEXPRESS";

$connectionOptions = array(
    "Database" => "procuratio",
    "CharacterSet" => "UTF-8"
);

$conn = sqlsrv_connect($serverName, $connectionOptions);

if ($conn === false) {
    die(print_r(sqlsrv_errors(), true));
}
?>
