<?php

header("content-type: application/json; charset=utf-8");
header("Access-Control-Allow-Origin: *");

$url = parse_url(getenv("CLEARDB_DATABASE_URL"));


$servername = $url["host"];
$username = $url["user"];
$password = $url["pass"];
$dbname = substr($url["path"], 1);

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// Create query using SQL string

$sql = "SELECT * FROM `categories`";
$result = $conn->query($sql);



//make the quer work under each row
/* if ($result->num_rows > 0) {
  // output data of each row
  $json = array();
  while($row = $result->fetch_assoc()) {
    $json[] = $row;
  }

  echo json_encode($json);

} else {
  echo "0 results";
} */


//Resource: json-data-students.php
if (mysqli_num_rows($result) > 0)
 {
	// Create Array for JSON response
	$response = array();
    
    // Create Array called students inside response Array
    $response["categories"] = array();
	
	// Loop through all results from Database
    while ($row = mysqli_fetch_array($result)) 
     {
        	// Assign results for each database row, to temp student array
            $categories = array();
            $categories["name"] = $row["name"];
            $categories["id"] = $row["id"];
            $categories["img_name"] = $row["img_name"];
           
            


       // push single student into final response array
        array_push($response["categories"], $categories);
    }
    // success
    $response["success"] = 1;

    // print JSON response
    print (json_encode($response));

}
else {
    // no categories found
    $response["success"] = 0;
    $response["message"] = "No categories found";

    // print no categories JSON
    print (json_encode($response));
}

$conn->close();
?>