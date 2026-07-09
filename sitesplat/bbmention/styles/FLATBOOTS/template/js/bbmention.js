function sitesplat_bbmention_init() {

if("undefined"!==typeof s9eNemtionsUrl&&s9eNemtionsUrl){var b=new Textcomplete(new Textcomplete.editors.Textarea(document.querySelector('textarea[name="message"]')),{dropdown:{footer:"",header:"",placement:"bottom"}});b.on("rendered",function(){0<b.dropdown.items.length&&b.dropdown.items[0].activate()});b.register([{id:"nemtions",match:/\B@(\S*)$/,search:function(a,c){$.getJSON(s9eNemtionsUrl,{str:a}).done(function(a){c(a)})},template:function(a){return a[1]},replace:function(a){return a[0]+" "},
index:1,cache:!0}])};

}

sitesplat_bbmention_init();
