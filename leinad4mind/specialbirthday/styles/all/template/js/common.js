jQuery(function($) {
    let $element = $('#registration_age_datepicker');
    $element.datepicker({
        autoShow: false,
        autoHide: true,
        autoPick: false,
        inline: false,
        language: $element.data('lang'),
        date: new Date(),
        startDate: new Date(1900, 0, 1),
        endDate: new Date(),
        startView: 2
    }).on('pick.datepicker', function(e) {
        $('#registration_age_day').val(e.date.getUTCDate());
        $('#registration_age_month').val(e.date.getUTCMonth() + 1);
        $('#registration_age_year').val(e.date.getUTCFullYear());
    });
});