<?php

include("credentials.php");
$password = PASSWORD

function OpenCon()
    {
        /* database name is hkathleen */
    $mysqli = new mysqli("mysql.eecs.ku.edu", "hkathleen", $password, "hkathleen") or die("Connect failed: %s\n". $mysqli -> error);
    
    return $mysqli;
    }
    
function CloseCon($mysqli)
    {
    $mysqli -> close();
    }
    
?>