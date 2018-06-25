<?php
/*
=================================================================================
|#|            _           _            |#| nebular DB  | v.0                 |#|
|#| _ __   ___| |__  _   _| | __ _ _ __ |#|---------------------------------- |#|
|#|| '_ \ / _ \ '_ \| | | | |/ _` | '__||#| experimental database application |#|
|#|| | | |  __/ |_) | |_| | | (_| | |   |#| using JS and PHP                  |#|
|#||_| |_|\___|_.__/ \__,_|_|\__,_|_|   |#| (c) Bryce Mercines 2018           |#|
=================================================================================
this project is opensource under MIT license, view it on github at:
https://github.com/quadroloop/nebular
*/

session_start();
header("Access-Control-Allow-Origin: *");
require('./nebular-src/nebular.auth.php');

$user = $_SESSION['user'];
$password = $_SESSION['password'];
$page = $_GET['p'];



// register api routes
$api_queries = array(
    "createdDB,get",
    "setObject,get",
    "putObject,get",
    "getObject,get",
    "deleteObject,get",
    "dropDB,get",
    "getStats,get"
    );




if(isset($_POST['uAuth'])){
    $usr1 = $_POST['usr1'];
    $usr2 = $_POST['usr2'];
    $psw1 = $_POST['psw1'];
    $psw2 = $_POST['psw2'];


   if($usr1 == $user && $psw1 == $password){
      $authfile = file_get_contents('./nebular-src/nebular.auth.php');
      $ou = "password_hash('".$usr1."', PASSWORD_BCRYPT);";
      $op = "password_hash('".$psw1."', PASSWORD_BCRYPT);";
      $nu = "password_hash('".$usr2."', PASSWORD_BCRYPT);";
      $np = "password_hash('".$psw2."', PASSWORD_BCRYPT);";
      $nauth1 = str_replace($ou,$nu,$authfile);
      $nauth2 = str_replace($op,$np,$nauth1);
      file_put_contents('./nebular-src/nebular.auth.php',$nauth2);
      if(isset($page)){
      echo '<script>
               window.location = "nebular.php?logout";
            </script>';
       }else{
         echo res('200','OK','Update Credetials Successfully!');
         exit();
       }     
   }else{
      if(isset($page)){
      echo '<script>
               window.location = "nebular.php?p=credentials";
            </script>';
       }else{
         echo res('500','Error','Auth Failed');
         exit();
       }     
   }

 exit();

}

// API-v0.2 Section, all DB processes go here..
function reqCapture() {
   $reqd = file_get_contents('./nebular-src/req.nebular');
       $reqadd = (int)$reqd+1;
       file_put_contents('./nebular-src/req.nebular',$reqadd);
}

//HTTP POST portions of the API
if(isset($_POST['api'])){
      if(isset($user) && isset($password)){
         $mquery = $_POST['api'];
             switch ($mquery) {
                  // creating an object
          case 'setObject' :
              if(isset($_POST['db_name']) || isset($_POST['name']) || isset($_POST['content'])){
                 reqCapture();
                 $dir = "./nebular-src/vm/".$_POST['db_name'].'/'.$_POST['name'];
                 file_put_contents($dir,$_POST['content']);
                 chmod($dir,0777);
                  echo res('200','OK','Object created successfully');
                 exit(); 
              }else{
                 echo res('400','Bad Request','Incompete Parameters');
                 exit();
              }   
          break;
           // append to object
          case 'putObject' :
              if(isset($_POST['db_name']) || isset($_POST['name']) || isset($_POST['content'])){
                 reqCapture();
                 $dir = "./nebular-src/vm/".$_POST['db_name'].'/'.$_POST['name'];
                 file_put_contents($dir,$_POST['content'],FILE_APPEND);
                  chmod($dir,0777);
                  echo res('200','OK','Data added to object successfully');
                 exit(); 
              }else{
                 echo res('400','Bad Request','Incompete Parameters');
                 exit();
              }   
          break;
           // get object
          case 'getObject' :
              if(isset($_POST['db_name']) && isset($_POST['name'])){
                 reqCapture();
                 $dir = "./nebular-src/vm/".$_POST['db_name'].'/'.$_POST['name'];
                  $data = file_get_contents($dir);
                  echo res('200','OK',$data);
                 exit(); 
              }else{
                 echo res('400','Bad Request','Incompete Parameters');
                 exit();
              }   
          break;
             }
      }else{
         echo res('500','Error','Bad Request Auth. failed.');
        exit();
      }
}

