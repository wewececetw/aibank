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
            url: '/admin/claim_repayments/update_row',
            type: 'PATCH'
        },
        table: "#claim_repayments_datatable",
        idSrc: "DT_RowId",
        fields: [
            {
                type: 'datetime',
                format: 'YYYY/MMM/D HH:mm',
                fieldInfo: '',
                label: 'paid_at',
                label: I18n.t('activerecord.attributes.claim_repayment.paid_at'),
                name: 'paid_at',
            },
            {
                type: 'datetime',
                format: 'YYYY/MMM/D HH:mm',
                fieldInfo: '',
                label: 'credited_at',
                label: I18n.t('activerecord.attributes.claim_repayment.credited_at'),
                name: 'credited_at',
            },
            {
                fieldInfo: '',
                label: 'amount',
                label: I18n.t('activerecord.attributes.claim_repayment.amount'),
                name: 'amount',
            },
            {
                fieldInfo: '',
                label: 'period_number',
                label: I18n.t('activerecord.attributes.claim_repayment.period_number'),
                name: 'period_number',
            },
            {
                fieldInfo: '',
                label: 'bank_code',
                label: I18n.t('activerecord.attributes.claim_repayment.bank_code'),
                name: 'bank_code',
            },
            {
                fieldInfo: '',
                label: 'bank_account_number',
                label: I18n.t('activerecord.attributes.claim_repayment.bank_account_number'),
                name: 'bank_account_number',
            },
            {
                fieldInfo: '',
                label: 'remark',
                label: I18n.t('activerecord.attributes.claim_repayment.remark'),
                name: 'remark',
            },
        ],
    });

    // Activate an inline edit on click of a table cell
    $('#claim_repayments_datatable').on( 'click', 'tbody td.editable', function (e) {
        editor.inline( this );
    } );

    var claim_repayments_datatable = $('#claim_repayments_datatable').DataTable({
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
            url: '/admin/claim_repayments/datatables.json',
            dataSrc: 'data',
            type: 'POST',
        },
        columns:[
            {
                data: 'claim_number',
                name: 'claim_id_eq',
                visible: true,
                orderable: true,
                className: 'editable col-claim_id',
            },
            {
                data: 'claim_state_i18n',
                name: 'claim_state_enum',
                visible: true,
                orderable: false,
                className: 'editable',
            },

            {
                data: 'paid_at',
                name: 'paid_at_between',
                visible: true,
                orderable: true,
                className: 'editable col-paid_at',
            },
            {
                data: 'credited_at',
                name: 'credited_at_between',
                visible: false,
                orderable: true,
                className: 'editable col-credited_at',
            },
            {
                data: 'amount',
                name: 'amount_between',
                visible: true,
                orderable: true,
                className: 'editable col-amount',
            },
            {
                data: 'period_number',
                name: 'period_number_between',
                visible: false,
                orderable: true,
                className: 'editable col-period_number',
            },
            {
                data: 'bank_code',
                name: 'bank_code_cont',
                visible: false,
                orderable: true,
                className: 'editable col-bank_code',
            },
            {
                data: 'bank_account_number',
                name: 'bank_account_number_cont',
                visible: false,
                orderable: true,
                className: 'editable col-bank_account_number',
            },
            {
                data: 'remark',
                name: 'remark_cont',
                visible: true,
                orderable: true,
                className: 'editable col-remark',
            },
            {
                data: 'state_i18n',
                name: 'state_enum',
                visible: true,
                orderable: true,
                className: 'editable col-state',
            },
            {
                // 操作
                data: null,
                visible: true,
                orderable: false,
                render: function ( data, type, full, meta ) {
                    var id = data.id;
                    var actions = '<a href="/admin/claim_repayments/' + id + '/edit" class="btn btn-default m-r-5"><span class="glyphicon glyphicon-pencil"></span></a>';
                    actions += '<a href="/admin/claim_repayments/' + id + '" data-confirm="確定刪除?" class="btn btn-default" rel="nofollow" data-method="delete"><span class="glyphicon glyphicon-trash"></span></a>';
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

    claim_repayments_datatable.on('row-reorder', function(e, diff, edit){
        var data = {rows_sorting:{}}
        var result = '';

        for ( var i=0, ien=diff.length ; i<ien ; i++ ) {
            data['rows_sorting'][$(diff[i].node).data('id')] = diff[i].newData;
        }

        $.ajax({
            type: 'patch',
            url: '/admin/claim_repayments/update_row_sorting',
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
            claim_repayments_datatable.search($(this).val()).draw() ;
        }
    });

    claim_repayment_claim_id_select2.on('select2:close', function(e){
        datatablesUtils.column_select_filter(claim_repayments_datatable, e.target.name);
    });


    $('.filter-paid_at').change(function(e){
       datatablesUtils.column_range_filter(claim_repayments_datatable, e.target.name);
    });


    $('.filter-credited_at').change(function(e){
       datatablesUtils.column_range_filter(claim_repayments_datatable, e.target.name);
    });


    $('.filter-amount').change(function(e){
       datatablesUtils.column_range_filter(claim_repayments_datatable, e.target.name);
    });


    $('.filter-period_number').change(function(e){
       datatablesUtils.column_range_filter(claim_repayments_datatable, e.target.name);
    });


    $('.filter-bank_code').change(function(e){
       datatablesUtils.column_string_filter(claim_repayments_datatable, e.target.name);
    });


    $('.filter-bank_account_number').change(function(e){
       datatablesUtils.column_string_filter(claim_repayments_datatable, e.target.name);
    });


    $('.filter-state').select2({theme:'bootstrap',placeholder: I18n.t('helpers.select.prompt'),allowClear: true,}).on('select2:close', function(e){
       datatablesUtils.column_select_filter(claim_repayments_datatable, e.target.name);
        });


    $('.filter-remark').change(function(e){
       datatablesUtils.column_string_filter(claim_repayments_datatable, e.target.name);
    });


    // 送出查詢
    $('button.filter-button').click(function(e){
        claim_repayments_datatable.draw();
    });

    // 清空查詢
    $('button.reset-button').click(function(e){
        $('input').val('');
        $('select').val('').trigger('change.select2');
        claim_repayments_datatable.search('').columns().search('').draw();
    });
});

var addRowClickEvent = function(row) {
    var id = $(row).attr('data-id')

    $(row).find('td:last-child').off('click').on('click', function() {
    });
};
