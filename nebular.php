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

@$put = $_GET['p'];
if(isset($put)){
  file_put_contents('./nsrc/db.nb', $put);
 exit(); 
}

//get data from database
@$get = $_GET['get'];
  if(isset($get)) {
    $age = array("Peter"=>"35", "Ben"=>"37", "Joe"=>"43");
    echo $age[$get];
    exit();
  }

?>


<html>
<title>Nebular</title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<script src="./nsrc/js/jquery.js"></script>
<script src="./nsrc/js/sweet-alert2.js"></script>
<link rel="stylesheet" href="./nsrc/css/w3.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/ace/1.2.9/ace.js"></script>
<script src="./nsrc/js/axios.min.js"></script>
<link rel="stylesheet" href="./nsrc/css/font-awesome.min.css">
<link rel="icon" href="./img/icon.png">
<link rel="stylesheet" href="./nsrc/css/perfect-scrollbar.css">
<link rel="stylesheet" href="./nsrc/css/nebular.css">
<body>




<div class="w3-sidebar w3-bar-block w3-card w3-animate-left w3-text-white dark-border-right" style="display:none;background-color:#272822;overflow: auto;" id="mySidebar">
  <button class="w3-bar-item w3-button w3-large w3-hover-black"><center><img src="nebular.png" class="crest-logo"></center></button>
    <div class="w3-bar dark-border-top dark-border-bottom">
        <!--small navbar-->
        <a class="w3-bar-item w3-center"><i class="w3-button w3-hover-indigo fa fa-bars w3-text-grey w3-round" onclick="nav('tools');"></i><i class="w3-round w3-button w3-hover-indigo fa fa-gear w3-text-grey" onclick="nav('settings');"></i><i class="w3-round w3-button w3-hover-indigo fa fa-chevron-circle-left w3-text-grey"  onclick="w3_close()"></i></a>
      </div>
  <div id="tab" class="w3-small">
      <!--tools tab-->
      <a id="tool_state" class="dark-border w3-round w3-padding-small w3-text-grey tool_state"><i class="fa fa-database w3-text-grey"></i> DATABASES</a>
      <div id="tools" class="w3-animate-left">
         <a onclick="nav('dashboard');" class="w3-bar-item w3-text-grey w3-button w3-hover-indigo"><i class="fa fa-area-chart w3-text-amber"></i> Dashboard</a>
         <a onclick="nav('editor');"class="w3-bar-item w3-button w3-hover-indigo w3-text-grey"><i class="fa fa-sitemap w3-text-blue"></i> Import Database</a>
         <a onclick="nav('addDB')" class="w3-bar-item w3-button w3-hover-indigo w3-text-grey"><i class="fa fa-plus-circle w3-text-blue"></i> Add database</a>
         <a class="dark-border w3-round w3-padding-small w3-text-grey tool_state"><i class="fa fa-slack w3-text-grey"></i> API</a>
         <a onclick="api_POST();" class="w3-bar-item w3-button w3-hover-indigo w3-text-pink"><i class="fa fa-circle"></i> POST</a>
         <a onclick="api_GET();" class="w3-bar-item w3-button w3-hover-indigo w3-text-blue"><i class="fa fa-circle"></i> GET</a>
         <a onclick="api_SEND();" class="w3-bar-item w3-button w3-hover-indigo w3-text-amber"><i class="fa fa-circle"></i> SEND</a>
        <a onc lick="api_listen()" class="w3-bar-item w3-button w3-hover-indigo w3-text-green"><i class="fa fa-hashtag"></i> LISTEN</a>
         <a class="dark-border w3-round w3-padding-small w3-text-grey tool_state"><i class="fa fa-folder-open w3-text-grey"></i> FILE</a>
         <a onclick="save();" class="w3-bar-item w3-button w3-hover-indigo w3-text-pink"><i class="fa fa-file"></i> SAVE</a>
         <a onclick="upload();" class="w3-bar-item w3-button w3-hover-indigo w3-text-blue"><i class="fa fa-upload"></i> UPLOAD</a>
          <a class="dark-border w3-round w3-padding-small w3-text-grey tool_state"><i class="fa fa-user w3-text-grey"></i> USER</a>
         <a onclick="save();" class="w3-bar-item w3-button w3-hover-indigo w3-text-white"><i class="fa fa-user-times w3-text-blue"></i> Log out</a>
      </div>
      <!--end of tools tab-->
      <!--settings tab-->
      <div id="settings" class="w3-animate-left">
          <a href="#" class="w3-bar-item w3-button w3-hover-purble w3-text-grey"><i class="fa fa-toggle-on w3-text-blue"></i> Incremental binding</a>
          <a href="#" class="w3-bar-item w3-button w3-hover-indigo w3-text-grey"><i class="fa fa-toggle-on w3-text-blue"></i> Data Logging</a>
          <a href="#" class="w3-bar-item w3-button w3-hover-indigo w3-text-grey"><i class="fa fa-toggle-off w3-text-grey"></i> Online Save</a>
          <a href="#" class="w3-bar-item w3-button w3-hover-indigo w3-text-grey"><i class="fa fa-bullseye w3-text-yellow"></i> View Commands</a>
          <a href="#" class="w3-bar-item w3-button w3-hover-indigo w3-text-blue"><i class="fa fa-tasks w3-text-yellow"></i> View Config</a>
          <a href="#" class="w3-bar-item w3-button w3-hover-indigo w3-text-blue"><i class="fa fa-navicon w3-text-yellow"></i> Export Settings</a>
          <a href="#" class="w3-bar-item w3-button w3-hover-indigo w3-text-blue"><i class="fa fa-braille w3-text-yellow"></i> Import Settings</a>
          <a class="dark-border w3-round w3-padding-small w3-text-grey tool_state"><i class="fa fa-terminal w3-text-grey"></i> CODE &amp; EDITOR</a>
          <a onclick="set_editor();" class="w3-bar-item w3-button w3-hover-indigo w3-text-pink"><i class="fa fa-cogs"></i> Set Preferences</a>
          <a class="dark-border w3-round w3-padding-small w3-text-grey tool_state"><i class="fa fa-hashtag w3-text-grey"></i> ABOUT</a>
      </div>
  </div>
