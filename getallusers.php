<?php 

include 'connection/connection.php';

// $row_count = sqlsrv_num_rows( $stmt );

$all_users = array();

$sql = "SELECT TOP (1000) * FROM [master].[dbo].[users_table]";
$stmt = sqlsrv_query( $conn, $sql);
if( $stmt === false ) {
     die( print_r( sqlsrv_errors(), true));
}

// Retrieve each row as an object.
// Because no class is specified, each row will be retrieved as a stdClass object.
// Property names correspond to field names.
while( $obj = sqlsrv_fetch_object( $stmt)) {
     $all_users[] = $obj;
}
 
print_r($all_users);
sqlsrv_close($conn);



?>