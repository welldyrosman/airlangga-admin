require('./bootstrap');
require('./Tools');
$(function () {
    $('#pack_desc').summernote()




    $('#btnSaveFac').click(function (e) {
        $(this).html('Sending..');
        callService('/api/facility',$('#formfacility'),"POST").then((ret)=>{
            console.log(ret)
            $('#btnSaveFac').html('Simpan Data');
        });
    });
    $('#saveBtn').click(function (e) {
        $(this).html('Sending..');
        callService('/api/package',$('#formPack'),"POST").then((ret)=>{
            $('#saveBtn').html('Simpan Data');
        });
    })
});



