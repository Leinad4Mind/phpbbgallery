head.ready(function () {
 // Fill modal with content from link href
 
	//	$(".modal-news").on("show.bs.modal", function(e) {
	//		var link = $(e.relatedTarget);
	//		$(this).find(".modal-body").load(link.attr("href"));
	//	});
		
	   var loadingContent = '<div class="modal-header"><h1>Processing...</h1></div><div class="modal-body"><div class="progress"><div class="progress-bar progress-bar-success progress-bar-striped active" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width:100%">loading...</div></div></div>';
      
	  // This is need so the content gets replaced correctly.
		$(".modal-news, .modal-arch").on("show.bs.modal", function (e) {
			$(this).find(".modal-body").html(loadingContent);        
			var link = $(e.relatedTarget);
			$(this).find(".modal-body").load(link.attr("href"));
		//	$(".progress-bar").css('width', '100%');
		});    

		$(".modal-news, .modal-arch").on("hide.bs.modal", function (e) {
			$(this).removeData('bs.modal');
		});
		
		$("a.modal-news-btn, a.modal-arch-btn").on('click', function(e) {
		  var src = $(this).attr('data-src');  
		
		     $(".modal-news iframe, .modal-arch iframe").attr({'src':src});
		});
		
		
		
});