<?php 
// header('Content-Type: text/xml');
header("Cache-Control: no-cache");
header("Pragma: no-cache"); 
header("Content-type:application/json");  

include 'connection/connection.php'; 


if(session_status() !== PHP_SESSION_ACTIVE){
    session_start(); 
}

if(isset($_SESSION['logged_in'])){
    if($_SESSION['logged_in']==1){
        echo '{"error":501,"result":"You are already logged in"}';

        sqlsrv_close($conn);
        exit();
    }
    

}
 
$check = 0; 
 
$email="";
$password="";
 
$obj_json = '';
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
    
    echo "{\n\t".'"customerlogin":['."\n";
    $obj_json=rtrim($obj_json, ",");
    print_r($obj_json."");
    
    echo "\n\n\t]\n}";
    sqlsrv_close($conn);
    exit();
}
 

$sql = "SELECT * FROM [master].[dbo].[customer_table] WHERE [email]= '$email' AND [password]= '$password'";
$stmt = sqlsrv_query( $conn, $sql);
if( $stmt === false ) {
    sqlsrv_close($conn);
    die( print_r( sqlsrv_errors(), true));
} 

$obj = sqlsrv_fetch_object($stmt);
 

if($obj != null){

    
    echo '{"error":0,"result":"Welcome back '.$obj->name.'","id":"'.$obj->id.'","name":"'.$obj->name.'","email":"'.$obj->email.'","firstname":"'.$obj->firstname.'","lastname":"'.$obj->lastname.'","address":"'.$obj->address.'","phone":"'.$obj->phone.'","country":"'.$obj->country.'","currency":"'.$obj->currency.'","discount":"'.$obj->discount.'"}';
    setcookie("userid", $obj->id, time()+30*24*60*60);
    
    $_SESSION['cookie'] = $_COOKIE;
    $_SESSION['logged_userid'] = $obj->id;
    $_SESSION['logged_in'] = 1;


}
else{
    echo '{"error":401,"result":"Incorrect email or password"}';
}



?>