$(function(){
    $('#btnsavefaq').click(function (e) {
        var id=$('#idfaq').val();
        console.log(id)
        var method=this.value=="new"?"/api/faq":"/api/faq/"+id
        callService(method,new FormData($('#formfaq')[0]),"POST").then((ret)=>{
            Swal.fire({
                icon: 'success',
                title: 'FAQ Berhasil di perbarui',
                showConfirmButton: false,
                timer: 1500
            }).then((result) => {
                location.reload();
            });
        });
    });

    $("#addfaq").click((e)=>{
        $('#btnsavefaq').val("new");
    });
    $(".btndelfaq").click(function(e){
        Swal.fire({
            title: 'Hapus Data ini?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Iye ,Hapus Aja!'
          }).then((result) => {
            if (result.isConfirmed) {
                var id=this.id.split("_")[1];
                callService('/api/faq/'+id,null,"DELETE").then((ret)=>{
                    Swal.fire({
                        icon: 'success',
                        title: 'FAQ Berhasil di hapus',
                        showConfirmButton: false,
                        timer: 1500
                    }).then((result) => {
                        location.reload();
                    });
                });
            }
          })
    });
    $(".btneditfaq").click(function(e){
        var obj=JSON.parse($(this).attr('data'))
        $('#btnsavefaq').val("edit");
        $('#question').val(obj.subject);
        $('#answer').val(obj.deskripsi);
        $('#idfaq').val(obj.id);
        $('#seq').val(obj.seq);
        $('#modalfaq').modal('show');
    });


});
