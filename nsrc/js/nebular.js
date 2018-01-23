 // Nebular Javascript


var ps = new PerfectScrollbar('#mySidebar');
var ps1 = new PerfectScrollbar('.data_log');
var ps2 = new PerfectScrollbar('#dashboard');
var ps3 = new PerfectScrollbar('#datatable');


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
  document.getElementById("search").focus(); // focus on command bar..
}


var capp = "dashboard";

function nav(screen) {
  document.getElementById(capp).style.display = "none";
  document.getElementById(screen).style.display = "block";
  capp = screen;
}

var cdb = "dtable"
var pointer = "list";
// search function
function search(data,pointer) {
    if(pointer == "list") {
      // search lists
    var input, filter, ul, li, a, i;
    input = document.getElementById('search');
    filter = input.value.toUpperCase();
    ul = document.getElementById(data);
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
}else{
  // search tables
  var input, filter, table, tr, td, i;
    input = document.getElementById("search");
    filter = input.value.toUpperCase();
    table = document.getElementById(data);
    tr = table.getElementsByTagName("tr");

    // Loop through all table rows, and hide those who don't match the search query
    for (i = 0; i < tr.length; i++) {
      td = tr[i].getElementsByTagName("td")[0];
      if (td) {
        if (td.innerHTML.toUpperCase().indexOf(filter) > -1) {
          tr[i].style.display = "";
        } else {
          tr[i].style.display = "none";
        }
      }
    }
}
}
