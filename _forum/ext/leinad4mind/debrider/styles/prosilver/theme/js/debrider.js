function debrider_url(self) {
  var elem = $(self).parent().parent().find('pre code');
  var links = elem.text().split('\n').filter(function (el) {
    return el != '';
  });

  $(self).parent().parent().find('.button').hide();
  $('<span id="debrider_url-generating" style="float: right">' + debrider_l_generating + '...</span>').insertAfter($(self).parent().parent().find('.button'));
  $.ajax({ url: './debrider/convert', data: {
    urls: links
  }, method: 'POST', success: function(result) {
    $('#debrider_url-generating').remove();
    if (result.error) {
      alert(result.error);
      $(self).parent().parent().find('.button').show();
    } else if (result.new_urls) {
      var links_text = result.new_urls.join('\n');
      $(elem).text(links_text);
      $(self).parent().parent().find('.button').hide();
    }
  }});
}
