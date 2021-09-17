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
            url: '/admin/tender_documents/update_row',
            type: 'PATCH'
        },
        table: "#tender_documents_datatable",
        idSrc: "DT_RowId",
        fields: [
            {
                fieldInfo: '',
                label: 'claim_id',
                label: I18n.t('activerecord.attributes.tender_document.claim_id'),
                name: 'claim_id',
            },
            {
                fieldInfo: '',
                label: 'order_number',
                label: I18n.t('activerecord.attributes.tender_document.order_number'),
                name: 'order_number',
            },
            {
                fieldInfo: '',
                label: 'amount',
                label: I18n.t('activerecord.attributes.tender_document.amount'),
                name: 'amount',
            },
            {
                fieldInfo: '',
                label: 'repayment_method',
                label: I18n.t('activerecord.attributes.tender_document.repayment_method'),
                name: 'repayment_method',
            },
            {
                fieldInfo: '',
                label: 'claim_certificate_number',
                label: I18n.t('activerecord.attributes.tender_document.claim_certificate_number'),
                name: 'claim_certificate_number',
            },
            {
                fieldInfo: '',
                label: 'state',
                label: I18n.t('activerecord.attributes.tender_document.state'),
                name: 'state',
            },
            {
                type: 'datetime',
                format: 'YYYY/MMM/D HH:mm',
                fieldInfo: '',
                label: 'paid_at',
                label: I18n.t('activerecord.attributes.tender_document.paid_at'),
                name: 'paid_at',
            },
        ],
    });

    // Activate an inline edit on click of a table cell
    $('#tender_documents_datatable').on( 'click', 'tbody td.editable', function (e) {
        editor.inline( this );
    } );

    // 強制提早還款
    var force_repayment_early = function(){
        var boolean = $('#js-force_repayment_early').val();
        return (boolean == 'true' ? true : false);
    }();

    // table左上button group
    var dataTableButtons = function() {
        return [
            {
                // text: I18n.t('labels.claim.batch_collecting_btn'),
                text: "批次標單取消",
                action: function ( e, dt, node, config ) {
                    var rows = dt.rows( { selected: true } ).data();

                    if(rows.length === 0){
                        // swal(I18n.t('labels.claim.please_at_least_select_one_row', '', 'error'));
                        swal("請選擇一筆標單");
                        return false;
                    }

                    var row_id = rows[0].id;
                    $.ajax({
                        url: '/admin/tender_documents/check_tender_documents',
                        type: 'POST',
                        dataType: 'json', data: {tender_document_id: row_id},
                        success: function(result){
                            // swal(I18n.t('labels.claim.update_collecting_successful'), '', 'success');
                            swal({
                              title: "確定刪除這些標單？",
                              text: result.tender_documents.join("\r\n") + "\r\n" + "總金額：" + result.total,
                              icon: "warning",
                              buttons: true,
                              dangerMode: true,
                            })
                            .then((willDelete) => {
                                if (willDelete) {
                                    $.ajax({
                                        url: '/admin/tender_documents/destroy_tender_documents',
                                        type: 'POST',
                                        dataType: 'json', 
                                        data: {
                                            tender_document_ids: result.tender_documents.toString()
                                        },
                                        success: function(result){
                                            if(result['status']){
                                                swal("標單取消成功", {icon: "success",});
                                                export_url = result['url']
                                                return_paid = result['return_paid']
                                                if(parseInt(return_paid) > 0 ){
                                                    location.href = '../'+export_url;
                                                }
                                            }else{
                                                swal("標單取消失敗\r\n有標單之債權為結標狀態，無法退款", {icon: "success",});
                                            }
                                            tender_documents_datatable.draw();
                                        }
                                    });
                                }else{
                                    tender_documents_datatable.draw();
                                }
                            });
                        }
                    });
                },
                className: 'btn btn-default datatables_buttons set_period_deadline_btn'
            },
        ]
    };


    var tender_documents_datatable = $('#tender_documents_datatable').DataTable({
        language: datatables_language,
        paging: true,
        responsive: true,
        searching: true,
        processing: true,
        serverSide: true,
        stateSave: false,
        autoWidth: false,
        select: true,
        dom: 'Brtip"bottom"l',
        ajax: {
            url: '/admin/tender_documents/datatables.json',
            dataSrc: function(res) {
                console.log(res.data);
                return res.data;
            },
            type: 'POST',
        },
        columns:[
            {
                data: 'claim_certificate_number',
                name: 'claim_certificate_number_eq',
                visible: true,
                orderable: true,
                className: 'excel col-claim_certificate_number',
            },
            {
                data: 'user_member_number',
                name: 'user_member_number_eq',
                visible: true,
                orderable: true,
                className: 'excel col-user_member_number',
            },
            {
                data: 'user_name',
                name: 'user_name_eq',
                visible: true,
                orderable: true,
                className: 'excel col-user_name',
            },
            {
                data: 'order_number',
                name: 'order_number_eq',
                visible: true,
                orderable: true,
                className: 'excel col-order_number',
            },
            {
                data: 'claim_claim_number',
                name: 'claim_claim_number_eq',
                visible: true,
                orderable: true,
                className: 'excel col-claim_claim_number',
            },
            {
                data: 'state_i18n',
                name: 'state_enum',
                visible: true,
                orderable: true,
                className: 'excel col-state',
            },
            {
                data: 'amount',
                name: 'amount_eq',
                visible: true,
                orderable: true,
                className: 'excel col-amount',
            },
            {
                data: 'claim_periods',
                name: 'claim_periods_eq',
                visible: true,
                orderable: true,
                className: 'excel col-claim_periods',
            },
            {
                data: 'claim_annual_interest_rate',
                name: 'claim_annual_interest_rate_eq',
                visible: true,
                orderable: true,
                className: 'excel col-claim_annual_interest_rate',
            },
            {
                data: 'repayment_method',
                name: 'repayment_method_eq',
                visible: true,
                orderable: true,
                className: 'excel col-state',
            },

            {
                // 操作
                data: null,
                visible: true,
                orderable: false,
                render: function ( data, type, full, meta ) {
                    var id = data.id;
                    var actions = '<a href="/admin/tender_documents/' + id + '" class="btn btn-default"><span class="glyphicon glyphicon-eye-open"></span></a>';
                    return actions;
                },
            },
            {
                // 操作
                data: null,
                visible: true,
                orderable: false,
                render: function ( data, type, full, meta ) {
                    var id = data.id;
                    var actions = "";
                    if(data.state == 'subscription' || data.state == 'checked_out' || data.state =="abnormal"){
                        actions = '<a href="/admin/tender_documents/pay?id=' + id + '" data-confirm="確定更改為已繳款?" class="btn btn-default" rel="nofollow" data-method="patch"><span class="glyphicon glyphicon-usd"></span></a>';
                    }
                    if( force_repayment_early && (data.state === 'repayment' || data.state === 'paid') ){
                        actions += '<a href="/admin/tender_documents/' + data.id + '/force_repayment_early" data-confirm="確定強制提早還款?" class="btn btn-danger" rel="nofollow" data-method="patch" style="display: none;">強制提早還款</a>';
                    }
                    return actions;
                },
            },
            {
                // 操作
                data: null,
                visible: true,
                orderable: false,
                render: function ( data, type, full, meta ) {
                    var id = data.id;
                    var actions = "";
                    if( data.state == 'checked_out' || data.state == 'abnormal'){
                        actions = '<a href="/admin/tender_documents/company_buy?id=' + id + '" data-confirm="確定將此筆標單列入公司帳號下?" class="btn btn-default" rel="nofollow" data-method="patch"><span class="glyphicon glyphicon-user"></span></a>';
                    }
                    return actions;
                },
            },
            {
                data: 'paid_at',
                name: 'paid_at_between',
                visible: false,
                orderable: false,
                className: 'col-paid_at',
            },
            {
                data: 'user_id_card_number',
                name: 'user_id_card_number_eq',
                visible: false,
                orderable: false,
                className: 'col-user_id_card_number',
            },
            {
                data: 'repayment_state_i18n',
                name: 'repayment_state_enum',
                visible: false,
                orderable: false,
                className: 'col-repayment_state',
            },
            {
                data: 'claim_value',
                name: 'claim_value_date_between',
                visible: false,
                orderable: false,
                className: 'col-value_date',
            },
            {
                data: 'target_repayment_date',
                name: 'tender_repayments_target_repayment_date_between',
                visible: false,
                orderable: false,
                className: 'col-target_repayment_date',
            },
        ],
        lengthMenu: [
            [10, 50, 100, -1],
            [10, 50, 100, I18n.t('helpers.datatables.length_menu_all')]
        ],
        buttons: [ dataTableButtons()
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

    tender_documents_datatable.on('row-reorder', function(e, diff, edit){
        var data = {rows_sorting:{}}
        var result = '';

        for ( var i=0, ien=diff.length ; i<ien ; i++ ) {
            data['rows_sorting'][$(diff[i].node).data('id')] = diff[i].newData;
        }

        $.ajax({
            type: 'patch',
            url: '/admin/tender_documents/update_row_sorting',
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
            tender_documents_datatable.search($(this).val()).draw() ;
        }
    });

tender_document_claim_id_select2.on('select2:close', function(e){
        datatablesUtils.column_select_filter(claim_repayments_datatable, e.target.name);
        });


    $('.filter-order_number').change(function(e){
       datatablesUtils.column_string_filter(tender_documents_datatable, e.target.name);
    });


    $('.filter-amount').change(function(e){
       datatablesUtils.column_range_filter(tender_documents_datatable, e.target.name);
    });


    $('.filter-repayment_method').change(function(e){
       datatablesUtils.column_range_filter(tender_documents_datatable, e.target.name);
    });


    $('.filter-claim_certificate_number').change(function(e){
       datatablesUtils.column_string_filter(tender_documents_datatable, e.target.name);
    });


    $('.filter-state').select2({theme:'bootstrap',width:'100%',placeholder: I18n.t('helpers.select.prompt'),allowClear: true,}).on('select2:close', function(e){
        datatablesUtils.column_select_filter(tender_documents_datatable, e.target.name);
    });

    $('.filter-repayment_state').select2({theme:'bootstrap',width:'100%',placeholder: I18n.t('helpers.select.prompt'),allowClear: true,}).on('select2:close', function(e){
        console.log(e.target.name);
        datatablesUtils.column_select_filter(tender_documents_datatable, e.target.name);
    });

    $('.filter-paid_at').change(function(e){
       datatablesUtils.column_range_filter(tender_documents_datatable, e.target.name);
    });

    $('.filter-value_date').change(function(e){
       datatablesUtils.column_range_filter(tender_documents_datatable, e.target.name);
    });

    $('.filter-target_repayment_date').change(function(e){
       datatablesUtils.column_range_filter(tender_documents_datatable, e.target.name);
    });


    $('.filter-claim_claim_number').change(function(e){
        datatablesUtils.column_string_filter(tender_documents_datatable, e.target.name);
    })

    $('.filter-user_name').change(function(e){
        datatablesUtils.column_string_filter(tender_documents_datatable, e.target.name);
    })

    $('.filter-user_member_number').change(function(e){
        datatablesUtils.column_string_filter(tender_documents_datatable, e.target.name);
    })

    $('.filter-user_id_card_number').change(function(e){
        datatablesUtils.column_string_filter(tender_documents_datatable, e.target.name);
    })

    // 送出查詢
    $('button.filter-button').click(function(e){
        tender_documents_datatable.draw();
    });

    // 清空查詢
    $('button.reset-button').click(function(e){
        $('input').val('');
        $('select').val('').trigger('change.select2');
        tender_documents_datatable.search('').columns().search('').draw();
    });
});

var addRowClickEvent = function(row) {
    var id = $(row).attr('data-id')

    $(row).find('td:last-child').off('click').on('click', function() {
    });
};
