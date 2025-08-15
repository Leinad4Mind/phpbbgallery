head.ready(function () {
(function($) { // Avoid conflicts with other libraries

"use strict";

$(".note").click(function() {
	var id = $(this).attr('id')
 
    $("#inner" + id).toggle(500);
})

})(jQuery); // Avoid conflicts with other libraries
});