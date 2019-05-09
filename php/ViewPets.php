<?php

include 'connect.php';

echo "<link rel='stylesheet' type='text/css' href='../css/style.css' />"; 

$mysqli = OpenCon();
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


closeCon($mysqli)


?>  