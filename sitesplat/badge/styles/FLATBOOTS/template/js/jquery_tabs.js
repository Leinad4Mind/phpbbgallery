head.ready(function () {  
  $('.nav-tabs').each(function(){
    // For each set of tabs, we want to keep track of
    // which tab is active and it's associated content
    var $active, $content, $links = $(this).find('a');

    // If the location.hash matches one of the links, use that as the active tab.
    // If no match is found, use the first link as the initial active tab.
    $active = $($links.filter('[href="'+location.hash+'"]')[0] || $links[0]);
    $active.parent().addClass('active');

    $content = $($active[0].hash);

    // Hide the remaining content
    $links.not($active).each(function () {
      $(this.hash).hide();
    });

    // Bind the click event handler
    $(this).on('click', 'a', function(e){
      // Make the old tab inactive.
      $active.parent().removeClass('active');
      $content.hide();

      // Update the variables with the new link and content
      $active = $(this);
      $content = $(this.hash);

      // Make the tab active.
      $active.parent().addClass('active');
      $content.show();

      // Prevent the anchor's default click action
      e.preventDefault();
    });
	
	// lets initilize nanoscroller on the first tab at first load
	$(".nano").nanoScroller();
	
  });
  
  // some popover and tooltips rules
  $('[data-toggle="popover"]').tooltip('disable')
   $('[data-toggle="popover"]').popover({
	   'placement': 'top',
       html: true	   
   });
   
   // Now lets make sure to load nanscroller at each tab 
   // Dirty solution but there is no other way with nanoscroller when a content is behind a display:none;
   $(".nav-tabs").each(function(index) {
      $(this).on("click", function(){
       setTimeout(function () {
        $(".nano").nanoScroller();
        }, 100);
      });
    });
	

 });  