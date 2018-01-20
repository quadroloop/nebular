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

?>


<html>
<title>Nebular</title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.0.7/sweetalert2.all.js"></script>
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/ace/1.2.9/ace.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="icon" href="./img/icon.png">
<link rel="stylesheet" href="https://rawgit.com/utatti/perfect-scrollbar/master/css/perfect-scrollbar.css">
<body>

<style>
/*nebular.css styles */
  
html, body{
    height: 99%;
    overflow: auto;
}

body {
    background-color:#272822;
}

.dark-border-0{border:0!important}.dark-border{border:1px solid #3A3A3A!important}
.dark-border-top{border-top:1px solid #3A3A3A!important}.dark-border-bottom{border-bottom:1px solid #3A3A3A!important}
.dark-border-left{border-left:1px solid #3A3A3A!important}.dark-border-right{border-right:1px solid #3A3A3A!important}

.crest-logo {
    width: 130px;
}

#editor { 
       width: 70%;
       height: 88%;
       top: 0;
       position: fixed;
       display: none;
    }

#dashboard { 
       width: 70%;
       height: 88%;
       top: 0;
       position: fixed;
    }    

    

    .data_log { 
       width: 20%;
       height: 88%;
       overflow: auto;
       top: 0;
       bottom: 0;
       right:0;
       position: fixed;
       background-color: #272822;
    }

  #logs {
  }  


.dash-switch-btn{border:none;display:inline-block;outline:0;padding:8px 16px;vertical-align:middle;overflow:hidden;text-decoration:none;color:inherit;background-color:inherit;text-align:center;cursor:pointer;white-space:nowrap}
.dash-switch-btn:hover{box-shadow:none;}
.dash-switch-btn{-webkit-touch-callout:none;-webkit-user-select:none;-khtml-user-select:none;-moz-user-select:none;-ms-user-select:none;user-select:none}   
.dash-switch-btn:disabled,{cursor:not-allowed;opacity:0.3}
.dash-switch-btn,.dash-switch-btn:disabled:hover{box-shadow:none}

.tool_state {
    margin:10px;
    float: left;
    }

#settings {
  display: none;
}

#file_holder {
  display:none;
  color: gainsboro;
  background: #333 !important;
}

#file_holder::-webkit-file-upload-button {
  visibility: hidden;
}


#mySidebar {
    height: 100%;
}

</style>


