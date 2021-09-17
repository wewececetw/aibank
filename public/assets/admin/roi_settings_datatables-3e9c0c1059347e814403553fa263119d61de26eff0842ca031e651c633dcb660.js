$(function() {
    $.fn.dataTable.ext.errMode = function(s,h,m){}

    var datatables_language = {
        "aria": {
            "sortAscending": ": activate to sort column ascending",
            "sortDescending": ": activate to sort column descending"
        },
        "emptyTable": "尚無取得資料",
        "info": "顯示 _START_ 到 _END_ 筆，共 _TOTAL_ 筆",
        "infoEmpty": "No records found",
        "infoFiltered": "(filtered from _MAX_ total records)",
        "lengthMenu": "顯示 _MENU_",
        "zeroRecords": "找不到符合的資料",
        "processing": "搜尋中，請稍後，如久無反應請重新整理頁面。",
        "paginate": {
            "previous":"前一頁",
            "next": "下一頁",
            "last": "Last",
            "first": "First"
        }
    };

    // 列表頁的 datatables 設定
    var roi_settings_datatable = $('#roi_settings_datatable').DataTable({
        language: datatables_language,
        paging: true,
        responsive: true,
        searching: true,
        processing: true,
        serverSide: true,
        stateSave: false,
        autoWidth: false,
        select: true,
        dom: 'Brtip',
        ajax: {
            url: '/admin/roi_settings/datatables.json',
            dataSrc: 'data',
            type: 'POST',
        },
        columns:[
            {
                data: 'name',
                name: 'name',
                visible: true,
                orderable: true,
                className: 'editable',
            },
            {
                data: 'description',
                name: 'description',
                visible: true,
                orderable: true,
                className: 'editable',
            },
            {
                // 操作
                data: null,
                visible: false,
                orderable: false,
                render: function ( data, type, full, meta ) {
                    var id = data.id;
                    var actions = '<a href="/admin/roi_settings/' + id + '/edit" class="btn btn-default m-r-5"><span class="glyphicon glyphicon-pencil"></span></a>';
                    actions += '<a href="/admin/roi_settings/' + id + '" data-confirm="確定刪除?" class="btn btn-default" rel="nofollow" data-method="delete"><span class="glyphicon glyphicon-trash"></span></a>';
                    return actions;
                },
            },
        ],
        lengthMenu: [
            [10, 50, 100],
            [10, 50, 100]
        ],
        buttons: [
        ],
        iDisplayLength: 10,
        rowCallback: function( row, data, index ) {
            $(row).attr('data-id', data.id);
            addRowClickEvent(row);
        },
        fnPreDrawCallback: function(){
            $('.dataTables_processing').css("visibility","visible");
            $('.dataTables_processing').css({"display": "block", "z-index": 10000 })
        },
    });

    roi_settings_datatable.on('row-reorder', function(e, diff, edit){
        var data = {rows_sorting:{}}
        var result = '';

        for ( var i=0, ien=diff.length ; i<ien ; i++ ) {
            data['rows_sorting'][$(diff[i].node).data('id')] = diff[i].newData;
        }

        $.ajax({
            type: 'patch',
            url: '/admin/roi_settings/update_row_sorting',
            data: data,
            datatype: 'json'
        });
    });

    // 關鍵字查詢
    $('#keyword_search').keyup(function(e){
        var keycode = (event.keyCode ? event.keyCode : event.which);
        if(keycode == '13'){
            roi_settings_datatable.search($(this).val()).draw() ;
        }
    });
});

var addRowClickEvent = function(row) {
    var id = $(row).attr('data-id')

    $(row).find('td:last-child').off('click').on('click', function() {
        location.href = '/admin/roi_settings/' + id + '/edit';
    });
};
