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
    timecount=0;

    $(document).on('click', '.butdeldate', function(e){
         var id=this.id.split("_")[1];
         var delid="#pack_time_"+id;
         //alert(delid)
         $(delid).remove();
         $('#'+this.id).remove();
    })
    // $('.butdeldate').click(function(e){
    //     alert();
    // })
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
            `
        );
    })
    $('#saveBtn').click(function (e) {
        $(this).html('Sending..');
        console.log($('#formPack').serialize())
        var obj=toolToObj($('#formPack'));
        var listFac=[];
        var notestr = null;
        var listdate=[];
        for(var p in obj) p.startsWith("F") && (obj["NF" + p.substr(1)] && (note = obj["NF" + p.substr(1)]), listFac.push({
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
        data.append('listDate',JSON.stringify(listdate))
        callService('/api/package',data,"POST").then((ret)=>{
           alert(ret)
            $('#saveBtn').html('Simpan Data');
        });
    })
});



