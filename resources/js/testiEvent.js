$(function(){
    var form = $("#formtesti");
    form.validate({
        rules:{
            fullnm:{required:true},
            testimoni:{required:true},
            testiseq:{required:true},

        },
        messages: {
            fullnm:{required: "Inpu Nama lengkapnya Yah",},
            testimoni:{required: "Input Testimoninya apa?",},
            testiseq:{required: "Input Urutannya dong",},
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

    $('#btnsavetesti').click(function (e) {
        if(form.valid() == true){
            var id=$('#idtesti').val();
            var method=this.value=="new"?"/api/testi":"/api/testi/"+id
            var data=new FormData($('#formtesti')[0]);
            callService(method,data,"POST").then((ret)=>{
                Swal.fire({
                    icon: 'success',
                    title: 'Testimoni Berhasil di perbarui',
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
    $('#imgtesti').change(function(){
        renderView('#view_img_testi',this);
    });
    $("#addtesti").click((e)=>{
        $('#btnsavetesti').val("new");
        var img=$('#pathpic').attr('value')
        $("#view_img_testi").attr("src",img);
        $('#idtesti').val('');
        $('#fullnm').val('');
        $('#testimoni').val('');
        $('#testiseq').val('');
    });
    $(".btndeltesti").click(function(e){
        Swal.fire({
            title: 'Hapus Testimoni ini?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Iye ,Hapus Aje!'
          }).then((result) => {
            if (result.isConfirmed) {
                var id=this.id.split("_")[1];
                callService('/api/testi/'+id,null,"DELETE").then((ret)=>{
                    Swal.fire({
                        icon: 'success',
                        title: 'Testimoni Berhasil di hapus',
                        showConfirmButton: false,
                        timer: 1000
                    }).then((result) => {
                        location.reload();
                    });
                });
            }
          })
    });
    $(".btnedittesti").click(function(e){
        var obj=JSON.parse($(this).attr('data'))
        var imgsrc=$(this).attr('img-src');
        $('#btnsavetesti').val("edit");
        $("#view_img_testi").attr("src",imgsrc);
        $('#idtesti').val(obj.id);
        $('#fullnm').val(obj.people_name);
        $('#testimoni').val(obj.testimoni);
        $('#testiseq').val(obj.seq);
        $('#modaltesti').modal('show');
    });


});
