<?php


header("content-type: application/json; charset=utf-8");
header("Access-Control-Allow-Origin: *");

$url = parse_url(getenv("CLEARDB_DATABASE_URL"));


$servername = $url["host"];
$username = $url["user"];
$password = $url["pass"];
$dbname = substr($url["path"], 1);
$item_id = $_GET["itemId"];

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// Create query using SQL string

// $sql = "SELECT * FROM `items` WHERE `subcategory_id`=$subcategory_id;";
$sql = "SELECT `description` FROM `items` where `id`=$item_id";
$result = $conn->query($sql);


//Resource: json-data-students.php
if (mysqli_num_rows($result) > 0)
 {
	// Create Array for JSON response
	$response = array();
    
    // Create Array called students inside response Array
    $response["items"] = array();
	
	// Loop through all results from Database
    while ($row = mysqli_fetch_array($result)) 
     {
        	// Assign results for each database row, to temp student array
            $items = array();
            $items["id"] = $item_id;
            $items["description"] = $row["description"];
       // push single student into final response array
        array_push($response["items"], $items);
    }
    // success
    $response["success"] = 1;

    // print JSON response
    print (json_encode($response));

}
else {
    // no students found
    $response["success"] = 0;
    $response["message"] = "No items found";

    // print no students JSON
    print (json_encode($response));
}

$conn->close();
?>