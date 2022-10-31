<?php

$data = file_get_contents("php://input");

if(isset($data)){
    $data = json_decode($data);
}
//It has been turned tempiroryly
/* print_r($data); */

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

$name = $data->name;
$description = $data->description;
$serialnumber = $data->serialnumber;
$status = $data->status;
$borrower_id = $data->borrower_id;
$photos =  $data->photos;
$subcategory_id =  $data->subcategory_id;


// Create query using SQL string
$sql_query = "INSERT INTO `items` ( `id`,`name`, `serialnumber`, `description`, `status`, `borrower_id`, `photos`, `subcategory_id` ) VALUES ( NULL,  '$name', '$serialnumber' , '$description', '$status', '$borrower_id', '$photos', '$subcategory_id');";


// Query database using connection
$result = $conn->query($sql_query);

// check for empty result
if ($result)
{

    // Create Array for JSON response
    $response = array();

    // success
    $response["success"] = 1;
    $response["message"] = "Data Inserted";
    
    // print data inserted JSON
    print (json_encode($response));
    
} else {
    // fail
    $response["success"] = 0;
    // no student inserted
    $response["message"] = "No Data Inserted";

    // print no data inserted JSON
    print (json_encode($response));
}

?>