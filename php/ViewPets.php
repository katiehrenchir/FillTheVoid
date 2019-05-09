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

$query = "SELECT NAME FROM PET WHERE NAME LIKE '%".$search."%'";
$result= $mysqli -> query($query);

while($row = $result -> fetch_object()){
    echo .$row -> NAME."</br>";
}

/* close connection */
$mysqli->close();

?>  