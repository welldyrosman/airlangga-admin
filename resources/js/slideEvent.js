$(function(){
    var formslide = $("#formslide");
    formslide.validate({
        rules:{
            slidenm:{required:true},
            slideseq:{required:true},

        },
        messages: {
            slidenm:{required: "Input Caption Photonya yah",},
            slideseq:{required: "Input Urutannya dong",},
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

    $('#btnsaveslide').click(function (e) {
        if(formslide.valid() == true){
            var id=$('#idslide').val();
            var method=this.value=="new"?"/api/slide":"/api/slide/"+id
            var data=new FormData($('#formslide')[0]);

            for (var value of data.values()) {
                console.log(value);
             }
            callService(method,data,"POST").then((ret)=>{
                Swal.fire({
                    icon: 'success',
                    title: 'Slide Berhasil di perbarui',
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
    $('#imgslide').change(function(){
        renderView('#view_img_slide',this);
    });
    $("#addslide").click((e)=>{
        $('#btnsaveslide').val("new");
        var img=$('#pathslide').attr('value')
        $("#view_img_slide").attr("src",img);
        $('#idslide').val('');
        $('#slidenm').val('');
        $('#slidedesc').val('');
        $('#slideseq').val('');
    });

    $(".btnbanslide").click(function(e){
        Swal.fire({
            title: 'Ubah Slide ini?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Iye ,Ubah Aje!'
          }).then((result) => {
            if (result.isConfirmed) {
                var id=this.id.split("_")[1];
                callService('/api/disabledslide/'+id,null,"POST").then((ret)=>{
                    Swal.fire({
                        icon: 'success',
                        title: 'Slide Berhasil di Ubah',
                        showConfirmButton: false,
                        timer: 1000
                    }).then((result) => {
                        location.reload();
                    });
                });
            }
          })
    });
    $(".btndelslide").click(function(e){
        Swal.fire({
            title: 'Hapus Slide ini?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Iye ,Hapus Aje!'
          }).then((result) => {
            if (result.isConfirmed) {
                var id=this.id.split("_")[1];
                callService('/api/slide/'+id,null,"DELETE").then((ret)=>{
                    Swal.fire({
                        icon: 'success',
                        title: 'Slide Berhasil di hapus',
                        showConfirmButton: false,
                        timer: 1000
                    }).then((result) => {
                        location.reload();
                    });
                });
            }
          })
    });
    $(".btneditslide").click(function(e){
        var obj=JSON.parse($(this).attr('data'))
        var imgsrc=$(this).attr('img-src');
        $('#btnsaveslide').val("edit");
        $("#view_img_slide").attr("src",imgsrc);
        $('#idslide').val(obj.id);
        $('#slidenm').val(obj.slide_nm);
        $('#slidedesc').val(obj.slide_desc);
        $('#slideseq').val(obj.seq);
        $('#modalslide').modal('show');
    });


});
