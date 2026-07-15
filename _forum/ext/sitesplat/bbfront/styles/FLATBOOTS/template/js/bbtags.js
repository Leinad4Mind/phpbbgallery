// import {event, parseURL} from './utils';
"use strict";

// bbtags related logic	
	const next = (element, query) => {
		let t = true,
			e = element,
			queries = query.indexOf(",") > -1 ? query.split(',') : [query]; 
		while ( t ) {
			e = e.nextElementSibling;
			for ( let i = 0; i < queries.length; i++ ) {
				if ( queries[i].indexOf("#") > -1 ) {
					if ( e.getAttribute("id") === queries[i] ) {
						t = false;
						return e;
					} 
				} else {
					const q = queries[i].replace(".", "");
					if ( e.classList.contains(q)  ) {
						t = false;
						return e;
					}
				}
			}
		}

		return e;
	}

	const prev = (element, query) => {
		let t = true,
			e = element,
			queries = query.indexOf(",") > -1 ? query.split(',') : [query]; 
		while ( t ) {
			e = e.previousElementSibling;
			for ( let i = 0; i < queries.length; i++ ) {
				if ( queries[i].indexOf("#") > -1 ) {
					if ( e.getAttribute("id") === queries[i] ) {
						t = false;
						return e;
					} 
				} else {
					const q = queries[i].replace(".", "");
					if ( e.classList.contains(q) ) {
						t = false;
						return e;
					}
				}
			}
		}

		return e;
	}

	event(".fab", "click", function(e) {
		e.stopPropagation();
		this.classList.toggle("clicked");
		next(this, ".screen2").classList.add("active");
		next(this, ".screen2").querySelector(".box1").classList.add("active")
		return false;
	});

	event(".close-bbtag", "click", function(e){
		e.stopPropagation();
		this.closest(".screen2").classList.remove("active");
		prev(this.closest(".screen2"), ".fab").classList.remove("clicked");
		this.closest(".screen2").querySelector(".box1").classList.remove("active");
		return false;
	});
// bbtags related logic		