<?php

header("Cache-Control: no-cache");
header("Pragma: no-cache"); 
header("Content-type:application/json");  

include 'connection/connection.php'; 
 
$check = 0; 

$username="";
$email="";
$password="";

$obj_json = '';

if (isset($_REQUEST['username'])) {
    // URL parameter exists
    $username = $_REQUEST['username'];
} 
else{ 
    $obj_json = $obj_json."\n\t\t".'{"error":401,"result":"invalid username"}'.','; 
    $check = 1;
}  


if (isset($_REQUEST['email'])) {
    // URL parameter exists
    $email = $_REQUEST['email'];
} 
else{ 
    $obj_json = $obj_json."\n\t\t".'{"error":401,"result":"invalid email"}'.','; 
    $check = 1;
} 

if (isset($_REQUEST['password'])) {
    // URL parameter exists
    $password = $_REQUEST['password'];
} 
else{ 
    $obj_json = $obj_json."\n\t\t".'{"error":401,"result":"invalid password"}'.','; 
    $check = 1;
} 

if($check == 1){ // if any of data is missing it will not allow to make user so this if will stop this function 
    echo "{\n\t".'"createuser":['."\n";
    $obj_json=rtrim($obj_json, ",");
    print_r($obj_json."");
    
    echo "\n\t]\n}";
    sqlsrv_close($conn);
    exit();
}

$sql = "SELECT* FROM [master].[dbo].[users_table] WHERE [email]= '$email'";
$stmt = sqlsrv_query( $conn, $sql);
if( $stmt === false ) {
    sqlsrv_close($conn);
    die( print_r( sqlsrv_errors(), true));
} 


$obj = sqlsrv_fetch_object($stmt);
if($obj!=null){
    echo '{"error":404,"result":"User with this email already exist"}';
    sqlsrv_close($conn);
    exit();
}
$createdate = date("Y-m-d H:i:s");
$updatedate = date("Y-m-d H:i:s");
$sql = "INSERT INTO [master].[dbo].[users_table]  (username,email, password, createdate, updatedate) VALUES   
('$username','$email','$password', '$createdate', '$updatedate')";
$stmt = sqlsrv_query($conn,$sql);

if( $stmt === false ) {
    sqlsrv_close($conn);
    die( print_r( sqlsrv_errors(), true));
} 
else{
    echo '{"error":0,"result":"Succes"}';
}


  
 

sqlsrv_close($conn);


?>