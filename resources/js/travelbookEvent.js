$(function(){
    function submitdp(data,id){
        callService('/api/submitdp/'+id,data,"POST").then((ret)=>{
            Swal.fire(
                'Sukses',
                'Pembarayan Berhasil Di Update',
                'success'
            )
            location.reload();
        })
    }


    $('.btnpaytravel').click(function (e) {
        var data=JSON.parse($(this).attr('data'));
        var dp=(data.price*data.pack_qty)*0.3;
        Swal.fire({
            title: 'Masukan DP yang di terima untuk Booking No :<br>'+data.book_no+'<br><small>Minimal DP : '+dp+'</small>',
            inputLabel:'DP minimal',
            html:'<input id="swal-input1" type="number" value="'+dp+'" class="swal2-input">'+
            '<input type="hidden" value="'+dp+'" id="dpmin">',
            showCancelButton: true,
            confirmButtonText: 'Submit DP',
            showLoaderOnConfirm: true,
            preConfirm: (login) => {
              var dp=document.getElementById('swal-input1').value;
              var dpmin=document.getElementById('dpmin').value;
              if(dp<dpmin){
                this.dp=dp;
                Swal.fire({
                    title: 'DP Kurang Dari yang ditentukan',
                    text: "Kamu Yakin untuk Confirm Pembayaran ini?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, Confirm'
                  }).then((result) => {
                    if (result.isConfirmed) {
                        var id=this.id.split("_")[1];
                        var data=new FormData();
                        data.append('dp',this.dp)
                        submitdp(data,id);
                    }
                  })
              }
            },
            allowOutsideClick: () => !Swal.isLoading()
        }).then((result) => {
            if (result.isConfirmed) {
                var id=this.id.split("_")[1];
                var data=new FormData();
                data.append('dp',this.dp)
                submitdp(data,id);
            }
        })
    })
});