// all request is GET request.
if(isset($_GET['api'])){
   // check if auth is ok.
    if(isset($user) && isset($password)){
       $queryX = $_GET['api'];
       switch($queryX){
          //create a database
          case 'createDB' :
             if(isset($_GET['db_name'])){
                   reqCapture();
                   $db = $_GET['db_name'];
                   $dir = './nebular-src/vm/'.$db;
                       if(!is_dir($dir)){
                          mkdir($dir,0777,true);
                          echo res('200','ok','DB created successfully.');
                          exit();
                       }else{
                          echo res('401','Error','DB already exists');
                          exit();
                       }
                 }else{
                echo res('400','Bad Request','Incompete Parameters');
                exit();
             }
          break;
          // drop DB
           case 'dropDB' :
               if(isset($_GET['db_name'])){
                  reqCapture();
                  if(is_dir('./nebular-src/vm/'.$_GET['db_name'])){
                  $dir = './nebular-src/vm/'.$_GET['db_name'];
                   $dbs = glob($dir.'/*');
                   foreach ($dbs as $dobj) {
                      unlink($dobj);
                   }
                  rmdir($dir);
                  echo res('200','OK','Successfully drop Database.');
                 exit();
               }else{
                 echo res('400','Bad Request','DB doesnt exist.');
                 exit();
               }
               }else{
                 echo res('400','Bad Request','Incompete Parameters');
                 exit();
               }
           break;  
           // Delete Object
            case 'deleteObject' :
              if(isset($_GET['db_name']) && isset($_GET['name'])){
                 reqCapture();
                 $dir = "./nebular-src/vm/".$_GET['db_name'].'/'.$_GET['name'];
                   unlink($dir);
                  echo res('200','OK','Object Deleted.');
                 exit(); 
              }else{
                 echo res('400','Bad Request','Incompete Parameters');
                 exit();
              }   
          break;
          // get stats
          case 'getStats' :
              $db_count = 0;
              $object_count = 0;
              $query_count = count($api_queries);
               // count DB;
              $d1 = './nebular-src/vm/*';
              $dba = glob($d1);
                  foreach ($dba as $dbc) {
                      if(is_dir($dbc)){
                      $db_count++;
                      $d2 = './nebular-src/vm/*';
                          $obj = glob($d2);
                             foreach ($obj as $obji) {
                                 $object_count++;
                             }
                         }
                  }    
              //send reponse
              $stats = array(
                "db" => $db_count,
                "objects" => $object_count,
                "queries" => $query_count,
                "req" => (int)file_get_contents('./nebular-src/req.nebular')
                );
              echo json_encode($stats);
              exit();
          break;
         case 'getRequests' :
            $req1 = file_get_contents('./nebular-src/req.nebular');
            $req_type = explode('#',$req1);
            $res = array(
                "status" => "200 OK",
                "type" => $req_type[0],
                "data"=> htmlspecialchars($req_type[2])
              );
            echo json_encode($res);   
          break;  
          default :
              echo res('200','OK','Nebular API v. 0.1');
              exit();
       }
    }else{
        echo res('500','Error','Bad Request Auth. failed.');
        exit();
    }
    exit();
}

// end of API

//login 
$loguser = $_POST['username'];
$logpassword = $_POST['password'];
if(isset($loguser)){
   if (password_verify($loguser, $s1) && password_verify($logpassword, $s2)){
      $_SESSION['user'] = $loguser;
      $_SESSION['password'] = $logpassword;
      if(isset($page)){
      header('Location: nebular.php?p=dashboard');
      }else{
        echo res('200','OK','Session is active');
        exit();
      }
   }
}



//log out
if(isset($_GET['logout'])){
    session_destroy();
    header('Location: ?p=login');
}

