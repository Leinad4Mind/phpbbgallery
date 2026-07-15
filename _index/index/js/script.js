/* Template: AvaLanche | Author: eriktailor | Version: 1.0  */
/*----------------------------------------------------------*/

/*----------------------------------------------------------*/
/*	# Table of Contents */
/*----------------------------------------------------------*/
/* 
	1.  Navigation
	2.  Welcome Text
	3.  Team & Process
	4.	Portfolio Effects
	5.	Testimonials

/*

/*--------------------- Start Document ---------------------*/

$(document).ready(function(){

/*----------------------------------------------------------*/
/* # Navigation */
/*----------------------------------------------------------*/	

	/* Sticky Navigation */
	$("#navigation").waypoint('sticky');
	
	/* Smooth Scrolling */	
	$(function(){

		var navBar = $("#navigation"),
			navBarHeight = navBar.outerHeight()+1,
			menuItems = $(".menu-item");

		menuItems.click(function(e){
			var href = $(this).attr("href"),
				offsetTop = href === "#" ? 0 : $(href).offset().top-navBarHeight+1;
			$('html, body').stop().animate({ 
				scrollTop: offsetTop
			}, 800);
			e.preventDefault();
		});

	});	
	
	/* Mobile Menu */
	$(function() {
	
		var mobileMenu 	= $('.mobile-menu');
			menu 		= $('#menu ul');
			menuHeight	= menu.height();

		$(mobileMenu).on('click', function(e) {
            e.stopPropagation();
            e.preventDefault();
			menu.slideToggle();
		});
		
		$(window).resize(function(){
        	var w = $(window).width();
        	if(w > 760 && menu.is(':hidden')) {
        		menu.removeAttr('style');
        	}
    	});
		
	});

/*----------------------------------------------------------*/
/* # Welcome Content */
/*----------------------------------------------------------*/		
	
	/* Header Title Load Effect */
	$('.header-title').addClass('animated fadeInUpBig');
	
	/* Header Title Text Effect */
	$(function () {
	
		$('.header-title').textillate({
		
		  selector: '.texts',
		  loop: false,
		  minDisplayTime: 1000,
		  initialDelay: 0,
		  autoStart: true,
		  inEffects: [ 'fadeInUp'],
		  outEffects: [ 'fadeOut' ],

		  in: {
			effect: 'fadeInUp',
			delayScale: 1.0,
			delay: 50,
			sync: false,
			shuffle: true,
		  },

		  out: {
			effect: 'fadeOut',
			delayScale: 1.0,
			delay: 20,
			sync: true,
			shuffle: false,
		  }
		  
		});
		
	});

	

	/* Header Content Parallax */	
	$(function () {	
		
		$(window).bind('scroll',function(e){
			parallaxScroll();
		});
					
					
		function parallaxScroll(){
			var scrolledY = $(window).scrollTop();
			$('.header-content').css('top','+'+((scrolledY*0.4))+'px');
		};
		
	});
	
	
	
	


/*----------------------------------------------------------*/
/* # Our Team  */
/*----------------------------------------------------------*/

	/* Member Details */
	
		// Appear and Toggle member information window
		$(".team-member a[data-toggle]").on("click", function(e) {
		  e.preventDefault();
		  var memberProfile = $(this).data("toggle");
		  $(".memberProfile").hide();
		  $(memberProfile).slideDown('slow');
		});
		
		// Add active class to the clicked member
		$(".team-member").bind("click", function(){
			$(".team-member").removeClass('team-member-active');		
			$(this).addClass('team-member-active');
		});
		
		// Close member information window
		$(".member-photo .close").click(function(){
		$(".team-member").removeClass('team-member-active');
		  $(".memberProfile").hide('slow');		  
		});
	

	
/*----------------------------------------------------------*/
/* # Our Process  */
/*----------------------------------------------------------*/

	/* Process Details */
	
		// Appear and Toggle member information window
		$(".process-part a[data-toggle]").on("click", function(e) {
		  e.preventDefault();
		  var processDetail = $(this).data("toggle");
		  $(".processInfo").hide();
		  $(processDetail).slideDown('slow');
		});
		
		// Add active class to the clicked member
		$(".process-part").bind("click", function(){
			$(".process-part").removeClass('process-part-active');		
			$(this).addClass('process-part-active');
		});
		
		// Close member information window
		$(".processInfo .close").click(function(){
			$(".process-part-active").removeClass('process-part-active');
			$(".processInfo").hide('slow');		  
		});		
		
	
/*----------------------------------------------------------*/
/* # Portfolio Effects & Filtering */
/*----------------------------------------------------------*/		

	/* Portfolio Items Load Animation */
	$('#portfolio').waypoint(function(){
	
		var $items = $('#portfolio-wrapper');
		
		$items.each(function(i){
			$(this).css('animation-delay', (i*0.4)+"s");
		});
		
		$items.addClass('animated fadeInUp');
		
	}, {offset: 300});
	
	
	/* Portfolio Filtering */

	
	

/*----------------------------------------------------------*/
/* # Services */
/*----------------------------------------------------------*/		

	/* Services Load Effect */
	$('#services').waypoint(function(){
	
		var $items=$('.service-item');
		
		$items.each(function(i){
			$(this).css('animation-delay', (i*0.3)+"s");
		});
		
		$items.addClass('animated fadeInUp');
		
	}, {offset: 400});

/*----------------------------------------------------------*/
/* # Portfolio Details Page */
/*----------------------------------------------------------*/			
	
	/* Tablet Slider */	
	$('.tablet-frame').addClass('animated fadeInDown');	

	
	/* Related Items Load Effect*/
	var pItem = $(".portfolio-item");
	
	$('#related-projects').waypoint(function() {
		
		pItem.eq(0).css("animation-delay","0s");
		pItem.eq(1).css("animation-delay","0.3s");	
		pItem.eq(2).css("animation-delay","0.6s");

		pItem.css("animation-duration","0.6s");
		
		pItem.addClass('animated fadeInUp');
		
	}, { offset: 400});	
	

	/* Image Hover Highlight Effect */
	
	var projectImage = $('.project-image');

	projectImage.hover(function(){
		$(this).addClass('highlight');
		$('#overlay').fadeIn(500);
	});	
	
	projectImage.mouseleave( function(){
		$('#overlay').fadeOut(10, function(){
			projectImage.removeClass('highlight');
		});
	});	
	
	

/*----------------------------------------------------------*/
/* # Office Maps */
/*----------------------------------------------------------*/

var myMap = (function(a,b,c){
	var latA = a;
	var latB = b;
	var map1 = c;

	var styles = [
		{
			stylers: [ { saturation: -200 } ]
		},{
		    featureType: 'road',
			elementType: 'geometry',
			stylers: [
				{ hue: "#cccccc" },
				{ visibility: 'simplified' }
			]
		        },{
		            featureType: 'road',
		            elementType: 'labels',
		            stylers: [
		                { visibility: 'off' }
		            ]
		        }
	],
				
	lat = latA, lng = latB,	
		
	// Create a new StyledMapType object, passing it the array of styles,
	// as well as the name to be displayed on the map type control.
	customMap = new google.maps.StyledMapType(styles,
		{name: 'Styled Map'}),
		
	// Create a map object, and include the MapTypeId to add
	// to the map type control.
	mapOptions = {
		zoom: 14,
		scrollwheel: false,
		center: new google.maps.LatLng( lat, lng ),
		streetViewControl: false,
		zoomControl: true,
		panControl: false,
		draggable: false,	
		mapTypeControl: false,		
		mapTypeControlOptions: {
			mapTypeIds: [google.maps.MapTypeId.ROADMAP],
					
		}
	},
	
	map = new google.maps.Map(document.getElementById(map1), mapOptions),
		myLatlng = new google.maps.LatLng( lat, lng ),
	
	marker = new google.maps.Marker({
		position: myLatlng,
		map: map,
		icon: ""
				
	});

	//Associate the styled map with the MapTypeId and set it to display.
	map.mapTypes.set('map_style', customMap);
	map.setMapTypeId('map_style');	
});


/* Your Details: lat, lng, map id */
myMap(40.81992, -73.90683, 'map1');
myMap(40.80287, -73.95361, 'map2');

	
	
	




	
	
	
	
	
	
	
/*---------------------- End Document ----------------------*/
});





















