flatpickr('#datepicker', {
    enableTime: true,
    dateFormat: 'm/d/Y H:i',
 	altInput: true,
	altInputClass: 'flatpickr-input',
	altFormat: sitesplat_futurepost_dateformat,
    minDate: new Date(sitesplat_futurepost_default_date - (5400 * 1000)),
    defaultDate: sitesplat_futurepost_default_date
});
