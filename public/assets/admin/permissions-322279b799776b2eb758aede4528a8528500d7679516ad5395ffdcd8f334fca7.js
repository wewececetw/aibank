
var permission_resource_item_id_select2;

var permission_action_item_id_select2;


$(function() {
    // 依據傳入的 master_show_tab 參數來切換 show 頁面的 detail 頁籤內容
    if( typeof permission_id !== 'undefined' && permission_id != "" && typeof master_show_tab !== 'undefined' && master_show_tab != "" ) {
        $.ajax({
            url: "/admin/permissions/"+ permission_id +"/render_tab_content",
            method: 'get',
            dataType: 'html',
            data: { master_show_tab: master_show_tab }
        }).success(function(tab_html){
            if(tab_html !== '') {
                $('.tab-pane.active').removeClass('active');
                $('.tab.active').removeClass('active');

                if($('#'+master_show_tab+'_tab').length === 0) {
                    master_show_tab = 'permission';
                }

                $('#'+master_show_tab+'_tab').addClass('active');
                $('#'+master_show_tab+'_tabpanel').addClass('active').html($(tab_html));
            }
        }); 
    }


    permission_resource_item_id_select2 = $('#permission_resource_item_id').is("select") && $('#permission_resource_item_id').select2({
        theme: 'bootstrap',
        width: '100%',
        placeholder: I18n.t('helpers.select.prompt'),
        allowClear: true,
        ajax: {
            url: '/admin/permissions/resource_items_for_select2',
            dataType: 'json',
            type: 'POST',
            data: function (params) {
                var query = {
                    search: params.term,
                    page: params.page || 1,
                    per: 10,
                }

                return query;
            },
            processResults: function (data, params) {
                params.page = params.page || 1;

                return {
                    results: data.results,
                    pagination: {
                        more: (params.page * data.per) < data.filtered_count
                    }
                };
            },
            delay: 250,
        },
    });

    permission_action_item_id_select2 = $('#permission_action_item_id').is("select") && $('#permission_action_item_id').select2({
        theme: 'bootstrap',
        width: '100%',
        placeholder: I18n.t('helpers.select.prompt'),
        allowClear: true,
        ajax: {
            url: '/admin/permissions/action_items_for_select2',
            dataType: 'json',
            type: 'POST',
            data: function (params) {
                var query = {
                    search: params.term,
                    page: params.page || 1,
                    per: 10,
                }

                return query;
            },
            processResults: function (data, params) {
                params.page = params.page || 1;

                return {
                    results: data.results,
                    pagination: {
                        more: (params.page * data.per) < data.filtered_count
                    }
                };
            },
            delay: 250,
        },
    });


});