$(window).load(function(){
	var portfolio = (function() {
		var $container = $('#portfolio-wrapper');
				$select = $('#filters select');
				
		// initialize Isotope
		$container.isotope({
		  // options...
		  resizable: false, // disable normal resizing
		  // set columnWidth to a percentage of container width
		  masonry: { columnWidth: $container.width() / 12 }
		});

		// update columnWidth on window resize
		$(window).smartresize(function(){
		  $container.isotope({
			// update columnWidth to a percentage of container width
			masonry: { columnWidth: $container.width() / 12 }
		  });
		});
		
		
		$container.isotope({
			itemSelector : '.portfolio-item'
		});
	  
		$select.change(function() {
			var filters = $(this).val();
	
			$container.isotope({
				filter: filters
			});
		});
	  
		// Portfolio Filtering
		var $optionSets = $('#filters .option-set'),
			$optionLinks = $optionSets.find('a');

		$optionLinks.click(function(){
				var $this = $(this);
				// don't proceed if already selected
				if ( $this.hasClass('selected') ) {
				return false;
			}
			var $optionSet = $this.parents('.option-set');
			$optionSet.find('.selected').removeClass('selected');
			$this.addClass('selected');
	  
			// make option object dynamically, i.e. { filter: '.my-filter-class' }
			var options = {},
				key = $optionSet.attr('data-option-key'),
				value = $this.attr('data-option-value');
			// parse 'false' as false boolean
			value = value === 'false' ? false : value;
			options[ key ] = value;
			if ( key === 'layoutMode' && typeof changeLayoutMode === 'function' ) {
			  // changes in layout modes need extra logic
			  changeLayoutMode( $this, options )
			} else {
			  // otherwise, apply new options
			  $container.isotope( options );
			}
			return false;
		});

	});
	
	portfolio();
});




















