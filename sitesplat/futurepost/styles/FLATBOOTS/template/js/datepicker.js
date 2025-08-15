// head.ready(function () {

//     $("#datepicker").change(function() {
// 		var title = $("#alternate").data('title');
//         $("#alternate").html(title + ': ' + $("#datepicker").val());
//        });
// });

var cal = new WinkelCalendar({
    container: 'datepicker',
    defaultDate: WinkelCalendarFutureDate,
    format : "MM/DD/YYYY"
});

document.querySelector('#alternate').addEventListener('click', function() {
    document.querySelector('.wc-date-container').click();
});
