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
  document.getElementById('dtable').classname = '';

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

// load table contents

axios.get('https://jsonplaceholder.typicode.com/posts/')
  .then(function (response) {
    var tablec = response.data;
    for(var i=0;i<tablec.length;i++) {
  document.getElementById('dbtable').innerHTML += '<tr><td>'+tablec[i].title+'</td><td>Smith</td><td>50</td><td>Jill</td><td>Smith</td><td>50</td><td>Jill</td><td>Smith</td><td>50</td><td>Jill</td><td>Smith</td><td>50</td></tr>';
}

  })
  .catch(function (error) {
    console.log(error);
  });

// load db panel contents

axios.get('https://jsonplaceholder.typicode.com/posts/')
  .then(function (response) {
    var tablec = response.data;
    for(var i=0;i<tablec.length;i++) {
  document.getElementById('dtable').innerHTML += '<li><div class="w3-container dark-border w3-col s4 db-panel w3-animate-opacity"><a id="tool_state" class="dark-border w3-round w3-padding-small w3-text-blue tool_state"><i class="fa fa-database w3-text-blue"></i> '+tablec[i].title+'</a><br><br> <hr style="border-top: 0.4px solid #333;"> <div class="w3-bar"> <a onclick="nav(&apos;datatable&apos;);cdb=&apos;dbtable&apos;;pointer=&apos;table&apos;" class="w3-bar-item w3-text-grey w3-btn w3-hover-blue w3-round"><i class="fa fa-bars w3-text-indigo"></i> View Database</a> <a class="w3-bar-item w3-text-grey w3-btn w3-hover-blue w3-round"><i class="fa fa-trash w3-text-red"></i> Delete</a> <a class="w3-bar-item w3-text-grey w3-btn w3-hover-blue w3-round"><i class="fa fa-upload w3-text-amber"></i> Export</a> </div> <br> </div> </li>';
}

  })
  .catch(function (error) {
    console.log(error);
  });
