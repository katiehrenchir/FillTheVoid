<!DOCTYPE  HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"  "http://www.w3.org/TR/html4/loose.dtd">
<html>
  <head>
    <meta  http-equiv="Content-Type" content="text/html;  charset=iso-8859-1">
    <title>Search  Pets</title>
    <link rel="stylesheet" type="text/css" href="../css/styles.css"/>

  </head>
  <p><body>
      <div class="main">

<?php

ini_set('display_startup_errors', true);
error_reporting(E_ALL);
ini_set('display_errors', true);

date_default_timezone_set('America/Chicago');

$mysqli = new mysqli("mysql.eecs.ku.edu", "hkathleen", "Phah7bie", "hkathleen");

$pet_id = $_GET['id'];
$orig_search = $_GET['search'];
$orig_type = $_GET['type'];


$query = "SELECT * FROM PET WHERE PID=".$pet_id;

if ($result = $mysqli->query($query)) {

    /* fetch object array */
    while ($obj = $result->fetch_object()) {
        echo "<h1>".$obj->NAME."</h1>";

        echo "<img src=../img/".$obj->PHOTOFILENAME." ></br>";
        
        echo "<div class=\"desc\" font-style=\"italic\">";
        echo $obj->BREED." | ";
        echo $obj->COLOR."</br>";
        echo ucwords($obj->SEX)."</br>";
        echo "Birthdate: ".getAgeCategory($obj->BIRTHDATE, $obj->TYPE)."</br>";
        echo "Weight: ".$obj->WEIGHT." pounds </br></br>";
        echo "</div>";

        echo "Adoption Fee: $".$obj->ADOPTIONFEE."</br>";


        echo "<h4>Description</h4>";
        echo $obj->DESCRIPTION."</br></br>";
        echo "Spayed/Neutered: ".$obj->FIXED."</br>";
        echo "Vaccinations up to date: ".$obj->VACCINATED."</br>";
        echo "Would do well in a home with: ".$obj->GOODWITH."</br>";

    }

    /* free result set */
    $result->close();
}

/* close connection */
$mysqli->close();

echo " <br>";
echo "<a href=\"search.php?search=$orig_search&animaltype=$orig_type\" class=\"button\">Return to Search Page</a>";


function getAgeCategory($birthdate, $animaltype){

    //get age
    $birthday = new DateTime($birthdate);
    $age = $birthday->diff(new DateTime())->format('y');

    //apply correct term for animal type (kitten, puppy, etc)

    return $birthdate;

}

?>

</div>
    <div class="footer">
        EECS 647 - May 9, 2019 | Source code on <a href="https://github.com/katiehrenchir/fill-the-void">GitHub</a>
    </div>
  </body>
</html>
</p>