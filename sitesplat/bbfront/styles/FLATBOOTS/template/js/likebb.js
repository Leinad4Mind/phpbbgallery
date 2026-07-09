// import {event, parseURL} from './utils';
"use strict";

function parseURL(url) {
    var parser = document.createElement('a'),
        id,
        queries, split, i;
 
    parser.href = url;
    queries = parser.search.replace(/^\?/, '').split('&');
    for( i = 0; i < queries.length; i++ ) {
        split = queries[i].split('=');
        id = split[0] + split[1];
    }
 
    return {
        pathname: parser.href,
        search: parser.search,
        id: id
    };
}

event(".bbfront_likebb", "click", function(e) {
    e.stopPropagation();
    e.preventDefault();

    const uri = parseURL(this.getAttribute("data-options"));

    // uri.pathname = ' https://www.sitesplat.com/ext/likedd/index.html?l=8'
    ajax({
        type: "POST",
        url: uri.pathname,
        data: uri.search.replace(/^\?/, ''),
        dataType: "application/x-www-form-urlencoded; charset=UTF-8",
        success: function(res){
        //    console.log("success", uri.pathname, JSON.parse(res));
            try {
                 res = JSON.parse(res);
                 if ( res.likes ) {
                    const val = uri.id;
                    document.getElementById(val).innerText = ( res.likes );
                }
                phpbb.alert(res.info, res.txt, true);
                phpbb.closeDarkenWrapper(4000);
            } catch(err) {
                console.log("parse error", err);
            }
        },
        error: function(res) {
            console.log("error", res);
        }
    })
    return false;
});

function ajax(options) {
    let opts = {
        type: "GET",
        dataType: "html",
        url: null,
        context: null,
        data: {},
        success: (response) => {},
        error: (response) => {}
    };

    Object.keys(options).forEach((option) => {
        if (options.hasOwnProperty(option)) {
          opts[option] = options[option];
        }
    });
    if ( opts.url === null ) return;
    var xhr = new XMLHttpRequest();
    xhr.open(opts.type.toUpperCase(), opts.url);
    if ( opts.dataType.toLowerCase() === "json" ) xhr.setRequestHeader("Content-Type", "application/json");
    else xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded; charset=UTF-8')
    xhr.onreadystatechange = function() {
        const c = (opts.context === null ) ? this : opts.context;
        if (this.readyState == 4 && this.status == 200) {
            let response = this.responseText;
            if ( opts.dataType.toLowerCase()==="json") {
                try {
                    response = JSON.parse(this.responseText);
                } catch(e) {
                    opts.error.call(c, this, e);
                    return;
                }
            }
            opts.success.call(c, response);
        } 
    };

    xhr.onerror = function() {
        const c = (opts.context === null ) ? this : opts.context;
        opts.error.call(c, this, this.status);
    };

    xhr.setRequestHeader("X-Requested-With", "XMLHttpRequest");
    xhr.send(opts.data);
}