// delete memory of requests file
if(isset($_GET['dreq'])){
   file_put_contents('./nebular-src/req.nebular',"0");
   header('location: ?p=dashboard');
}

// http responses
function res($code,$msg,$data){
    $resdata = array(
        "status" => $code,
        "message" => $msg,
        "data" => $data
        );
    return json_encode($resdata);
}

// init
checkAuthUI($page,$user,$password);


function checkAuthUI($req,$usr,$pass){     
    if(!isset($usr) || !isset($pass)){
        
        if($req != 'login'){
              header("Location: ?p=login");
              }       
    }else{
      //API restrictions
if($usr == 'delta' && $pass == 'APIv0'){
  echo "Nebular DB: Status Running. Access Level: API";
  exit();
}
    }
}




//remove directory slashes
function ndir($var) {
  return str_replace('./nebular-src/vm/', '', $var);
}

// select request color
function qcolor($req){
  switch($req){
    case 'post' :
        return 'w3-text-amber w3-small';
    break;
     case 'get' :
        return 'w3-text-light-green w3-small';
    break;
     case 'put' :
        return 'w3-text-blue w3-small';
    break;
     case 'delete' :
        return 'w3-text-red w3-small';
    break;
  }
 }
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />

    <title>Nebular</title>

    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
    <meta name="viewport" content="width=device-width" />
    <link rel="icon" href="./nebular-src/img/nebular-logo.png">
    <link href="./nebular-src/css/bootstrap.min.css" rel="stylesheet" />
    <link href="./nebular-src/css/animate.min.css" rel="stylesheet"/>
    <link href="./nebular-src/css/paper-dashboard.css" rel="stylesheet"/>
    <link href="./nebular-src/css/w3.css" rel="stylesheet"/>
    <link href="./nebular-src/css/demo.css" rel="stylesheet" />
    <link href="./nebular-src/css/themify-icons.css" rel="stylesheet">
    <script type="text/javascript" src="./nebular-src/js/sweet-alert2.js"></script>
    <script type="text/javascript" src="./nebular.api.js"></script>
    <script type="text/javascript" src="./nebular-src/js/nebular.ui.js"></script>

</head>
<body>

<?php
if($page == 'login'): ?>

    <div id="login">
       <center>
          <div class="login-container">
              <form action="nebular.php?p=dashboard" method="POST">
                <img src="./nebular-src/img/nebular.png" style="width:190px;margin:30px;"><br>
                <span class="text-dark">Nebular DB | Admin Login</span>
                <div class="w3-margin">
                    <input class="w3-input w3-border w3-round" name='username' placeholder="Username" required><br>
                     <input class="w3-input w3-border w3-round" name='password' placeholder="Password" type="password" required>
                </div>
                <button type="submit" class="w3-btn w3-black w3-round w3-margin">Log in</button><br>
                <a href="https://github.com/quadroloop/nebular">Quadroloop | Nebular v. 0.1</a>
             </form>   
          </div>
       </center> 
    </div>
    <script>
        window.onload = function() {
            var x = document.getElementsByTagName('input')[0].focus();
        }

    </script>
  </body>
  </html>       
 <?php 
    exit();
    endif;
 ?>

