var cptfork= {};

cptfork.dateandtime = function (){
	const today = new Date();
	const dateInputElement = document.querySelector('[name="cf_date"]');
	const timeInputElement = document.querySelector('[name="cf_time"]');
	var hour = today.getHours().toString().padStart(2, '0');
	var minutes = today.getMinutes().toString().padStart(2, '0');
	dateInputElement.valueAsDate = today;
	timeInputElement.value = hour + ':' + minutes;
}
