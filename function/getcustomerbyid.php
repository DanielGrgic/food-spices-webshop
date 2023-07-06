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

$sql = "SELECT * from [master].[dbo].[customer_table] where id = ".$_REQUEST['id'];
$stmt = sqlsrv_query( $conn, $sql );
if( $stmt === false) {
    sqlsrv_close($conn);
    die( print_r( sqlsrv_errors(), true) ); 
}

$obj = sqlsrv_fetch_object($stmt);
 
 

if($obj == null){
    echo '{"error":204,"result":"Customer with id = '.$_REQUEST['id'].' does not exist"}'; 
}

        
else{ 
    echo '{"error":0,"result":"Customer is found", "id":"'.$obj->id.'","name":"'.$obj->name.'","email":"'.$obj->email.'","firstname":"'.$obj->firstname.'","lastname":"'.$obj->lastname.'","address":"'.$obj->address.'","phone":"'.$obj->phone.'","country":"'.$obj->country.'","currency":"'.$obj->currency.'","discount":"'.$obj->discount.'"}';
}
    

 

sqlsrv_close($conn);

?>