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

$sql = "SELECT [id] from [master].[dbo].[products] where id = ".$_REQUEST['id'];
$stmt = sqlsrv_query( $conn, $sql );
if( $stmt === false) {
    sqlsrv_close($conn);
    die( print_r( sqlsrv_errors(), true) ); 
}
while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
  $level = $row['id'];

} 

sqlsrv_free_stmt($stmt);


if($level!=0){
  $sql = "UPDATE [master].[dbo].[products] SET ";

  if (isset($_REQUEST['productname'])) $sql = $sql."[productname]="."'".$_REQUEST['productname']."'".", ";

  if (isset($_REQUEST['price'])) $sql = $sql."[price]="."'".$_REQUEST['price']."'".", ";

  if (isset($_REQUEST['tax'])) $sql = $sql."[tax]="."'".$_REQUEST['tax']."'".", ";

  if (isset($_REQUEST['discount'])) $sql = $sql."[discount]="."'".$_REQUEST['discount']."'".", ";

  if (isset($_REQUEST['description'])) $sql = $sql."[description]="."'".$_REQUEST['description']."'".", ";


  $updatedate = date("Y-m-d H:i:s");
  $sql = $sql."[updatedate]="."'".$updatedate."'";

  $sql = $sql."WHERE [id]=".$_REQUEST['id'];

  $stmt = sqlsrv_query( $conn, $sql);
  if( $stmt === false ) {
    sqlsrv_close($conn);
    die( print_r( sqlsrv_errors(), true));
  } 
  else{
    echo '{"error":0,"result":"Succes"}';
  }

  
}
else{ 
    echo '{"error":204,"result":"Product with id = '.$_REQUEST['id'].' does not exist"}';
}
  
sqlsrv_close($conn);

?>