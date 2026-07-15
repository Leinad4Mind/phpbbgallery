; (function ($, window, document) {

	$("select").change(function(e)
	 {
		$("select option").prop("disabled", false);  //enable everything
		 
		//collect the values from selected;
		var  arr = $.map
		(
			$("select option:selected"), function(n)
			{
				return (n.value > 1) ? n.value : null;
			}
		);
	
		if (this.value >= 0 && this.value < 2)
		{
			(this.value == 0) ? $("#sidebar_slot" + this.name.substring(12,13)).slideUp():$("#sidebar_slot" + this.name.substring(12,13)).slideDown();
			$("#show_mobile" + this.name.substring(12,13)).css('display', 'none');
			$("#show_tablet" + this.name.substring(12,13)).css('display', 'none');

		} else
		{
			$("#sidebar_slot" + this.name.substring(12,13)).slideUp();
			a = parseInt(this.value);
			var a = rule_type[0][a];
			$("#sidebar_slot" + this.name.substring(12,13) + "_show_mobile").prop('checked', parseInt(a.substring(0,1)));
			$("#sidebar_slot" + this.name.substring(12,13) + "_show_tablet").prop('checked', parseInt(a.substring(1)));
			$("#show_mobile" + this.name.substring(12,13)).css('display', 'inline-block');
			$("#show_tablet" + this.name.substring(12,13)).css('display', 'inline-block');
		}
	
		$("select option").filter(function()
		{
			x = $(this).val();
			return $.inArray(x, arr) > -1;
		}).prop("disabled", true);   

		var arr = [0,1];
		$("select option").filter(function()
		{
			x = $(this).val();
			return $.inArray(x, arr) > -1;
		}).prop("disabled", false);   
	});

	$('form').bind('submit', function() {
		$(this).find(':disabled').removeAttr('disabled');
	});
	

	$("#sidebartype").click(function()
	{
		if ($("#sidebar-nav").css("float") == "right")
		{
			$("#sidebar-nav").css("float", "left");
			$("#sidebar-section").css("float", "right");
		} else
		{
			$("#sidebar-nav").css("float", "right");
			$("#sidebar-section").css("float", "left");
		}
	});

	$("#width_s").click(function()
	{
		if ($("#sidebar-nav").css("width") == "50px")
		{
			$("#sidebar-nav").css("width", "30px");
			$("#sidebar-section").css("width", "220px");
		} 
		else
		{
			$("#sidebar-nav").css("width", "50px");
			$("#sidebar-section").css("width", "200px");
		}
	});
	
})(jQuery, window, document);

