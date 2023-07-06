<?php

header("Cache-Control: no-cache");
header("Pragma: no-cache"); 
header("Content-type:application/json");  

include 'connection/connection.php';  

$check = 0; 

$category_id="";
$productname="";
$price=0;
$description="";

$obj_json = '';

if (isset($_REQUEST['category_id'])) {
    // URL parameter exists
    $category_id = $_REQUEST['category_id'];
} 
else{ 
    $obj_json = $obj_json."\n\t\t".'{"error":401,"result":"invalid category_id"}'.','; 
    $check = 1;
}  


if (isset($_REQUEST['productname'])) {
    // URL parameter exists
    $productname = $_REQUEST['productname'];
} 
else{ 
    $obj_json = $obj_json."\n\t\t".'{"error":401,"result":"invalid productname"}'.','; 
    $check = 1;
} 

if (isset($_REQUEST['price'])) {
    // URL parameter exists
    $price = $_REQUEST['price'];
} 
else{ 
    $obj_json = $obj_json."\n\t\t".'{"error":401,"result":"invalid price"}'.','; 
    $check = 1;
} 

if (isset($_REQUEST['description'])) {
    // URL parameter exists
    $description = $_REQUEST['description'];
} 
else{ 
    $obj_json = $obj_json."\n\t\t".'{"error":401,"result":"invalid description"}'.','; 
    $check = 1;
} 
if($check == 1){ // if any of data is missing it will not allow to make user so this if will stop this function 
    echo "{\n\t".'"createproduct":['."\n";
    $obj_json=rtrim($obj_json, ",");
    print_r($obj_json."");
    
    echo "\n\t]\n}";
    sqlsrv_close($conn);
    exit();
}

$sql = "SELECT * FROM [master].[dbo].[products] WHERE [productname]= '$productname'";
$stmt = sqlsrv_query( $conn, $sql);
if( $stmt === false ) {
    sqlsrv_close($conn);
    die( print_r( sqlsrv_errors(), true));
} 


$obj = sqlsrv_fetch_object($stmt);
if($obj!=null){
    echo '{"error":404,"result":"Product with this name already exist"}';
    sqlsrv_close($conn);
    exit();
}


$sql = "SELECT * FROM [master].[dbo].[categories] WHERE [id]= '$category_id'";
$stmt = sqlsrv_query( $conn, $sql);
if( $stmt === false ) {
    sqlsrv_close($conn);
    die( print_r( sqlsrv_errors(), true));
} 


$obj = sqlsrv_fetch_object($stmt);
if($obj==null){
    echo '{"error":404,"result":"Category with this id does not exist"}';
    sqlsrv_close($conn);
    exit();
}


$createdate = date("Y-m-d H:i:s");
$updatedate = date("Y-m-d H:i:s"); 

$sql = "INSERT INTO [master].[dbo].[products]  (category_id,productname, price, description,createdate, updatedate) VALUES   
('$category_id','$productname','$price', '$description','$createdate', '$updatedate')";
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