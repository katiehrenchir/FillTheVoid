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

include('credentials.php'); 
$mysqli = new mysqli("mysql.eecs.ku.edu", "hkathleen", $password, "hkathleen");

$pet_id = $_GET['id'];
$shelter_id = $_GET['sid'];
$orig_search = $_GET['search'];
$orig_type = $_GET['type'];

$shelterquery = "SELECT * FROM SHELTER where SID = ".$shelter_id;
$shelterresult = $mysqli->query($shelterquery);
while ($obj = $shelterresult->fetch_object()) {
  $shelter = $obj;
}

$bondedquery = "SELECT * FROM BONDEDPAIR where PID1 = ".$pet_id." or PID2 = ".$pet_id;
$bondedresult = $mysqli->query($bondedquery);

if(mysqli_num_rows($bondedresult) > 0){
  while ($obj = $bondedresult->fetch_object()) {
    $bondedpairinfo = $obj;
  }

  if($bondedpairinfo->PID1 == $pet_id){
    $companion_pid = $bondedpairinfo->PID2;
  } else {
    $companion_pid = $bondedpairinfo->PID1;
  }

  //get companion info
  $companionquery = "SELECT * FROM PET where PID = ".$companion_pid;
  $companionresult = $mysqli->query($companionquery);
  
  while ($obj = $companionresult->fetch_object()) {
    $companion_type = $obj->TYPE;
    $companion_name = $obj->NAME; 
  }


}


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
        echo "Birthdate: ".$obj->BIRTHDATE."</br>";
        echo "Weight: ".$obj->WEIGHT." pounds </br></br>";
        echo "</div>";

        if($bondedpairinfo){
          echo "<h4>This animal is part of a bonded pair!</h4>";
          echo "Companion: ";
          echo "<a href=\"viewpet.php?search=$orig_search&type=$companion_type&id=$companion_pid&sid=$shelter_id\">".$companion_name."</a></br></br>";
          echo "Combined Adoption Fee: $".$bondedpairinfo->ADOPTIONFEE."</br></br>";

        }          
        echo "Adoption Fee: $".$obj->ADOPTIONFEE."</br>";
    

        echo "<h3>Description</h3>";
        echo $obj->DESCRIPTION."</br></br>";
        echo "Spayed/Neutered: ".$obj->FIXED."</br>";
        echo "Vaccinations up to date: ".$obj->VACCINATED."</br>";
        echo "Would do well in a home with: ".ucwords($obj->GOODWITH)."</br></br>";

        echo "This pet is housed at ";
        echo "<a href=\"viewshelter.php?sid=$shelter_id\">".$shelter->SNAME."</a></br>";


    }

    /* free result set */
    $result->close();
}

/* close connection */
$mysqli->close();

echo " <br>";
echo "<a href=\"search.php?search=$orig_search&animaltype=$orig_type\" class=\"button\">Return to Search Page</a>";

?>

</div>
    <div class="footer">
        EECS 647 - May 18, 2019 | Source code on <a href="https://github.com/katiehrenchir/fill-the-void">GitHub</a>
    </div>
  </body>
</html>
</p>