
$(function () {
    const renderView=(target,scope)=>{
        let reader = new FileReader();
        reader.onload = (e) => {
          $(target).attr('src', e.target.result);
        }
        reader.readAsDataURL(scope.files[0]);
    }

    $('#img_1').change(function(){
        renderView('#view_img_1',this);
    });
    $('#img_2').change(function(){
        renderView('#view_img_2',this);
    });
    $('#img_3').change(function(){
        renderView('#view_img_3',this);
    });
    $('#img_4').change(function(){
        renderView('#view_img_4',this);
    });
    $('#btnSaveFac').click(function (e) {
        callService('/api/facility',new FormData($('#formfacility')[0]),"POST").then((ret)=>{
            location.reload();
        });
    });
    timecount=0;
    $(document).on('click', '.butdeldate', function(e){
         var id=this.id.split("_")[1];
         var delid="#pack_time_"+id;
         //alert(delid)
         $(delid).remove();
         $('#'+this.id).remove();
    })
    $('.butdeldateview').click(function(e){
        var id=this.id.split("_")[1];
        var delid="#pack_time_view_"+id;
        $(delid).remove();
        $('#'+this.id).remove();
    })
    $('#btntime').click(function(e){
        timecount++;
        $("#contime").append(`
            <div class="row">
                <div class="col-10">
                    <input type="date" id="pack_time_`+timecount+`" name="pack_time_`+timecount+`" class="form-control form-control-sm"/>
                </div>
                <div class="col-2">
                    <button type="button" id="btntime_`+timecount+`" class="btn btn-danger butdeldate"><i class="fas fa-minus"></i></button>
                </div>
            </div>
            <br>
            `
        );
    })
    function updservice(data,id){
       // alert("update service");
        callService('/api/package/'+id,data,"POST").then((ret)=>{
            Swal.fire({
                    icon: 'success',
                    title: 'Tour Baru Berhasil Disimpan',
                    showConfirmButton: false,
                    timer: 1500
                }).then((result) => {
                    window.location.reload();
                });
            $('#saveBtn').html('Simpan Data');
        }).catch((err)=>{
            Swal.fire({
                icon: 'error',
                title: JSON.parse(err.responseText).message
                })
            $('#saveBtn').html('Simpan Data');
        });;
    }
    function saveservice(data){
        callService('/api/package',data,"POST").then((ret)=>{
            Swal.fire({
                icon: 'success',
                title: 'Tour Baru Berhasil Disimpan',
                showConfirmButton: false,
                timer: 1500
            }).then((result) => {
                window.location='/managetour';
            });
            $('#saveBtn').html('Simpan Data');
        }).catch((err)=>{
            Swal.fire({
                icon: 'error',
                title: JSON.parse(err.responseText).message
              })
            $('#saveBtn').html('Simpan Data');
        });
    }
    $('#saveBtn').click(function (e) {
        $(this).html('Sending..');
        var obj=toolToObj($('#formPack'));
        console.log(obj);
        var listFac=[];
        var notestr = null;
        var listdate=[];
        for(var p in obj) p.startsWith("F") && (obj["NF" + p.substr(1)] && (notestr = obj["NF" + p.substr(1)]), listFac.push({
            id: 1 * p.substr(1),
            note: notestr,
            status:true
        })), p.startsWith("NF") && !obj["F" + p.substr(2)] && listFac.push({
            id: 1 * p.substr(2),
            note: obj[p],
            status:false
        }),p.startsWith("pack_time")&&listdate.push(obj[p]);
        var data=new FormData($('#formPack')[0]);
        data.append('listFac',JSON.stringify(listFac))
        listdate=[...new Set(listdate)];
        data.append('listDate',JSON.stringify(listdate))
        if(obj.isNew==0){
           updservice(data,obj.travel_id);
        }else if(obj.isNew==1){
           saveservice(data);
        }
    })
    $('.btndelpack').click(function (e) {
        Swal.fire({
            title: 'Yakin untuk Hapus?',
            text: "Data yang terhapus tidak bisa kembali!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yoi, Hapus aja!'
          }).then((result) => {
            if (result.isConfirmed) {
                callService('/api/package/'+this.value,null,"DELETE").then((ret)=>{
                    Swal.fire({
                        icon: 'success',
                        title: 'Tournya sudah Berhasil Dihapus broo',
                        showConfirmButton: false,
                        timer: 1500
                    }).then((result) => {
                        window.location.reload();
                    });
                }).catch((err)=>{
                    Swal.fire({
                        icon: 'error',
                        title: JSON.parse(err.responseText).message
                        })
                });
            }
        });
    });
    $('.btndisbpack').click(function (e) {
        Swal.fire({
            title: 'Non Aktifkan Pake ini??',
            text: "Paket Tidak Akan Muncul di tampilan user web",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yoi, Disabled aja!'
          }).then((result) => {
            if (result.isConfirmed) {
                callService('/api/dispackage/'+this.value,null,"POST").then((ret)=>{
                    Swal.fire({
                        icon: 'success',
                        title: 'Tournya sudah Berhasil di non aktifkan broo',
                        showConfirmButton: false,
                        timer: 1500
                    }).then((result) => {
                        window.location.reload();
                    });
                }).catch((err)=>{
                    Swal.fire({
                        icon: 'error',
                        title: JSON.parse(err.responseText).message
                    })
                });
            }
        });

    });
});



