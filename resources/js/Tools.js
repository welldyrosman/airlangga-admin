$(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    getFormData=($form)=>{
        var unindexed_array = $form.serializeArray();
        var indexed_array = {};

        $.map(unindexed_array, function(n, i){
            indexed_array[n['name']] = n['value'];
        });
        var form = new FormData();
        for ( var key in indexed_array ) {
            form.append(key, indexed_array[key]);
        }
        return form;
    }
    callService =  (url,data,method)=>{
        return new Promise((resolve, reject) => {
            $.ajax({
                data:getFormData(data),
                url:url,
                type:method,
                processData: false,
                mimeType: "multipart/form-data",
                contentType: false,
                success:function(ret){
                    resolve(ret);
                },
                error:function(error){
                    reject(error)
                }
            })
        });
    };
});
