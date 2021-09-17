var keepClassOpen = false;

$('#intelligentModal').on('shown.bs.modal', function() {
    $('body').addClass('modal-open');
});

// Slider init values
var set1SlidersInitValue = 50;
var set2SlidersInitValue1 = 40;
var set2SlidersInitValue2 = 70;
var set3SlidersInitValue = 50;

var make_intelligent_slider_bar = function(initial){
    initial = initial && true;

    if (typeof noUiSlider === 'object') {
        if(initial && typeof user_slider_percents !== undefined && Array.isArray(user_slider_percents)){
            if(user_slider_percents.length === 2){
                if( $('#groupingRadios1').prop('checked') ) set1SlidersInitValue = user_slider_percents[0];
                if( $('#groupingRadios4').prop('checked') ) set3SlidersInitValue = user_slider_percents[0];
            } else if(user_slider_percents.length === 3){
                set2SlidersInitValue1 = user_slider_percents[0];
                set2SlidersInitValue2 = user_slider_percents[0] + user_slider_percents[1];
            }
        }

        // set1
        var set1Sliders = $( ".proportion-slider-first" );

        set1Sliders.each(function( index ){
            var set1Slider = $(this)[ 0 ];
            var set1InfoAs = $(this).parent().find( ".slider-first-A" );
            var set1InfoBs = $(this).parent().find( ".slider-first-B" );

            try {
                noUiSlider.create(set1Slider, {
                    start: set1SlidersInitValue,
                    connect: [true, false],
                    padding: 10,
                    step: 10,
                    range: {
                        'min': 0,
                        'max': 100
                    }
                });
            } catch(err) {
                console.log(err.message);
            }

            set1Slider.noUiSlider.set([set1SlidersInitValue]);

            // Update Input values
            set1Slider.noUiSlider.on('update', function( values, handle ) {
                var value = Math.floor(values[handle]);
                if ( handle ) {
                    set1InfoBs.value = value;
                } else {
                    set1InfoAs.value = value;
                }
                set1InfoAs.html('A：'+ value + '%');
                set1InfoBs.html('B：'+ (100-value) + '%');

                set1SlidersInitValue = value;
            });
        });

        // set2
        var set2Sliders = $( ".proportion-slider-second" );

        set2Sliders.each(function( index ){
            var set2Slider = $(this)[ 0 ];
            var set2InfoCs = $(this).parent().find( ".slider-second-C" );
            var set2InfoDs = $(this).parent().find( ".slider-second-D" );
            var set2InfoEs = $(this).parent().find( ".slider-second-E" );

            try {
                noUiSlider.create(set2Slider, {
                    start: [ set2SlidersInitValue1, set2SlidersInitValue2 ],
                    connect: [true, true, true],
                    padding: 10,
                    margin: 10,
                    step: 10,
                    range: {
                        'min': 0,
                        'max': 100
                    }
                });
            } catch(err) {
                console.log(err.message);
            }

            set2Slider.noUiSlider.set([set2SlidersInitValue1, set2SlidersInitValue2]);

            var set2A = set2SlidersInitValue1;
            var set2B = set2SlidersInitValue2;

            set2Slider.noUiSlider.on('update', function ( values, handle ) {
                var value = Math.floor(values[handle]);
                if ( handle ) {
                    //拉動B
                    set2B = value;
                    set2InfoDs.css("width", Math.floor(set2B-set2A) + '%')
                    set2InfoEs.css("width", Math.floor(100-set2B) + '%')
                    set2InfoDs.html('D：'+ Math.floor(set2B-set2A) + '%'); //D
                    set2InfoEs.html('E：'+ Math.floor(100-set2B) + '%'); // E
                } else {
                    // 拉動A
                    set2A = value;
                    set2InfoCs.css("width", Math.floor(set2A) + '%')
                    set2InfoDs.css("width", Math.floor(set2B-set2A) + '%')
                    set2InfoCs.html('C：'+ Math.floor(set2A) + '%'); //C
                    set2InfoDs.html('D：'+ Math.floor(set2B-set2A) + '%'); //D
                }

                set2SlidersInitValue1 = set2A;
                set2SlidersInitValue2 = set2B;
            });

            var set2Connect = set2Slider.querySelectorAll('.noUi-connect');
            var set2Class = ['c-color', 'd-color', 'e-color'];

            for ( var i = 0; i < set2Connect.length; i++ ) {
                set2Connect[i].classList.add(set2Class[i]);
            }
        });


        // set3
        var set3Sliders = $( ".proportion-slider-third" );

        set3Sliders.each(function( index ){
            var set3Slider = $(this)[ 0 ];
            var set3InfoABs = $(this).parent().find( ".slider-third-AB" );
            var set3InfoCDEs = $(this).parent().find( ".slider-third-CDE" );

            try {
                noUiSlider.create(set3Slider, {
                    start: set3SlidersInitValue,
                    connect: [true, true],
                    padding: 40,
                    step: 10,
                    range: {
                        'min': 0,
                        'max': 100
                    } });
            } catch(err) {
                console.log(err.message);
            }

            set3Slider.noUiSlider.set([set3SlidersInitValue]);

            set3Slider.noUiSlider.on('update', function( values, handle ) {
                var value = Math.floor(values[handle]);

                if ( handle ) {
                    set3InfoABs.value = value;
                } else {
                    set3InfoCDEs.value = value;
                }

                set3InfoABs.html(value + '%');
                set3InfoCDEs.html((100-value) + '%');

                set3SlidersInitValue = value;
            });

            var set3connect = set3Slider.querySelectorAll('.noUi-connect');
            var set3classes = ['a-color','c-color'];

            for ( var i = 0; i < set3connect.length; i++ ) {
                set3connect[i].classList.add(set3classes[i]);
            }
        });

        // set4、set5
        // 據使用者投資習慣設定下拉初始值，並改變 slider 顏色
        if(initial){
            if( user_risk_category === 4 ) {
                change_slider_color_and_text('proportion-slider-third', 'first', user_risk_options[0], true);
                change_slider_color_and_text('proportion-slider-third', 'second', user_risk_options[1], true);

                change_slider_color_and_text('proportion-slider-third', 'first', user_risk_options[0], false);
                change_slider_color_and_text('proportion-slider-third', 'second', user_risk_options[1], false);
            } else if( user_risk_category === 5 ) {
                change_slider_color_and_text('proportion-slider-forth', '', user_risk_options[0], true);
                change_slider_color_and_text('proportion-slider-forth', '', user_risk_options[0], false);
            }
        }
    }
};

