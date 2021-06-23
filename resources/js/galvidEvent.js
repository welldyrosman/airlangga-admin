$(function(){
    $('#btnsavevid').click(function (e) {

        var id=$('#idvid').val();
        var method=this.value=="new"?"/api/galvid":"/api/galvid/"+id
        callService(method,new FormData($('#formvid')[0]),"POST").then((ret)=>{
            Swal.fire({
                icon: 'success',
                title: 'Video Berhasil di perbarui',
                showConfirmButton: false,
                timer: 1500
            }).then((result) => {
                location.reload();
            });
        });
    });

    $("#addvid").click((e)=>{
        $('#btnsavevid').val("new");
    });
    $(".btndelvid").click(function(e){
        Swal.fire({
            title: 'Hapus Video ini?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Iye ,Hapus Aja!'
          }).then((result) => {
            if (result.isConfirmed) {
                var id=this.id.split("_")[1];
                callService('/api/galvid/'+id,null,"DELETE").then((ret)=>{
                    Swal.fire({
                        icon: 'success',
                        title: 'Video Berhasil di hapus',
                        showConfirmButton: false,
                        timer: 1500
                    }).then((result) => {
                        location.reload();
                    });
                });
            }
          })
    });
    $(".btneditvid").click(function(e){
        var obj=JSON.parse($(this).attr('data'))
        $('#btnsavevid').val("edit");
        $('#idvid').val(obj.id);
        $('#vidname').val(obj.video_nm);
        $('#url').val(obj.video_url);
        $('#viddesk').val(obj.video_desc);
        $('#seq').val(obj.seq);
        $('#modalgalvid').modal('show');
    });


});
