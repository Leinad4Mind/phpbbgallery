// http://www.3site.eu/examples/nevex/
// http://www.3site.eu/examples/nevex/nevex.js
// http://www.3site.eu/examples/nevex/nevex.css

document.addEventListener("DOMContentLoaded", function nevex() {
    // (C) Andrea Giammarchi - Mit Style License
    // Happy Holidays by WebReflection!
    for (var
        offsetHeight = document.documentElement.offsetHeight,
        offsetWidth = document.documentElement.offsetWidth,
        F = document.createDocumentFragment(),
        random = Math.random,
        Int = parseInt,
        i = Math.max(Math.min((offsetWidth * offsetHeight / 15000) >> 0, 40), 10),
        radius = 6,
        p, width, border, style, top, left;
        i--;
    ){
        p = document.createElement("p");
        p.style.cssText = "".concat(
            "position:absolute;",
			"color:#CC9900;",
            "top:", (random() * offsetHeight) >> 0, "px;",
            "left:", (random() * offsetWidth) >> 0, "px;",
            "width:", width = ((random() * radius) >> 0) + 1, "px;",
            "height:", width, "px;",
            "z-index:", width, ";",
            "-moz-border-radius:", border = (width / 2) >> 0, "px;",
            "-webkit-border-radius:", border, "px;",
            "border-radius:", border, "px;",
            "font-size:", (random() * (radius / 2)) >> 0, "px;"
        );
        F.appendChild(p).className = "nevex";
    };
    document.body.appendChild(F);
    window.addEventListener("resize", function () {
        offsetHeight = document.documentElement.offsetHeight;
        offsetWidth = document.documentElement.offsetWidth;
    }, false);
    radius = radius / 2;
    setTimeout(function nevex(p) {
        for(i = p.length; i--;) {
            style = p[i].style;
            width = Int(style.width, 10);
            top = Int(style.top, 10) + width;
            left = Int(style.left, 10) + (border = width + Int(style.fontSize, 10));
            if ((style.top =  (top + width < offsetHeight ? top : 0) + "px") === "0px") {
                style.left = ((random() * offsetWidth) >> 0) + "px";
                style.fontSize = ((random() * (radius / 2)) >> 0) + "px";
            } else {
                style.left =  (left + border < offsetWidth ? left : 0) + "px";
            };
        };
        setTimeout(nevex, 30, p);
    }, 30, document.getElementsByClassName("nevex"));
}, false);