import $ from 'jquery';

    $(document).ready(function () {

    $('.delete').on('click', function confirmDelete(e) {
        let id;
        e.preventDefault();
        id = $(this).attr('id');
        //  console.log(id);
        swal({
            title: "Are you sure?",
            icon: "warning",
            buttons: true,
            dangerMode: true,

        }).then((willDelete) => {
            if (willDelete) {

                $.post("/product/type/delete/"+id, function (data) {
                    swal(data.message, {
                        icon: "success",
                        timer:1000,
                        button:false,


                    }).then(function (){ window.location='/product/type/list'})
                })

            } else {
                swal("Your file is safe!");
            }
        });
    });
});
