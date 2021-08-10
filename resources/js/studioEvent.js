$(function(){
    $('#btnSaveFacstudio').click(function (e) {
        callService('/api/facilitystudio',new FormData($('#formfacility')[0]),"POST").then((ret)=>{
            location.reload();
        });
    });
    $('#saveStuBtn').click(function (e) {
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
           updStuservice(data,obj.travel_id);
        }else if(obj.isNew==1){
           saveStuservice(data);
        }
    });
    function updStuservice(data,id){
        // alert("update service");
         callService('/api/studiopackage/'+id,data,"POST").then((ret)=>{
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
     function saveStuservice(data){
         callService('/api/studiopackage',data,"POST").then((ret)=>{
             Swal.fire({
                 icon: 'success',
                 title: 'Tour Baru Berhasil Disimpan',
                 showConfirmButton: false,
                 timer: 1500
             }).then((result) => {
                 window.location='/managestudio';
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
                alert(this.value)
                callService('/api/studiopackage/'+this.value,null,"DELETE").then((ret)=>{
                    Swal.fire({
                        icon: 'success',
                        title: 'Paket Studio sudah Berhasil Dihapus broo',
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
            title: 'Anda Yakin?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya!'
          }).then((result) => {
            if (result.isConfirmed) {
                callService('/api/dispackagestudio/'+this.value,null,"POST").then((ret)=>{
                    Swal.fire({
                        icon: 'success',
                        title: 'Paket Studio sudah Berhasil di update',
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
