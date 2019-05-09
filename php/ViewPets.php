<?php

$mysqli = OpenCon();
echo "connected successfully";
closeCon($mysqli)

// $petname = $_POST['name'];
// echo "<h1> Information about ".$petname."</h1>";

// $postId = array();
// $postContent = array();
// $query = "SELECT Posts.author_id, Posts.post_id, Posts.content FROM Users INNER JOIN Posts ON Users.user_id=Posts.author_id ORDER BY Posts.post_id";
// $length = 0;
// if ($result = $mysqli->query($query)) {

//     /* fetch associative array */

// 	while ($row = $result->fetch_assoc()) {
// 		if(strcasecmp($row["author_id"], $username) == 0 ) {
// 			$postContent[$length] = $row["content"];
// 			$postId[$length] = $row["post_id"];
// 			$length++;
// 		}
// 	}


//     /* free result set */
//     $result->free();
// } 


// $arrlength = count($postId);
// if($arrlength != 0)  {
// 	echo "<table><tr><th>Post Id</th><th>Post Content</th></tr>";
// 	for($x = 0; $x < $arrlength; $x++) {
// 		echo "<tr><td>".$postId[$x]."</td>";
// 		echo "<td>".$postContent[$x]."</td></tr>";
// 	}
// 	echo "</table>";
// } else {
// 	echo "There is no information about this pet.";
// }

// 	echo " <br>";
// 	echo "<a href=\"../src/AdminHome.html\" class=\"button\">Return to Search Page</a>";
// /* close connection */
// $mysqli->close();

?>  