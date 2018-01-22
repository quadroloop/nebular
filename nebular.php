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
<script src="./nsrc/js/jquery.js"></script>
<script src="./nsrc/js/sweet-alert2.js"></script>
<link rel="stylesheet" href="./nsrc/css/w3.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/ace/1.2.9/ace.js"></script>
<link rel="stylesheet" href="./nsrc/css/font-awesome.min.css">
<link rel="icon" href="./img/icon.png">
<link rel="stylesheet" href="./nsrc/css/perfect-scrollbar.css">
<link rel="stylesheet" href="./nsrc/css/nebular.css">
<body>


<div class="w3-sidebar w3-bar-block w3-card w3-animate-left w3-text-white dark-border-right" style="display:none;background-color:#272822;overflow: auto;" id="mySidebar">
  <button class="w3-bar-item w3-button w3-large w3-hover-black"><center><img src="nebular.png" class="crest-logo"></center></button>
    <div class="w3-bar dark-border-top dark-border-bottom">
        <!--small navbar-->
        <a class="w3-bar-item w3-center"><i class="w3-button w3-hover-indigo fa fa-bars w3-text-grey w3-round" onclick="open_tools();"></i><i class="w3-round w3-button w3-hover-indigo fa fa-gear w3-text-grey" onclick="open_settings();"></i><i class="w3-round w3-button w3-hover-indigo fa fa-chevron-circle-left w3-text-grey"  onclick="w3_close()"></i></a>
      </div>
  <div id="tab" class="w3-small">
      <!--tools tab-->
      <a id="tool_state" class="dark-border w3-round w3-padding-small w3-text-grey tool_state"><i class="fa fa-database w3-text-grey"></i> DATABASES</a>
      <div id="tools" class="w3-animate-left">
         <a onclick="dboard();" class="w3-bar-item w3-text-grey w3-button w3-hover-indigo"><i class="fa fa-area-chart w3-text-amber"></i> Dashboard</a>
         <a onclick="import_template();" class="w3-bar-item w3-button w3-hover-indigo w3-text-grey"><i class="fa fa-sitemap w3-text-blue"></i> Import Database</a>
         <a onclick="clearcode();" class="w3-bar-item w3-button w3-hover-indigo w3-text-grey"><i class="fa fa-refresh w3-text-red"></i> Clear</a>
         <a class="dark-border w3-round w3-padding-small w3-text-grey tool_state"><i class="fa fa-slack w3-text-grey"></i> API</a>
         <a onclick="api_POST();" class="w3-bar-item w3-button w3-hover-indigo w3-text-pink"><i class="fa fa-circle"></i> POST</a>
         <a onclick="api_GET();" class="w3-bar-item w3-button w3-hover-indigo w3-text-blue"><i class="fa fa-circle"></i> GET</a>
         <a onclick="api_SEND();" class="w3-bar-item w3-button w3-hover-indigo w3-text-amber"><i class="fa fa-circle"></i> SEND</a>
         <a onclick="api_listen()" class="w3-bar-item w3-button w3-hover-indigo w3-text-green"><i class="fa fa-hashtag"></i> LISTEN</a>
         <a class="dark-border w3-round w3-padding-small w3-text-grey tool_state"><i class="fa fa-folder-open w3-text-grey"></i> FILE</a>
         <a onclick="save();" class="w3-bar-item w3-button w3-hover-indigo w3-text-pink"><i class="fa fa-file"></i> SAVE</a>
         <a onclick="upload();" class="w3-bar-item w3-button w3-hover-indigo w3-text-blue"><i class="fa fa-upload"></i> UPLOAD</a>
         <input id="file_holder" type="file">
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
  <div id="datatable">
    <table class="nb-table w3-small w3-hoverable w3-margin">
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
    <tr>
      <td>Jill</td>
      <td>Smith</td>
      <td>50</td>
      <td>Jill</td>
      <td>Smith</td>
      <td>50</td>
      <td>Jill</td>
      <td>Smith</td>
      <td>50</td>
      <td>Jill</td>
      <td>Smith</td>
      <td>50</td>
    </tr>
    <tr>
      <td>Jill</td>
      <td>Smith</td>
      <td>50</td>
      <td>Jill</td>
      <td>Smith</td>
      <td>50</td>
      <td>Jill</td>
      <td>Smith</td>
      <td>50</td>
      <td>Jill</td>
      <td>Smith</td>
      <td>50</td>
    </tr>
    <tr>
      <td>Jill</td>
      <td>Smith</td>
      <td>50</td>
      <td>Jill</td>
      <td>Smith</td>
      <td>50</td>
      <td>Jill</td>
      <td>Smith</td>
      <td>50</td>
      <td>Jill</td>
      <td>Smith</td>
      <td>50</td>
    </tr>
    <tr>
      <td>Jill</td>
      <td>Smith</td>
      <td>50</td>
      <td>Jill</td>
      <td>Smith</td>
      <td>50</td>
      <td>Jill</td>
      <td>Smith</td>
      <td>50</td>
      <td>Jill</td>
      <td>Smith</td>
      <td>50</td>
    </tr>
    <tr>
      <td>Jill</td>
      <td>Smith</td>
      <td>50</td>
      <td>Jill</td>
      <td>Smith</td>
      <td>50</td>
      <td>Jill</td>
      <td>Smith</td>
      <td>50</td>
      <td>Jill</td>
      <td>Smith</td>
      <td>50</td>
    </tr>
    <tr>
      <td>Jill</td>
      <td>Smith</td>
      <td>50</td>
      <td>Jill</td>
      <td>Smith</td>
      <td>50</td>
      <td>Jill</td>
      <td>Smith</td>
      <td>50</td>
      <td>Jill</td>
      <td>Smith</td>
      <td>50</td>
    </tr>
    <tr>
      <td>Jill</td>
      <td>Smith</td>
      <td>50</td>
      <td>Jill</td>
      <td>Smith</td>
      <td>50</td>
      <td>Jill</td>
      <td>Smith</td>
      <td>50</td>
      <td>Jill</td>
      <td>Smith</td>
      <td>50</td>
    </tr>
    <tr>
      <td>Jill</td>
      <td>Smith</td>
      <td>50</td>
      <td>Jill</td>
      <td>Smith</td>
      <td>50</td>
      <td>Jill</td>
      <td>Smith</td>
      <td>50</td>
      <td>Jill</td>
      <td>Smith</td>
      <td>50</td>
    </tr>
    <tr>
      <td>Jill</td>
      <td>Smith</td>
      <td>50</td>
      <td>Jill</td>
      <td>Smith</td>
      <td>50</td>
      <td>Jill</td>
      <td>Smith</td>
      <td>50</td>
      <td>Jill</td>
      <td>Smith</td>
      <td>50</td>
    </tr>
    <tr>
      <td>Jill</td>
      <td>Smith</td>
      <td>50</td>
      <td>Jill</td>
      <td>Smith</td>
      <td>50</td>
      <td>Jill</td>
      <td>Smith</td>
      <td>50</td>
      <td>Jill</td>
      <td>Smith</td>
      <td>50</td>
    </tr>
    <tr>
      <td>Jill</td>
      <td>Smith</td>
      <td>50</td>
      <td>Jill</td>
      <td>Smith</td>
      <td>50</td>
      <td>Jill</td>
      <td>Smith</td>
      <td>50</td>
      <td>Jill</td>
      <td>Smith</td>
      <td>50</td>
    </tr>
    <tr>
      <td>Jill</td>
      <td>Smith</td>
      <td>50</td>
      <td>Jill</td>
      <td>Smith</td>
      <td>50</td>
      <td>Jill</td>
      <td>Smith</td>
      <td>50</td>
      <td>Jill</td>
      <td>Smith</td>
      <td>50</td>
    </tr>
    <tr>
      <td>Jill</td>
      <td>Smith</td>
      <td>50</td>
      <td>Jill</td>
      <td>Smith</td>
      <td>50</td>
      <td>Jill</td>
      <td>Smith</td>
      <td>50</td>
      <td>Jill</td>
      <td>Smith</td>
      <td>50</td>
    </tr>
    <tr>
      <td>Jill</td>
      <td>Smith</td>
      <td>50</td>
      <td>Jill</td>
      <td>Smith</td>
      <td>50</td>
      <td>Jill</td>
      <td>Smith</td>
      <td>50</td>
      <td>Jill</td>
      <td>Smith</td>
      <td>50</td>
    </tr>
    <tr>
      <td>Jill</td>
      <td>Smith</td>
      <td>50</td>
      <td>Jill</td>
      <td>Smith</td>
      <td>50</td>
      <td>Jill</td>
      <td>Smith</td>
      <td>50</td>
      <td>Jill</td>
      <td>Smith</td>
      <td>50</td>
    </tr>
    <tr>
      <td>Jill</td>
      <td>Smith</td>
      <td>50</td>
      <td>Jill</td>
      <td>Smith</td>
      <td>50</td>
      <td>Jill</td>
      <td>Smith</td>
      <td>50</td>
      <td>Jill</td>
      <td>Smith</td>
      <td>50</td>
    </tr>
    <tr>
      <td>Jill</td>
      <td>Smith</td>
      <td>50</td>
      <td>Jill</td>
      <td>Smith</td>
      <td>50</td>
      <td>Jill</td>
      <td>Smith</td>
      <td>50</td>
      <td>Jill</td>
      <td>Smith</td>
      <td>50</td>
    </tr>
    <tr>
      <td>Jill</td>
      <td>Smith</td>
      <td>50</td>
      <td>Jill</td>
      <td>Smith</td>
      <td>50</td>
      <td>Jill</td>
      <td>Smith</td>
      <td>50</td>
      <td>Jill</td>
      <td>Smith</td>
      <td>50</td>
    </tr>
    <tr>
      <td>Jill</td>
      <td>Smith</td>
      <td>50</td>
      <td>Jill</td>
      <td>Smith</td>
      <td>50</td>
      <td>Jill</td>
      <td>Smith</td>
      <td>50</td>
      <td>Jill</td>
      <td>Smith</td>
      <td>50</td>
    </tr>
    <tr>
      <td>Jill</td>
      <td>Smith</td>
      <td>50</td>
      <td>Jill</td>
      <td>Smith</td>
      <td>50</td>
      <td>Jill</td>
      <td>Smith</td>
      <td>50</td>
      <td>Jill</td>
      <td>Smith</td>
      <td>50</td>
    </tr>
    <tr>
      <td>Jill</td>
      <td>Smith</td>
      <td>50</td>
      <td>Jill</td>
      <td>Smith</td>
      <td>50</td>
      <td>Jill</td>
      <td>Smith</td>
      <td>50</td>
      <td>Jill</td>
      <td>Smith</td>
      <td>50</td>
    </tr>
    <tr>
      <td>Jill</td>
      <td>Smith</td>
      <td>50</td>
      <td>Jill</td>
      <td>Smith</td>
      <td>50</td>
      <td>Jill</td>
      <td>Smith</td>
      <td>50</td>
      <td>Jill</td>
      <td>Smith</td>
      <td>50</td>
    </tr>
    <tr>
      <td>Jill</td>
      <td>Smith</td>
      <td>50</td>
      <td>Jill</td>
      <td>Smith</td>
      <td>50</td>
      <td>Jill</td>
      <td>Smith</td>
      <td>50</td>
      <td>Jill</td>
      <td>Smith</td>
      <td>50</td>
    </tr>
    <tr>
      <td>Jill</td>
      <td>Smith</td>
      <td>50</td>
      <td>Jill</td>
      <td>Smith</td>
      <td>50</td>
      <td>Jill</td>
      <td>Smith</td>
      <td>50</td>
      <td>Jill</td>
      <td>Smith</td>
      <td>50</td>
    </tr>
    <tr>
      <td>Jill</td>
      <td>Smith</td>
      <td>50</td>
      <td>Jill</td>
      <td>Smith</td>
      <td>50</td>
      <td>Jill</td>
      <td>Smith</td>
      <td>50</td>
      <td>Jill</td>
      <td>Smith</td>
      <td>50</td>
    </tr>
    <tr>
      <td>Jill</td>
      <td>Smith</td>
      <td>50</td>
      <td>Jill</td>
      <td>Smith</td>
      <td>50</td>
      <td>Jill</td>
      <td>Smith</td>
      <td>50</td>
      <td>Jill</td>
      <td>Smith</td>
      <td>50</td>
    </tr>
    <tr>
      <td>Jill</td>
      <td>Smith</td>
      <td>50</td>
      <td>Jill</td>
      <td>Smith</td>
      <td>50</td>
      <td>Jill</td>
      <td>Smith</td>
      <td>50</td>
      <td>Jill</td>
      <td>Smith</td>
      <td>50</td>
    </tr>
    <tr>
      <td>Jill</td>
      <td>Smith</td>
      <td>50</td>
      <td>Jill</td>
      <td>Smith</td>
      <td>50</td>
      <td>Jill</td>
      <td>Smith</td>
      <td>50</td>
      <td>Jill</td>
      <td>Smith</td>
      <td>50</td>
    </tr>
    <tr>
      <td>Jill</td>
      <td>Smith</td>
      <td>50</td>
      <td>Jill</td>
      <td>Smith</td>
      <td>50</td>
      <td>Jill</td>
      <td>Smith</td>
      <td>50</td>
      <td>Jill</td>
      <td>Smith</td>
      <td>50</td>
    </tr>
    <tr>
      <td>Jill</td>
      <td>Smith</td>
      <td>50</td>
      <td>Jill</td>
      <td>Smith</td>
      <td>50</td>
      <td>Jill</td>
      <td>Smith</td>
      <td>50</td>
      <td>Jill</td>
      <td>Smith</td>
      <td>50</td>
    </tr>
    <tr>
      <td>Jill</td>
      <td>Smith</td>
      <td>50</td>
      <td>Jill</td>
      <td>Smith</td>
      <td>50</td>
      <td>Jill</td>
      <td>Smith</td>
      <td>50</td>
      <td>Jill</td>
      <td>Smith</td>
      <td>50</td>
    </tr>
    <tr>
      <td>Jill</td>
      <td>Smith</td>
      <td>50</td>
      <td>Jill</td>
      <td>Smith</td>
      <td>50</td>
      <td>Jill</td>
      <td>Smith</td>
      <td>50</td>
      <td>Jill</td>
      <td>Smith</td>
      <td>50</td>
    </tr>
    <tr>
      <td>Jill</td>
      <td>Smith</td>
      <td>50</td>
      <td>Jill</td>
      <td>Smith</td>
      <td>50</td>
      <td>Jill</td>
      <td>Smith</td>
      <td>50</td>
      <td>Jill</td>
      <td>Smith</td>
      <td>50</td>
    </tr>
    <tr>
      <td>Jill</td>
      <td>Smith</td>
      <td>50</td>
      <td>Jill</td>
      <td>Smith</td>
      <td>50</td>
      <td>Jill</td>
      <td>Smith</td>
      <td>50</td>
      <td>Jill</td>
      <td>Smith</td>
      <td>50</td>
    </tr>
    <tr>
      <td>Jill</td>
      <td>Smith</td>
      <td>50</td>
      <td>Jill</td>
      <td>Smith</td>
      <td>50</td>
      <td>Jill</td>
      <td>Smith</td>
      <td>50</td>
      <td>Jill</td>
      <td>Smith</td>
      <td>50</td>
    </tr>

  </table>
  </div>
  <div id="dashboard">
    <div class="w3-row w3-small">
      <!-- start of Db cell-->
      <div class="w3-container dark-border w3-col s4 db-panel">
    <a id="tool_state" class="dark-border w3-round w3-padding-small w3-text-blue tool_state"><i class="fa fa-database w3-text-blue"></i> Sample_DB</a><br><br>
    <hr style="border-top: 0.4px solid #333;">
    <div class="w3-bar">
      <a class="w3-bar-item w3-text-grey w3-btn w3-hover-blue w3-round"><i class="fa fa-bars w3-text-indigo"></i> View Database</a>
     <a class="w3-bar-item w3-text-grey w3-btn w3-hover-blue w3-round"><i class="fa fa-trash w3-text-red"></i> Delete</a>
     <a class="w3-bar-item w3-text-grey w3-btn w3-hover-blue w3-round"><i class="fa fa-upload w3-text-amber"></i> Export</a>
    </div>
    <br>
    </div>
    <!--end of db cell-->
    <!-- start of Db cell-->
    <div class="w3-container dark-border w3-col s4 db-panel">
  <a id="tool_state" class="dark-border w3-round w3-padding-small w3-text-blue tool_state"><i class="fa fa-database w3-text-blue"></i> Sample_DB</a><br><br>
  <hr style="border-top: 0.4px solid #333;">
  <div class="w3-bar">
    <a class="w3-bar-item w3-text-grey w3-btn w3-hover-blue w3-round"><i class="fa fa-bars w3-text-indigo"></i> View Database</a>
   <a class="w3-bar-item w3-text-grey w3-btn w3-hover-blue w3-round"><i class="fa fa-trash w3-text-red"></i> Delete</a>
   <a class="w3-bar-item w3-text-grey w3-btn w3-hover-blue w3-round"><i class="fa fa-upload w3-text-amber"></i> Export</a>
  </div>
  <br>
  </div>
  <!--end of db cell-->
  <!-- start of Db cell-->
  <div class="w3-container dark-border w3-col s4 db-panel">
