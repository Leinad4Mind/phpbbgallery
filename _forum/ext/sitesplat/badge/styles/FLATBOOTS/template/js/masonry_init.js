// experimental effects - add to badge.css
// .user_view_badge {
// -webkit-transition: left .4s ease-in-out, top .4s ease-in-out .4s;
// -moz-transition: left .4s ease-in-out, top .4s ease-in-out .4s;
// -ms-transition: left .4s ease-in-out, top .4s ease-in-out .4s;
// -o-transition: left .4s ease-in-out, top .4s ease-in-out .4s;
// transition: left .4s ease-in-out, top .4s ease-in-out .4s;
// }

head.ready(function () {
  jQuery(window).load(function(){

    var container = document.querySelector('.user_view');	
    var msnry = new Masonry( container, {
      // options
      columnWidth: '.col-xs-6',
      itemSelector: '.col-xs-6'
    });
  });
  
});