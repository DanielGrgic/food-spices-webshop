<?php

header("Cache-Control: no-cache");
header("Pragma: no-cache"); 
header("Content-type:application/json"); 

include 'connection/connection.php'; 

 
//SESSION
if(session_status() !== PHP_SESSION_ACTIVE){
    session_start(); 
}

check();


//check does cmd param exist in link
$function = "";
if(isset($_REQUEST['cmd'])){   
    $function = $_REQUEST['cmd'];
}
else{
    echo '{"error": "1", "result": "please choose function"}';
    exit();
} 
 
// check_login();


switch($function){

    //all for users
    case 'login':
        //how to call this case :  http://foodspices.com/service.php?cmd=login&email=admin@gmail.com&pass=admin123
        include 'function/login.php';
        print_r($_SESSION);

        break;

    case 'logout':
        //how to call this case :  http://foodspices.com/service.php?cmd=logout
        echo '{"error":0,"result":"You are successfully logged out"}';
        session_destroy(); 

        break;
    case 'createuser':
        //how to call this case :  http://foodspices.com/service.php?cmd=createuser&username=daniel&email=daniel@gmail.com&password=daniel1234
        include 'function/createuser.php';

        break;

    case 'deleteuserbyid':
        //how to call this case :  http://foodspices.com/service.php?cmd=deleteuserbyid&id=1
        include 'function/deleteuserbyid.php';

        break;

    case 'updateuserbyid':
        //how to call this case :  http://foodspices.com/service.php?cmd=updateuserbyid&id=1&username=newusername...
        //you need to put in parrams 
        include 'function/updateuserbyid.php';

        break;

    case 'getallusers':
        //how to call this case :  http://foodspices.com/service.php?cmd=getallusers
        //you need to put in parrams 
        include 'function/getallusers.php';

        break;

    case 'getuserbyid':
        //how to call this case :  http://foodspices.com/service.php?cmd=getuserbyid&id=1
        //you need to put in parrams 
        include 'function/getuserbyid.php';

        break;

    //All for customers

    case 'createcustomer':
        //how to call this case :  http://foodspices.com/service.php?cmd=createcustomer&name=daniel&email=daniel@gmail.com&password=daniel1234
        include 'function/createcustomer.php';

        break;

    case 'getallcustomers':
        //how to call this case :  http://foodspices.com/service.php?cmd=getallcustomers
        include 'function/getallcustomers.php';

        break; 

    case 'customerlogin':
        //how to call this case :  http://foodspices.com/service.php?cmd=customerlogin&email=customer1@gmail.com&password=customer123
        include 'function/customerlogin.php';

        break;

    case 'deletecustomerbyid':
        //how to call this case :  http://foodspices.com/service.php?cmd=deletecustomerbyid&id=1
        include 'function/deletecustomerbyid.php';

        break;
    
    case 'updatecustomerbyid':
        //how to call this case :  http://foodspices.com/service.php?cmd=updatecustomerbyid&id=1&name=newname...
        //you need to put in parrams 
        include 'function/updatecustomerbyid.php';

        break;

    case 'getcustomerbyid':
        //how to call this case :  http://foodspices.com/service.php?cmd=getcustomerbyid&id=1
        //you need to put in parrams 
        include 'function/getcustomerbyid.php';

        break;


    //All for categories

    case 'createcategory':
        //how to call this case :  http://foodspices.com/service.php?cmd=createcategory&category_name=newacategory
        include 'function/createcategory.php';

        break;
    
    case 'updatecategorybyid':
        //how to call this case :  http://foodspices.com/service.php?cmd=updatecategorybyid&id=1&category_name=newname...
        //you need to put in parrams 
        include 'function/updatecategorybyid.php';

        break;

    case 'deletecategorybyid':
        //how to call this case :  http://foodspices.com/service.php?cmd=deletecategorybyid&id=1
        include 'function/deletecategorybyid.php';

        break;

    case 'getallcategories':
        //how to call this case :  http://foodspices.com/service.php?cmd=getallcategories
        include 'function/getallcategories.php';

        break;

    //All for products

    case 'createproduct':
        //how to call this case :  http://foodspices.com/service.php?cmd=createproduct&category_id=1&productname=product1&price=100&description=new description
        include 'function/createproduct.php';

        break;

    case 'updateproductbyid':
        //how to call this case :  http://foodspices.com/service.php?cmd=updateproductbyid&id=1&productname=newname...
        //you need to put in parrams 
        include 'function/updateproductbyid.php';

        break;

    case 'deleteproductbyid':
        //how to call this case :  http://foodspices.com/service.php?cmd=deleteproductbyid&id=1
        include 'function/deleteproductbyid.php';

        break;

    case 'getallproducts':
        //how to call this case :  http://foodspices.com/service.php?cmd=getallproducts
        include 'function/getallproducts.php';

        break;

    case 'getproductbyid':
        //how to call this case :  http://foodspices.com/service.php?cmd=getproductbyid&id=1
        //you need to put in parrams 
        include 'function/getproductbyid.php';

        break;
    

    default:
        echo '{"error":1,"result":"no function is selected"}';
}

