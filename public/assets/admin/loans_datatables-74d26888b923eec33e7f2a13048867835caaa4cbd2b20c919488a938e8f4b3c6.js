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
    var loans_datatable = $('#loans_datatable').DataTable({
        language: datatables_language,
        paging: true,
        responsive: true,
        searching: true,
        processing: true,
        serverSide: true,
        stateSave: false,
        autoWidth: true,
        select: true,
        dom: 'Brtip',
        ajax: {
            url: '/admin/loans/datatables.json',
            dataSrc: 'data',
            type: 'POST',
        },
        columns:[
            {
                data: 'name',
                name: 'name_cont',
                visible: true,
                orderable: true,
                className: 'col-name'
            },
            {
                data: 'dob',
                name: 'dob',
                visible: true,
                orderable: true,
            },
            {
                data: 'id_number',
                name: 'id_number_cont',
                visible: true,
                orderable: true,
                className: 'col-id_number'
            },
            {
                data: 'cellphone_number',
                name: 'cellphone_number_cont',
                visible: true,
                orderable: true,
            },
            {
                data: 'loan_type',
                name: 'loan_type_eq',
                visible: true,
                orderable: true,
                className: 'col-loan_type'
            },
            {
                data: 'amount',
                name: 'amount',
                visible: true,
                orderable: true,
            },
            {
                data: 'periods',
                name: 'periods',
                visible: true,
                orderable: true,
            },
            {
                data: null,
                name: 'is_contact',
                visible: true,
                orderable: true,
                render: function ( data, type, full, meta ) {
                  if (data.is_contact === true) {
                    return '<input type="checkbox" class="isContact" data-id="' + data.id + '" checked>'
                  } else {
                    return '<input type="checkbox" class="isContact" data-id="' + data.id + '">'
                  }
                }
            },
            {
                data: 'remark',
                name: 'remark',
                visible: true,
                orderable: true,
                className: 'editable',
            },
            {
                data: 'telephone_number',
                name: 'telephone_number',
                visible: false,
                orderable: true,
                className: 'editable',
            },
            {
                data: 'address',
                name: 'address',
                visible: false,
                orderable: true,
                className: 'editable',
            },
            {
                data: 'company_name',
                name: 'company_name',
                visible: false,
                orderable: true,
                className: 'editable',
            },
            {
                data: 'company_phone',
                name: 'company_phone',
                visible: false,
                orderable: true,
                className: 'editable',
            },
            {
                data: 'job_title',
                name: 'job_title',
                visible: false,
                orderable: true,
                className: 'editable',
            },
            {
                data: 'monthly_salary',
                name: 'monthly_salary',
                visible: false,
                orderable: true,
                className: 'editable',
            },
            {
                data: 'building_location',
                name: 'building_location',
                visible: false,
                orderable: true,
                className: 'editable',
            },
            {
                data: 'building_numbers',
                name: 'building_numbers',
                visible: false,
                orderable: true,
                className: 'editable',
            },
            {
                data: 'land_numbers',
                name: 'land_numbers',
                visible: false,
                orderable: true,
                className: 'editable',
            },
            {
                data: 'car_type',
                name: 'car_type',
                visible: false,
                orderable: true,
                className: 'editable',
            },
            {
                data: 'car_brand',
                name: 'car_brand',
                visible: false,
                orderable: true,
                className: 'editable',
            },
            {
                data: 'car_model',
                name: 'car_model',
                visible: false,
                orderable: true,
                className: 'editable',
            },
            {
                data: 'plate_number',
                name: 'plate_number',
                visible: false,
                orderable: true,
                className: 'editable',
            },
            {
                data: 'car_capacity',
                name: 'car_capacity',
                visible: false,
                orderable: true,
                className: 'editable',
            },
            {
                data: 'car_color',
                name: 'car_color',
                visible: false,
                orderable: true,
                className: 'editable',
            },
            {
                data: 'production_at',
                name: 'production_at',
                visible: false,
                orderable: true,
                className: 'editable',
            },
            {
                data: 'check_number',
                name: 'check_number',
                visible: false,
                orderable: true,
                className: 'editable',
            },
            {
                data: 'expire_at',
                name: 'expire_at',
                visible: false,
                orderable: true,
                className: 'editable',
            },
            {
                data: 'drawer',
                name: 'drawer',
                visible: false,
                orderable: true,
                className: 'editable',
            },
            {
                data: 'check_amount',
                name: 'check_amount',
                visible: false,
                orderable: true,
                className: 'editable',
            },
            {
                data: 'bank',
                name: 'bank',
                visible: false,
                orderable: true,
                className: 'editable',
            },
            {
                data: 'bank_branch',
                name: 'bank_branch',
                visible: false,
                orderable: true,
                className: 'editable',
            },
            {
                data: 'is_forbid_endorsement',
                name: 'is_forbid_endorsement',
                visible: false,
                orderable: true,
                className: 'editable',
            },
            {
                // 操作
                data: null,
                visible: true,
                orderable: false,
                render: function ( data, type, full, meta ) {
                    var id = data.id;
                    var actions = '<a href="/admin/loans/' + id + '/edit" class="btn btn-info"><span>內容</span></a>';
                    return actions;
                },
            },
            {
                data: 'created_at',
                name: 'created_at_between',
                visible: false,
                className: 'col-created_at',
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
        order: [[ 33, "desc" ]],
    });

    loans_datatable.on('row-reorder', function(e, diff, edit){
        var data = {rows_sorting:{}}
        var result = '';

        for ( var i=0, ien=diff.length ; i<ien ; i++ ) {
            data['rows_sorting'][$(diff[i].node).data('id')] = diff[i].newData;
        }

        $.ajax({
            type: 'patch',
            url: '/admin/loans/update_row_sorting',
            data: data,
            datatype: 'json'
        });
    });

    // 關鍵字查詢
    $('#keyword_search').keyup(function(e){
        var keycode = (event.keyCode ? event.keyCode : event.which);
        if(keycode == '13'){
            loans_datatable.search($(this).val()).draw() ;
        }
    });

    $('.filter-name, .filter-id_number').change(function(e) {
      datatablesUtils.column_string_filter(loans_datatable, e.target.name);
    });


    $('.filter-loan_type').select2({theme: 'bootstrap'}).on('select2:close', function(e) {
      datatablesUtils.column_select_filter(loans_datatable, e.target.name);
    });

    $('.filter-created_at').change(function(e) {
      datatablesUtils.column_range_filter(loans_datatable, e.target.name);
    });

    $('#loans_datatable').on('click', '.isContact', function() {
      $.ajax({
        method: 'POST',
        data: {
          _method: 'PUT'
        },
        url: '/admin/loans/' + $(this).attr('data-id') + '/contact',
        success: function() {
          swal("已成功更新Loan資料", "", "info");
        }
      });
    });

    // 送出查詢
    $('button.filter-button').click(function(e){
        loans_datatable.draw();
    });

    // 清空查詢
    $('button.reset-button').click(function(e){
        $('input').val('');
        $('select').val('').trigger('change.select2');
        loans_datatable.search('').columns().search('').draw();
    })

    $('#export_button').click(function(e){
      name = $('[name=name]').val();
      id_number = $('[name=id_number]').val();
      loan_type = $('[name=loan_type]').val();
      created_at_start = $('[name=created_at_start]').val();
      created_at_end = $('[name=created_at_end]').val();

      $.ajax({
          type: "POST",
          url: '/admin/loans/export',
          dataType: 'json',
          data: {name:name, id_number:id_number ,loan_type:loan_type ,created_at_start:created_at_start, created_at_end:created_at_end},
          success: function(data,status,xhr) {
            export_url = data[0]['url']
            console.log(location.href);
            location.href = '../'+export_url;
          },
          erroe: function(xhr, ajaxOptions, thrownError) {
              console.log(xhr);
              console.log(ajaxOptions);
              console.log(thrownError);
          }
      });
    })

});

var addRowClickEvent = function(row) {
    var id = $(row).attr('data-id')

    $(row).find('td:last-child').off('click').on('click', function() {
        // location.href = '/admin/loans/' + id + '/edit';
    });
};
