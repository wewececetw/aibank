

$(function() {
    // 依據傳入的 master_show_tab 參數來切換 show 頁面的 detail 頁籤內容
    if( typeof internal_letter_id !== 'undefined' && internal_letter_id != "" && typeof master_show_tab !== 'undefined' && master_show_tab != "" ) {
        $.ajax({
        url: "/admin/internal_letters/"+ internal_letter_id +"/render_tab_content",
        method: 'get',
        dataType: 'html',
        data: { master_show_tab: master_show_tab }
        }).success(function(tab_html){
            if(tab_html !== '') {
                $('.tab-pane.active').removeClass('active');
                $('.tab.active').removeClass('active');

                if($('#'+master_show_tab+'_tab').length === 0) {
                    master_show_tab = 'internal_letter';
                }

                $('#'+master_show_tab+'_tab').addClass('active');
                $('#'+master_show_tab+'_tabpanel').addClass('active').html($(tab_html));
            }
        });
    }

    internal_letter_user_for_select2 = $('#internal_letter_user_ids').is("select") && $('#internal_letter_user_ids').select2({
        theme: 'bootstrap',
        width: '100%',
        placeholder: I18n.t('helpers.select.prompt'),
        closeOnSelect: false,
        allowClear: true,
        ajax: {
            url: '/admin/internal_letters/users_for_select2',
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

                var results = [{id: 0, text: '全部(All)'}];
                return {
                    results: results.concat( data.results ),
                    pagination: {
                        more: (params.page * data.per) < data.filtered_count
                    }
                };
            },
            delay: 250,
        },
    });
});
