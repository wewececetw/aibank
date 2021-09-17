CKEDITOR.addTemplates(
'default',
{
    //圖片資料夾路徑，放在同目錄的images資料夾內
    imagesPath: CKEDITOR.getUrl(CKEDITOR.plugins.getPath("templates")+"templates/images/"),
    templates: [
    {
        //標題
        title: '兩欄圖文',
        image: 'template5.png',//圖片
        description: '電腦版兩欄，手機板一欄', //樣板描述
        //自訂樣板內容
        html: '<div class="two_cols clearfix">'+
                '<div><img src="/images/sample_image.png" /></div>' +
                '<div><img src="/images/sample_image.png" /></div>' +
              '</div>'  
    },
    //第二個樣板
    {
        title: '三欄圖文',
        image: 'template4.png',
        description: '電腦版三欄，手機板一欄',
        html: '<div class="three_cols clearfix">'+
                '<div><img src="/images/sample_image.png" /></div>' +
                '<div><img src="/images/sample_image.png" /></div>' +
                '<div><img src="/images/sample_image.png" /></div>' +
              '</div>'
    }
    ]
});