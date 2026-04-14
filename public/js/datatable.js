"use strict";
$(function(){
    $("#datatable-1").DataTable({responsive:true,"info":false, "paging": false,columnDefs:[{targets:-1,title:"Actions",searchable:true,orderable:false,
    }]})
    $("#datatable-2").DataTable({responsive:true, "paging": false,columnDefs:[{targets:-1,title:"Actions",searchable:false,orderable:false,
        }]})
});
