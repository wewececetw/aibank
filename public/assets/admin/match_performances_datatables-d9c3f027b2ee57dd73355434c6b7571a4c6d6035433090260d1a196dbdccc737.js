$(function() {
    $.fn.dataTable.ext.errMode = function(s,h,m){}

    var datatables_language = {
        "aria": {
            "sortAscending": ": activate to sort column ascending",
            "sortDescending": ": activate to sort column descending"
        },
        "emptyTable": I18n.t('datatables.empty_table'),
        "info": I18n.t('datatables.info'),
        "infoEmpty": I18n.t('datatables.info_empty'),
        "infoFiltered": I18n.t('datatables.info_filtered'),
        "lengthMenu": I18n.t('datatables.length_menu'),
        "zeroRecords": I18n.t('datatables.zero_records'),
        "processing": I18n.t('datatables.processing'),
        "paginate": {
            "previous": I18n.t('datatables.previous'),
            "next": I18n.t('datatables.next'),
            "last": I18n.t('datatables.last'),
            "first": I18n.t('datatables.first')
        },
    };

    // 列表頁的 datatables 設定
    var editor = new $.fn.dataTable.Editor({
        ajax: {
            url: '/admin/match_performances/update_row',
            type: 'PATCH'
        },
        table: "#match_performances_datatable",
        idSrc: "DT_RowId",
        fields: [
            {
                fieldInfo: '',
                label: 'user_income',
                label: I18n.t('activerecord.attributes.match_performance.user_income'),
                name: 'user_income',
            },
            {
                fieldInfo: '',
                label: 'invest_amount',
                label: I18n.t('activerecord.attributes.match_performance.invest_amount'),
                name: 'invest_amount',
            },
            {
                fieldInfo: '',
                label: 'annual_avg',
                label: I18n.t('activerecord.attributes.match_performance.annual_avg'),
                name: 'annual_avg',
            },
        ],
    });

    // Activate an inline edit on click of a table cell
    $('#match_performances_datatable').on( 'click', 'tbody td.editable', function (e) {
        editor.inline( this );
    } );

    var match_performances_datatable = $('#match_performances_datatable').DataTable({
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
            url: '/admin/match_performances/datatables.json',
            dataSrc: 'data',
            type: 'POST',
        },
        columns:[
            {
                data: 'user_income',
                name: 'user_income_between',
                visible: true,
                orderable: true,
                className: 'editable col-user_income',
            },
            {
                data: 'invest_amount',
                name: 'invest_amount_between',
                visible: true,
                orderable: true,
                className: 'editable col-invest_amount',
            },
            {
                data: 'annual_avg',
                name: 'annual_avg_between',
                visible: true,
                orderable: true,
                className: 'editable col-annual_avg',
            },
            {
                // 操作
                data: null,
                visible: true,
                orderable: false,
                render: function ( data, type, full, meta ) {
                    var id = data.id;
                    var actions = '<a href="/admin/match_performances/' + id + '/edit" class="btn btn-default m-r-5"><span class="glyphicon glyphicon-pencil"></span></a>';
                    actions += '<a href="/admin/match_performances/' + id + '" data-confirm="確定刪除?" class="btn btn-default" rel="nofollow" data-method="delete"><span class="glyphicon glyphicon-trash"></span></a>';
                    return actions;
                },
            },
        ],
        lengthMenu: [
            [10, 50, 100],
            [10, 50, 100]
        ],
        buttons: [
            { extend: 'edit', editor: editor, text: '編輯', className: 'btn btn-default m-b-5' },
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

    match_performances_datatable.on('row-reorder', function(e, diff, edit){
        var data = {rows_sorting:{}}
        var result = '';

        for ( var i=0, ien=diff.length ; i<ien ; i++ ) {
            data['rows_sorting'][$(diff[i].node).data('id')] = diff[i].newData;
        }

        $.ajax({
            type: 'patch',
            url: '/admin/match_performances/update_row_sorting',
            data: data,
            datatype: 'json'
        });
    });

    editor.on( 'initEdit', function () {
        // Disable for edit (re-ordering is performed by click and drag)
    } );

    // 關鍵字查詢
    $('#keyword_search').keyup(function(e){
        var keycode = (event.keyCode ? event.keyCode : event.which);
        if(keycode == '13'){
            match_performances_datatable.search($(this).val()).draw() ;
        }
    });

$('.filter-user_income').change(function(e){
       datatablesUtils.column_range_filter(match_performances_datatable, e.target.name);
    });


    $('.filter-invest_amount').change(function(e){
       datatablesUtils.column_range_filter(match_performances_datatable, e.target.name);
    });


    $('.filter-annual_avg').change(function(e){
       datatablesUtils.column_range_filter(match_performances_datatable, e.target.name);
    });


    // 送出查詢
    $('button.filter-button').click(function(e){
        match_performances_datatable.draw();
    });

    // 清空查詢
    $('button.reset-button').click(function(e){
        $('input').val('');
        $('select').val('').trigger('change.select2');
        match_performances_datatable.search('').columns().search('').draw();
    });
});

var addRowClickEvent = function(row) {
    var id = $(row).attr('data-id')

    $(row).find('td:last-child').off('click').on('click', function() {
    });
};
