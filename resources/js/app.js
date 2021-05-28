require('./bootstrap');
require('./Tools');
$(function () {
    $('#pack_desc').summernote()



    $('#pack_cov').change(function(){
        let reader = new FileReader();
        reader.onload = (e) => {
          $('#img_cov').attr('src', e.target.result);
        }
        reader.readAsDataURL(this.files[0]);
    });
    $('#btnSaveFac').click(function (e) {
        $(this).html('Sending..');
        callService('/api/facility',$('#formfacility'),"POST").then((ret)=>{
            location.reload();
        });
    });
    $('#saveBtn').click(function (e) {
        $(this).html('Sending..');
        console.log($('#formPack').serialize())
        var obj=toolToObj($('#formPack'));
        var listFac=[];
        for(var p in obj){
            if(p.startsWith("F")){
                listFac.push(p.substr(1,1));
                delete obj[p];
            }

        }
        obj.listFac=listFac;
        var data=toolToFormData(obj);
        callService('/api/package',new FormData($('#formPack')[0]),"POST").then((ret)=>{
            console.log(ret)
            $('#saveBtn').html('Simpan Data');
        });
    })
});



