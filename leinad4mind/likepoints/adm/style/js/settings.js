$("#sync_like_points").click(function (e) {
  e.preventDefault();
  $("#sync_like_points-progressbar").show("slow");
  $("#sync_like_points-processing").show();
  $('#sync_like_points-progressbar').css('display', 'inline-block');
  $('#sync_like_points-sync_points').prop('disabled', true);

  $.ajax({ type: "GET", 
  url: leinad4mind_likepoints_sync_points_url, 
  dataType: "json",
  data: {
    sync_points: true,
    action: 'progressbar',
    skiprows: 0,
  },
  success: function (result) {
    if (result.percent)
    {
      $("#sync_like_points-percent").text(result.percent + ' %');
      $( "#sync_like_points-progress" ).addClass( "done done-transition" );
      if (result.percent == 100) {
        $("#sync_like_points-processing").hide();
      }
    }
    if (result.total_posts) {
      $("#sync_like_points-summary").show();
      $("#sync_like_points-summary #total-posts").text(result.total_posts);
    }
    if (result.url)
    {
      adminurl = result.url;
      $('#sync_like_points').click(); 
    }
    }
  });
});
