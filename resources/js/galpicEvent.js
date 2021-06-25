$(function(){
    var formpic = $("#formpic");
    formpic.validate({
        rules:{
            photonm:{required:true},
            picseq:{required:true},

        },
        messages: {
            photonm:{required: "Input Nama Photonya yah",},
            picseq:{required: "Input Urutannya dong",},
        },
        errorElement: 'span',
        errorPlacement: function (error, element) {
          error.addClass('invalid-feedback');
          element.closest('.form-group').append(error);
        },
        highlight: function (element, errorClass, validClass) {
          $(element).addClass('is-invalid');
        },
        unhighlight: function (element, errorClass, validClass) {
          $(element).removeClass('is-invalid');
        },
    });

    $('#btnsavepic').click(function (e) {

        if(formpic.valid() == true){
            var id=$('#idpic').val();
            var method=this.value=="new"?"/api/galpic":"/api/galpic/"+id
            var data=new FormData($('#formpic')[0]);
            callService(method,data,"POST").then((ret)=>{
                Swal.fire({
                    icon: 'success',
                    title: 'Photo Berhasil di perbarui',
                    showConfirmButton: false,
                    timer: 1000
                }).then((result) => {
                    location.reload();
                })
            }).catch((err)=>{

                Swal.fire({
                    icon: 'error',
                    title: JSON.parse(err.responseText).message,
                })
            });
        }
    });
    const renderView=(target,scope)=>{
        let reader = new FileReader();
        reader.onload = (e) => {
          $(target).attr('src', e.target.result);
        }
        reader.readAsDataURL(scope.files[0]);
    }
    $('#imgpic').change(function(){
        renderView('#view_img_pic',this);
    });
    $("#addpic").click((e)=>{
        $('#btnsavepic').val("new");
        var img=$('#pathpic').attr('value')
        $("#view_img_pic").attr("src",img);
        $('#idpic').val('');
        $('#photonm').val('');
        $('#photodesc').val('');
        $('#picseq').val('');
    });
    $(".btndelpic").click(function(e){
        Swal.fire({
            title: 'Hapus Photo ini?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Iye ,Hapus Aje!'
          }).then((result) => {
            if (result.isConfirmed) {
                var id=this.id.split("_")[1];
                callService('/api/galpic/'+id,null,"DELETE").then((ret)=>{
                    Swal.fire({
                        icon: 'success',
                        title: 'Photo Berhasil di hapus',
                        showConfirmButton: false,
                        timer: 1000
                    }).then((result) => {
                        location.reload();
                    });
                });
            }
          })
    });
    $(".btneditpic").click(function(e){
        var obj=JSON.parse($(this).attr('data'))
        var imgsrc=$(this).attr('img-src');
        $('#btnsavepic').val("edit");
        $("#view_img_pic").attr("src",imgsrc);
        $('#idpic').val(obj.id);
        $('#photonm').val(obj.photo_name);
        $('#photodesc').val(obj.photo_desc);
        $('#picseq').val(obj.seq);
        $('#modalpic').modal('show');
    });


});
