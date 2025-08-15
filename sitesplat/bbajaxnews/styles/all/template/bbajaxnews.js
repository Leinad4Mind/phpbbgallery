var timeout = null;

if (bbajaxnews_driver == 'pubnub') {
	var pubnub = new PubNub({
		subscribeKey: window.bbajaxnews_sub_key
	});
	pubnub.addListener({
		message: function(response) {
			display_ajaxnew(response.message.message, false);
		}
	});
	pubnub.subscribe({
		channels: [window.bbajaxnews_user_channel]
	});
} else if (bbajaxnews_driver == 'pusher') {
	Pusher.logToConsole = true;
	var pusher = new Pusher(window.bbajaxnews_sub_key, {
		cluster: window.bbajaxnews_cluster,
		encrypted: true
	});
	var channel = pusher.subscribe(window.bbajaxnews_user_channel);
	channel.bind('ajaxnews', function(data) {
		display_ajaxnew(data, false);
	});
}

function display_ajaxnew(message, is_casual) {
	if (message) {
		// Let's close all casual news before we display a new one
		if (is_casual) {
			Noty.closeAll('casual');
		//	Noty.clearQueue('casual');
		}

		var config = {
			type: 'info',
		//	dismissQueue: true,
			queue: is_casual ? 'casual' : 'special',
			layout: window.bbajaxnews_layout,
			text: message,
			timeout: window.bbajaxnews_timeout,
			progressBar: window.bbajaxnews_progress_bar,
			closeWith: ['button'],
			visibilityControl: window.bbajaxnews_visibility_control,
		};
//	mo.js animation inizia
		if (window.bbajaxnews_mo) {
			config.animation = {
				open: function (promise) {
					var n = this;
					var Timeline = new mojs.Timeline();
					var body = new mojs.Html({
						el        : n.barDom,
						x         : {500: 0, delay: 0, duration: 500, easing: 'elastic.out'},
						isForce3d : true,
						onComplete: function () {
							promise(function(resolve) {
								resolve();
							})
						}
					});
		
					var parent = new mojs.Shape({
						parent: n.barDom,
						width      : 200,
						height     : n.barDom.getBoundingClientRect().height,
						radius     : 0,
						x          : {[150]: -150},
						duration   : 1.2 * 500,
						isShowStart: true
					});
		
					n.barDom.style['overflow'] = 'visible';
					parent.el.style['overflow'] = 'hidden';
		
					var burst = new mojs.Burst({
						parent  : parent.el,
						count   : 10,
						top     : n.barDom.getBoundingClientRect().height + 75,
						degree  : 90,
						radius  : 75,
						angle   : {[-90]: 40},
						children: {
							fill     : '#EBD761',
							delay    : 'stagger(500, -50)',
							radius   : 'rand(8, 25)',
							direction: -1,
							isSwirl  : true
						}
					});
		
					var fadeBurst = new mojs.Burst({
						parent  : parent.el,
						count   : 2,
						degree  : 0,
						angle   : 75,
						radius  : {0: 100},
						top     : '90%',
						children: {
							fill     : '#EBD761',
							pathScale: [.65, 1],
							radius   : 'rand(12, 15)',
							direction: [-1, 1],
							delay    : .8 * 500,
							isSwirl  : true
						}
					});
		
					Timeline.add(body, burst, fadeBurst, parent);
					Timeline.play();
				},
				close: function (promise) {
					var n = this;
					new mojs.Html({
						el        : n.barDom,
						x         : {0: 500, delay: 10, duration: 500, easing: 'cubic.out'},
						skewY     : {0: 10, delay: 10, duration: 500, easing: 'cubic.out'},
						isForce3d : true,
						onComplete: function () {
							promise(function(resolve) {
								resolve();
							})
						}
					}).play();
				}
			}
		}
//	mo.js animation fine
		new Noty(config).show();
	}

	if (window.bbajaxnews_casual_interval)
	{
		clearTimeout(timeout);
		startTimeout();
	}
}

function startTimeout() {
	timeout = setTimeout(function() {
		fetch(window.bbajaxnews_casual_route, {
			credentials: 'include',
		})
		.then(function(response) {
			return response.json();
		})
		.then(function(data) {
			display_ajaxnew(data.message, true);
		})
	}, window.bbajaxnews_casual_interval);
}

if (window.bbajaxnews_casual_interval)
{
	startTimeout();
}