<div class="w3-sidebar w3-bar-block w3-card w3-animate-left w3-text-white dark-border-right" style="display:none;background-color:rgb(34, 44, 40); overflow: auto;" id="mySidebar">
  <button class="w3-bar-item w3-button w3-large w3-hover-black"><center><img src="nebular.jpg" class="crest-logo"></center></button>
    <div class="w3-bar dark-border-top dark-border-bottom">
        <!--small navbar-->
        <a class="w3-bar-item w3-center"><i class="w3-button w3-hover-purple fa fa-bars w3-text-grey w3-round" onclick="open_tools();"></i><i class="w3-round w3-button w3-hover-purple fa fa-gear w3-text-grey" onclick="open_settings();"></i><i class="w3-round w3-button w3-hover-purple fa fa-chevron-circle-left w3-text-grey"  onclick="w3_close()"></i></a>
      </div>
  <div id="tab" class="w3-small">
      <!--tools tab-->
      <a id="tool_state" class="dark-border w3-round w3-padding-small w3-text-grey tool_state"><i class="fa fa-database w3-text-grey"></i> DATABASES</a>
      <div id="tools" class="w3-animate-left">
         <a onclick="tag_history();" class="w3-bar-item w3-text-grey w3-button w3-hover-purple"><i class="fa fa-area-chart w3-text-amber"></i> Open Tag History</a>
         <a onclick="import_template();" class="w3-bar-item w3-button w3-hover-purple w3-text-grey"><i class="fa fa-copy w3-text-blue"></i> Import Template Code</a>
         <a onclick="clearcode();" class="w3-bar-item w3-button w3-hover-purple w3-text-grey"><i class="fa fa-refresh w3-text-red"></i> Clear</a>
         <a class="dark-border w3-round w3-padding-small w3-text-grey tool_state"><i class="fa fa-slack w3-text-grey"></i> API</a>
         <a onclick="api_POST();" class="w3-bar-item w3-button w3-hover-purple w3-text-pink"><i class="fa fa-circle"></i> POST</a>
         <a onclick="api_GET();" class="w3-bar-item w3-button w3-hover-purple w3-text-blue"><i class="fa fa-circle"></i> GET</a>
         <a onclick="api_SEND();" class="w3-bar-item w3-button w3-hover-purple w3-text-amber"><i class="fa fa-circle"></i> SEND</a>
         <a onclick="api_listen()" class="w3-bar-item w3-button w3-hover-purple w3-text-green"><i class="fa fa-hashtag"></i> LISTEN</a>
         <a class="dark-border w3-round w3-padding-small w3-text-grey tool_state"><i class="fa fa-folder-open w3-text-grey"></i> FILE</a>
         <a onclick="save();" class="w3-bar-item w3-button w3-hover-purple w3-text-pink"><i class="fa fa-file"></i> SAVE</a>
         <a onclick="upload();" class="w3-bar-item w3-button w3-hover-purple w3-text-blue"><i class="fa fa-upload"></i> UPLOAD</a>
         <input id="file_holder" type="file">
      </div>
      <!--end of tools tab-->
      <!--settings tab-->
      <div id="settings" class="w3-animate-left">
          <a href="#" class="w3-bar-item w3-button w3-hover-purble w3-text-grey"><i class="fa fa-toggle-on w3-text-blue"></i> Incremental binding</a>
          <a href="#" class="w3-bar-item w3-button w3-hover-purple w3-text-grey"><i class="fa fa-toggle-on w3-text-blue"></i> Data Logging</a>
          <a href="#" class="w3-bar-item w3-button w3-hover-purple w3-text-grey"><i class="fa fa-toggle-off w3-text-grey"></i> Online Save</a>
          <a href="#" class="w3-bar-item w3-button w3-hover-purple w3-text-grey"><i class="fa fa-bullseye w3-text-yellow"></i> View Commands</a>
          <a href="#" class="w3-bar-item w3-button w3-hover-purple w3-text-blue"><i class="fa fa-tasks w3-text-yellow"></i> View Config</a>
          <a href="#" class="w3-bar-item w3-button w3-hover-purple w3-text-blue"><i class="fa fa-navicon w3-text-yellow"></i> Export Settings</a>
          <a href="#" class="w3-bar-item w3-button w3-hover-purple w3-text-blue"><i class="fa fa-braille w3-text-yellow"></i> Import Settings</a>
          <a class="dark-border w3-round w3-padding-small w3-text-grey tool_state"><i class="fa fa-terminal w3-text-grey"></i> CODE &amp; EDITOR</a>
          <a onclick="set_editor();" class="w3-bar-item w3-button w3-hover-purple w3-text-pink"><i class="fa fa-cogs"></i> Set Preferences</a>
          <a class="dark-border w3-round w3-padding-small w3-text-grey tool_state"><i class="fa fa-hashtag w3-text-grey"></i> ABOUT</a>

      </div>
  </div>
</div>

