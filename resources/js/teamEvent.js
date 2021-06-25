$(function(){
    var formtim = $("#formtim");
    formtim.validate({
        rules:{
            fullnm:{required:true},
            nicknm:{required:true},
            akunig:{required:true},
            jabatan:{required:true},
            nicknm:{required:true},
            timseq:{required:true},

        },
        messages: {
            fullnm:{required: "Inpu Nama Panggilannya Yah",},
            nicknm:{required: "Input Nama Lengkapnya Yah",},
            akunig:{required: "IG nya ga boleh kosong broo",},
            jabatan:{required: "Jabatan dia apa?",},
            timseq:{required: "Input Urutannya dong",},
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

    $('#btnsavetim').click(function (e) {
        if(formtim.valid() == true){
            var id=$('#idtim').val();
            var method=this.value=="new"?"/api/teams":"/api/teams/"+id
            var data=new FormData($('#formtim')[0]);
            callService(method,data,"POST").then((ret)=>{
                Swal.fire({
                    icon: 'success',
                    title: 'Team Berhasil di perbarui',
                    showConfirmButton: false,
                    timer: 1500
                }).then((result) => {
                    location.reload();
                })
            }).catch((err)=>{
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
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
    $('#imgtim').change(function(){
        renderView('#view_img_tim',this);
        var img=$('#pathtimpic').attr('value')
        $("#view_img_tim").attr("src",img);
        $('#nicknm').val('');
        $('#fullnm').val('');
        $('#akunig').val('');
        $('#jabatan').val('');
        $('#timseq').val('');
    });
    $("#addtim").click((e)=>{
        $('#btnsavetim').val("new");
    });
    $(".btndeltim").click(function(e){
        Swal.fire({
            title: 'Hapus dia dari Team?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Iye ,Hapus Aje!'
          }).then((result) => {
            if (result.isConfirmed) {
                var id=this.id.split("_")[1];
                callService('/api/teams/'+id,null,"DELETE").then((ret)=>{
                    Swal.fire({
                        icon: 'success',
                        title: 'Team Berhasil di hapus',
                        showConfirmButton: false,
                        timer: 1500
                    }).then((result) => {
                        location.reload();
                    });
                });
            }
          })
    });
    $(".btnedittim").click(function(e){
        var obj=JSON.parse($(this).attr('data'))
        var imgsrc=$(this).attr('img-src');
        $('#btnsavetim').val("edit");
        $("#view_img_tim").attr("src",imgsrc);
        $('#idtim').val(obj.id);
        $('#nicknm').val(obj.nickname);
        $('#fullnm').val(obj.fullname);
        $('#akunig').val(obj.ig);
        $('#jabatan').val(obj.position);
        $('#timseq').val(obj.seq);
        $('#modaltim').modal('show');
    });


});
