require('./bootstrap');
require('./Tools');
$(function () {
    $('#pack_desc').summernote()

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
        var notestr = null;
        debugger
        for(var p in obj) p.startsWith("F") && (obj["NF" + p.substr(1)] && (note = obj["NF" + p.substr(1)]), listFac.push({
            id: 1 * p.substr(1),
            note: notestr,
            status:true
        })), p.startsWith("NF") && !obj["F" + p.substr(2)] && listFac.push({
            id: 1 * p.substr(2),
            note: obj[p],
            status:false
        });
        var data=new FormData($('#formPack')[0]);
        data.append('listFac',JSON.stringify(listFac))
        callService('/api/package',data,"POST").then((ret)=>{
           alert(ret)
            $('#saveBtn').html('Simpan Data');
        });
    })
});



