<?php ?>
<?php 

// ini_set('display_startup_errors', true);
// error_reporting(E_ALL);
// ini_set('display_errors', true);

include('credentials.php'); 
$mysqli = new mysqli("mysql.eecs.ku.edu", "hkathleen", $password, "hkathleen");

/* check connection */
if ($mysqli->connect_errno) {
    printf("Connect failed: %s\n", $mysqli->connect_error);
    exit();
}
?>  
 
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title>Search results - Animal Companion Locator</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link rel="stylesheet" type="text/css" href="../css/styles.css"/>
</head>
<body>
<div class="main">

<h1>Animal Companion Locator</h1>
<form  method="GET" action="search.php">
            <p>Find a 
            <input type="radio" name="animaltype" value="dog"> Dog 
            <input type="radio" name="animaltype" value="cat"> Cat
            <input type="radio" name="animaltype" value="other"> Other<br>
            </p>

            <p>near 
            <input  type="text" name="search" placeholder="Location">
            <input  type="submit" name="submit" value="Search">
            </p>
</form>

<?php 

$search = $_GET['search'];
$type = $_GET['animaltype'];
$goodwith = $_GET['goodwith'];
$age = $_GET['age'];
$sex = $_GET['sex'];
$size = $_GET['weight'];
$fixed = $_GET['fixed'];
$vaxx = $_GET['vaxx'];

//the following line protects from sqlinjection
//$search = mysql_real_escape_string($search);

echo "<h3>Search results</h3>";

$petsid = array();
$petscontent = array();
$pettype = array();
$breed = array();
$sheltername = array();
$petphotos = array();

$query = "SELECT * FROM SHELTER inner join 
HOUSED_AT on HOUSED_AT.SID = SHELTER.SID 
inner join PET on HOUSED_AT.PID = PET.PID
inner join SHELTER_ADDRESS on SHELTER.SID = SHELTER_ADDRESS.SID";

//check if the search box was empty - if not, add 'where' clause to query
if( !empty($search) ){
    $query = $query." WHERE PET.NAME LIKE '%".$search."%' OR CITY LIKE '%".$search."%'";
}


// filter by pet type
if($type == 'other'){
    $query = $query." AND TYPE != 'cat' AND TYPE != 'dog'";
} else if($type == ""){
    //do nothing
} else {
    $query = $query." AND TYPE='".$type."'";
}

//filter by good with (dogs, cats, children)
for($goodwithindex = 0; $goodwithindex < count($goodwith); $goodwithindex++){
    $query = $query." AND FIND_IN_SET('".$goodwith[$goodwithindex]."', PET.GOODWITH)";
}

// //filter by age
if(!empty($age)){
    if($age == "young"){
        $query = $query." and TIMESTAMPDIFF(YEAR, PET.BIRTHDATE, CURDATE()) < 1";
    } else if ($age == "adult"){
        $query = $query." and TIMESTAMPDIFF(YEAR, PET.BIRTHDATE, CURDATE()) between 1 and 8";
    } else if ($age == "senior"){
        $query = $query." and TIMESTAMPDIFF(YEAR, PET.BIRTHDATE, CURDATE()) > 8";
    }
}

//filter by sex
if(!empty($sex)){
    $query = $query." and PET.SEX = '".$sex."'";
}

//filter by size/weight
if(!empty($size)){
    if($size == "under5"){
        $query = $query." and PET.WEIGHT < 5";
    } else if ($size == "6to25"){
        $query = $query." and PET.WEIGHT between 5 and 25";
    } else if ($size == "26to65"){
        $query = $query." and PET.WEIGHT between 25 and 65";
    } else if ($size ==" 66andabove"){
        $query = $query." and PET.WEIGHT > 65";
    }
}

//filter by spay/neuter
if(!empty($fixed)){
    $query = $query." and PET.FIXED = TRUE";
}

//filter by vaxx up to date
if(!empty($vaxx)){
    $query = $query." and PET.VACCINATED = TRUE";
}

//print query - helpful for debugging
//echo $query;

$length = 0;
if ($result = $mysqli->query($query)) {

    /* fetch associative array */

	while ($row = $result->fetch_assoc()) {
        $petscontent[$length] = $row["NAME"];
        $pettype[$length] = $row["TYPE"];
        $petsid[$length] = $row["PID"];
        $breed[$length] = $row["BREED"];
        $sheltercity[$length] = $row['CITY'].", ".$row['STATE'];
        $petphotos[$length] = $row['PHOTOFILENAME'];
        $length++;
	}

    /* free result set */
    $result->free();
}

$arrlength = count($petsid);
if($arrlength != 0)  {

    echo "<div class=\"container\">";
	for($x = 0; $x < $arrlength; $x++) {

        echo "<div class=\"search-result\">";
            
            echo "<img class=\"search-result-img\" src=../img/".$petphotos[$x]." width=\"300px\"\" ></br>";
            echo "</br></br>";
            echo "<a href=\"viewpet.php?search=$search&type=$type&id=$petsid[$x]\">".$petscontent[$x]."</a></br></br>";
            echo $breed[$x]."</br>";
            echo $sheltercity[$x]."</br></br>";

        echo "</div>";
	}
	echo "</br> </div>";
} else {
	echo "There were no pets matching that query";
}

echo " </br>";

/* close connection */
$mysqli->close();

?>  

</div>
    <div class="footer">
        EECS 647 - May 9, 2019 | Source code on <a href="https://github.com/katiehrenchir/fill-the-void">GitHub</a>
    </div>
  </body>
</html>
</p>