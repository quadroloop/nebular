 // Nebular Javascript


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