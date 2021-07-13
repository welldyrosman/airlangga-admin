
$(function () {
    dpPay=function(id,dp,bookno){
        this.selectedid=id;
        this.dp=dp*0.3;
        Swal.fire({
            title: 'Masukan DP yang di terima untuk Booking No :<br>'+bookno+'<br><small>Minimal DP : '+dp+'</small>',
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
                        var id=this.selectedid;
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
                var dp=document.getElementById('swal-input1').value;
                var id=this.selectedid;
                var data=new FormData();
                data.append('dp',dp)
                submitdp(data,id);
            }
        })
    }

    submitdp=(data,id)=>{
        callService('/api/submitdp/'+id,data,"POST").then((ret)=>{
            Swal.fire(
                'Sukses',
                'Pembarayan Berhasil Di Update',
                'success'
            )
            location.reload()
        })
    }
    $("#btnbyrdp").click(()=>{
        dpPay($("#idpack").val(),$("#totalamt").val(),$(".bookno").html())
    })
    $("#btnbtltrip").click(()=>{
        Swal.fire({
            title: 'Apakah Yakin Membatalkan Booking ini?',
            text: "Pendapatan akan dikurangi dengan jumlah yang disetorkan[Refund]",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Iye , Batalin Aje!'
          }).then((result) => {
            if (result.isConfirmed) {
              Swal.fire(
                'Pembatalan',
                'Berhasil Melakukan Pembatalan',
                'success'
              )
            }
          })
    })
});
