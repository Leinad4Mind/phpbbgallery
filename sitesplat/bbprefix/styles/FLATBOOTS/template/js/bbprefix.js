(function(){
	var options = {
		group: 'sortable_prefixes',
		ghostClass: 'ui-sortable-placeholder'
	};
	var available_prefixes = document.getElementById('available_prefixes');
	var sortable_available_prefixes = Sortable.create(available_prefixes, options);

	var used_prefixes = document.getElementById('used_prefixes');
	var sortable_used_prefixes = Sortable.create(used_prefixes, options);

	// Move on click
	var click_areas = document.querySelectorAll('.click_area');
	for (var i = 0; i < click_areas.length; i++) {
		click_areas[i].addEventListener('click', function(e){
			var parent, elem;
			if (e.target.parentNode.nodeName == 'UL')
			{
				parent = e.target.parentNode;
				elem = e.target;
			}
			else
			{
				parent = e.target.parentNode.parentNode;
				elem = e.target.parentNode;
			}
			if (parent.id == 'available_prefixes')
			{
				document.getElementById('used_prefixes').appendChild(elem);
			}
			else
			{
				document.getElementById('available_prefixes').appendChild(elem);
			}
		});
	}

	// Send prefixes with form
	document.getElementById('postform').addEventListener('submit', function(e){
		var sorted = sortable_used_prefixes.toArray().map(function(val){
			return 'prefix[]=' + val
		}).join('&');

		var input = document.createElement('input');
		input.setAttribute('type', 'hidden');
		input.setAttribute('name', 'prefixes_used');
		input.setAttribute('value', sorted);

		document.getElementById('postform').appendChild(input);
	});

	// Toggle prefix popover
	document.querySelector("[data-toggle='toggle']").addEventListener('click', function(e){
		var selector = e.target.parentNode.dataset.target
		document.querySelector(selector).classList.toggle('in');
		document.querySelector('.prefix-popover').classList.toggle('is-visible');
	});
})();
