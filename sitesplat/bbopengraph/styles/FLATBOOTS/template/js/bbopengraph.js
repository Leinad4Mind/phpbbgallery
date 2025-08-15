head.ready(function () {
    postShareButtonClick = $(function() {
	var buttonWrapper = $(".share-button"),
		button = $(".share-button > a"),
		icons = $(".share-button > .icons-wrapper"),
		close = $(".close-social-icons");

	function init() {
		button.on("click", toggle);
		close.on("click", closeIcons);
	}

	function toggle(e) {
		if (buttonWrapper.hasClass("active")) {
			closeIcons();
		} else {
			openIcons();
		}
		e.preventDefault();
	}

	function openIcons() {
		buttonWrapper.addClass("active");
		button.addClass("hidden");
		buttonWrapper.animate({
			width: "362"
		}, 500);
		icons.animate({
			left: "0"
		}, 500);
	}

	function closeIcons() {
		buttonWrapper.removeClass("active");
		button.removeClass("hidden");
		icons.animate({
			left: "-362"
		}, 0);
		buttonWrapper.animate({
			width: "111"
		}, 0);
	}

	init();
});

$('.popup-btn').click(function(e) {
    $('.popup-wrap').fadeIn(250);
    $('.popup-box').removeClass('transform-out').addClass('transform-in');

    e.preventDefault();
  });

  $('.popup-close').click(function(e) {
    $('.popup-wrap').fadeOut(500);
    $('.popup-box').removeClass('transform-in').addClass('transform-out');

    e.preventDefault();
  });
});