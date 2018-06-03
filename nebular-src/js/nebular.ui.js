
        function logout() {
            swal({
              timer: 1200,
              title: 'Success',
              text: 'You have logged out!',
              type: 'success',
              showConfirmButton: false
            });
            setTimeout("window.location = '?logout'",1200);
        }

        function del(file,type){
           switch(type){
            case '1' :
               // delete object
               swal({
                   title: 'Are you sure?',
                   text: "This action cannot be undone",
                   type: 'warning',
                   showCancelButton: true,
                   confirmButtonColor: '#3085d6',
                   cancelButtonColor: '#d33',
                   confirmButtonText: 'Delete Object'
                }).then((result) => {
                  if (result.value) {
                   swal({
                    title: 'Deleted!',
                    text: 'Object has been deleted.',
                    type: 'success',
                    showConfirmButton: false,
                    timer: 1000
                  })
                   var ffile = file.split('/')[1];
                   nb_delete(ffile);
                   setTimeout("location.reload()",1000);
                }
              })
            break;
            case '2' :
               // delete database
               swal({
                   title: 'Are you sure?',
                   text: "This action cannot be undone",
                   type: 'warning',
                   showCancelButton: true,
                   confirmButtonColor: '#3085d6',
                   cancelButtonColor: '#d33',
                   confirmButtonText: 'Drop Database'
                }).then((result) => {
                  if (result.value) {
                   swal({
                    title: 'Deleted!',
                    text: 'Database has been deleted.',
                    type: 'success',
                    showConfirmButton: false,
                    timer: 1000
                  })
                     // alert(file);
                    dropDB(file);
                   setTimeout("window.location='?p=databases'",1000);
                }
              })
            break;
           }
        }

        // UI Operations

        //create Database
        function dbAdd() {
       
             swal({
  title: '<i class="ti-server"></i> Create Database',
  html: '<br>provide a database name and click <strong>Create!</strong><br><br>'+
         '<input id="db_name" class="w3-input w3-round w3-border" placeholder="Database Name:">',
  showCloseButton: true,
  showCancelButton: true,
  focusConfirm: false,
  confirmButtonText:
    '<i class="ti-server"></i> Create',
  confirmButtonAriaLabel: 'Thumbs up, great!',
  cancelButtonText:
  '<i class="ti-close"></i> Cancel',
  cancelButtonAriaLabel: 'Thumbs down',
}).then((result) => {
                  if (result.value) {
                   if(document.getElementById('db_name').value){
                      axios.get('nebular.php?api=createDB&db_name='+document.getElementById('db_name').value)
                      .then(function(res){
                      swal({
                        title: 'Success!',
                    text: 'database created',
                    type: 'success',
                    showConfirmButton: false,
                    timer: 1000
                      })
                    });
                      setTimeout("window.location='?p=databases'",1000);
                   }else{
                       swal({
                        title: 'Error!',
                    text: 'no database name provided',
                    type: 'error',
                    showConfirmButton: false,
                    timer: 1000
                      })
                   }
                }
              })
}

  // add object
  function objAdd() {
     
             swal({
  title: '<i class="ti-wallet"></i> Create Object',
  html: '<br>provide a database name and object name and click <strong>Create!</strong><br><br>'+
         '<input id="db_name" class="w3-input w3-round w3-border" placeholder="Database Name:"><br>'+
         '<input id="obj" class="w3-input w3-round w3-border" placeholder="Object Name:"><br>'+
         '<textarea id="content" class="w3-input w3-round w3-border" placeholder="Content"></textarea>'
         ,
  showCloseButton: true,
  showCancelButton: true,
  focusConfirm: false,
  confirmButtonText:
    '<i class="ti-waller"></i> Create',
  confirmButtonAriaLabel: 'Thumbs up, great!',
  cancelButtonText:
  '<i class="ti-close"></i> Cancel',
  cancelButtonAriaLabel: 'Thumbs down',
}).then((result) => {
                  if (result.value) {
                   if(document.getElementById('db_name').value && document.getElementById('obj').value && document.getElementById('content').value ){
                      axios.get('nebular.php?api=setObject&db_name='+document.getElementById('db_name').value+'&name='+document.getElementById('obj').value+"&content="+document.getElementById('content').value)
                      .then(function(res){
                      swal({
                        title: 'Success!',
                    text: 'Object created',
                    type: 'success',
                    showConfirmButton: false,
                    timer: 1000
                      })
                    });
                      setTimeout("window.location.reload();",1000);
                   }else{
                       swal({
                        title: 'Error!',
                    text: 'Incomeplete data provided',
                    type: 'error',
                    showConfirmButton: false,
                    timer: 1000
                      })
                   }
                }
              })


  }

   function subnet() {
     var objectname = document.getElementById('ed0').value;
     var api = document.getElementById('ed1').value;
     var dbname = document.getElementById('ed2').value;
     var content = document.getElementById('ed3').value;

     axios.get('nebular.php?api='+api+"&name="+objectname+"&db_name="+dbname+"&content="+content)
     .then(function(res) {
         location.reload();
     })

       }


 function addKey() {
  var key = document.getElementById('key').value;
  if(key){
    axios.get('./nebular-src/nebular.auth.php?save_key='+key)
      .then(function(res){
     swal({
      type: 'success',
      title: 'Success!',
      text: '"'+key+'" is registered as a API key',
      showConfirmButton: false,
      timer: 1000
     })
     setTimeout('location.reload()',1000);
   });
     
  }else{
    swal('Sorry','Please provide a key first','info');
  }
 }      

 function manage_key(data) {
    swal({
  title: 'Delete API Key?',
  text: data,
  type: 'warning',
  showCancelButton: true,
  confirmButtonColor: '#3085d6',
  cancelButtonColor: '#d33',
  confirmButtonText: 'Yes, delete it!'
}).then((result) => {
  if (result.value) {
   axios.get('./nebular-src/nebular.auth.php?delete_key='+data).then(function(res){
    swal( {
        type: 'success',
        title: "Success",
        text: "API key successfully Deleted",
        timer: 1000,
        showConfirmButton: false
      })
       setTimeout('location.reload()',1000);
    })
  }
})
 }