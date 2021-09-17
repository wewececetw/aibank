var users_datatable;
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
            url: '/admin/users/update_row',
            type: 'PATCH'
        },
        table: "#users_datatable",
        idSrc: "DT_RowId",
        fields: [
            {
                fieldInfo: '',
                label: 'member_number',
                label: I18n.t('activerecord.attributes.user.member_number'),
                name: 'member_number',
            },
            {
                fieldInfo: '',
                label: 'email',
                label: I18n.t('activerecord.attributes.user.email'),
                name: 'email',
            },
            {
                fieldInfo: '',
                label: 'name',
                label: I18n.t('activerecord.attributes.user.name'),
                name: 'name',
            },
            {
                fieldInfo: '',
                label: 'id_card_number',
                label: I18n.t('activerecord.attributes.user.id_card_number'),
                name: 'id_card_number',
            },
            {
                fieldInfo: '',
                label: 'passport_number',
                label: I18n.t('activerecord.attributes.user.passport_number'),
                name: 'passport_number',
            },
            {
                fieldInfo: '',
                label: 'contact_address',
                label: I18n.t('activerecord.attributes.user.contact_address'),
                name: 'contact_address',
            },
            {
                fieldInfo: '',
                label: 'residence_address',
                label: I18n.t('activerecord.attributes.user.residence_address'),
                name: 'residence_address',
            },
            {
                fieldInfo: '',
                label: 'phone_number',
                label: I18n.t('activerecord.attributes.user.phone_number'),
                name: 'phone_number',
            },
            {
                fieldInfo: '',
                label: 'birthday',
                label: I18n.t('activerecord.attributes.user.birthday'),
                name: 'birthday',
            },
        ],
    });

    // Activate an inline edit on click of a table cell
    $('#users_datatable').on( 'click', 'tbody td.editable', function (e) {
        editor.inline( this );
    } );

    var toggleBannedButtonDisplayBoolean = function() {
        var boolean = $('#js-toggle-banned-button-display-boolean').val();
        return (boolean == 'true' ? true : false);
    }();

    users_datatable = $('#users_datatable').DataTable({
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
            url: '/admin/users/datatables.json',
            dataSrc: 'data',
            type: 'POST',
        },
        columns:[
            {
                data: 'member_number',
                name: 'member_number_cont',
                visible: true,
                orderable: true,
                className: 'excel'
            },
            {
                data: 'name',
                name: 'name_cont',
                visible: true,
                orderable: true,
                className: 'editable excel col-name',
            },
            {
                data: 'id_card_number',
                name: 'id_card_number_cont',
                visible: true,
                orderable: true,
                className: 'editable excel col-id_card_number',
            },
            {
                data: 'passport_number',
                name: 'passport_number_cont',
                visible: true,
                orderable: true,
                className: 'editable excel col-passport_number',
            },
            {
                data: 'confirmed_at',
                name: 'confirmed_at_between',
                visible: true,
                orderable: true,
                className: 'editable col-confirmed_at',
            },
            {
                data: 'vip',
                name: 'roles_name_eq',
                visible: true,
                orderable: false,
                className: 'excel col-vip',
            },
            {
                data: 'alert',
                name: 'roles_name_eq',
                visible: true,
                orderable: false,
                className: 'excel col-alert',
            },
            {
                data: 'approved_at',
                name: 'check_sent_detect',
                visible: true,
                orderable: true,
                className: 'excel col-approved_at',
                render: function ( data, type, full, meta ) {
                    if (!isNaN(data)){
                      var actions = '<a href="/admin/users/' + data+ '" >待審核</a>';
                    }else{
                      actions = data;
                    }
                    return actions;
                }
            },
            {
                data: 'bank_approved',
                name: 'bank_approved_cont',
                visible: true,
                orderable: false,
                className: 'excel col-bank_approved',
            },
            {
                data: 'email',
                name: 'email_cont',
                visible: true,
                orderable: true,
                className: 'editable excel col-email',
            },
            {
                data: 'remember_created_at',
                name: 'remember_created_at_between',
                visible: false,
                orderable: true,
                className: 'editable col-remember_created_at',
            },
            {
                data: 'sign_in_count',
                name: 'sign_in_count_between',
                visible: true,
                orderable: true,
                className: 'editable excel col-sign_in_count',
            },
            {
                data: 'current_sign_in_at',
                name: 'current_sign_in_at_between',
                visible: true,
                orderable: true,
                className: 'editable excel col-current_sign_in_at',
            },
            {
                data: 'last_sign_in_at',
                name: 'last_sign_in_at_between',
                visible: false,
                orderable: true,
                className: 'editable col-last_sign_in_at',
            },
            {
                data: 'current_sign_in_ip',
                name: 'current_sign_in_ip_cont',
                visible: true,
                orderable: true,
                className: 'editable excel col-current_sign_in_ip',
            },
            {
                data: 'last_sign_in_ip',
                name: 'last_sign_in_ip_cont',
                visible: false,
                orderable: true,
                className: 'editable col-last_sign_in_ip',
            },
            {
                data: 'contact_address',
                name: 'contact_address_cont',
                visible: true,
                orderable: true,
                className: 'editable excel col-contact_address',
            },
            {
                data: 'residence_address',
                name: 'residence_address_cont',
                visible: true,
                orderable: true,
                className: 'editable excel col-residence_address',
            },
            {
                data: 'phone_number',
                name: 'phone_number_cont',
                visible: true,
                orderable: true,
                className: 'editable excel col-phone_number',
            },
            {
                data: 'confirmation_sent_at',
                name: 'confirmation_sent_at_between',
                visible: true,
                orderable: true,
                className: 'editable col-confirmation_sent_at',
            },
            {
                data: 'unconfirmed_email',
                name: 'unconfirmed_email_cont',
                visible: true,
                orderable: true,
                className: 'editable col-unconfirmed_email',
            },
            {
                data: 'birthday',
                visible: true,
                orderable: true,
                className: 'editable excel col-birthday excel',
            },
            {
                data: 'id_front_file_name',
                name: 'id_front_file_name_cont',
                visible: true,
                orderable: true,
                className: 'editable col-id_front_file_name',
            },
            {
                data: 'id_front_content_type',
                name: 'id_front_content_type_cont',
                visible: true,
                orderable: true,
                className: 'editable col-id_front_content_type',
            },
            {
                data: 'id_front_file_size',
                name: 'id_front_file_size_between',
                visible: true,
                orderable: true,
                className: 'editable col-id_front_file_size',
            },
            {
                data: 'id_front_updated_at',
                name: 'id_front_updated_at_between',
                visible: true,
                orderable: true,
                className: 'editable col-id_front_updated_at',
            },
            {
                data: 'id_back_file_name',
                name: 'id_back_file_name_cont',
                visible: true,
                orderable: true,
                className: 'editable col-id_back_file_name',
            },
            {
                data: 'id_back_content_type',
                name: 'id_back_content_type_cont',
                visible: true,
                orderable: true,
                className: 'editable col-id_back_content_type',
            },
            {
                data: 'id_back_file_size',
                name: 'id_back_file_size_between',
                visible: true,
                orderable: true,
                className: 'editable col-id_back_file_size',
            },
            {
                data: 'id_back_updated_at',
                name: 'id_back_updated_at_between',
                visible: true,
                orderable: true,
                className: 'editable col-id_back_updated_at',
            },
            {
                data: 'come_from_info',
                name: 'come_from_info',
                visible: false,
                orderable: true,
                className: 'editable excel col-come_from_info',
            },
            {
                data: 'come_from_info_text',
                name: 'come_from_info_text',
                visible: false,
                orderable: true,
                className: 'editable excel col-come_from_info_text',
            },
            {
                data: 'recommendation_code',
                name: 'recommendation_code',
                visible: false,
                orderable: true,
                className: 'editable excel col-come_from_info_text',
            },
            {
                data: 'recommendation_qty',
                name: 'recommendation_qty',
                visible: false,
                orderable: true,
                className: 'editable excel col-come_from_info_text',
            },
            {
                // 操作
                data: null,
                visible: true,
                orderable: false,
                render: function ( data, type, full, meta ) {
                    var id = data.id;
                    var actions = '<a href="/admin/users/' + id + '" class="btn btn-default m-r-5"><span class="glyphicon glyphicon-pencil"></span></a>';

                    if (toggleBannedButtonDisplayBoolean) {

                        if(data.banned) {
                            actions += '<a href="/admin/users/' + id + '/toggle_banned" class="btn btn-success toggle_banned" data-remote="true" data-method="patch">' + I18n.t('labels.user.allow') + '</span></a>';
                        } else {
                            actions += '<a href="/admin/users/' + id + '/toggle_banned" class="btn btn-danger toggle_banned" data-remote="true" data-method="patch">' + I18n.t('labels.user.ban') + '</span></a>';
                        }
                    }

                    return actions;
                },
            },
        ],
        lengthMenu: [
            [10, 50, 100, -1],
            [10, 50, 100, '全部']
        ],
        buttons: [
            { extend: 'excel', text: 'Excel', className: 'btn btn-default datatables_buttons', exportOptions: {columns: '.excel'} },
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

    users_datatable.on('row-reorder', function(e, diff, edit){
        var data = {rows_sorting:{}}
        var result = '';

        for ( var i=0, ien=diff.length ; i<ien ; i++ ) {
            data['rows_sorting'][$(diff[i].node).data('id')] = diff[i].newData;
        }

        $.ajax({
            type: 'patch',
            url: '/admin/users/update_row_sorting',
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
            users_datatable.search($(this).val()).draw() ;
        }
    });

    $('.filter-email').change(function(e){
       datatablesUtils.column_string_filter(users_datatable, e.target.name);
    });


    $('.filter-name').change(function(e){
       datatablesUtils.column_string_filter(users_datatable, e.target.name);
    });


    $('.filter-id_card_number').change(function(e){
       datatablesUtils.column_string_filter(users_datatable, e.target.name);
    });


    $('.filter-passport_number').change(function(e){
       datatablesUtils.column_string_filter(users_datatable, e.target.name);
    });


    $('.filter-contact_address').change(function(e){
       datatablesUtils.column_string_filter(users_datatable, e.target.name);
    });


    $('.filter-residence_address').change(function(e){
       datatablesUtils.column_string_filter(users_datatable, e.target.name);
    });


    $('.filter-phone_number').change(function(e){
       datatablesUtils.column_string_filter(users_datatable, e.target.name);
    });

    $('.filter-birthday').change(function(e){
    });

    $('.filter-member_number').change(function(e){
       datatablesUtils.column_string_filter(users_datatable, e.target.name);
    });

    $('.filter-banned').select2({theme:'bootstrap',width:'100%',placeholder: I18n.t('helpers.select.prompt'),allowClear: true,}).on('select2:close', function(e){
        datatablesUtils.column_select_filter(users_datatable, e.target.name);
    });

    $('.filter-vip').select2({theme:'bootstrap',width:'100%',placeholder: I18n.t('helpers.select.prompt'),allowClear: true,}).on('select2:close', function(e){
        datatablesUtils.column_select_filter(users_datatable, e.target.name);
    });

    $('.filter-alert').select2({theme:'bootstrap',width:'100%',placeholder: I18n.t('helpers.select.prompt'),allowClear: true,}).on('select2:close', function(e){
        datatablesUtils.column_select_filter(users_datatable, e.target.name);
    });

    // 個資審核查詢
    $('#is_check_sent').click(function(){
        var search_value = $(this).prop("checked");
        search_value = search_value ? search_value : '';
        users_datatable.columns(7).search( search_value );
    });

    // 送出查詢
    $('button.filter-button').click(function(e){
        users_datatable.draw();
    });

    // 清空查詢
    $('button.reset-button').click(function(e){
        $('input').val('');
        $('select').val('').trigger('change.select2');
        users_datatable.search('').columns().search('').draw();
    });
});

var addRowClickEvent = function(row) {
    var id = $(row).attr('data-id')

    $(row).find('td:first-child').off('click').on('click', function() {
    });
};
