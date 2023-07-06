<?php

header("Cache-Control: no-cache");
header("Pragma: no-cache"); 
header("Content-type:application/json");  

include 'connection/connection.php'; 
 
$check = 0; 
 

if (!isset($_REQUEST['category_name'])) { 
    echo '{"error":401,"result":"invalid category name"}';
    sqlsrv_close($conn);
    exit();
}  


$category_name = $_REQUEST['category_name'];

if($check == 1){ // if any of data is missing it will not allow to make user so this if will stop this function 
    sqlsrv_close($conn);
    exit();
}

$sql = "SELECT* FROM [master].[dbo].[categories] WHERE [category_name]='$category_name'";
$stmt = sqlsrv_query( $conn, $sql);
if( $stmt === false ) {
    sqlsrv_close($conn);
    die( print_r( sqlsrv_errors(), true));
} 


$obj = sqlsrv_fetch_object($stmt);
if($obj!=null){
    echo '{"error":404,"result":"Category with this name already exist"}';
    sqlsrv_close($conn);
    exit();
}
$createdate = date("Y-m-d H:i:s");
$updatedate = date("Y-m-d H:i:s");
$sql = "INSERT INTO [master].[dbo].[categories]  (category_name, createdate, updatedate) VALUES   
('$category_name','$createdate', '$updatedate')";
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