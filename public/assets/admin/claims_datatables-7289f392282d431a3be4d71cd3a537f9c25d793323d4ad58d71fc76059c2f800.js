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
    CLAIMS_DATA = null;

    // 債權匯入/新增、修改的button顯示
    var claimsEditButtonDisplayBoolean = function() {
        var boolean = $('#js-claims-edit-button-display-boolean').val();
        return (boolean == 'true' ? true : false);
    }();

    // 債權募集/結標/設定/隱藏/刪除的button顯示
    var collectCloseSetupVisibleOrDestroyButtonDisplayBoolean = function() {
        var boolean = $('#js-claims-collect-close-setup-visible-or-destroy-button-display-boolean').val();
        return (boolean == 'true' ? true : false);
    }();

    var isDevelopment = function(){
        var environment = $('#environmentVariable').val();
        return (environment == 'development' ? true : false);
    }() 

    // table左上button group
    var dataTableButtons = function(collectBoolean) {
        if (collectBoolean) {
            return [
                { extend: 'selectAll', text: '全選', className: 'btn btn-default datatables_buttons' },
                { extend: 'selectNone', text: '全不選', className: 'btn btn-default datatables_buttons' },
                {
                    text: I18n.t('labels.claim.batch_collecting_btn'),
                    action: function ( e, dt, node, config ) {
                        var rows = dt.rows( { selected: true } ).data();

                        if(rows.length === 0){
                            swal(I18n.t('labels.claim.please_at_least_select_one_row', '', 'error'));
                            return false;
                        }

                        var row_ids = rows.map(function(elem){return elem.id;}).join(",");

                        $.ajax({
                            url: '/admin/claims/batch_collecting',
                            type: 'PATCH',
                            dataType: 'json', data: {claim_ids: row_ids},
                            success: function(result){
                                swal(I18n.t('labels.claim.update_collecting_successful'), '', 'success');
                                claims_datatable.draw();
                            }
                        });
                    },
                    className: 'btn btn-default datatables_buttons set_period_deadline_btn'
                },
            ]
        } else {
            return [
                { extend: 'selectAll', text: '全選', className: 'btn btn-default datatables_buttons' },
                { extend: 'selectNone', text: '全不選', className: 'btn btn-default datatables_buttons' },
            ]
        }
    };


    var claims_datatable = $('#claims_datatable').DataTable({
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
            url: '/admin/claims/datatables.json',
            dataSrc: function(res) {
                CLAIMS_DATA = res.data;
                return res.data;
            },
            type: 'POST',
        },
        columns:[
            {
                data: null,
                visible: true,
                orderable: true,
                render: function(data, type, full, meta) {
                    return '<a href="/admin/claims/' + data.id + '">' + data.claim_number + '</a>';
                },
            },
            {
                data: 'serial_number',
                name: 'serial_number_cont',
                visible: true,
                orderable: true,
                searchable: true,
                className: 'editable col-serial_number'
            },
            {
                data: 'state_i18n',
                name: 'state_eq',
                visible: true,
                orderable: true,
                className: 'editable col-state'
            },
            {
                data: 'number_of_sales',
                name: 'number_of_sales_eq',
                visible: true,
                orderable: true,
                className: 'editable col-nubmer_of_salse'
            },
            {
                data: null,
                name: 'staging_amount',
                visible: true,
                orderable: true,
                searchable: false,
                className: 'editable col-staging_amount',
                render: function(data, _, _, _) {
                    return data.staging_amount * data.auto_close_threshold / 100;
                }
            },
            {
                data: 'periods',
                name: 'periods',
                visible: true,
                orderable: true,
                searchable: false,
                className: 'editable col-periods'
            },
            {
                data: 'collected',
                name: 'collected',
                visible: true,
                orderable: true,
                searchable: false,
                className: 'editable col-periodic_payment'
            },
            {
                data: 'actual_collected',
                name: 'actual_collected',
                visible: true,
                orderable: true,
                searchable: false,
                className: 'editable col-remaining_balance'
            },
            {
                data: null,
                visible: collectCloseSetupVisibleOrDestroyButtonDisplayBoolean,
                orderable: false,
                searchable: false,
                render: function(data, type, full, meta) {
                    var btn_html = '';
                    if( data.closed_at === null && data.state !== 'floating' ) {
                        btn_html = '<a href="/admin/claims/' + data.id + '/close" data-confirm="確定結標?" class="btn btn-danger" rel="nofollow" data-method="put" style="display: none;">結標</a>';
                    }
                    return btn_html;
                }
            },
            {
                data: null,
                visible: collectCloseSetupVisibleOrDestroyButtonDisplayBoolean,
                orderable: false,
                searchable: false,
                render: function(data, type, full, meta) {
                    var btn_html = '';

                    if( data.state === 'previewing') {
                        btn_html = '<a href="#" data-id="' + data.id + '" class="btn btn-primary claims" rel="nofollow">設定</a>';
                    }

                    return btn_html;
                }
            },
            {
                data: null,
                visible: collectCloseSetupVisibleOrDestroyButtonDisplayBoolean,
                orderable: false,
                searchable: false,
                render: function(data, type, full, meta) {
                    var visible = data.visible === false ? '顯示' : '隱藏';
                    return '<a href="/admin/claims/' + data.id + '/visible" class="btn btn-info" rel="nofollow" data-method="put">' + visible + '</a>';
                }
            },
            {
                // 操作
                data: null,
                visible: true,
                orderable: false,
                searchable: false,
                render: function ( data, type, full, meta ) {
                    var id = data.id;
                    var actions = '';

                    if(data.editable) {
                        if(claimsEditButtonDisplayBoolean && collectCloseSetupVisibleOrDestroyButtonDisplayBoolean) {
                            actions += '<a href="/admin/claims/' + id + '/edit" class="btn btn-default m-r-5"><span class="glyphicon glyphicon-pencil"></span></a>';
                            actions += '<a href="/admin/claims/' + id + '" class="btn btn-default delete-claim-btn" rel="nofollow" data-method="delete" data-id="'+ id +'"><span class="glyphicon glyphicon-trash"></span></a>';
                        } else if(claimsEditButtonDisplayBoolean) {
                            actions += '<a href="/admin/claims/' + id + '/edit" class="btn btn-default m-r-5"><span class="glyphicon glyphicon-pencil"></span></a>';
                        } else if(collectCloseSetupVisibleOrDestroyButtonDisplayBoolean) {
                            actions += '<a href="/admin/claims/' + id + '" class="btn btn-default delete-claim-btn" rel="nofollow" data-method="delete" data-id="'+ id +'"><span class="glyphicon glyphicon-trash"></span></a>';
                        }
                    }

                    if( isDevelopment && data.state === 'collecting' ){
                        actions += '<a href="/admin/claims/' + data.id + '/force_float_early" data-confirm="確定強制流標?" class="btn btn-danger" rel="nofollow" data-method="patch">強制流標</a>';
                        actions += '<a href="/admin/claims/' + id + '/edit" class="btn btn-default m-r-5"><span class="glyphicon glyphicon-picture"></span></a>';
                    }

                    return actions;
                },
            },
            {
                data: 'launched_at',
                name: 'launched_at_between',
                visible: false,
                orderable: false,
                className: 'col-launched_at'
            },
            {
                data: 'estimated_close_date',
                name: 'estimated_close_date_between',
                visible: false,
                orderable: false,
                className: 'col-estimated_close_date'
            },
            {
                data: 'closed_at',
                name: 'closed_at_between',
                visible: false,
                orderable: false,
                className: 'col-closed_at'
            },
            {
                data: 'risk_category',
                name: 'risk_category_eq',
                visible: false,
                orderable: false,
                className: 'col-risk_category'
            },
            {
                data: 'typing',
                name: 'typing_cont',
                visible: false,
                orderable: false,
                className: 'col-typing'
            },
            {
                data: 'claim_number',
                name: 'claim_number_cont',
                visible: false,
                orderable: false,
                searchable: true,
                className: 'col-claim_number'
            },
        ],
        lengthMenu: [
            [10, 50, 100],
            [10, 50, 100]
        ],
        buttons: dataTableButtons(collectCloseSetupVisibleOrDestroyButtonDisplayBoolean)
        ,
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

    claims_datatable.on('row-reorder', function(e, diff, edit){
        var data = {rows_sorting:{}}
        var result = '';

        for ( var i=0, ien=diff.length ; i<ien ; i++ ) {
            data['rows_sorting'][$(diff[i].node).data('id')] = diff[i].newData;
        }

        $.ajax({
            type: 'patch',
            url: '/admin/claims/update_row_sorting',
            data: data,
            datatype: 'json'
        });
    });

    // 關鍵字查詢
    $('#keyword_search').keyup(function(event) {
        var keycode = (event.keyCode ? event.keyCode : event.which);
        if (keycode == '13') {
            claims_datatable.search($(this).val()).draw();
        }
    });

    $('button.filter-button').click(function(e) {
        claims_datatable.draw();
    });

    $('button.reset-button').click(function(e) {
        $('input').val('');
        $('select').val('').trigger('change.select2');
        claims_datatable.search('').columns().search('').draw();
    });

    $('.filter-claim_number, .filter-typing').change(function(e) {
        datatablesUtils.column_string_filter(claims_datatable, e.target.name);
    });

    $('.filter-serial_number').change(function(e) {
        datatablesUtils.column_string_filter(claims_datatable, e.target.name);
    });

    $('.filter-launched_at, .filter-closed_at, .filter-estimated_close_date').change(function(e) {
        datatablesUtils.column_range_filter(claims_datatable, e.target.name);
    });

    $('.filter-state, .filter-grouping, .filter-risk_category').select2({theme: 'bootstrap'}).on('select2:close', function(e) {
        datatablesUtils.column_select_filter(claims_datatable, e.target.name);
    });

    $('#claims_datatable').on('click', '.delete-claim-btn', function(){
        var id = $(this).data('id');
        var random_number = Math.round( Math.random() * 10000 );
        bootbox.prompt({
            title: "請輸入指定數字 "+ random_number +" 來刪除物件。",
            inputType: 'number',
            callback: function(result){
                if(random_number === parseInt(result)){
                    $.ajax({
                        url: '/admin/claims/'+ id,
                        type: 'DELETE',
                        dataType: 'json',
                        success: function(result){
                            swal('已成功刪除債權資料。', "", "info");
                            claims_datatable.draw();
                        }
                    });
                } else if(result !== null) {
                    bootbox.alert("輸入數字不正確!");
                };
            }
        });
        return false;
    });
});


$('#export-floating').click(function(e){
    $.ajax({
        type: "POST",
        url: '/admin/claims/export_floating/',
        dataType: 'json',
        success: function(data,status,xhr) {
            export_url = data[0]['url']
            location.href = '../'+export_url;
        },
        erroe: function(xhr, ajaxOptions, thrownError) {
            console.log(xhr);
            console.log(ajaxOptions);
            console.log(thrownError);
        }
    });
});

$('#export_claim_state').click(function(e){
    var startTime = $("#claim_state_start").val();
    var endTime = $("#claim_state_end").val();
    $.ajax({
        type: "POST",
        url: '/admin/claims/export_claim_state/',
        data: {"start_time" : startTime, "end_time": endTime},
        dataType: 'json',
        success: function(data,status,xhr) {
            export_url = data[0]['url']
            location.href = '../'+export_url;
        },
        erroe: function(xhr, ajaxOptions, thrownError) {
            console.log(xhr);
            console.log(ajaxOptions);
            console.log(thrownError);
        }
    });
});


var addRowClickEvent = function(row) {
    var id = $(row).attr('data-id')

    // $(row).find('td:last-child').off('click').on('click', function() {
    //   location.href = '/admin/claims/' + id + '/edit';
    // });
};
