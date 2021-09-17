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
            url: '/admin/cooperative_companies/update_row',
            type: 'PATCH'
        },
        table: "#cooperative_companies_datatable",
        idSrc: "DT_RowId",
        fields: [
            {
                fieldInfo: '',
                label: 'company_no',
                label: I18n.t('activerecord.attributes.cooperative_company.company_no'),
                name: 'company_no',
            },
            {
                fieldInfo: '',
                label: 'name',
                label: I18n.t('activerecord.attributes.cooperative_company.name'),
                name: 'name',
            },
            {
                fieldInfo: '',
                label: 'description',
                label: I18n.t('activerecord.attributes.cooperative_company.description'),
                name: 'description',
            },
            {
                fieldInfo: '',
                label: 'tax_id',
                label: I18n.t('activerecord.attributes.cooperative_company.tax_id'),
                name: 'tax_id',
            },
            {
                fieldInfo: '',
                label: 'active',
                label: I18n.t('activerecord.attributes.cooperative_company.active'),
                name: 'active',
            },
        ],
    });

    // Activate an inline edit on click of a table cell
    $('#cooperative_companies_datatable').on( 'click', 'tbody td.editable', function (e) {
        editor.inline( this );
    } );

    var cooperative_companies_datatable = $('#cooperative_companies_datatable').DataTable({
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
            url: '/admin/cooperative_companies/datatables.json',
            dataSrc: 'data',
            type: 'POST',
        },
        columns:[
            {
                data: 'company_no',
                name: 'company_no_cont',
                visible: true,
                orderable: true,
                className: 'editable col-company_no',
            },
            {
                data: 'name',
                name: 'name_cont',
                visible: true,
                orderable: true,
                className: 'editable col-name',
            },
            {
                data: 'description',
                name: 'description_cont',
                visible: true,
                orderable: true,
                className: 'editable col-description',
            },
            {
                data: 'tax_id',
                name: 'tax_id_cont',
                visible: true,
                orderable: true,
                className: 'editable col-tax_id',
            },
            {
                data: 'active',
                name: 'active_true',
                visible: true,
                orderable: true,
                className: 'editable col-active',
            },
            {
                // 操作
                data: null,
                visible: true,
                orderable: false,
                render: function ( data, type, full, meta ) {
                    var id = data.id;
                    var actions = '<a href="/admin/cooperative_companies/' + id + '/edit" class="btn btn-default m-r-5"><span class="glyphicon glyphicon-pencil"></span></a>';
                    actions += '<a href="/admin/cooperative_companies/' + id + '" data-confirm="確定刪除?" class="btn btn-default" rel="nofollow" data-method="delete"><span class="glyphicon glyphicon-trash"></span></a>';
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

    cooperative_companies_datatable.on('row-reorder', function(e, diff, edit){
        var data = {rows_sorting:{}}
        var result = '';

        for ( var i=0, ien=diff.length ; i<ien ; i++ ) {
            data['rows_sorting'][$(diff[i].node).data('id')] = diff[i].newData;
        }

        $.ajax({
            type: 'patch',
            url: '/admin/cooperative_companies/update_row_sorting',
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
            cooperative_companies_datatable.search($(this).val()).draw() ;
        }
    });

    $('.filter-company_no').change(function(e){
       datatablesUtils.column_string_filter(cooperative_companies_datatable, e.target.name);
    });

    $('.filter-name').change(function(e){
       datatablesUtils.column_string_filter(cooperative_companies_datatable, e.target.name);
    });


    $('.filter-description').change(function(e){
       datatablesUtils.column_string_filter(cooperative_companies_datatable, e.target.name);
    });


    $('.filter-tax_id').change(function(e){
       datatablesUtils.column_string_filter(cooperative_companies_datatable, e.target.name);
    });


    $('.filter-active').select2({theme:'bootstrap',placeholder: I18n.t('helpers.select.prompt'),allowClear: true,}).on('select2:close', function(e){
       datatablesUtils.column_select_filter(cooperative_companies_datatable, e.target.name);
        });


    // 送出查詢
    $('button.filter-button').click(function(e){
        cooperative_companies_datatable.draw();
    });

    // 清空查詢
    $('button.reset-button').click(function(e){
        $('input').val('');
        $('select').val('').trigger('change.select2');
        cooperative_companies_datatable.search('').columns().search('').draw();
    });
});

var addRowClickEvent = function(row) {
    var id = $(row).attr('data-id')

    $(row).find('td:last-child').off('click').on('click', function() {
    });
};