<div id="main" style="position:fixed;">
<!--responsive body of document-->
  <div id="editor"></div>
  <div id="dashboard">
      <div class="w3-container dark-border" style="border-radius:5px;width:250px;margin:30px;">
         <p class="w3-text-white"><i class="w3-text-blue fa fa-database"></i> Schema_database</p>
      </div><div class="w3-container dark-border" style="border-radius:5px;width:250px;margin:30px;">
         <p class="w3-text-white"><i class="w3-text-blue fa fa-database"></i> Schema_database</p>
      </div>
      <div class="w3-container dark-border" style="border-radius:5px;width:250px;margin:30px;">
         <p class="w3-text-white"><i class="w3-text-blue fa fa-database"></i> Schema_database</p>
      </div>
      <div class="w3-container dark-border" style="border-radius:5px;width:250px;margin:30px;">
         <p class="w3-text-white"><i class="w3-text-blue fa fa-database"></i> Schema_database</p>
      </div>
      <div class="w3-container dark-border" style="border-radius:5px;width:250px;margin:30px;">
         <p class="w3-text-white"><i class="w3-text-blue fa fa-database"></i> Schema_database</p>
      </div>
      <div class="w3-container dark-border" style="border-radius:5px;width:250px;margin:30px;">
         <p class="w3-text-white"><i class="w3-text-blue fa fa-database"></i> Schema_database</p>
      </div>
      <div class="w3-container dark-border" style="border-radius:5px;width:250px;margin:30px;">
         <p class="w3-text-white"><i class="w3-text-blue fa fa-database"></i> Schema_database</p>
      </div>
      <div class="w3-container dark-border" style="border-radius:5px;width:250px;margin:30px;">
         <p class="w3-text-white"><i class="w3-text-blue fa fa-database"></i> Schema_database</p>
      </div>
      <div class="w3-container dark-border" style="border-radius:5px;width:250px;margin:30px;">
         <p class="w3-text-white"><i class="w3-text-blue fa fa-database"></i> Schema_database</p>
      </div>
      <div class="w3-container dark-border" style="border-radius:5px;width:250px;margin:30px;">
         <p class="w3-text-white"><i class="w3-text-blue fa fa-database"></i> Schema_database</p>
      </div>
      <div class="w3-container dark-border" style="border-radius:5px;width:250px;margin:30px;">
         <p class="w3-text-white"><i class="w3-text-blue fa fa-database"></i> Schema_database</p>
      </div>
      <div class="w3-container dark-border" style="border-radius:5px;width:250px;margin:30px;">
         <p class="w3-text-white"><i class="w3-text-blue fa fa-database"></i> Schema_database</p>
      </div>
      <div class="w3-container dark-border" style="border-radius:5px;width:250px;margin:30px;">
         <p class="w3-text-white"><i class="w3-text-blue fa fa-database"></i> Schema_database</p>
      </div>
      <div class="w3-container dark-border" style="border-radius:5px;width:250px;margin:30px;">
         <p class="w3-text-white"><i class="w3-text-blue fa fa-database"></i> Schema_database</p>
      </div>
  </div>


    <div class="data_log dark-border">
       <div class="w3-bar dark-border-bottom">
           <a class="w3-bar-item w3-text-grey w3-small"><i class="fa fa-slack w3-text-blue"></i> Data Logs | </a>
        </div>
          <div id="logs" style="margin-left: 10px" class="w3-small"></div>
   </div>
<div class="position:fixed">
<div class="w3-bottom">
 <div class="w3-bar dark-border-top" style="background-color:#272822;">
    <input id="data" class="w3-text-white w3-input w3-bar-item w3-round dark-border w3-margin" placeholder="Command Here.." type="text" style="width:800px;background-color:rgb(1, 6, 34);">
    <a id="open-db" class="dash-switch-btn w3-text-white w3-small w3-round w3-margin" onclick="w3_open()"><i class="fa fa-chevron-circle-right fa-2x"></i></a>
 </div>
</div> 
</div>

<!--code container-->

<!--identifiers-->
<div style="display:none">
<input title="Case Sensitive" type="checkbox" id="globl" CHECKED />Global matching.
<input title="Case Sensitive" type="checkbox" id="case_sen" />Case sensitive.
</div>

</div>

<!-- file input -->


<script src="https://rawgit.com/utatti/perfect-scrollbar/master/dist/perfect-scrollbar.js"></script>
<script>
  // Nebular.css Javascript


var ps = new PerfectScrollbar('#mySidebar');
var ps1 = new PerfectScrollbar('.data_log');

 $( document ).ready(function() {
      var editorscroll = new PerfectScrollbar('.ace_scrollbar');
      var editorscroll_h = new PerfectScrollbar('.ace_scrollbar-h');
    });

function w3_open() {
  document.getElementById("main").style.marginLeft = "15%";
  document.getElementById("mySidebar").style.width = "15%";
  document.getElementById("mySidebar").style.display = "block";
}
function w3_close() {
  document.getElementById("main").style.marginLeft = "0%";
  document.getElementById("mySidebar").style.display = "none";
}



window.onload = function() {
  setTimeout("w3_open()",500); // open dashboard
  document.getElementById("data").focus(); // focus on command bar..
}
</script>   


<iframe src="" id="api-frame" onload="api_response();" style="display:none;"></iframe>
<textarea id="api-base" style="display:none;"></textarea>

<script> 
var editor = ace.edit("editor");
    editor.setTheme("ace/theme/monokai");
    editor.getSession().setMode("ace/mode/php");


</script>


</body>
</html>