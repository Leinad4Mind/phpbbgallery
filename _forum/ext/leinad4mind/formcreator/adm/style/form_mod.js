/***
* This is a collection of scripts written for Form Mod (Form Creator)
*
*	takes three possible elements...
*	switches the first element and set cookie
*	switch second element visibility...
*
***/

// Show/Hide element with cookie option

function Show(id)
{
	$('#' + id).show();
}

function Hide(id)
{
	$('#' + id).hide();
}

function ShowHide(id1)
{
	$('#' + id1).toggle();
}

function is_hidden(id)
{
	return $('#' + id).is(':visible');
}

function toggle_validation()
{
	document.forms.postform.noValidate = !is_hidden('thisform');
}
