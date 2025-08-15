function ss_bbr_getURLParameter(url, name) {
	return (RegExp(name + "=" + "(.+?)(&|$)").exec(url)||[,null])[1];
}

function sitesplat_bbreaction_init() {
	var elems = document.querySelectorAll('.reward');
	if (elems) {
		elems.forEach(function(elem) {
			if (!elem.classList.contains('rwhooked')) {
				elem.classList.add('rwhooked');
				elem.onclick = function(e) {
					e.preventDefault();
					$.ajax({ type: "POST",
						url: sitesplat_board_url + "app.php/bbreaction/index.html",
						data: this.getAttribute('data-options'),
						dataType: "json",
						success: function (result) {
							if (result.likes)
							{
								data = $.parseJSON(result.likes);
								$.each(data, function(i, item) {
									$("#" + i).text(item);
								});
							}
							phpbb.alert(result.info, result.txt, true);
							phpbb.closeDarkenWrapper(3000);
						}
					});
				};
			}
		});
	}

	elems = document.querySelectorAll('.open-ReactionDialog');
	if (elems) {
		elems.forEach(function(elem) {
			if (!elem.classList.contains('ordhooked')) {
				elem.classList.add('ordhooked');
				elem.onclick = function(e) {
					var postid = elem.getAttribute('data-id');
					var hack = new Date();
					$.ajax({
						url: sitesplat_board_url + 'app.php/bbreaction/likers.html?p=' + postid + '&time=' + String(hack.getTime()),
						context: document.getElementById("bbreaction-profile-data"),
						error: function (e, text, ee) {
						},
						success: function (s, x) {
							$(".modal-body #bbreaction-profile-data").html( s );
						}
					});
				};
			}
		});
	}

	elems = document.querySelectorAll('.ReactionPagination');
	if (elems) {
		elems.forEach(function(elem) {
			if (!elem.classList.contains('rphooked')) {
				elem.classList.add('rphooked');
				elem.onclick = function(e) {
					e.preventDefault();
					var url = elem.getAttribute('href');
					var postid = ss_bbr_getURLParameter(url, 'p');
					var start = ss_bbr_getURLParameter(url, 'start');
					var hack = new Date();

					$.ajax({
						url: sitesplat_board_url + 'app.php/bbreaction/likers.html?p=' + postid + '&start=' + start + '&time=' + String(hack.getTime()),
						context: document.getElementById("bbreaction-profile-data"),
						error: function (e, text, ee) {
						},
						success: function (s, x) {
							$(".modal-body #bbreaction-profile-data").html( s );
						}
					});
				};
			}
		});
	}

	// toggle the active classes for the bbreaction panel and trigger icon
	elems = document.querySelectorAll('.com-expand-holder');
	if (elems) {
		elems.forEach(function(elem) {
			if (!elem.classList.contains('cehhooked')) {
				elem.classList.add('cehhooked');
				elem.onclick = function(e) {
					e.preventDefault();
					$(elem).parent().find(".com-contain, .com-expand-holder").toggleClass('active');
				};
			}
		});
	}

	// toggle icon stuff
	elems = document.querySelectorAll('.star');
	if (elems) {
		elems.forEach(function(elem) {
			if (!elem.classList.contains('starhooked')) {
				elem.classList.add('starhooked');
				elem.onclick = function(e) {
					if (this.classList.contains('starred')) {
						this.classList.remove('starred');
						this.classList.add('unstarred');
					} else if (this.classList.contains('unstarred')) {
						this.classList.remove('unstarred');
						this.classList.add('starred');
					} else {
						this.classList.add('starred');
					}
				};
			}
		});
	}
}

var sitesplat_bbreaction_loaded = true;
sitesplat_bbreaction_init();
