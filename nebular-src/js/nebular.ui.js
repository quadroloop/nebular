
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