<div class="wrapper">
    <div class="sidebar" data-background-color="black" data-active-color="info">
        <div class="sidebar-wrapper">
            <div class="logo">
                <a href="https://github.com/quadroloop/nebular" class="simple-text">
                    <img src="./nebular-src/img/nebular.png" style="width:150px;">
                </a>
            </div>

            <ul class="nav">
                <li id="dashboard" onclick="nav(this);">
                    <a href="?p=dashboard">
                        <i class="ti-panel"></i>
                        <p>Dashboard</p>
                    </a>
                </li>
                <li id="databases" onclick="nav(this);">
                    <a href="?p=databases">
                        <i class="ti-server"></i>
                        <p>Databases</p>
                    </a>
                </li>
                <li id="credentials" onclick="nav(this);">
                    <a href="?p=credentials">
                        <i class="ti-view-list-alt"></i>
                        <p>Credentials</p>
                    </a>
                </li>
                <li id="api" onclick="nav(this);">
                    <a href="?p=api">
                        <i class="ti-bolt"></i>
                        <p>API</p>
                    </a>
                </li>
            </ul>
        </div>
    </div>
   <!-- end of sidebar -->
    <div class="main-panel">
        <nav class="navbar navbar-default">
            <div class="container-fluid">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar bar1"></span>
                        <span class="icon-bar bar2"></span>
                        <span class="icon-bar bar3"></span>
                    </button>
                    <a id="nav-head" class="navbar-brand" style="text-transform:capitalize;" href="#"><?php echo $page; ?></a>
                </div>
                <div class="collapse navbar-collapse">
                    <ul class="nav navbar-nav navbar-right">
                        <li class="dropdown">
                              <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                    <i class="ti-panel"></i>
                                    <p>Operations</p>
                                    <b class="caret"></b>
                              </a>
                              <ul class="dropdown-menu">
                                <li><a onclick="dbAdd();"><i class="ti-plus"></i> Add Database</a></li>
                                <li><a onclick="objAdd();"><i class="ti-plus"></i> Add Object</a></li>
                                <li><a onclick="logout();"><i class="ti-user"></i> Log out</a></li>

                              </ul>
                        </li>
                         <li class="dropdown">
                              <a class="dropdown-toggle" data-toggle="dropdown">
                                    <i class="ti-settings"></i>
                                    <p>Settings</p>
                                    <b class="caret"></b>
                              </a>
                              <ul class="dropdown-menu">
                                <li><a href="nebular.php?dreq"><i class="ti-trash"></i> Delete Request Memory</a></li>
                              </ul>
                        </li>
                    </ul>

                </div>
            </div>
        </nav>

     <?php 
       // Databases page
       if($page == 'databases'):
        ?>
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                   <?php
                   $db_focus = $_GET['db'];
                   $obj_edit = $_GET['edit'];
                  if(isset($db_focus)){
                      if(!file_exists('./nebular-src/vm/'.$obj_edit)){
                             echo '<p><i class="ti-check"></i> Object Deleted.</p>
                                    <script>window.location = "nebular.php?p=databases"</script>
                             ';
                             exit();
                           }
                      echo '<script>nb_DB = "'.$db_focus.'";</script>';
                      if(isset($obj_edit)){
                         echo '<script>nb_DB = "'.explode('/',$db_focus)[0].'";</script>';
                        echo '
                          <div class="col-lg-4 col-md-5">
                        <div class="card card-user w3-card-4">
                            <div class="image">
                                <img src="./nebular-src/img/network.gif" alt="..."/>
                            </div>
                            <div class="content">
                                <div class="author">
                                  <img class="avatar border-white" src="./nebular-src/img/object.gif" alt="..."/>
                                  <h4 class="title">'.$obj_edit.'<br />
                                     <a class="w3-text-blue"><small>nebular database object</small></a>
                                  </h4>
                                </div>
                                <p class="description text-center">
                                   Changes you make in this panel overwrites the changes before it.
                                </p>
                            </div>
                            <hr>
                            <div class="text-center">
                                <div class="row">
                                    <div class="col-md-3 col-md-offset-1">
                                        <br><a href="?p=databases&db='.explode('/',$db_focus)[0].'" class="btn btn-info">Back to DB</a><br>
                                    </div>
                                    <div class="col-md-3 col-md-offset-1">
                                        <br><a onclick="del(&apos;'.$obj_edit.'&apos;,&apos;1&apos;)" class="btn btn-danger"><i class="ti-trash"></i> Delete Object</a><br><br>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-8 col-md-7">
                        <div class="card w3-card-4">
                            <div class="header">
                                <h4 class="title"><i class="ti-bolt"></i> Update Object</h4>
                            </div>
                            <div class="content">
                                <form >
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="exampleInputEmail1">Object Name</label>
                                                <input id="ed0" type="text" name="name" class="form-control border-input" placeholder="Object Name" value="'.explode('/', $obj_edit)[1]
                                                .'">
                                                <input id="ed1" name="db_name" value="'.explode('/',$obj_edit)[0].'" class="w3-hide">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Content</label>
                                                <textarea id="ed3" rows="15" name="content" class="form-control border-input" placeholder="Object Content">'.htmlspecialchars(file_get_contents('./nebular-src/vm/'.$obj_edit)).'</textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="text-center">
                                        <button onclick="subnet();" class="btn btn-info btn-fill btn-wd"><i class="ti-bolt"></i> Update Object</button>
                                    </div>
                                    <div class="clearfix"></div>
                                </form>
                            </div>
                        ';
                        //editing object
                      }else{
                    echo '
                    <div class="w3-margin">
                      <div class="w3-bar w3-round w3-black">
                         <a class="w3-bar-item"><i class="ti-server"></i> '.$db_focus.'</a>
                         <input id="sdata" class="w3-bar-item w3-right w3-input w3-border w3-text-black" placeholder="Search" onkeyup="search();">
                       <div class="w3-dropdown-hover w3-right">
                         <button class="w3-button w3-hover-indigo"><i class="ti-settings"></i> Menu</button>
                           <div class="w3-dropdown-content w3-bar-block w3-card-4 w3-black" style="z-index:1000;">
                           <a onclick="objAdd();" class="w3-bar-item w3-button w3-hover-indigo"><i class="ti-plus"></i> Add Object</a>
                           <a onclick="del(&apos;'.$db_focus.'&apos;,&apos;2&apos;)" class="w3-bar-item w3-button  w3-hover-red"><i class="ti-trash"></i> Drop DB</a>
                       </div>
                      </div>
                      </div>
                    </div>
                        ';
    $obj_count = 0;
    $datafiles = "*";
    $directory = "./nebular-src/vm/".$db_focus."/";
     $dbs = glob($directory . $datafiles);
     echo '<ul id="dblist" style="list-style:none;" class="list-unstyled">';
    foreach($dbs as $db) {
                      echo '
                      <li class="w3-animate-opacity">
                      <a>
                       <div class="col-lg-3 col-sm-6">
                        <div class="card w3-card-2">
                            <div class="content">
                                <div class="row">
                                    <div class="col-xs-5">
                                        <div class="icon-big icon-info text-center">
                                            <i class="ti-wallet"></i>
                                        </div>
                                    </div>
                                    <div class="col-xs-7">
                                        <div class="numbers">
                                            <p>'.explode('/',$db)[4].'</p>
                                            '.rand(1,1000).'
                                        </div>
                                    </div>
                                </div>
                                <div class="footer">
                                    <hr />
                                    <div class="stats w3-small">
                                        <span class="w3-btn w3-indigo w3-round" onclick="location.href=&apos;?p=databases&db='.ndir($db).'&edit='.ndir($db).'&apos;"><i class="ti-pencil"></i> Edit</span>
                                        <span class="w3-btn w3-black w3-round" onclick="del(&apos;'.ndir($db).'&apos;,&apos;1&apos;)"><i class="ti-trash"></i> Delete</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    </a>
                    </li>
                      ';
                     $obj_count++; 
                  }
                   if($obj_count == 0) {
                    echo '
                    <div class="w3-margin">
                       <h4><i class="ti-wallet"></i> No Objects</h4>
                       <span>click here to <a class="w3-btn w3-border w3-round" onclick="objAdd();"><i class="ti-plus"></i> Add Object</a></span>
                    </div>
                    ';
                 } 
                 echo '</ul>'; 

                }  

                  }else {
     $db_count = 0;               
    $datafiles = "*";
    $directory = "./nebular-src/vm/";
     $dbs = glob($directory . $datafiles);
    foreach($dbs as $db)
    {
        if(is_dir($db)){
                      echo '
                       <div class="col-lg-3 col-sm-6">
                        <div class="card w3-card-4">
                            <div class="content">
                                <div class="row">
                                    <div class="col-xs-5">
                                        <div class="icon-big icon-warning text-center">
                                            <i class="ti-server"></i>
                                        </div>
                                    </div>
                                    <div class="col-xs-7">
                                        <div class="numbers">
                                            <p>'.ndir($db).'</p>
                                            '.rand(1,1000).'
                                        </div>
                                    </div>
                                </div>
                                <div class="footer">
                                    <hr />
                                    <div class="stats">
                                        <a class="btn btn-info" href="?p=databases&db='.ndir($db).'"><i class="ti-search"></i> Explore</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                      ';
                      $db_count++;
                  }
                  }
                  if($db_count == 0) {
                    echo '
                    <div class="w3-margin">
                       <h4><i class="ti-server"></i> No Databases</h4>
                       <span>click here to <a class="w3-btn w3-border w3-round" onclick="dbAdd();"><i class="ti-plus"></i> Add Database</a></span>
                    </div>
                    ';
                 } 
              }
                   ?>
                 </div>
             </div>  
            </div>      
   <?php endif; ?>
    

   <?php
     // Dashboard Page
    if($page == 'dashboard'):
   ?>
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-3 col-sm-6">
                        <div class="card w3-card-4">
                            <div class="content">
                                <div class="row">
                                    <div class="col-xs-5">
                                        <div class="icon-big icon-warning text-center">
                                            <i class="ti-server"></i>
                                        </div>
                                    </div>
                                    <div class="col-xs-7">
                                        <div class="numbers">
                                            <p>Databases</p>
                                            <span id="db"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="footer">
                                    <hr />
                                    <div class="stats">
                                        <i class="ti-reload"></i>Realtime
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-6">
                        <div class="card w3-card-4 w3-card-4">
                            <div class="content">
                                <div class="row">
                                    <div class="col-xs-5">
                                        <div class="icon-big icon-success text-center">
                                            <i class="ti-layout-accordion-list"></i>
                                        </div>
                                    </div>
                                    <div class="col-xs-7">
                                        <div class="numbers">
                                            <p>Segments</p>
                                            <span id="obj"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="footer">
                                    <hr />
                                    <div class="stats">
                                        <i class="ti-calendar"></i>Realtime
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-6">
                        <div class="card w3-card-4">
                            <div class="content">
                                <div class="row">
                                    <div class="col-xs-5">
                                        <div class="icon-big icon-danger text-center">
                                            <i class="ti-pulse"></i>
                                        </div>
                                    </div>
                                    <div class="col-xs-7">
                                        <div class="numbers">
                                            <p>Queries</p>
                                            <span id="q"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="footer">
                                    <hr />
                                    <div class="stats">
                                        <i class="ti-timer"></i> Realtime
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-6">
                        <div class="card w3-card-4">
                            <div class="content">
                                <div class="row">
                                    <div class="col-xs-5">
                                        <div class="icon-big icon-info text-center">
                                            <i class="ti-bolt"></i>
                                        </div>
                                    </div>
                                    <div class="col-xs-7">
                                        <div class="numbers">
                                            <p>Requests</p>
                                            <span id="req">0</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="footer">
                                    <hr />
                                    <div class="stats">
                                        <i class="ti-reload"></i> Realtime
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">

                    <div class="col-md-12 w3-hide-small">
                        <div class="card w3-card-4">
                            <div class="header">
                                <h4 class="title"><i class="ti-bolt"></i> Query Overview</h4>
                                <p class="category">Update Realtime</p>
                            </div>
                            <div class="content">
                              <!-- data -->
                                  <div class="w3-round w3-white w3-container w3-padding">
                                    <div id="container" style="width: 100%;">
                                    <canvas id="canvas"></canvas>
                                    </div>
                                  </div>
                              <!-- data end -->
                                <div class="footer">
                                    <hr>
                                    <div class="stats">
                                        <i class="ti-reload"></i> Updated 3 minutes ago
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script src="./nebular-src/js/chart.min.js"></script>
        <script src="./nebular-src/js/chart.utils.js"></script>
        <script type="text/javascript">
             setInterval(function(){
                     axios.get('nebular.php?api=getStats')
                       .then(function (response) {
                           document.getElementById('db').innerText = response.data['db'];
                           document.getElementById('obj').innerText = response.data['objects'];
                           document.getElementById('q').innerText = response.data['queries'];
                           var req_count = document.getElementById('req');
                           // document.getElementById('offset').innerHTML = response.data['req'];

                              if(req_count.innerText != response.data['req']){
                                 var delta = parseInt(req_count.innerText)+1;
                                 req_count.innerHTML = delta; 
                                 addData();
                              }

                      })
                        .catch(function (error) {
                          console.log(error);
                      });

             },200);
           var n=0;
            var MONTHS = ['Bt:1','Bt:2','Bt:3','Bt:4','Bt:5','Bt:6','Bt:7','Bt:8','Bt:9','Bt:10'];
    var color = Chart.helpers.color;
    var barChartData = {
      labels: ['Bt:1'],
      datasets: [{
        label: 'Bt: GET',
        backgroundColor: color(window.chartColors.red).alpha(0.5).rgbString(),
        borderColor: window.chartColors.red,
        borderWidth: 1,
        data: [
         
        ]
      }, {
        label: 'Bt: POST',
        backgroundColor: color(window.chartColors.blue).alpha(0.5).rgbString(),
        borderColor: window.chartColors.blue,
        borderWidth: 1,
        data: [
          
        ]
      }]

    };

    window.onload = function() {
      var ctx = document.getElementById('canvas').getContext('2d');
      window.myBar = new Chart(ctx, {
        type: 'bar',
        data: barChartData,
        options: {
          responsive: true,
          legend: {
            position: 'top',
          },
          title: {
            display: true,
            text: 'API requests'
          }
        }
      });

    };

   
    var colorNames = Object.keys(window.chartColors);
    

    function addData() {
      if (barChartData.datasets.length > 0) {
        var month = MONTHS[barChartData.labels.length % MONTHS.length];
        barChartData.labels.push(month);

        for (var index = 0; index < barChartData.datasets.length; ++index) {
          barChartData.datasets[index].data.push(randomScalingFactor());
        }
        window.myBar.update();
      }

    }

   
        </script>     
       <?php endif; ?>

       <?php if($page == 'credentials'): ?>
           <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-4 col-md-5">
                        <div class="card card-user w3-card-4">
                            <div class="image">
                                <img src="./nebular-src/img/user_cover.gif"  alt="..."/>
                            </div>
                            <div class="content">
                                <div class="author">
                                  <img class="avatar border-white bg-avatar" src="./nebular-src/img/ghost.gif" alt="..."/>
                                  <h4 class="title"><?php echo $user; ?><br />
                                     <a href="#"><small>Nebular DB User</small></a>
                                  </h4>
                                </div>
                                <p class="description text-center">
                                  Administrator
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-8 col-md-7">
                        <div class="card w3-card-4">
                            <div class="header">
                                <h4 class="title"><i class="ti-user"></i> Update Credentials</h4>
                            </div>
                            <div class="content">
                                 <form action="nebular.php?p" method="POST">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Current Username</label>
                                                <input type="text" name="usr1" class="form-control border-input" placeholder="Current Username" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Current Password</label>
                                                <input type="password" name="psw1" class="form-control border-input" placeholder="Current Password" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                      <div class="col-md-6">
                                            <div class="form-group">
                                                <label>New Username</label>
                                                <input type="text" name="usr2" class="form-control border-input" placeholder="New Username" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>New Password</label>
                                                <input type="password" name="psw2" class="form-control border-input" placeholder="New Password" required>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>API Key</label>
                                                <input type="text" class="form-control border-input" placeholder="API Key" name="uAuth" value="<?php echo password_hash("rasmuslerdorf", PASSWORD_DEFAULT); ?>">
                                            </div>
                                        </div>
                                    </div>


                                    <div class="text-center">
                                        <button class="btn btn-info btn-fill btn-wd" type="submit"><i class="ti-bolt"></i> Update Credentials</button>
                                    </div>
                                    <div class="clearfix"></div>
                                 </form>   
                            </div>
                        </div>
                    </div>


                </div>
            </div>
        </div>

       <?php endif; ?>

       <?php
         // api page
         if($page == 'api'):
       ?>
         <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-4 col-md-5">
                        <div class="card card-user w3-card-4">
                            <div class="image">
                                <img src="./nebular-src/img/graph.gif"  alt="..."/>
                            </div>
                            <div class="content">
                                <div class="author">
                                  <img class="avatar border-white bg-avatar" src="./nebular-src/img/geometry.gif" alt="..."/>
                                  <h4 class="title">Nebular API<br />
                                     <a href="#"><small>Nebular DB version 0.1</small></a>
                                  </h4>
                                </div>
                                <p class="description text-center">
                                    Nebular API overview.
                                </p>
                            </div>
                            <hr>
                            <div class="text-center">
                                <div class="row">
                                    <div class="w3-margin">
                                        <a href="nebular.api.js" download="nebular.api.js" class="btn btn-warning"><i class='ti-download'></i> Download JS file</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
             
                    </div>
                    <div class="col-lg-8 col-md-7">
                        <div class="card w3-card-4">
                            <div class="header">
                                <h4 class="title"><i class="ti-bolt"></i>Nebular API Key</h4>
                            </div>
                            <div class="content">
                                   <!-- queries -->
                                      <ul class="w3-ul w3-border w3-round">
                                          <?php
                                          foreach ($api_keys as $q) {
                                               $query = explode(',', $q);
                                               echo '
                                               <li class="w3-bar" title="'.$query[1].'" onclick="manage_key(this.title)">
      <img src="./nebular-src/img/query.gif" class="w3-bar-item w3-circle w3-hide-small" style="width:85px">
      <div class="w3-bar-item">
        <span class="w3-large"><i class="ti-bolt w3-text-blue"></i> '.substr($query[0],0,8).'</span><br>
        <span class="'.qcolor($query[1]).' w3-small w3-text-grey"><i class="ti-panel"></i> '.strtoupper($query[1]).'</span>
      </div>
    </li>
                                               ';
                                           } 
                                          ?>
                                      </ul>
                                      <br>
                                      <br>
                                     
                                   <!-- end of queries -->
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label><i class="ti-bolt"></i> Register API Key</label>
                                                <br>
                                                <br>
                                                <input type="text" id=key class="form-control border-input" placeholder="New API Key">
                                            </div>
                                        </div>
                                    </div>


                                    <div class="text-center">
                                        <button type="button" onclick="addKey();" class="btn btn-info btn-fill btn-wd"><i class="ti-bolt"></i> Register API Key</button>
                                    </div>
                                    <div class="clearfix"></div>
                            </div>
                        </div>
                    </div>


                </div>
            </div>
        </div>
       <?php endif; ?>


        <footer class="footer">
            <div class="container-fluid">
                <nav class="pull-left">
                    <ul>

                        <li>
                            <a href="https://github.com/quadroloop/nebular">
                                Nebular v. 0.1 | Quadroloop
                            </a>
                        </li>
                    </ul>
                </nav>
                <div class="copyright pull-right">
                    &copy; <script>document.write(new Date().getFullYear())</script>, paper-dashboard by <a href="http://www.creative-tim.com">Creative Tim</a>
                </div>
            </div>
        </footer>

    </div>
