<?php

session_start();
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

//it tells you, when you have issue, creates log file
ini_set("display_errors", 1);
ini_set("log_errors", 1);
ini_set('error_log',dirname(__FILE__). '/log.txt');
error_reporting(E_ALL);

//creating post
$_POST = json_decode(file_get_contents('php://input'), true);
//once you get the post, you will write two different code

 $email = $_POST['email'];
$password = $_POST['password'];

// $data = file_get_contents("php://input");

// if(isset($data)){
//     $data = json_decode($data);
// }

// $email = $data->email;
// $password = md5($data->password);
//$email = $_POST['email'];


// $password = md5($_POST['password']);


$result = mysqli_query($conn,"select * from administrator where email = '$email' and password = '$password'");
//$result = mysqli_query($conn,"select * from students where email = '$email' and password = md5('$password')");


if (mysqli_num_rows($result) > 0)
 {
	$response = array();

    $output = mysqli_fetch_array($result);
    
    $_SESSION["login"] = "success";

    // print JSON response
    print(json_encode($output));
    // print("login successful");

}
else {
    // no students found

    $_SESSION["login"] = "failed";

    print("login failed");
}

$conn->close();



?> 