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

$sql = "SELECT [id] from [master].[dbo].[customer_table] where id = ".$_REQUEST['id'];
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
  $sql = "UPDATE [master].[dbo].[customer_table] SET ";

  if (isset($_REQUEST['name'])) $sql = $sql."[name]="."'".$_REQUEST['name']."'".", ";

  if (isset($_REQUEST['firstname'])) $sql = $sql."[firstname]="."'".$_REQUEST['firstname']."'".", ";

  if (isset($_REQUEST['lastname'])) $sql = $sql."[lastname]="."'".$_REQUEST['lastname']."'".", ";

  if (isset($_REQUEST['email'])) $sql = $sql."[email]="."'".$_REQUEST['email']."'".", ";

  if (isset($_REQUEST['password'])) $sql = $sql."[password]="."'".$_REQUEST['password']."'".", ";

  if (isset($_REQUEST['address'])) $sql = $sql."[address]="."'".$_REQUEST['address']."'".", ";

  if (isset($_REQUEST['phone'])) $sql = $sql."[phone]="."'".$_REQUEST['phone']."'".", ";

  if (isset($_REQUEST['country'])) $sql = $sql."[country]="."'".$_REQUEST['country']."'".", ";

  if (isset($_REQUEST['currency'])) $sql = $sql."[currency]="."'".$_REQUEST['currency']."'".", ";

  if (isset($_REQUEST['discount'])) $sql = $sql."[discount]="."'".$_REQUEST['discount']."'".", ";

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
    echo '{"error":204,"result":"Customer with id = '.$_REQUEST['id'].' does not exist"}';
}
  
sqlsrv_close($conn);

?>