function check(){
    
    $server_ip = gethostbyname($_SERVER['SERVER_NAME']);
    
    // if($server_ip!='184.154.5.218'){
    //     echo '{"error":1,"result":"error, IP address is not right"}';
        
    //     exit();
    // }

    $invoice_number = 1;
 

    if($_REQUEST == null){ //this if check if query is empty
        echo '{"error":1,"result":"params is empty"}';
         
        exit();
    } 

    $url = $url = $_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'];
    $values = parse_url($url);
    $query = explode('&',$values['query']);
    $num = count($query);
    $array = [];
    for ($i=0; $i < $num; $i++) { 
        $split = explode('=',$query[$i]); 
        array_push($array,$split[0]);
    } 
    $possible_query = ['cmd','category_name', 'price', 'category_id','productname','username', 'password', 'email', 'id', 'user_type', 'active', 'lastloginip', 'firstname', 'lastname', 'name', 'address', 'phone', 'country', 'currency', 'amount', 'tax', 'ispaid', 'customer_id', 'itemname', 'itemprice', 'discount', 'invoicenumber', 'description', 'invoicenum', 'createdby'];

    $bFound = (count(array_intersect($array, $possible_query)));
    //This if check if there is some query that does not belongs there
    //for example you can only put cmd, username and password and if you put for example any other then you will get error and not be possible to continue
    if($num!=$bFound){
        echo '{"error":1,"result":"Query You sent is not right!"}';
        
        exit();
    }

    if (isset($_REQUEST['username'])){
        if (strlen($_REQUEST['username'])>255){
            echo '{"error":1,"result":"invalid username"}';
            
            exit();
        }
    }
    if (isset($_REQUEST['category_name'])){
        if (strlen($_REQUEST['category_name'])>255){
            echo '{"error":1,"result":"invalid category_name"}';
            
            exit();
        }
    }
    if (isset($_REQUEST['productname'])){
        if (strlen($_REQUEST['productname'])>255){
            echo '{"error":1,"result":"invalid productname"}';
            
            exit();
        }
    }
    if (isset($_REQUEST['price'])){
        if (strlen((string)$_REQUEST['price'])>8){
            echo '{"error":1,"result":"invalid price"}';
            
            exit();
        }
        elseif ( !is_numeric($_REQUEST['price']) ) {
            $price= $_REQUEST['price'];
            echo '{"error":1,"result":"'.$price.' is not a number"}';
            
            exit();
        }
    }
    
    if (isset($_REQUEST['category_id'])){
        if (strlen((string)$_REQUEST['category_id'])>8){
            echo '{"error":1,"result":"invalid category_id"}';
            
            exit();
        }
        elseif ( !is_numeric($_REQUEST['category_id']) ) {
            $category_id= $_REQUEST['category_id'];
            echo '{"error":1,"result":"'.$category_id.' is not a number"}';
            
            exit();
        }
    }
    if (isset($_REQUEST['password'])){
        if (strlen($_REQUEST['password'])>255){
            echo '{"error":1,"result":"invalid password"}';
            
            exit();
        }
    }
    if (isset($_REQUEST['email'])){
        if (strlen($_REQUEST['email'])>255){
            echo '{"error":1,"result":"invalid email"}';
            
            exit();
        }
    }
    if (isset($_REQUEST['id'])){
        if (strlen((string)$_REQUEST['id'])>8){
            echo '{"error":1,"result":"invalid id"}';
            
            exit();
        }
        elseif ( !is_numeric($_REQUEST['id']) ) {
            $check_id= $_REQUEST['id'];
            echo '{"error":1,"result":"$check_id is not a number"}';
            
            exit();
        }
    }
     
    if (isset($_REQUEST['user_type'])){
        if (strlen($_REQUEST['user_type'])>255){
            echo '{"error":1,"result":"invalid user_type"}';
            
            exit();
        }
    }
    if (isset($_REQUEST['active'])){
        if (strlen($_REQUEST['active'])>255){
            echo '{"error":1,"result":"invalid active"}';
            
            exit();
        }
    }
    if (isset($_REQUEST['lastloginip'])){
        if (strlen($_REQUEST['lastloginip'])>255){
            echo '{"error":1,"result":"invalid lastloginip"}';
            
            exit();
        }
    }
    if (isset($_REQUEST['firstname'])){
        if (strlen($_REQUEST['firstname'])>255){
            echo '{"error":1,"result":"invalid firstname"}';
            
            exit();
        }
    }
    if (isset($_REQUEST['lastname'])){
        if (strlen($_REQUEST['lastname'])>255){
            echo '{"error":1,"result":"invalid lastname"}';
            
            exit();
        }
    }
    if (isset($_REQUEST['name'])){
        if (strlen($_REQUEST['name'])>255){
            echo '{"error":1,"result":"invalid name"}';
            
            exit();
        }
    }
    if (isset($_REQUEST['address'])){
        if (strlen($_REQUEST['address'])>255){
            echo '{"error":1,"result":"invalid address"}';
            
            exit();
        }
    }
    if (isset($_REQUEST['phone'])){
        if (strlen($_REQUEST['phone'])>255){
            echo '{"error":1,"result":"invalid phone"}';
            
            exit();
        }
    }
    if (isset($_REQUEST['country'])){
        if (strlen($_REQUEST['country'])>255){
            echo '{"error":1,"result":"invalid country"}';
            
            exit();
        }
    }
    if (isset($_REQUEST['currency'])){
        if (strlen($_REQUEST['currency'])>255){
            echo '{"error":1,"result":"invalid currency"}';
            
            exit();
        }
    }
    if (isset($_REQUEST['amount'])){
        if (strlen((string)$_REQUEST['amount'])>20){
            echo '{"error":1,"result":"invalid amount"}';
            
            exit();
        } 
        elseif ( !is_numeric($_REQUEST['amount']) ) {
            $check_amount= $_REQUEST['amount'];
            echo '{"error":1,"result":"$check_amount is not a number"}';
            
            exit();
        }
    }
    if (isset($_REQUEST['tax'])){
        if (strlen((string)$_REQUEST['tax'])>20){
            echo '{"error":1,"result":"invalid tax"}';
            
            exit();
        } 
        elseif ( !is_numeric($_REQUEST['tax']) ) {
            $check_tax= $_REQUEST['tax'];
            echo '{"error":1,"result":"$check_tax is not a number"}';
            
            exit();
        }
    }
    if (isset($_REQUEST['ispaid'])){
        if (strlen((string)$_REQUEST['ispaid'])>20){
            echo '{"error":1,"result":"invalid ispaid"}';
            
            exit();
        } 
        elseif ( !is_numeric($_REQUEST['ispaid']) ) {
            $check_ispaid= $_REQUEST['ispaid'];
            echo '{"error":1,"result":"$check_ispaid is not a number"}';
            
            exit();
        }
    }

    if (isset($_REQUEST['customer_id'])){
        if (strlen((string)$_REQUEST['customer_id'])>20){
            echo '{"error":1,"result":"invalid customer_id"}';
            
            exit();
        } 
        elseif ( !is_numeric($_REQUEST['customer_id']) ) {
            $customer_id= $_REQUEST['customer_id'];
            echo '{"error":1,"result":"$customer_id is not a number"}';
            
            exit();
        }
    }
    if (isset($_REQUEST['itemname'])){
        if (strlen($_REQUEST['itemname'])>255){
            echo '{"error":1,"result":"invalid itemname"}';
            
            exit();
        }
    }
    if (isset($_REQUEST['itemprice'])){
        if (strlen((string)$_REQUEST['itemprice'])>20){
            echo '{"error":1,"result":"invalid itemprice"}';
            
            exit();
        } 
        elseif ( !is_numeric($_REQUEST['itemprice']) ) {
            $itemprice= $_REQUEST['itemprice'];
            echo '{"error":1,"result":"$itemprice is not a number"}';
            
            exit();
        }
    }
    if (isset($_REQUEST['discount'])){
        if (strlen((string)$_REQUEST['discount'])>20){
            echo '{"error":1,"result":"invalid discount"}';
            
            exit();
        } 
        elseif ( !is_numeric($_REQUEST['discount']) ) {
            $discount= $_REQUEST['discount'];
            echo '{"error":1,"result":"$discount is not a number"}';
            
            exit();
        }
    }
    if (isset($_REQUEST['invoicenumber'])){
        if (strlen($_REQUEST['invoicenumber'])>255){
            echo '{"error":1,"result":"invalid invoicenumber"}';
            
            exit();
        }
    }
    if (isset($_REQUEST['invoicenum'])){
        if (strlen($_REQUEST['invoicenum'])>255){
            echo '{"error":1,"result":"invalid invoicenum"}';
            
            exit();
        }
    }
    if (isset($_REQUEST['description'])){
        if (strlen($_REQUEST['description'])>255){
            echo '{"error":1,"result":"invalid description"}';
            
            exit();
        }
    }
    if (isset($_REQUEST['createdby'])){
        if (strlen((string)$_REQUEST['createdby'])>20){
            echo '{"error":1,"result":"invalid createdby"}';
            
            exit();
        } 
        elseif ( !is_numeric($_REQUEST['createdby']) ) {
            $createdby= $_REQUEST['createdby'];
            echo '{"error":1,"result":"$createdby is not a number"}';
            
            exit();
        }
    }
    
}

// function check_login(){
    
    
//     if (!isset($_SESSION['logged_in']) && $_REQUEST['cmd']!='login' && $_REQUEST['cmd']!='customerlogin'){
//         if($_REQUEST['cmd']=='createuser'){
//             $function = $_REQUEST['cmd'];
//         }
//         else{
//             echo '{"error":1,"result":"Please login or register first before start using our service."}';
            
//             exit();
//         }
//     } 

// }
 
?>