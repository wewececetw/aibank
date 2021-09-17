$(function() {
    var riskPercentages = null;
    var setRate = function(risk, riskPercentages) {
        if (/[A-E]/.test(risk)) {
            $('#annualInterestRate').val(riskPercentages[risk]);
            $('#annualInterestRate').attr('readonly', true);
        } else {
            $('#annualInterestRate').attr('readonly', false);
        }
    };

    var riskOnLoad = $('#riskCategory').val();

    $('#riskCategory').on('change', function() {
        var risk = $(this).val();
        setRate(risk, riskPercentages);
    });
});
