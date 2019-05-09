<?php

ini_set('display_startup_errors', true);
error_reporting(E_ALL);
ini_set('display_errors', true);

$mysqli = new mysqli("mysql.eecs.ku.edu", "hkathleen", "Phah7bie", "hkathleen");

$pet_id = $_GET['id'];


$query = "SELECT * FROM PET WHERE PID=".$pet_id;

if ($result = $mysqli->query($query)) {

    /* fetch object array */
    while ($obj = $result->fetch_object()) {
        echo "<h1>".$obj->NAME."</h1>";

        echo "<img src=../img/".$obj->PHOTOFILENAME."></br>";
        echo $obj->NAME."</br>";
        echo $obj->TYPE."</br>";
        echo $obj->SEX."</br>";
        echo $obj->COLOR."</br>";
        echo $obj->BIRTHDATE."</br>";
        echo $obj->BREED."</br>";
        echo $obj->WEIGHT."</br>";
        echo $obj->DESCRIPTION."</br>";
        echo $obj->FIXED."</br>";
        echo $obj->VACCINATED."</br>";
        echo $obj->ADOPTIONFEE."</br>";
        echo $obj->GOODWITH."</br>";

    }

    /* free result set */
    $result->close();
}

/* close connection */
$mysqli->close();

echo " <br>";
echo "<a href=\"../index.html\" class=\"button\">Return to Search Page</a>";


?>