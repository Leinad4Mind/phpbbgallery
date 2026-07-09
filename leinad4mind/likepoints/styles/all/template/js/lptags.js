function get_query(){
    var url = document.location.href;
    var qs = url.substring(url.indexOf('?') + 1).split('&');
    for(var i = 0, result = {}; i < qs.length; i++){
        qs[i] = qs[i].split('=');
        result[qs[i][0]] = decodeURIComponent(qs[i][1]);
    }
    return result;
}

head.ready(function () {
  (function($) { // Avoid conflicts with other libraries
  
  "use strict";

  $('#contributors').tagEditor({ 
    initialTags: [],
    forceLowercase: false,
    placeholder: lptagsLangPlaceholder,
    maxTags: 100,
    maxLength: 100,
     autocomplete: {
      html: true,
            delay: 500, 
            position: { collision: 'flip' },
              source: function(request, response) {
                  var qs = get_query();
                  qs['term'] = request.term;
                  $.ajax({
                      type: "GET",
                      url: lptagsNemtionsUrl,
                      dataType: "json",
                      data: qs,
                      error: function(xhr, textStatus, errorThrown) {
                          alert('Error: ' + xhr.responseText);
                      },
                      success: function(data) {
                          response($.map(data, function(c) {
                              return {
                                label: c[0],
                    value: c[0],
                              }
                          }));
                      }
                  });
              },
      }
  });
  
  })(jQuery); // Avoid conflicts with other libraries
  });