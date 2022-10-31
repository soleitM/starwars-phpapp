<?php

$data = file_get_contents("php://input");

/* if(isset($data)){
    $data = json_decode($data);
}
//It has been turned tempiroryly
 print_r($data); */

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
/* $studentID = $data->studentID;
 $name = $data->name;
 $surname = $data->surname;
$items = $data->cart;
 
 $startDate = $data->startDate;
 $endDate = $data->endDate; 
 */
$_POST = json_decode(file_get_contents('php://input'), true);

 $studentID = $_POST['studentID'];
 $name = $_POST['name'];
 $surname = $_POST['surname'];
// $items = $data->items;
//  $items = $_POST['cart'];
 $itemId = $_POST['itemId'];
 $itemName = $_POST['itemName'];
 $startDate = $_POST['startDate'];
 $endDate = $_POST['endDate'];

// $student_id= $_POST['studentID'];
// $name= $_POST['name'];
// $surname= $_POST['surname'];
// $item_id= $_POST['cart'];
// $start_date= $_POST['startDate'];
// $end_date= $_POST['endDate'];


// Create query using SQL string
 $sql_query = "INSERT INTO `borrowingtable`(`id`, `studentID`, `name`, `surname`, `items`,`itemId`, `startDate`, `endDate`) VALUES (NULL, '$studentID', '$name', '$surname' ,0 , '$itemId' ,'$startDate', '$endDate');";

/* $items=$data->cart;
foreach($items as $item) {
    $itemId = $item['id'];
    $itemName = $item['name'];

    $sql_query = "INSERT INTO `borrowingtable`(`id`, `studentID`, `name`, `surname`, `items`, `itemId`, `itemName`, `startDate`, `endDate`) VALUES (NULL, '$studentID', '$name', '$surname' , '$items' ,'$itemId' , '$name', '$startDate', '$endDate');";
   
    $result = mysqli_query($conn,$sql_query);
}  */

// Query database using connection
 $result = $conn->query($sql_query);


// $result=mysqli_query($conn,"SELECT id FROM `borrowingtable` ORDER BY id DESC");
// $id = $data['id']; 



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


// $q=mysqli_query($connection,$sql_query);

// $q = mysqli_query($connection,"SELECT id FROM `borrowingtable` ORDER BY id DESC");
// $data = mysqli_fetch_array($q);
// $id = $data['id'];


// Query database using connection
// $result = $conn->query($sql_query);

// check for empty result
// if ($result)
// {

//     // Create Array for JSON response
//     $response = array();

//     // success
//     $response["success"] = 1;
//     $response["message"] = "Data Inserted";
    
//     // print data inserted JSON
//     print (json_encode($response));  
    
// } else {
//     // fail
//     $response["success"] = 0;
//     // no student inserted
//     $response["message"] = "No Data Inserted";

//     // print no data inserted JSON
//     print (json_encode($response));
// }

?>