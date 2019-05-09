<?php

echo "<link rel='stylesheet' type='text/css' href='../css/style.css' />"; 

include("credentials.php");
$password = PASSWORD

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