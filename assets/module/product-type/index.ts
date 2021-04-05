import "jquery";
//import Swal from 'sweetalert2';

declare const $;
 const Swal = require('sweetalert2');

$(document).ready(function () {
    $('.delete').on('click', function confirmDelete(e) {
        e.preventDefault();
        var id = $(this).attr('id');
     //   console.log(id);
        alert(id);
        Swal.fire({
            title: 'Are you sureeeeeee?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Delete'
        }).then((result) => {
            if (result.isConfirmed) {
                $.post("/product/type/delete/"+id, function (data) {
                    Swal.fire( {
                        title:data.message,
                        icon: "success",
                        timer:1000,
                        button:false,
                        position: 'top-end',
                        showConfirmButton: false,
                    }).then(function (){ window.location.href='/product/type/list'})
                })
            } else {
                Swal.fire({title:"Your file is safe!",
                    position: 'top-end',
                    showConfirmButton: false,
                    icon: "success",
                    timer:1500,
                });
            }
        });
    });
});