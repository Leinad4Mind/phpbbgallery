head.ready(function () {
(function($) { // Avoid conflicts with other libraries

"use strict";

	$(".ccount").characterCounter({
        counterFormat: '%1 ' + chars_remaining,
		limit: max_post_chars,
    });

	 //setup before functions
	var typingTimer;                //timer identifier
	var doneTypingInterval = 1000;  //time in ms, 5 seconds for example
	
	var editor = document.querySelector("#message"); //lets select the postform to save

	//on keyup, start the countdown
	$('#message').keyup(function(){
		clearTimeout(typingTimer);
		if ($('#message').val) {
			typingTimer = setTimeout(doneTyping, doneTypingInterval);
		}
	});

	//user finished typing
	function doneTyping () {
		//do something
		$('.snappy_saved').finish().fadeIn("fast").delay(1000).fadeOut("slow");
	}

	if (window.localStorage["TextEditorData"]) {
		editor.value = window.localStorage["TextEditorData"];
	}    
	editor.addEventListener("keyup", function() {
		window.localStorage["TextEditorData"] = editor.value;
	});
	
	$('#qr_postform').submit(function() {
        localStorage.removeItem("TextEditorData");
    });
	
	//lets clear empty local storage and textarea if needed
	$(".btn-clr").click(function(e) {
        e.preventDefault();
        $(".ccount").val('');
		localStorage.removeItem("TextEditorData");
    });
	
//	$('.panel-qr > .qr-textarea > textarea').on('keyup', function(event) {
//        var $comment = $(this).closest('.panel-qr');
//        
//        $comment.find('.load').addClass('disabled');
//        if ($(this).val().length >= 1) {
//            $comment.find('.load').removeClass('disabled');
//        }
//   });
   
   // setInterval(function () {
	  // if($("#message").val().length >= 1) {
		// $(".load").removeAttr("disabled");
	  // } else {
		// $(".load").attr("disabled", "disabled");
	  // }
	// }, 400); //Runs every 0.4s
   
   //	$('.toggleModal').on('click', function () {
   //      $('#col1').toggleClass('col-md-12 col-md-9');
   //      $('#col2').toggleClass('hidden col-md-3');
   //  });

  
	$('.togglesnappy').on('click', function () {
        $('#colPanel').toggleClass('hidden col-md-snappy');
    });
	
})(jQuery); // Avoid conflicts with other libraries
});