var change_slider_color_and_text = function(_id, _target, _color, has_current_block){
    console.log(_id, _target, _color, has_current_block);
    var change_elmt_selector = "select[data-id='"+ _id + "']";
    if(_target !== undefined && _target !== ""){
        change_elmt_selector += "[data-target='"+ _target +"']";
    }

    var current_block_selector = ":not(.current_block)";
    if(has_current_block) {
        current_block_selector = ".current_block";
    }

    var change_elmt = $(change_elmt_selector);
    var _parent = change_elmt.parents( '.intelligent_block' + current_block_selector );

    // 設定風險選單的選項
    if(_target !== undefined && _target !== ""){
        _parent.find("select[data-target='"+ _target +"']").val(_color);
    } else {
        _parent.find("select").val(_color);
    }

    var _element = null;
    if(_id == 'proportion-slider-third'){
        var _connects = _parent.find('.noUi-connect');

        if(_target=='first'){
            // 左邊資訊
            _element = _connects[0];
            // 替代標題A或B
            _parent.find('.slider-third-AB-label').html(_parent.find("[data-target='"+ _target +"'] option:selected").text());
        } else {
            // 右邊資訊
            _element = _connects[1];
            // 替代標題CDE
            _parent.find('.slider-third-CDE-label').html(_parent.find("[data-target='"+ _target +"'] option:selected").text());
        }
    } else {
        // 第四組
        _element = _parent.find('.unique_block');
        $(_element).html(_parent.find('option:selected').text()+'：100%');
    }

    $(_element).removeClass('a-color b-color c-color d-color e-color').addClass(_color);
};

// 依據登入者的智能媒合設定來定義初始的智能分組
var roiSetting_mappimg_changeIntelligent = {first: 1, second: 2, average: 3, third: 4, fourth: 5};
var make_default_changeIntelligent = function(){
    for (var mapping in roiSetting_mappimg_changeIntelligent){
        if(roiSetting_mappimg_changeIntelligent[mapping] == user_risk_category){
            changeIntelligent = mapping;
            break;
        }
    }
    $('#groupingRadios'+user_risk_category).prop('checked', true);
};

$(function () {
    // tooltip
    // $('[data-toggle="tooltip"]').tooltip();

    // 變換顏色
    $( document ).on('change', '.js-change-color', function(){
        var change_elmt = $(this);
        var current_block = change_elmt.parents('.current_block');
        var has_current_block = (current_block.length === 1);
        var _id = change_elmt.attr('data-id');
        var _target = change_elmt.attr('data-target');
        var _color = change_elmt.val();
        change_slider_color_and_text(_id, _target, _color, has_current_block);
    });

    $('#intelligentInfoModal').on('hidden.bs.modal', function() {
        if(keepClassOpen){
            $('body').addClass('modal-open');
        }
    });
    $('.js-detect-model-close').on('click', function(){
        if($(this).attr('id')=='intelligentInfoModalKeepOpen'){
            keepClassOpen = true;
        }else {
            keepClassOpen = false;
        }
    });
});
