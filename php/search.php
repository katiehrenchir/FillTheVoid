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
?>  
 
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title>Search results</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link rel="stylesheet" type="text/css" href="../css/styles.css"/>
</head>
<body>

<h3>Search Pets</h3>
    <p>You  may search by name</p>
    <form  method="GET" action="search.php">
    <p>Find a </p>
        <input type="radio" name="animaltype" value="dog" checked="checked"> Dog<br>
        <input type="radio" name="animaltype" value="cat"> Cat<br>
        <input type="radio" name="animaltype" value="other"> Other<br>
        <p>near </p>
      <input  type="text" name="search" placeholder="Location">
      <input  type="submit" name="submit" value="Search">
    </form>

<?php 

$search = $_GET['search'];
$type = $_GET['animaltype'];
//the following line protects from sqlinjection
//$search = mysql_real_escape_string($search);

$petsid = array();
$petscontent = array();
$pettype = array();

$query = "SELECT * FROM PET WHERE NAME LIKE '%".$search."%'";

if($type == 'other'){
    $query = $query." AND TYPE != 'cat' AND TYPE != 'dog'";
} else {
    $query = $query." AND TYPE='".$type."'";

}
$length = 0;

echo $query;

if ($result = $mysqli->query($query)) {

    /* fetch associative array */

	while ($row = $result->fetch_assoc()) {
        $petscontent[$length] = $row["NAME"];
        $pettype[$length] = $row["TYPE"];
        $petsid[$length] = $row["PID"];
        $length++;
	}

    /* free result set */
    $result->free();
}

$arrlength = count($petsid);
if($arrlength != 0)  {
	echo "<table><tr><th>Pet ID</th><th>Name</th><th>Type</th></tr>";
	for($x = 0; $x < $arrlength; $x++) {
		echo "<tr><td>".$petsid[$x]."</a></td>";
        echo "<td><a href=\"viewpet.php?id=$petsid[$x]\">".$petscontent[$x]."</a></td>";
        echo "<td>".$pettype[$x]."</td></tr>";
	}
	echo "</table>";
} else {
	echo "There were no pets matching that query";
}

echo " <br>";
echo "<a href=\"../index.html\" class=\"button\">Return to Search Page</a>";

/* close connection */
$mysqli->close();

?>  

</body>
</html>