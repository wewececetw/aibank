var claim_repayment_claim_id_select2;
$(function() {

    claim_repayment_claim_id_select2 = $('#claim_repayment_claim_id').select2({
        theme: 'bootstrap',
        width: '100%',
        placeholder: I18n.t('helpers.select.prompt'),
        allowClear: true,
        ajax: {
            url: '/admin/claim_repayments/claims_for_select2',
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
