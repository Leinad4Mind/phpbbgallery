jQuery(function($) {
    $('#registration_age_datepicker').datepicker({
        autoShow: false,
        autoHide: true,
        autoPick: false,
        inline: false,
        language: 'en-GB',
        date: new Date(),
        startDate: null,
        endDate: new Date(),
        startView: 2
    }).on('pick.datepicker', function(e) {
        $('#registration_age_day').val(e.date.getUTCDate());
        $('#registration_age_month').val(e.date.getUTCMonth() + 1);
        $('#registration_age_year').val(e.date.getUTCFullYear());
    });
});