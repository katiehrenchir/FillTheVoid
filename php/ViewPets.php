<?php

ini_set('display_startup_errors', true);
error_reporting(E_ALL);
ini_set('display_errors', true);

echo "<link rel='stylesheet' type='text/css' href='../css/style.css' />"; 

require_once 'credentials.php';
$mysqli = new mysqli("mysql.eecs.ku.edu", "hkathleen", $password, "hkathleen");

/* check connection */
if ($mysqli->connect_errno) {
    printf("Connect failed: %s\n", $mysqli->connect_error);
    exit();
}

echo "<h1>connected successfully</h1>";

$query = "SELECT NAME FROM PET";

if ($result = $mysqli->query($query)) {

    /* fetch associative array */
    while ($row = $result->fetch_assoc()) {
        printf ("%s (%s)\n", $row["Name"]);
    }

    /* free result set */
    $result->free();
}

/* close connection */
$mysqli->close();

?>  