<a id="tool_state" class="dark-border w3-round w3-padding-small w3-text-blue tool_state"><i class="fa fa-database w3-text-blue"></i> Sample_DB</a><br><br>
<hr style="border-top: 0.4px solid #333;">
<div class="w3-bar">
  <a class="w3-bar-item w3-text-grey w3-btn w3-hover-blue w3-round"><i class="fa fa-bars w3-text-indigo"></i> View Database</a>
 <a class="w3-bar-item w3-text-grey w3-btn w3-hover-blue w3-round"><i class="fa fa-trash w3-text-red"></i> Delete</a>
 <a class="w3-bar-item w3-text-grey w3-btn w3-hover-blue w3-round"><i class="fa fa-upload w3-text-amber"></i> Export</a>
</div>
<br>
</div>
<!--end of db cell-->
<!-- start of Db cell-->
<div class="w3-container dark-border w3-col s4 db-panel">
<a id="tool_state" class="dark-border w3-round w3-padding-small w3-text-blue tool_state"><i class="fa fa-database w3-text-blue"></i> Sample_DB</a><br><br>
<hr style="border-top: 0.4px solid #333;">
<div class="w3-bar">
<a class="w3-bar-item w3-text-grey w3-btn w3-hover-blue w3-round"><i class="fa fa-bars w3-text-indigo"></i> View Database</a>
<a class="w3-bar-item w3-text-grey w3-btn w3-hover-blue w3-round"><i class="fa fa-trash w3-text-red"></i> Delete</a>
<a class="w3-bar-item w3-text-grey w3-btn w3-hover-blue w3-round"><i class="fa fa-upload w3-text-amber"></i> Export</a>
</div>
<br>
</div>
<!--end of db cell-->
<!-- start of Db cell-->
<div class="w3-container dark-border w3-col s4 db-panel">
<a id="tool_state" class="dark-border w3-round w3-padding-small w3-text-blue tool_state"><i class="fa fa-database w3-text-blue"></i> Sample_DB</a><br><br>
<hr style="border-top: 0.4px solid #333;">
<div class="w3-bar">
<a class="w3-bar-item w3-text-grey w3-btn w3-hover-blue w3-round"><i class="fa fa-bars w3-text-indigo"></i> View Database</a>
<a class="w3-bar-item w3-text-grey w3-btn w3-hover-blue w3-round"><i class="fa fa-trash w3-text-red"></i> Delete</a>
<a class="w3-bar-item w3-text-grey w3-btn w3-hover-blue w3-round"><i class="fa fa-upload w3-text-amber"></i> Export</a>
</div>
<br>
</div>
<!--end of db cell-->
<!-- start of Db cell-->
<div class="w3-container dark-border w3-col s4 db-panel">
<a id="tool_state" class="dark-border w3-round w3-padding-small w3-text-blue tool_state"><i class="fa fa-database w3-text-blue"></i> Sample_DB</a><br><br>
<hr style="border-top: 0.4px solid #333;">
<div class="w3-bar">
<a class="w3-bar-item w3-text-grey w3-btn w3-hover-blue w3-round"><i class="fa fa-bars w3-text-indigo"></i> View Database</a>
<a class="w3-bar-item w3-text-grey w3-btn w3-hover-blue w3-round"><i class="fa fa-trash w3-text-red"></i> Delete</a>
<a class="w3-bar-item w3-text-grey w3-btn w3-hover-blue w3-round"><i class="fa fa-upload w3-text-amber"></i> Export</a>
</div>
<br>
</div>
<!--end of db cell-->
<!-- start of Db cell-->
<div class="w3-container dark-border w3-col s4 db-panel">
<a id="tool_state" class="dark-border w3-round w3-padding-small w3-text-blue tool_state"><i class="fa fa-database w3-text-blue"></i> Sample_DB</a><br><br>
<hr style="border-top: 0.4px solid #333;">
<div class="w3-bar">
<a class="w3-bar-item w3-text-grey w3-btn w3-hover-blue w3-round"><i class="fa fa-bars w3-text-indigo"></i> View Database</a>
<a class="w3-bar-item w3-text-grey w3-btn w3-hover-blue w3-round"><i class="fa fa-trash w3-text-red"></i> Delete</a>
<a class="w3-bar-item w3-text-grey w3-btn w3-hover-blue w3-round"><i class="fa fa-upload w3-text-amber"></i> Export</a>
</div>
<br>
</div>
<!--end of db cell-->
<!-- start of Db cell-->
<div class="w3-container dark-border w3-col s4 db-panel">
<a id="tool_state" class="dark-border w3-round w3-padding-small w3-text-blue tool_state"><i class="fa fa-database w3-text-blue"></i> Sample_DB</a><br><br>
<hr style="border-top: 0.4px solid #333;">
<div class="w3-bar">
<a class="w3-bar-item w3-text-grey w3-btn w3-hover-blue w3-round"><i class="fa fa-bars w3-text-indigo"></i> View Database</a>
<a class="w3-bar-item w3-text-grey w3-btn w3-hover-blue w3-round"><i class="fa fa-trash w3-text-red"></i> Delete</a>
<a class="w3-bar-item w3-text-grey w3-btn w3-hover-blue w3-round"><i class="fa fa-upload w3-text-amber"></i> Export</a>
</div>
<br>
</div>
<!--end of db cell-->
<!-- start of Db cell-->
<div class="w3-container dark-border w3-col s4 db-panel">
<a id="tool_state" class="dark-border w3-round w3-padding-small w3-text-blue tool_state"><i class="fa fa-database w3-text-blue"></i> Sample_DB</a><br><br>
<hr style="border-top: 0.4px solid #333;">
<div class="w3-bar">
<a class="w3-bar-item w3-text-grey w3-btn w3-hover-blue w3-round"><i class="fa fa-bars w3-text-indigo"></i> View Database</a>
<a class="w3-bar-item w3-text-grey w3-btn w3-hover-blue w3-round"><i class="fa fa-trash w3-text-red"></i> Delete</a>
<a class="w3-bar-item w3-text-grey w3-btn w3-hover-blue w3-round"><i class="fa fa-upload w3-text-amber"></i> Export</a>
</div>
<br>
</div>
<!--end of db cell-->
<!-- start of Db cell-->
<div class="w3-container dark-border w3-col s4 db-panel">
<a id="tool_state" class="dark-border w3-round w3-padding-small w3-text-blue tool_state"><i class="fa fa-database w3-text-blue"></i> Sample_DB</a><br><br>
<hr style="border-top: 0.4px solid #333;">
<div class="w3-bar">
<a class="w3-bar-item w3-text-grey w3-btn w3-hover-blue w3-round"><i class="fa fa-bars w3-text-indigo"></i> View Database</a>
<a class="w3-bar-item w3-text-grey w3-btn w3-hover-blue w3-round"><i class="fa fa-trash w3-text-red"></i> Delete</a>
<a class="w3-bar-item w3-text-grey w3-btn w3-hover-blue w3-round"><i class="fa fa-upload w3-text-amber"></i> Export</a>
</div>
<br>
</div>
<!--end of db cell-->
<!-- start of Db cell-->
<div class="w3-container dark-border w3-col s4 db-panel">
<a id="tool_state" class="dark-border w3-round w3-padding-small w3-text-blue tool_state"><i class="fa fa-database w3-text-blue"></i> Sample_DB</a><br><br>
<hr style="border-top: 0.4px solid #333;">
<div class="w3-bar">
<a class="w3-bar-item w3-text-grey w3-btn w3-hover-blue w3-round"><i class="fa fa-bars w3-text-indigo"></i> View Database</a>
<a class="w3-bar-item w3-text-grey w3-btn w3-hover-blue w3-round"><i class="fa fa-trash w3-text-red"></i> Delete</a>
<a class="w3-bar-item w3-text-grey w3-btn w3-hover-blue w3-round"><i class="fa fa-upload w3-text-amber"></i> Export</a>
</div>
<br>
</div>
<!--end of db cell-->
<!-- start of Db cell-->
<div class="w3-container dark-border w3-col s4 db-panel">
<a id="tool_state" class="dark-border w3-round w3-padding-small w3-text-blue tool_state"><i class="fa fa-database w3-text-blue"></i> Sample_DB</a><br><br>
<hr style="border-top: 0.4px solid #333;">
<div class="w3-bar">
<a class="w3-bar-item w3-text-grey w3-btn w3-hover-blue w3-round"><i class="fa fa-bars w3-text-indigo"></i> View Database</a>
<a class="w3-bar-item w3-text-grey w3-btn w3-hover-blue w3-round"><i class="fa fa-trash w3-text-red"></i> Delete</a>
<a class="w3-bar-item w3-text-grey w3-btn w3-hover-blue w3-round"><i class="fa fa-upload w3-text-amber"></i> Export</a>
</div>
<br>
</div>
<!--end of db cell-->
  <!-- start of Db cell-->
  <div class="w3-container dark-border w3-col s4 db-panel">
