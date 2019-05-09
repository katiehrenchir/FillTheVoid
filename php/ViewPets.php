<?php 

ini_set('display_startup_errors', true);
error_reporting(E_ALL);
ini_set('display_errors', true);

echo "<link rel='stylesheet' type='text/css' href='../css/style.css' />"; 

$mysqli = new mysqli("mysql.eecs.ku.edu", "hkathleen", "Phah7bie", "hkathleen");

/* check connection */
if ($mysqli->connect_errno) {
    printf("Connect failed: %s\n", $mysqli->connect_error);
    exit();
}

echo "<h1>connected successfully</h1>";

$search = $_GET['search'];
$search = $mysqli -> real_escape_string($search);

$query1 = "SELECT NAME FROM PET WHERE NAME LIKE '%".$search."%'";
$result= $mysqli -> query($query1);

while($row = $result -> fetch_object()){
    echo .$row -> NAME."</br>"
}

$query = "SELECT NAME FROM PET";

if ($result = $mysqli->query($query)) {

    /* fetch associative array */
    while ($row = $result->fetch_assoc()) {
        printf ("%s \n", $row["NAME"]);
    }

    /* free result set */
    $result->free();
}

/* close connection */
$mysqli->close();

?>  