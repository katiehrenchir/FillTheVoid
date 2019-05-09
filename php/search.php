
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
?>  
 
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title>Search results</title>
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
//the following line protects from sqlinjection
//$search = mysql_real_escape_string($search);

$petsid = array();
$petscontent = array();
$pettype = array();
$breed = array();
$sheltername = array();
$petphotos = array();

$query = "SELECT * FROM SHELTER inner join 
HOUSED_AT on HOUSED_AT.SID = SHELTER.SID 
inner join PET on HOUSED_AT.PID = PET.PID
inner join SHELTER_ADDRESS on SHELTER.SID = SHELTER_ADDRESS.SID WHERE CITY LIKE '%".$search."%'";

if($type == 'other'){
    $query = $query." AND TYPE != 'cat' AND TYPE != 'dog'";
} else if($type == ""){

} else {
    $query = $query." AND TYPE='".$type."'";

}
$length = 0;

//echo $query;

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

        echo "<div id=\"search-result\">";
            
            echo "<img src=../img/".$petphotos[$x]." width=\"300px\"\" ></br>";
            echo "</br></br>";
            echo "<a href=\"viewpet.php?search=$search&type=$type&id=$petsid[$x]\">".$petscontent[$x]."</a></br>";
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