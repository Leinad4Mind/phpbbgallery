$(function(){
	$('#avatar_settings').on('submit', function(){
		$('#svga-work-overlay').fadeIn('fast');
		$('#svga-canvas').attr({width: png_one_download_size, height: png_one_download_size});
		var svg = $('#svga-svgmain').html();
		svg = '<svg xmlns="http://www.w3.org/2000/svg" version="1.1" width="' + png_one_download_size+ 'px" height="' + png_one_download_size+ 'px" xlink="http://www.w3.org/1999/xlink" style="overflow:hidden!important;"><g id="svga-group-wrapper" transform="scale(' + png_one_download_size/200 + ' ' + png_one_download_size/200 + ')">'
			+
			svg.replace(/<svg(.*?)>/, '').replace(/<g id(.*?)>/, '').replace(/data-(.*?)\"(.*?)\"/g, '').replace(/   /g, ' ').replace(/  /g, ' ').replace(/  /g, ' ');
		var canvas = document.getElementById('svga-canvas');
		canvg(canvas, svg, { ignoreMouse: true, ignoreDimensions: true });
		var img = canvas.toDataURL("image/png");

		$(this).append('<input type="hidden" name="imgdata" value="' + img + '" />')
	});
});
