

$(function() {
    // 依據傳入的 master_show_tab 參數來切換 show 頁面的 detail 頁籤內容
    if( typeof action_item_id !== 'undefined' && action_item_id != "" && typeof master_show_tab !== 'undefined' && master_show_tab != "" ) {
        $.ajax({
            url: "/admin/action_items/"+ action_item_id +"/render_tab_content",
            method: 'get',
            dataType: 'html',
            data: { master_show_tab: master_show_tab }
        }).success(function(tab_html){
            if(tab_html !== '') {
                $('.tab-pane.active').removeClass('active');
                $('.tab.active').removeClass('active');

                if($('#'+master_show_tab+'_tab').length === 0) {
                    master_show_tab = 'action_item';
                }

                $('#'+master_show_tab+'_tab').addClass('active');
                $('#'+master_show_tab+'_tabpanel').addClass('active').html($(tab_html));
            }
        }); 
    }



});