</div>

<div id="main" style="position:fixed;">
<!--responsive body of document-->
  <div id="editor"></div>
  <div id="datatable" class="w3-animate-opacity">
  <div class="w3-top">
    <div class="w3-bar dark-border-bottom bg-dark">
       <a class="w3-text-blue w3-bar-item"><i class="fa fa-connectdevelop w3-spin"></i> Database Name</a>
       <div class="w3-dropdown-hover">
   <button class="w3-btn w3-text-white w3-hover-indigo dark-border-left dark-border-right"><i class="fa fa-chevron-down"></i> DB Sections</button>
   <div class="w3-dropdown-content w3-bar-block w3-card-4 bg-dark w3-text-white">
     <a href="#" class="w3-bar-item w3-btn">Link 1</a>
     <a href="#" class="w3-bar-item w3-btn">Link 2</a>
     <a href="#" class="w3-bar-item w3-btn">Link 3</a>
   </div>
 </div>
    </div>
  </div>
    <br>
    <br>
    <table class="nb-table w3-small w3-hoverable w3-margin" id="dbtable">
      <!--table headers-->
    <tr>
      <th>First Name</th>
      <th>Last Name</th>
      <th>Points</th>
      <th>First Name</th>
      <th>Last Name</th>
      <th>Points</th>
      <th>First Name</th>
      <th>Last Name</th>
      <th>Points</th>
      <th>First Name</th>
      <th>Last Name</th>
      <th>Points</th>
    </tr>
    <!--table headers-->
    <!--table data-->
     <?php
     /*
      $i = 0;
      while($i < 100) {
        echo '<tr><td>Bryce</td><td>Smith</td><td>50</td><td>Jill</td><td>Smith</td><td>50</td><td>Jill</td><td>Smith</td><td>50</td><td>Jill</td><td>Smith</td><td>50</td></tr>';
       $i++;
      }
      */

     ?>


  </table>
  </div>
  <div id="dashboard" class="w3-animate-opacity">
    <div class="w3-row w3-small">

      <ul id="dtable" style="list-style:none;">
</ul>
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
    <input id="search" class="w3-text-white w3-input w3-bar-item w3-round dark-border w3-margin" onkeyup="search(cdb,pointer);" placeholder="Search Database" type="text" style="width:800px;background-color:rgb(1, 6, 34);">
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


<script src="./nsrc/js/perfect-scrollbar.js"></script>
<script src="./nsrc/js/nebular.js"></script>

<script>
var editor = ace.edit("editor");
    editor.setTheme("ace/theme/monokai");
    editor.getSession().setMode("ace/mode/php");
</script>


</body>
</html>
