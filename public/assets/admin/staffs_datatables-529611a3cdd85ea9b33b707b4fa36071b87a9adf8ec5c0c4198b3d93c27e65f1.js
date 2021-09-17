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
            url: '/admin/staffs/update_row',
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
                label: 'name',
                label: I18n.t('activerecord.attributes.user.name'),
                name: 'name',
            },
            {
                fieldInfo: '',
                label: 'email',
                label: I18n.t('activerecord.attributes.user.email'),
                name: 'email',
            },
            {
                type: 'datetime',
                format: 'YYYY/MMM/D HH:mm',
                fieldInfo: '',
                label: 'remember_created_at',
                label: I18n.t('activerecord.attributes.user.remember_created_at'),
                name: 'remember_created_at',
            },
            {
                fieldInfo: '',
                label: 'sign_in_count',
                label: I18n.t('activerecord.attributes.user.sign_in_count'),
                name: 'sign_in_count',
            },
            {
                type: 'datetime',
                format: 'YYYY/MMM/D HH:mm',
                fieldInfo: '',
                label: 'current_sign_in_at',
                label: I18n.t('activerecord.attributes.user.current_sign_in_at'),
                name: 'current_sign_in_at',
            },
            {
                type: 'datetime',
                format: 'YYYY/MMM/D HH:mm',
                fieldInfo: '',
                label: 'last_sign_in_at',
                label: I18n.t('activerecord.attributes.user.last_sign_in_at'),
                name: 'last_sign_in_at',
            },
            {
                fieldInfo: '',
                label: 'current_sign_in_ip',
                label: I18n.t('activerecord.attributes.user.current_sign_in_ip'),
                name: 'current_sign_in_ip',
            },
            {
                fieldInfo: '',
                label: 'last_sign_in_ip',
                label: I18n.t('activerecord.attributes.user.last_sign_in_ip'),
                name: 'last_sign_in_ip',
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
                type: 'datetime',
                format: 'YYYY/MMM/D HH:mm',
                fieldInfo: '',
                label: 'confirmed_at',
                label: I18n.t('activerecord.attributes.user.confirmed_at'),
                name: 'confirmed_at',
            },
            {
                type: 'datetime',
                format: 'YYYY/MMM/D HH:mm',
                fieldInfo: '',
                label: 'confirmation_sent_at',
                label: I18n.t('activerecord.attributes.user.confirmation_sent_at'),
                name: 'confirmation_sent_at',
            },
            {
                fieldInfo: '',
                label: 'unconfirmed_email',
                label: I18n.t('activerecord.attributes.user.unconfirmed_email'),
                name: 'unconfirmed_email',
            },
            {
                fieldInfo: '',
                label: 'birthday',
                label: I18n.t('activerecord.attributes.user.birthday'),
                name: 'birthday',
            },
            {
                fieldInfo: '',
                label: 'id_front_file_name',
                label: I18n.t('activerecord.attributes.user.id_front_file_name'),
                name: 'id_front_file_name',
            },
            {
                fieldInfo: '',
                label: 'id_front_content_type',
                label: I18n.t('activerecord.attributes.user.id_front_content_type'),
                name: 'id_front_content_type',
            },
            {
                fieldInfo: '',
                label: 'id_front_file_size',
                label: I18n.t('activerecord.attributes.user.id_front_file_size'),
                name: 'id_front_file_size',
            },
            {
                type: 'datetime',
                format: 'YYYY/MMM/D HH:mm',
                fieldInfo: '',
                label: 'id_front_updated_at',
                label: I18n.t('activerecord.attributes.user.id_front_updated_at'),
                name: 'id_front_updated_at',
            },
            {
                fieldInfo: '',
                label: 'id_back_file_name',
                label: I18n.t('activerecord.attributes.user.id_back_file_name'),
                name: 'id_back_file_name',
            },
            {
                fieldInfo: '',
                label: 'id_back_content_type',
                label: I18n.t('activerecord.attributes.user.id_back_content_type'),
                name: 'id_back_content_type',
            },
            {
                fieldInfo: '',
                label: 'id_back_file_size',
                label: I18n.t('activerecord.attributes.user.id_back_file_size'),
                name: 'id_back_file_size',
            },
            {
                type: 'datetime',
                format: 'YYYY/MMM/D HH:mm',
                fieldInfo: '',
                label: 'id_back_updated_at',
                label: I18n.t('activerecord.attributes.user.id_back_updated_at'),
                name: 'id_back_updated_at',
            },
        ],
    });

    // Activate an inline edit on click of a table cell
    $('#users_datatable').on( 'click', 'tbody td.editable', function (e) {
        editor.inline( this );
    } );

    var users_datatable = $('#users_datatable').DataTable({
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
            url: '/admin/staffs/datatables.json',
            dataSrc: 'data',
            type: 'POST',
        },
        columns:[
            {
                data: 'member_number',
                name: 'member_number_cont',
                visible: true,
                orderable: true,
                className: 'editable col-member_number',
            },
            {
                data: 'name',
                name: 'name_cont',
                visible: true,
                orderable: true,
                className: 'editable col-name',
            },
            {
                data: 'email',
                name: 'email_cont',
                visible: true,
                orderable: true,
                className: 'editable col-email',
            },
            {
                data: 'remember_created_at',
                name: 'remember_created_at_between',
                visible: true,
                orderable: true,
                className: 'editable col-remember_created_at',
            },
            {
                data: 'sign_in_count',
                name: 'sign_in_count_between',
                visible: true,
                orderable: true,
                className: 'editable col-sign_in_count',
            },
            {
                data: 'current_sign_in_at',
                name: 'current_sign_in_at_between',
                visible: true,
                orderable: true,
                className: 'editable col-current_sign_in_at',
            },
            {
                data: 'last_sign_in_at',
                name: 'last_sign_in_at_between',
                visible: true,
                orderable: true,
                className: 'editable col-last_sign_in_at',
            },
            {
                data: 'current_sign_in_ip',
                name: 'current_sign_in_ip_cont',
                visible: true,
                orderable: true,
                className: 'editable col-current_sign_in_ip',
            },
            {
                data: 'last_sign_in_ip',
                name: 'last_sign_in_ip_cont',
                visible: true,
                orderable: true,
                className: 'editable col-last_sign_in_ip',
            },
            {
                data: 'id_card_number',
                name: 'id_card_number_cont',
                visible: true,
                orderable: true,
                className: 'editable col-id_card_number',
            },
            {
                data: 'passport_number',
                name: 'passport_number_cont',
                visible: true,
                orderable: true,
                className: 'editable col-passport_number',
            },
            {
                data: 'contact_address',
                name: 'contact_address_cont',
                visible: true,
                orderable: true,
                className: 'editable col-contact_address',
            },
            {
                data: 'residence_address',
                name: 'residence_address_cont',
                visible: true,
                orderable: true,
                className: 'editable col-residence_address',
            },
            {
                data: 'phone_number',
                name: 'phone_number_cont',
                visible: true,
                orderable: true,
                className: 'editable col-phone_number',
            },
            {
                data: 'confirmed_at',
                name: 'confirmed_at_between',
                visible: true,
                orderable: true,
                className: 'editable col-confirmed_at',
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
                className: 'editable col-birthday',
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
                // 操作
                data: null,
                visible: true,
                orderable: false,
                render: function ( data, type, full, meta ) {
                    var id = data.id;
                    var actions = '<a href="/admin/staffs/' + id + '/edit" class="btn btn-default m-r-5"><span class="glyphicon glyphicon-pencil"></span></a>';
                    actions += '<a href="/admin/staffs/' + id + '" data-confirm="確定刪除?" class="btn btn-default" rel="nofollow" data-method="delete"><span class="glyphicon glyphicon-trash"></span></a>';
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

    users_datatable.on('row-reorder', function(e, diff, edit){
        var data = {rows_sorting:{}}
        var result = '';

        for ( var i=0, ien=diff.length ; i<ien ; i++ ) {
            data['rows_sorting'][$(diff[i].node).data('id')] = diff[i].newData;
        }

        $.ajax({
            type: 'patch',
            url: '/admin/staffs/update_row_sorting',
            data: data,
            datatype: 'json'
        });
    });

    editor.on( 'initEdit', function () {
        // Disable for edit (re-ordering is performed by click and drag)
    } );

    $('.filter-email').change(function(e){
        console.log('email');
        datatablesUtils.column_string_filter(users_datatable, e.target.name);
    });

    $('.filter-name').change(function(e){
        console.log('name');
        datatablesUtils.column_string_filter(users_datatable, e.target.name);
    });

    $('.filter-phone_number').change(function(e){
        console.log('phone_number');
        datatablesUtils.column_string_filter(users_datatable, e.target.name);
    });

    $('.filter-member_number').change(function(e){
        console.log('member_number');
        datatablesUtils.column_string_filter(users_datatable, e.target.name);
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

    $(row).find('td:last-child').off('click').on('click', function() {
    });
};
