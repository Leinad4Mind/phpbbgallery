$(document).ready(function(){

	// Panel Slide-in-out
	$('#style-switcher-tab').toggle(function () {
        $(this).parent().animate({left:'0px'}, {queue: false, duration: 500});
    }, function () {
        $(this).parent().animate({left:'-130px'}, {queue: false, duration: 500});
    });
	
	

	// Gear Icon
    var r = 0;
	
	$('#style-switcher .icon-cog').click(function(){
        $(this).css('transform','rotate(' + (r += 120) + 'deg)');
	});

	
	// Color Switcher
	$('.warm').click(function (){
	   $('body').removeClass();
	   $('body').addClass('warm-skin'); 	
	});	
	
	
	$('.cold').click(function (){
	   $('body').removeClass();
	   $('body').addClass('cold-skin');	  
	});	
	
	
	// Pattern Switcher
	$('.patternFirst').click(function (){
	   $('#pattern-overlay').removeClass();
	   $('#pattern-overlay').addClass('pattern-01'); 		   
	});		
	
	$('.patternSecond').click(function (){
	   $('#pattern-overlay').removeClass();
	   $('#pattern-overlay').addClass('pattern-02'); 		   
	});	

	$('.patternThird').click(function (){
	   $('#pattern-overlay').removeClass();
	   $('#pattern-overlay').addClass('pattern-03'); 		   
	});	

	$('.patternFourth').click(function (){
	   $('#pattern-overlay').removeClass();
	   $('#pattern-overlay').addClass('pattern-04'); 		   
	});		
	
	$('.patternNone').click(function (){
	   $('#pattern-overlay').removeClass();		   
	});		
	
});	
	
	
	