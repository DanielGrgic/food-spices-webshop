<?php

header("Cache-Control: no-cache");
header("Pragma: no-cache"); 
header("Content-type:application/json"); 

include 'connection/connection.php'; 
 
if (!isset($_REQUEST['id'])) {
    echo '{"error":401,"result":"invalid id"}';
    sqlsrv_close($conn);
    exit();
}  
 

$level = 0;

$sql = "SELECT * from [food_spices].[dbo].[products] where id = ".$_REQUEST['id'];
$stmt = sqlsrv_query( $conn, $sql );
if( $stmt === false) {
    sqlsrv_close($conn);
    die( print_r( sqlsrv_errors(), true) ); 
}

$obj = sqlsrv_fetch_object($stmt);
 
 

if($obj == null){
    echo '{"error":204,"result":"Products with id = '.$_REQUEST['id'].' does not exist"}'; 
}

        
else{ 
    echo '{"error":0,"result":"Product is found", "id":"'.$obj->id.'","productname":"'.$obj->productname.'","price":"'.$obj->price.'","tax":"'.$obj->tax.'","discount":"'.$obj->discount.'","created_by":"'.$obj->created_by.'","description":"'.$obj->description.'"}';
}
    

 

sqlsrv_close($conn);

?>