</div>
</body>

    <!--   Core JS Files   -->
    <script src="./nebular-src/js/jquery-1.10.2.js" type="text/javascript"></script>

    <script src="./nebular-src/js/bootstrap.min.js" type="text/javascript"></script>

   
    <!-- Paper Dashboard Core javascript and methods for Demo purpose -->
    <script src="./nebular-src/js/paper-dashboard.js"></script>

    <!-- Paper Dashboard DEMO methods, don't include it in your project! -->
    <script src="./nebular-src/js/demo.js"></script>

    <script type="text/javascript">
      
        function nav(menu){
            document.getElementsByClassName('active')[0].classList.remove('active'); 
            menu.classList.add('active');
        }


        function search(){          
    // Declare variables
    var input, filter, ul, li, a, i;
    input = document.getElementById('sdata');
    filter = input.value.toUpperCase();
    ul = document.getElementById("dblist");
    li = ul.getElementsByTagName('li');

    // Loop through all list items, and hide those who don't match the search query
    for (i = 0; i < li.length; i++) {
        a = li[i].getElementsByTagName("a")[0];
        if (a.innerHTML.toUpperCase().indexOf(filter) > -1) {
            li[i].style.display = "";
        } else {
            li[i].style.display = "none";
        }
    }
        }
    </script>

    <?php echo '
      <script>
         document.getElementById("'.$page.'").classList.add("active");
      </script>
    '; ?>

</html>

