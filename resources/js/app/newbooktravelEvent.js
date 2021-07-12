
$(function () {
operateFormatter=function(value, row, index) {
    return [
    '<a href="/detailbooktravel/'+row.id+'"  id="btnres_'+index+'" class="btn btn-info btn-sm" ><i class="fas fa-info"></i> Detail</a>',
    ].join('')
}

});

