<?php 

include 'connection/connection.php';
 

$all_users = array();

$sql = "SELECT * FROM [users_table]";
$stmt = sqlsrv_query( $conn, $sql);
if( $stmt === false ) {
     sqlsrv_close($conn);
     die( print_r( sqlsrv_errors(), true));
}

// Retrieve each row as an object.
// Because no class is specified, each row will be retrieved as a stdClass object.
// Property names correspond to field names.

$obj_json = '';
echo "{\n\t".'"users":['."\n"; 
while( $obj = sqlsrv_fetch_object( $stmt)) {
     $obj_json = $obj_json."\n\t\t".json_encode($obj).',';
}
$obj_json=rtrim($obj_json, ",");
print_r($obj_json."");
 
echo "\n\n\t]\n}";
 
sqlsrv_close($conn);



?>