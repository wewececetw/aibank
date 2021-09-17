$(document).ready(function() {

    $(".custom-checkbox").click(function() {

        Array.from($(".form-check-input:checked")).forEach(function(element){
            if(element.value.includes("<=")){
                element.checked = false
            }
        })

        // GET THE INPUT
        var activeInput = $(this).children("input");

        if (activeInput.is(':checked')) {
            // DESELECT IF ALREADY CHECKED
            $(activeInput).prop("checked", false);
        } else {
            // SELECT IF NOT CHECKED
            $(activeInput).prop("checked", true);
        }

        // IF RADIO REMOVE SELECTION FROM OTHER OPTIONS
        if (activeInput.is('[type=radio]')) {
            var nonActiveInput = $(this).siblings().children("input");
            $(nonActiveInput).prop("checked", false);
        }

    });

});



// IF IE <9 
// REPLACE :checked WITH .checked
if ($.browser.msie && parseInt($.browser.version) < 9) {
    var inputs = $('.custom-checkbox input');
    inputs.live('change', function() {
        var ref = $(this),
            wrapper = ref.parent();
        if (ref.is(':checked')) wrapper.addClass('checked');
        else wrapper.removeClass('checked');
    });
    inputs.trigger('change');
}
;
