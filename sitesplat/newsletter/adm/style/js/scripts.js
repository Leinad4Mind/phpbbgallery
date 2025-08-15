tinymce.init({
	selector: "textarea.mceEditor",
	relative_urls: false,
		language : "en",
		height : "300",
	forced_root_block : "", 
	force_br_newlines : true,
	force_p_newlines : false,
	plugins: [
			"advlist autolink lists link image charmap print preview anchor",
			"searchreplace visualblocks code fullscreen",
			"insertdatetime media table contextmenu paste imagetools"
		],
	toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | preview",
	imagetools_cors_hosts: ['www.tinymce.com'],
});