<a id="tool_state" class="dark-border w3-round w3-padding-small w3-text-blue tool_state"><i class="fa fa-database w3-text-blue"></i> Sample_DB</a><br><br>
<hr style="border-top: 0.4px solid #333;">
<div class="w3-bar">
  <a class="w3-bar-item w3-text-grey w3-btn w3-hover-blue w3-round"><i class="fa fa-bars w3-text-indigo"></i> View Database</a>
 <a class="w3-bar-item w3-text-grey w3-btn w3-hover-blue w3-round"><i class="fa fa-trash w3-text-red"></i> Delete</a>
 <a class="w3-bar-item w3-text-grey w3-btn w3-hover-blue w3-round"><i class="fa fa-upload w3-text-amber"></i> Export</a>
</div>
<br>
</div>
<!--end of db cell-->
<!-- start of Db cell-->
<div class="w3-container dark-border w3-col s4 db-panel">
<a id="tool_state" class="dark-border w3-round w3-padding-small w3-text-blue tool_state"><i class="fa fa-database w3-text-blue"></i> Sample_DB</a><br><br>
<hr style="border-top: 0.4px solid #333;">
<div class="w3-bar">
<a class="w3-bar-item w3-text-grey w3-btn w3-hover-blue w3-round"><i class="fa fa-bars w3-text-indigo"></i> View Database</a>
<a class="w3-bar-item w3-text-grey w3-btn w3-hover-blue w3-round"><i class="fa fa-trash w3-text-red"></i> Delete</a>
<a class="w3-bar-item w3-text-grey w3-btn w3-hover-blue w3-round"><i class="fa fa-upload w3-text-amber"></i> Export</a>
</div>
<br>
</div>
<!--end of db cell-->
<!-- start of Db cell-->
<div class="w3-container dark-border w3-col s4 db-panel">
<a id="tool_state" class="dark-border w3-round w3-padding-small w3-text-blue tool_state"><i class="fa fa-database w3-text-blue"></i> Sample_DB</a><br><br>
<hr style="border-top: 0.4px solid #333;">
<div class="w3-bar">
<a class="w3-bar-item w3-text-grey w3-btn w3-hover-blue w3-round"><i class="fa fa-bars w3-text-indigo"></i> View Database</a>
<a class="w3-bar-item w3-text-grey w3-btn w3-hover-blue w3-round"><i class="fa fa-trash w3-text-red"></i> Delete</a>
<a class="w3-bar-item w3-text-grey w3-btn w3-hover-blue w3-round"><i class="fa fa-upload w3-text-amber"></i> Export</a>
</div>
<br>
</div>
<!--end of db cell-->
<!-- start of Db cell-->
<div class="w3-container dark-border w3-col s4 db-panel">
<a id="tool_state" class="dark-border w3-round w3-padding-small w3-text-blue tool_state"><i class="fa fa-database w3-text-blue"></i> Sample_DB</a><br><br>
<hr style="border-top: 0.4px solid #333;">
<div class="w3-bar">
<a class="w3-bar-item w3-text-grey w3-btn w3-hover-blue w3-round"><i class="fa fa-bars w3-text-indigo"></i> View Database</a>
<a class="w3-bar-item w3-text-grey w3-btn w3-hover-blue w3-round"><i class="fa fa-trash w3-text-red"></i> Delete</a>
<a class="w3-bar-item w3-text-grey w3-btn w3-hover-blue w3-round"><i class="fa fa-upload w3-text-amber"></i> Export</a>
</div>
<br>
</div>
<!--end of db cell-->
<!-- start of Db cell-->
<div class="w3-container dark-border w3-col s4 db-panel">
<a id="tool_state" class="dark-border w3-round w3-padding-small w3-text-blue tool_state"><i class="fa fa-database w3-text-blue"></i> Sample_DB</a><br><br>
<hr style="border-top: 0.4px solid #333;">
<div class="w3-bar">
<a class="w3-bar-item w3-text-grey w3-btn w3-hover-blue w3-round"><i class="fa fa-bars w3-text-indigo"></i> View Database</a>
<a class="w3-bar-item w3-text-grey w3-btn w3-hover-blue w3-round"><i class="fa fa-trash w3-text-red"></i> Delete</a>
<a class="w3-bar-item w3-text-grey w3-btn w3-hover-blue w3-round"><i class="fa fa-upload w3-text-amber"></i> Export</a>
</div>
<br>
</div>
<!--end of db cell-->
<!-- start of Db cell-->
<div class="w3-container dark-border w3-col s4 db-panel">
<a id="tool_state" class="dark-border w3-round w3-padding-small w3-text-blue tool_state"><i class="fa fa-database w3-text-blue"></i> Sample_DB</a><br><br>
<hr style="border-top: 0.4px solid #333;">
<div class="w3-bar">
<a class="w3-bar-item w3-text-grey w3-btn w3-hover-blue w3-round"><i class="fa fa-bars w3-text-indigo"></i> View Database</a>
<a class="w3-bar-item w3-text-grey w3-btn w3-hover-blue w3-round"><i class="fa fa-trash w3-text-red"></i> Delete</a>
<a class="w3-bar-item w3-text-grey w3-btn w3-hover-blue w3-round"><i class="fa fa-upload w3-text-amber"></i> Export</a>
</div>
<br>
</div>
<!--end of db cell-->
<!-- start of Db cell-->
<div class="w3-container dark-border w3-col s4 db-panel">
<a id="tool_state" class="dark-border w3-round w3-padding-small w3-text-blue tool_state"><i class="fa fa-database w3-text-blue"></i> Sample_DB</a><br><br>
<hr style="border-top: 0.4px solid #333;">
<div class="w3-bar">
<a class="w3-bar-item w3-text-grey w3-btn w3-hover-blue w3-round"><i class="fa fa-bars w3-text-indigo"></i> View Database</a>
<a class="w3-bar-item w3-text-grey w3-btn w3-hover-blue w3-round"><i class="fa fa-trash w3-text-red"></i> Delete</a>
<a class="w3-bar-item w3-text-grey w3-btn w3-hover-blue w3-round"><i class="fa fa-upload w3-text-amber"></i> Export</a>
</div>
<br>
</div>
<!--end of db cell-->
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


<script src="./nsrc/js/perfect-scrollbar.js"></script>
<script src="./nsrc/js/nebular.js"></script>

<script>
var editor = ace.edit("editor");
    editor.setTheme("ace/theme/monokai");
    editor.getSession().setMode("ace/mode/php");
</script>


</body>
</html>
