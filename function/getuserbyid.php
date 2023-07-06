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

$sql = "SELECT * from [master].[dbo].[users_table] where id = ".$_REQUEST['id'];
$stmt = sqlsrv_query( $conn, $sql );
if( $stmt === false) {
    sqlsrv_close($conn);
    die( print_r( sqlsrv_errors(), true) ); 
}

$obj = sqlsrv_fetch_object($stmt);
 
 

if($obj == null){
    echo '{"error":204,"result":"User with id = '.$_REQUEST['id'].' does not exist"}'; 
}

        
else{ 
    echo '{"error":0,"result":"User is found", "id":"'.$obj->id.'", "username":"'.$obj->username.'","email":"'.$obj->email.'"}';
}
    

 

sqlsrv_close($conn);

?>