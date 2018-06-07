<?php
session_start();
$api_keys = array(
     "a56e97f5adba76b8f33329acec261f2be04e6267,X2X-VCX-KV11",//-->apikey
    );


// check key
if(isset($_GET['chk_key'])){
   $authkey = sha1($_GET['chk_key']).','.$_GET['chk_key'];
   if(!in_array($authkey,$api_keys)){
   	    $resdata = array(
   	    	"status" => "200",
   	    	"data" => "API key is not recognized."
   	    	);
   	    echo json_encode($resdata);
   	   exit();
   	}else{
   		 $_SESSION['user'] = "delta";
   	    $_SESSION['password'] = "APIv0";
   	}
}

// save key
if(isset($_GET['save_key'])){
    $authkey = sha1($_GET['save_key']).','.$_GET['save_key'];
   if(in_array($authkey,$api_keys)){
   	    $resdata = array(
   	    	"status" => "200",
   	    	"data" => "API key already exists."
   	    	);
   	    echo json_encode($resdata);
   	    exit();
   }else{
   	  // save API key
   	  $aux = '//-->api';
   	  $key = $_GET['save_key'];
   	  $api_code = file_get_contents('nebular.auth.php');
   	  $api_encode = sha1($key);
   	  $key_entry = '"'.$api_encode.','.$key.'",'.$aux;
   	  $mutated_code = str_replace($aux,$key_entry,$api_code);
   	  $stabilizer =  "'".$key_entry."'";
   	  $saux = "'".$aux."'";
   	  $stable_code = str_replace($stabilizer,$saux,$mutated_code);
   	  file_put_contents('nebular.auth.php', $stable_code);
   	  // proceed auth
   	    $_SESSION['user'] = "detla";
   	    $_SESSION['password'] = "guest";
   }
}


if(isset($_GET['delete_key'])){
   $authkey = sha1($_GET['delete_key']).','.$_GET['delete_key'];
   if(!in_array($authkey,$api_keys)){
   	    $resdata = array(
   	    	"status" => "200",
   	    	"data" => "API does not exist."
   	    	);
   	    echo json_encode($resdata);
   	   exit();
   	}else{
        $rmkey = '"'.$authkey.'",';
        $m1 = file_get_contents('nebular.auth.php');
        $m2 = str_replace($rmkey,'',$m1);
        file_put_contents('nebular.auth.php',$m2);
   	 }
 }

$s1 = password_hash('root', PASSWORD_BCRYPT);
$s2 = password_hash('admin', PASSWORD_BCRYPT);




?>