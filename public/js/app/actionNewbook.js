/******/ (() => { // webpackBootstrap
var __webpack_exports__ = {};
/*!*******************************************!*\
  !*** ./resources/js/app/actionNewbook.js ***!
  \*******************************************/
$(function () {
  dpPay = function dpPay(id, dp, bookno) {
    var _this = this;

    this.selectedid = id;
    this.dp = dp * 0.3;
    Swal.fire({
      title: 'Masukan DP yang di terima untuk Booking No :<br>' + bookno + '<br><small>Minimal DP : ' + dp + '</small>',
      inputLabel: 'DP minimal',
      html: '<input id="swal-input1" type="number" value="' + dp + '" class="swal2-input">' + '<input type="hidden" value="' + dp + '" id="dpmin">',
      showCancelButton: true,
      confirmButtonText: 'Submit DP',
      showLoaderOnConfirm: true,
      preConfirm: function preConfirm(login) {
        var dp = document.getElementById('swal-input1').value;
        var dpmin = document.getElementById('dpmin').value;

        if (dp < dpmin) {
          _this.dp = dp;
          Swal.fire({
            title: 'DP Kurang Dari yang ditentukan',
            text: "Kamu Yakin untuk Confirm Pembayaran ini?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Confirm'
          }).then(function (result) {
            if (result.isConfirmed) {
              var id = _this.selectedid;
              var data = new FormData();
              data.append('dp', _this.dp);
              submitdp(data, id);
            }
          });
        }
      },
      allowOutsideClick: function allowOutsideClick() {
        return !Swal.isLoading();
      }
    }).then(function (result) {
      if (result.isConfirmed) {
        var dp = document.getElementById('swal-input1').value;
        var id = _this.selectedid;
        var data = new FormData();
        data.append('dp', dp);
        submitdp(data, id);
      }
    });
  };

  submitdp = function submitdp(data, id) {
    callService('/api/submitdp/' + id, data, "POST").then(function (ret) {
      Swal.fire('Sukses', 'Pembarayan Berhasil Di Update', 'success');
      location.reload();
    });
  };

  $("#btnbyrdp").click(function () {
    dpPay($("#idpack").val(), $("#totalamt").val(), $(".bookno").html());
  });
  $("#btnbtltrip").click(function () {
    Swal.fire({
      title: 'Apakah Yakin Membatalkan Booking ini?',
      text: "Pendapatan akan dikurangi dengan jumlah yang disetorkan[Refund]",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Iye , Batalin Aje!'
    }).then(function (result) {
      if (result.isConfirmed) {
        callService('/api/cancelbook/' + $("#idpack").val(), null, "POST").then(function (ret) {
          Swal.fire('Pembatalan', 'Berhasil Melakukan Pembatalan', 'success');
          location.href = '/newtravel';
        });
      }
    });
  });
  $(".datelist").click(function () {
    var val = this.innerText;
    var id = $("#idpack").val();
    Swal.fire({
      title: 'Apakah Yakin Mengubah Tanggal Booking ini?',
      text: "Perjalan di ubah ke tanggal  :" + val,
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Iye , Ubah Tanggal!'
    }).then(function (result) {
      if (result.isConfirmed) {
        var dat;
        callService('/api/changebookdate/' + $("#idpack").val(), null, "POST").then(function (ret) {
          Swal.fire('Pembatalan', 'Berhasil Melakukan Pembatalan', 'success');
          location.reload();
        });
      }
    });
  });
});
/******/ })()
;