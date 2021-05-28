require('./bootstrap');
$(function () {
    $('#pack_desc').summernote()
    function getFormData($form){
        var unindexed_array = $form.serializeArray();
        var indexed_array = {};

        $.map(unindexed_array, function(n, i){
            indexed_array[n['name']] = n['value'];
        });
        var form = new FormData();
        for ( var key in indexed_array ) {
            form.append(key, indexed_array[key]);
        }
        return form;
    }
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('#saveBtn').click(function (e) {
        $(this).html('Sending..');
        $.ajax({
            data:getFormData($('#formPack')),
            url:'/api/package',
            type:"POST",
            processData: false,
            mimeType: "multipart/form-data",
            contentType: false,
            success:function(ret){
                console.log(ret)
                $('#saveBtn').html('Simpan Data');
            },
            error:function(error){
                console.log(error)
                $('#saveBtn').html('Simpan Data');
            }
        })
    })
});



