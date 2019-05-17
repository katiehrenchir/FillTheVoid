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

$shelter_id = $_GET['sid'];


$query = "SELECT * FROM SHELTER WHERE SID=".$shelter_id;

if ($result = $mysqli->query($query)) {

    /* fetch object array */
    while ($obj = $result->fetch_object()) {
        echo "<h1>".$obj->NAME."</h1>";
        
        echo "<div class=\"desc\" font-style=\"italic\">";
        echo "<a href=\"$obj->WEBSITEURL\">Website</a>";
        echo $obj->PHONE."</br>";
        echo $obj->EMAIL."</br>";
        echo "</div>";

        echo "<h4>Description</h4>";
        echo $obj->DESCRIPTION."</br></br>";
        echo $obj->ADOPTIONPOLICY."</br></br>";
    }

    /* free result set */
    $result->close();
}

/* close connection */
$mysqli->close();

echo " <br>";
echo "<a href=\"search.php\" class=\"button\">Return to Search Page</a>";


?>

</div>
    <div class="footer">
        EECS 647 - May 9, 2019 | Source code on <a href="https://github.com/katiehrenchir/fill-the-void">GitHub</a>
    </div>
  </body>
</html>
</p>