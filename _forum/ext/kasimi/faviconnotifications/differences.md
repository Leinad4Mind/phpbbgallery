Existem diferencas reais no codigo ou texto. Diferencas de formatacao (espacos, tabs) foram ignoradas abaixo.

```diff
diff --git "[ORIGINAL]/kasimi\\faviconnotifications/composer.json" "[FORUM_EXT]/kasimi\\faviconnotifications/composer.json"
--- "[ORIGINAL]/kasimi\\faviconnotifications/composer.json"
+++ "[FORUM_EXT]/kasimi\\faviconnotifications/composer.json"
@@ -3,19 +3,20 @@
     "type": "phpbb-extension",
     "description": "Displays the number of new notifications in the favicon",
     "homepage": "https://github.com/kasimi",
-    "version": "1.0.1",
-    "time": "2020-02-19",
-    "license": "GPL-2.0-only",
+    "version": "1.0.0",
+    "time": "2016-08-23",
+    "license": "GPL-2.0",
     "authors": [
         {
             "name": "kasimi",
-            "email": "mail@kasimi.net",
-            "homepage": "https://kasimi.net",
-            "role": "Extension Developer"
+            "email": "",
+            "homepage": "https://www.phpbb.com/community/memberlist.php?mode=viewprofile&u=1330603",
+            "role": "Lead Developer"
         }
     ],
     "require": {
-        "php": ">=5.3.3"
+        "php": ">=5.3.3",
+        "phpbb/phpbb": ">=3.1.0@dev"
     },
     "extra": {
         "display-name": "Favicon Notifications",
diff --git "[FORUM_EXT]/kasimi\\faviconnotifications/diff_full.tmp" "[FORUM_EXT]/kasimi\\faviconnotifications/diff_full.tmp"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/kasimi\\faviconnotifications/diff_full.tmp"
@@ -0,0 +1,1295 @@
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\kasimi\\faviconnotifications/composer.json" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\kasimi\\faviconnotifications/composer.json"
+index d1ef011e4..be1fdfeb7 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\kasimi\\faviconnotifications/composer.json"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\kasimi\\faviconnotifications/composer.json"
+@@ -3,19 +3,20 @@
+     "type": "phpbb-extension",
+     "description": "Displays the number of new notifications in the favicon",
+     "homepage": "https://github.com/kasimi",
+-    "version": "1.0.1",
+-    "time": "2020-02-19",
+-    "license": "GPL-2.0-only",
++    "version": "1.0.0",
++    "time": "2016-08-23",
++    "license": "GPL-2.0",
+     "authors": [
+         {
+             "name": "kasimi",
+-            "email": "mail@kasimi.net",
+-            "homepage": "https://kasimi.net",
+-            "role": "Extension Developer"
++            "email": "",
++            "homepage": "https://www.phpbb.com/community/memberlist.php?mode=viewprofile&u=1330603",
++            "role": "Lead Developer"
+         }
+     ],
+     "require": {
+-        "php": ">=5.3.3"
++        "php": ">=5.3.3",
++        "phpbb/phpbb": ">=3.1.0@dev"
+     },
+     "extra": {
+         "display-name": "Favicon Notifications",
+@@ -28,4 +29,4 @@
+             "filename": "version_check"
+         }
+     }
+-}
++}
+\ No newline at end of file
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\kasimi\\faviconnotifications/diff_full.tmp" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\kasimi\\faviconnotifications/diff_full.tmp"
+new file mode 100644
+index 000000000..e69de29bb
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\kasimi\\faviconnotifications/styles/BBOOTS/template/event/overall_header_head_append.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\kasimi\\faviconnotifications/styles/BBOOTS/template/event/overall_header_head_append.html"
+new file mode 100644
+index 000000000..7c674b05d
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\kasimi\\faviconnotifications/styles/BBOOTS/template/event/overall_header_head_append.html"
+@@ -0,0 +1,4 @@
++<!-- IF S_USER_LOGGED_IN and not S_IS_BOT -->
++	<!-- INCLUDEJS js/favico-0.3.10.min.js -->
++	<!-- INCLUDEJS js/faviconnotifications.js -->
++<!-- ENDIF -->
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\kasimi\\faviconnotifications/styles/BBOOTS/template/js/favico-0.3.10.min.bak.js" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\kasimi\\faviconnotifications/styles/BBOOTS/template/js/favico-0.3.10.min.bak.js"
+new file mode 100644
+index 000000000..cd411658b
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\kasimi\\faviconnotifications/styles/BBOOTS/template/js/favico-0.3.10.min.bak.js"
+@@ -0,0 +1,7 @@
++/**
++ * @license MIT
++ * @fileOverview Favico animations
++ * @author Miroslav Magda, http://blog.ejci.net
++ * @version 0.3.10
++ */
++!function(){var e=function(e){"use strict";function t(e){if(e.paused||e.ended||g)return!1;try{f.clearRect(0,0,s,l),f.drawImage(e,0,0,s,l)}catch(o){}p=setTimeout(function(){t(e)},S.duration),O.setIcon(h)}function o(e){var t=/^#?([a-f\d])([a-f\d])([a-f\d])$/i;e=e.replace(t,function(e,t,o,n){return t+t+o+o+n+n});var o=/^#?([a-f\d]{2})([a-f\d]{2})([a-f\d]{2})$/i.exec(e);return o?{r:parseInt(o[1],16),g:parseInt(o[2],16),b:parseInt(o[3],16)}:!1}function n(e,t){var o,n={};for(o in e)n[o]=e[o];for(o in t)n[o]=t[o];return n}function r(){return b.hidden||b.msHidden||b.webkitHidden||b.mozHidden}e=e?e:{};var i,a,l,s,h,f,c,d,u,y,w,g,x,m,p,b,v={bgColor:"#d00",textColor:"#fff",fontFamily:"sans-serif",fontStyle:"bold",type:"circle",position:"down",animation:"slide",elementId:!1,dataUrl:!1,win:window};x={},x.ff="undefined"!=typeof InstallTrigger,x.chrome=!!window.chrome,x.opera=!!window.opera||navigator.userAgent.indexOf("Opera")>=0,x.ie=/*@cc_on!@*/!1,x.safari=Object.prototype.toString.call(window.HTMLElement).indexOf("Constructor")>0,x.supported=x.chrome||x.ff||x.opera;var C=[];w=function(){},d=g=!1;var E=function(){i=n(v,e),i.bgColor=o(i.bgColor),i.textColor=o(i.textColor),i.position=i.position.toLowerCase(),i.animation=S.types[""+i.animation]?i.animation:v.animation,b=i.win.document;var t=i.position.indexOf("up")>-1,r=i.position.indexOf("left")>-1;if(t||r)for(var d=0;d<S.types[""+i.animation].length;d++){var u=S.types[""+i.animation][d];t&&(u.y=u.y<.6?u.y-.4:u.y-2*u.y+(1-u.w)),r&&(u.x=u.x<.6?u.x-.4:u.x-2*u.x+(1-u.h)),S.types[""+i.animation][d]=u}i.type=A[""+i.type]?i.type:v.type,a=O.getIcon(),h=document.createElement("canvas"),c=document.createElement("img"),a.hasAttribute("href")?(c.setAttribute("crossOrigin","anonymous"),c.onload=function(){l=c.height>0?c.height:32,s=c.width>0?c.width:32,h.height=l,h.width=s,f=h.getContext("2d"),M.ready()},c.setAttribute("src",a.getAttribute("href"))):(c.onload=function(){l=32,s=32,c.height=l,c.width=s,h.height=l,h.width=s,f=h.getContext("2d"),M.ready()},c.setAttribute("src",""))},M={};M.ready=function(){d=!0,M.reset(),w()},M.reset=function(){d&&(C=[],u=!1,y=!1,f.clearRect(0,0,s,l),f.drawImage(c,0,0,s,l),O.setIcon(h),window.clearTimeout(m),window.clearTimeout(p))},M.start=function(){if(d&&!y){var e=function(){u=C[0],y=!1,C.length>0&&(C.shift(),M.start())};if(C.length>0){y=!0;var t=function(){["type","animation","bgColor","textColor","fontFamily","fontStyle"].forEach(function(e){e in C[0].options&&(i[e]=C[0].options[e])}),S.run(C[0].options,function(){e()},!1)};u?S.run(u.options,function(){t()},!0):t()}}};var A={},I=function(e){return e.n="number"==typeof e.n?Math.abs(0|e.n):e.n,e.x=s*e.x,e.y=l*e.y,e.w=s*e.w,e.h=l*e.h,e.len=(""+e.n).length,e};A.circle=function(e){e=I(e);var t=!1;2===e.len?(e.x=e.x-.4*e.w,e.w=1.4*e.w,t=!0):e.len>=3&&(e.x=e.x-.65*e.w,e.w=1.65*e.w,t=!0),f.clearRect(0,0,s,l),f.drawImage(c,0,0,s,l),f.beginPath(),f.font=i.fontStyle+" "+Math.floor(e.h*(e.n>99?.85:1))+"px "+i.fontFamily,f.textAlign="center",t?(f.moveTo(e.x+e.w/2,e.y),f.lineTo(e.x+e.w-e.h/2,e.y),f.quadraticCurveTo(e.x+e.w,e.y,e.x+e.w,e.y+e.h/2),f.lineTo(e.x+e.w,e.y+e.h-e.h/2),f.quadraticCurveTo(e.x+e.w,e.y+e.h,e.x+e.w-e.h/2,e.y+e.h),f.lineTo(e.x+e.h/2,e.y+e.h),f.quadraticCurveTo(e.x,e.y+e.h,e.x,e.y+e.h-e.h/2),f.lineTo(e.x,e.y+e.h/2),f.quadraticCurveTo(e.x,e.y,e.x+e.h/2,e.y)):f.arc(e.x+e.w/2,e.y+e.h/2,e.h/2,0,2*Math.PI),f.fillStyle="rgba("+i.bgColor.r+","+i.bgColor.g+","+i.bgColor.b+","+e.o+")",f.fill(),f.closePath(),f.beginPath(),f.stroke(),f.fillStyle="rgba("+i.textColor.r+","+i.textColor.g+","+i.textColor.b+","+e.o+")","number"==typeof e.n&&e.n>999?f.fillText((e.n>9999?9:Math.floor(e.n/1e3))+"k+",Math.floor(e.x+e.w/2),Math.floor(e.y+e.h-.2*e.h)):f.fillText(e.n,Math.floor(e.x+e.w/2),Math.floor(e.y+e.h-.15*e.h)),f.closePath()},A.rectangle=function(e){e=I(e);var t=!1;2===e.len?(e.x=e.x-.4*e.w,e.w=1.4*e.w,t=!0):e.len>=3&&(e.x=e.x-.65*e.w,e.w=1.65*e.w,t=!0),f.clearRect(0,0,s,l),f.drawImage(c,0,0,s,l),f.beginPath(),f.font=i.fontStyle+" "+Math.floor(e.h*(e.n>99?.9:1))+"px "+i.fontFamily,f.textAlign="center",f.fillStyle="rgba("+i.bgColor.r+","+i.bgColor.g+","+i.bgColor.b+","+e.o+")",f.fillRect(e.x,e.y,e.w,e.h),f.fillStyle="rgba("+i.textColor.r+","+i.textColor.g+","+i.textColor.b+","+e.o+")","number"==typeof e.n&&e.n>999?f.fillText((e.n>9999?9:Math.floor(e.n/1e3))+"k+",Math.floor(e.x+e.w/2),Math.floor(e.y+e.h-.2*e.h)):f.fillText(e.n,Math.floor(e.x+e.w/2),Math.floor(e.y+e.h-.15*e.h)),f.closePath()};var T=function(e,t){t=("string"==typeof t?{animation:t}:t)||{},w=function(){try{if("number"==typeof e?e>0:""!==e){var n={type:"badge",options:{n:e}};if("animation"in t&&S.types[""+t.animation]&&(n.options.animation=""+t.animation),"type"in t&&A[""+t.type]&&(n.options.type=""+t.type),["bgColor","textColor"].forEach(function(e){e in t&&(n.options[e]=o(t[e]))}),["fontStyle","fontFamily"].forEach(function(e){e in t&&(n.options[e]=t[e])}),C.push(n),C.length>100)throw new Error("Too many badges requests in queue.");M.start()}else M.reset()}catch(r){throw new Error("Error setting badge. Message: "+r.message)}},d&&w()},U=function(e){w=function(){try{var t=e.width,o=e.height,n=document.createElement("img"),r=o/l>t/s?t/s:o/l;n.setAttribute("crossOrigin","anonymous"),n.onload=function(){f.clearRect(0,0,s,l),f.drawImage(n,0,0,s,l),O.setIcon(h)},n.setAttribute("src",e.getAttribute("src")),n.height=o/r,n.width=t/r}catch(i){throw new Error("Error setting image. Message: "+i.message)}},d&&w()},R=function(e){w=function(){try{if("stop"===e)return g=!0,M.reset(),void(g=!1);e.addEventListener("play",function(){t(this)},!1)}catch(o){throw new Error("Error setting video. Message: "+o.message)}},d&&w()},L=function(e){if(window.URL&&window.URL.createObjectURL||(window.URL=window.URL||{},window.URL.createObjectURL=function(e){return e}),x.supported){var o=!1;navigator.getUserMedia=navigator.getUserMedia||navigator.oGetUserMedia||navigator.msGetUserMedia||navigator.mozGetUserMedia||navigator.webkitGetUserMedia,w=function(){try{if("stop"===e)return g=!0,M.reset(),void(g=!1);o=document.createElement("video"),o.width=s,o.height=l,navigator.getUserMedia({video:!0,audio:!1},function(e){o.src=URL.createObjectURL(e),o.play(),t(o)},function(){})}catch(n){throw new Error("Error setting webcam. Message: "+n.message)}},d&&w()}},O={};O.getIcon=function(){var e=!1,t=function(){for(var e=b.getElementsByTagName("head")[0].getElementsByTagName("link"),t=e.length,o=t-1;o>=0;o--)if(/(^|\s)icon(\s|$)/i.test(e[o].getAttribute("rel")))return e[o];return!1};return i.element?e=i.element:i.elementId?(e=b.getElementById(i.elementId),e.setAttribute("href",e.getAttribute("src"))):(e=t(),e===!1&&(e=b.createElement("link"),e.setAttribute("rel","icon"),b.getElementsByTagName("head")[0].appendChild(e))),e.setAttribute("type","image/png"),e},O.setIcon=function(e){var t=e.toDataURL("image/png");if(i.dataUrl&&i.dataUrl(t),i.element)i.element.setAttribute("href",t),i.element.setAttribute("src",t);else if(i.elementId){var o=b.getElementById(i.elementId);o.setAttribute("href",t),o.setAttribute("src",t)}else if(x.ff||x.opera){var n=a;a=b.createElement("link"),x.opera&&a.setAttribute("rel","icon"),a.setAttribute("rel","icon"),a.setAttribute("type","image/png"),b.getElementsByTagName("head")[0].appendChild(a),a.setAttribute("href",t),n.parentNode&&n.parentNode.removeChild(n)}else a.setAttribute("href",t)};var S={};return S.duration=40,S.types={},S.types.fade=[{x:.4,y:.4,w:.6,h:.6,o:0},{x:.4,y:.4,w:.6,h:.6,o:.1},{x:.4,y:.4,w:.6,h:.6,o:.2},{x:.4,y:.4,w:.6,h:.6,o:.3},{x:.4,y:.4,w:.6,h:.6,o:.4},{x:.4,y:.4,w:.6,h:.6,o:.5},{x:.4,y:.4,w:.6,h:.6,o:.6},{x:.4,y:.4,w:.6,h:.6,o:.7},{x:.4,y:.4,w:.6,h:.6,o:.8},{x:.4,y:.4,w:.6,h:.6,o:.9},{x:.4,y:.4,w:.6,h:.6,o:1}],S.types.none=[{x:.4,y:.4,w:.6,h:.6,o:1}],S.types.pop=[{x:1,y:1,w:0,h:0,o:1},{x:.9,y:.9,w:.1,h:.1,o:1},{x:.8,y:.8,w:.2,h:.2,o:1},{x:.7,y:.7,w:.3,h:.3,o:1},{x:.6,y:.6,w:.4,h:.4,o:1},{x:.5,y:.5,w:.5,h:.5,o:1},{x:.4,y:.4,w:.6,h:.6,o:1}],S.types.popFade=[{x:.75,y:.75,w:0,h:0,o:0},{x:.65,y:.65,w:.1,h:.1,o:.2},{x:.6,y:.6,w:.2,h:.2,o:.4},{x:.55,y:.55,w:.3,h:.3,o:.6},{x:.5,y:.5,w:.4,h:.4,o:.8},{x:.45,y:.45,w:.5,h:.5,o:.9},{x:.4,y:.4,w:.6,h:.6,o:1}],S.types.slide=[{x:.4,y:1,w:.6,h:.6,o:1},{x:.4,y:.9,w:.6,h:.6,o:1},{x:.4,y:.9,w:.6,h:.6,o:1},{x:.4,y:.8,w:.6,h:.6,o:1},{x:.4,y:.7,w:.6,h:.6,o:1},{x:.4,y:.6,w:.6,h:.6,o:1},{x:.4,y:.5,w:.6,h:.6,o:1},{x:.4,y:.4,w:.6,h:.6,o:1}],S.run=function(e,t,o,a){var l=S.types[r()?"none":i.animation];return a=o===!0?"undefined"!=typeof a?a:l.length-1:"undefined"!=typeof a?a:0,t=t?t:function(){},a<l.length&&a>=0?(A[i.type](n(e,l[a])),m=setTimeout(function(){o?a-=1:a+=1,S.run(e,t,o,a)},S.duration),O.setIcon(h),void 0):void t()},E(),{badge:T,video:R,image:U,webcam:L,reset:M.reset,browser:{supported:x.supported}}};"undefined"!=typeof define&&define.amd?define([],function(){return e}):"undefined"!=typeof module&&module.exports?module.exports=e:this.Favico=e}();
+\ No newline at end of file
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\kasimi\\faviconnotifications/styles/BBOOTS/template/js/favico-0.3.10.min.js" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\kasimi\\faviconnotifications/styles/BBOOTS/template/js/favico-0.3.10.min.js"
+new file mode 100644
+index 000000000..66ccf4740
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\kasimi\\faviconnotifications/styles/BBOOTS/template/js/favico-0.3.10.min.js"
+@@ -0,0 +1,7 @@
++/**
++ * @license MIT
++ * @fileOverview Favico animations
++ * @author Miroslav Magda, http://blog.ejci.net
++ * @version 0.3.10
++ */
++!function(){var e=function(e){"use strict";function t(e){if(e.paused||e.ended||w)return!1;try{h.clearRect(0,0,l,a),h.drawImage(e,0,0,l,a)}catch(e){}m=setTimeout(function(){t(e)},I.duration),A.setIcon(s)}function o(e){e=e.replace(/^#?([a-f\d])([a-f\d])([a-f\d])$/i,function(e,t,o,n){return t+t+o+o+n+n});var t=/^#?([a-f\d]{2})([a-f\d]{2})([a-f\d]{2})$/i.exec(e);return!!t&&{r:parseInt(t[1],16),g:parseInt(t[2],16),b:parseInt(t[3],16)}}function n(e,t){var o,n={};for(o in e)n[o]=e[o];for(o in t)n[o]=t[o];return n}e=e||{};var r,i,a,l,s,h,f,c,d,u,y,w,g,x,m,p,b={bgColor:"#d00",textColor:"#fff",fontFamily:"sans-serif",fontStyle:"bold",type:"circle",position:"down",animation:"slide",elementId:!1,dataUrl:!1,win:window};(g={}).ff="undefined"!=typeof InstallTrigger,g.chrome=!!window.chrome,g.opera=!!window.opera||navigator.userAgent.indexOf("Opera")>=0,g.ie=!1,g.safari=Object.prototype.toString.call(window.HTMLElement).indexOf("Constructor")>0,g.supported=g.chrome||g.ff||g.opera;var v=[];y=function(){},c=w=!1;var C={ready:function(){c=!0,C.reset(),y()},reset:function(){c&&(v=[],d=!1,u=!1,h.clearRect(0,0,l,a),h.drawImage(f,0,0,l,a),A.setIcon(s),window.clearTimeout(x),window.clearTimeout(m))}};C.start=function(){if(c&&!u){if(v.length>0){u=!0;var e=function(){["type","animation","bgColor","textColor","fontFamily","fontStyle"].forEach(function(e){e in v[0].options&&(r[e]=v[0].options[e])}),I.run(v[0].options,function(){d=v[0],u=!1,v.length>0&&(v.shift(),C.start())},!1)};d?I.run(d.options,function(){e()},!0):e()}}};var E={},M=function(e){return e.n="number"==typeof e.n?Math.abs(0|e.n):e.n,e.x=l*e.x,e.y=a*e.y,e.w=l*e.w,e.h=a*e.h,e.len=(""+e.n).length,e};E.circle=function(e){var t=!1;2===(e=M(e)).len?(e.x=e.x-.4*e.w,e.w=1.4*e.w,t=!0):e.len>=3&&(e.x=e.x-.65*e.w,e.w=1.65*e.w,t=!0),h.clearRect(0,0,l,a),h.drawImage(f,0,0,l,a),h.beginPath(),h.font=r.fontStyle+" "+Math.floor(e.h*(e.n>99?.85:1))+"px "+r.fontFamily,h.textAlign="center",t?(h.moveTo(e.x+e.w/2,e.y),h.lineTo(e.x+e.w-e.h/2,e.y),h.quadraticCurveTo(e.x+e.w,e.y,e.x+e.w,e.y+e.h/2),h.lineTo(e.x+e.w,e.y+e.h-e.h/2),h.quadraticCurveTo(e.x+e.w,e.y+e.h,e.x+e.w-e.h/2,e.y+e.h),h.lineTo(e.x+e.h/2,e.y+e.h),h.quadraticCurveTo(e.x,e.y+e.h,e.x,e.y+e.h-e.h/2),h.lineTo(e.x,e.y+e.h/2),h.quadraticCurveTo(e.x,e.y,e.x+e.h/2,e.y)):h.arc(e.x+e.w/2,e.y+e.h/2,e.h/2,0,2*Math.PI),h.fillStyle="rgba("+r.bgColor.r+","+r.bgColor.g+","+r.bgColor.b+","+e.o+")",h.fill(),h.closePath(),h.beginPath(),h.stroke(),h.fillStyle="rgba("+r.textColor.r+","+r.textColor.g+","+r.textColor.b+","+e.o+")","number"==typeof e.n&&e.n>999?h.fillText((e.n>9999?9:Math.floor(e.n/1e3))+"k+",Math.floor(e.x+e.w/2),Math.floor(e.y+e.h-.2*e.h)):h.fillText(e.n,Math.floor(e.x+e.w/2),Math.floor(e.y+e.h-.15*e.h)),h.closePath()},E.rectangle=function(e){2===(e=M(e)).len?(e.x=e.x-.4*e.w,e.w=1.4*e.w):e.len>=3&&(e.x=e.x-.65*e.w,e.w=1.65*e.w),h.clearRect(0,0,l,a),h.drawImage(f,0,0,l,a),h.beginPath(),h.font=r.fontStyle+" "+Math.floor(e.h*(e.n>99?.9:1))+"px "+r.fontFamily,h.textAlign="center",h.fillStyle="rgba("+r.bgColor.r+","+r.bgColor.g+","+r.bgColor.b+","+e.o+")",h.fillRect(e.x,e.y,e.w,e.h),h.fillStyle="rgba("+r.textColor.r+","+r.textColor.g+","+r.textColor.b+","+e.o+")","number"==typeof e.n&&e.n>999?h.fillText((e.n>9999?9:Math.floor(e.n/1e3))+"k+",Math.floor(e.x+e.w/2),Math.floor(e.y+e.h-.2*e.h)):h.fillText(e.n,Math.floor(e.x+e.w/2),Math.floor(e.y+e.h-.15*e.h)),h.closePath()};var A={getIcon:function(){var e=!1;return r.element?e=r.element:r.elementId?(e=p.getElementById(r.elementId)).setAttribute("href",e.getAttribute("src")):!1===(e=function(){for(var e=p.getElementsByTagName("head")[0].getElementsByTagName("link"),t=e.length-1;t>=0;t--)if(/(^|\s)icon(\s|$)/i.test(e[t].getAttribute("rel")))return e[t];return!1}())&&((e=p.createElement("link")).setAttribute("rel","icon"),p.getElementsByTagName("head")[0].appendChild(e)),e.setAttribute("type","image/png"),e},setIcon:function(e){var t=e.toDataURL("image/png");if(r.dataUrl&&r.dataUrl(t),r.element)r.element.setAttribute("href",t),r.element.setAttribute("src",t);else if(r.elementId){var o=p.getElementById(r.elementId);o.setAttribute("href",t),o.setAttribute("src",t)}else if(g.ff||g.opera){var n=i;i=p.createElement("link"),g.opera&&i.setAttribute("rel","icon"),i.setAttribute("rel","icon"),i.setAttribute("type","image/png"),p.getElementsByTagName("head")[0].appendChild(i),i.setAttribute("href",t),n.parentNode&&n.parentNode.removeChild(n)}else i.setAttribute("href",t)}},I={duration:40,types:{}};return I.types.fade=[{x:.4,y:.4,w:.6,h:.6,o:0},{x:.4,y:.4,w:.6,h:.6,o:.1},{x:.4,y:.4,w:.6,h:.6,o:.2},{x:.4,y:.4,w:.6,h:.6,o:.3},{x:.4,y:.4,w:.6,h:.6,o:.4},{x:.4,y:.4,w:.6,h:.6,o:.5},{x:.4,y:.4,w:.6,h:.6,o:.6},{x:.4,y:.4,w:.6,h:.6,o:.7},{x:.4,y:.4,w:.6,h:.6,o:.8},{x:.4,y:.4,w:.6,h:.6,o:.9},{x:.4,y:.4,w:.6,h:.6,o:1}],I.types.none=[{x:.4,y:.4,w:.6,h:.6,o:1}],I.types.pop=[{x:1,y:1,w:0,h:0,o:1},{x:.9,y:.9,w:.1,h:.1,o:1},{x:.8,y:.8,w:.2,h:.2,o:1},{x:.7,y:.7,w:.3,h:.3,o:1},{x:.6,y:.6,w:.4,h:.4,o:1},{x:.5,y:.5,w:.5,h:.5,o:1},{x:.4,y:.4,w:.6,h:.6,o:1}],I.types.popFade=[{x:.75,y:.75,w:0,h:0,o:0},{x:.65,y:.65,w:.1,h:.1,o:.2},{x:.6,y:.6,w:.2,h:.2,o:.4},{x:.55,y:.55,w:.3,h:.3,o:.6},{x:.5,y:.5,w:.4,h:.4,o:.8},{x:.45,y:.45,w:.5,h:.5,o:.9},{x:.4,y:.4,w:.6,h:.6,o:1}],I.types.slide=[{x:.4,y:1,w:.6,h:.6,o:1},{x:.4,y:.9,w:.6,h:.6,o:1},{x:.4,y:.9,w:.6,h:.6,o:1},{x:.4,y:.8,w:.6,h:.6,o:1},{x:.4,y:.7,w:.6,h:.6,o:1},{x:.4,y:.6,w:.6,h:.6,o:1},{x:.4,y:.5,w:.6,h:.6,o:1},{x:.4,y:.4,w:.6,h:.6,o:1}],I.run=function(e,t,o,i){var a=I.types[p.hidden||p.msHidden||p.webkitHidden||p.mozHidden?"none":r.animation];return i=!0===o?void 0!==i?i:a.length-1:void 0!==i?i:0,t=t||function(){},i<a.length&&i>=0?(E[r.type](n(e,a[i])),x=setTimeout(function(){o?i-=1:i+=1,I.run(e,t,o,i)},I.duration),void A.setIcon(s)):void t()},function(){(r=n(b,e)).bgColor=o(r.bgColor),r.textColor=o(r.textColor),r.position=r.position.toLowerCase(),r.animation=I.types[""+r.animation]?r.animation:b.animation,p=r.win.document;var t=r.position.indexOf("up")>-1,c=r.position.indexOf("left")>-1;if(t||c)for(var d=0;d<I.types[""+r.animation].length;d++){var u=I.types[""+r.animation][d];t&&(u.y=u.y<.6?u.y-.4:u.y-2*u.y+(1-u.w)),c&&(u.x=u.x<.6?u.x-.4:u.x-2*u.x+(1-u.h)),I.types[""+r.animation][d]=u}r.type=E[""+r.type]?r.type:b.type,i=A.getIcon(),s=document.createElement("canvas"),f=document.createElement("img"),i.hasAttribute("href")?(f.setAttribute("crossOrigin","anonymous"),f.onload=function(){a=f.height>0?f.height:32,l=f.width>0?f.width:32,s.height=a,s.width=l,h=s.getContext("2d"),C.ready()},f.setAttribute("src",i.getAttribute("href"))):(f.onload=function(){a=32,l=32,f.height=a,f.width=l,s.height=a,s.width=l,h=s.getContext("2d"),C.ready()},f.setAttribute("src",""))}(),{badge:function(e,t){t=("string"==typeof t?{animation:t}:t)||{},y=function(){try{if("number"==typeof e?e>0:""!==e){var n={type:"badge",options:{n:e}};if("animation"in t&&I.types[""+t.animation]&&(n.options.animation=""+t.animation),"type"in t&&E[""+t.type]&&(n.options.type=""+t.type),["bgColor","textColor"].forEach(function(e){e in t&&(n.options[e]=o(t[e]))}),["fontStyle","fontFamily"].forEach(function(e){e in t&&(n.options[e]=t[e])}),v.push(n),v.length>100)throw new Error("Too many badges requests in queue.");C.start()}else C.reset()}catch(e){throw new Error("Error setting badge. Message: "+e.message)}},c&&y()},video:function(e){y=function(){try{if("stop"===e)return w=!0,C.reset(),void(w=!1);e.addEventListener("play",function(){t(this)},!1)}catch(e){throw new Error("Error setting video. Message: "+e.message)}},c&&y()},image:function(e){y=function(){try{var t=e.width,o=e.height,n=document.createElement("img"),r=o/a>t/l?t/l:o/a;n.setAttribute("crossOrigin","anonymous"),n.onload=function(){h.clearRect(0,0,l,a),h.drawImage(n,0,0,l,a),A.setIcon(s)},n.setAttribute("src",e.getAttribute("src")),n.height=o/r,n.width=t/r}catch(e){throw new Error("Error setting image. Message: "+e.message)}},c&&y()},webcam:function(e){if(window.URL&&window.URL.createObjectURL||(window.URL=window.URL||{},window.URL.createObjectURL=function(e){return e}),g.supported){var o=!1;navigator.getUserMedia=navigator.getUserMedia||navigator.oGetUserMedia||navigator.msGetUserMedia||navigator.mozGetUserMedia||navigator.webkitGetUserMedia,y=function(){try{if("stop"===e)return w=!0,C.reset(),void(w=!1);(o=document.createElement("video")).width=l,o.height=a,navigator.getUserMedia({video:!0,audio:!1},function(e){o.src=URL.createObjectURL(e),o.play(),t(o)},function(){})}catch(e){throw new Error("Error setting webcam. Message: "+e.message)}},c&&y()}},reset:C.reset,browser:{supported:g.supported}}};"undefined"!=typeof define&&define.amd?define([],function(){return e}):"undefined"!=typeof module&&module.exports?module.exports=e:this.Favico=e}();
+\ No newline at end of file
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\kasimi\\faviconnotifications/styles/BBOOTS/template/js/faviconnotifications.bak.js" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\kasimi\\faviconnotifications/styles/BBOOTS/template/js/faviconnotifications.bak.js"
+new file mode 100644
+index 000000000..15165fc80
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\kasimi\\faviconnotifications/styles/BBOOTS/template/js/faviconnotifications.bak.js"
+@@ -0,0 +1,41 @@
++/**
++ *
++ * @package phpBB Extension - Favicon Notifications
++ * @copyright (c) 2016 kasimi
++ * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
++ *
++ */
++head.ready(function () {
++jQuery(function($) {
++	// Initialize favicon
++	var favicon = new Favico({
++		bgColor		: '#d00',
++		textColor	: '#fff',
++		fontFamily	: 'sans-serif',
++		fontStyle	: 'bold',
++		type		: 'circle',
++		position	: 'down',
++		animation	: 'popFade'
++	});
++
++	var setUnreadNotificationsCount = function(count) {
++		favicon.badge(count);
++	};
++
++	// Set initial notifications count
++	var unreadCount = parseInt($('em', '#notification_list_button').html());
++	setUnreadNotificationsCount(unreadCount);
++
++	// Update notifications count when marking notifications read
++	var phpbbMarkNotifications = phpbb.markNotifications;
++	phpbb.markNotifications = function($popup, unreadCount) {
++		setUnreadNotificationsCount(unreadCount);
++		return phpbbMarkNotifications($popup, unreadCount);
++	};
++
++	// Listen to notifications count updates from extensions
++	$(phpbb).on('kasimi_faviconnotifications_update', function(event, notificationsCount) {
++		setUnreadNotificationsCount(notificationsCount);
++	});
++});
++});
+\ No newline at end of file
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\kasimi\\faviconnotifications/styles/BBOOTS/template/js/faviconnotifications.js" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\kasimi\\faviconnotifications/styles/BBOOTS/template/js/faviconnotifications.js"
+new file mode 100644
+index 000000000..21f4d69dc
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\kasimi\\faviconnotifications/styles/BBOOTS/template/js/faviconnotifications.js"
+@@ -0,0 +1,8 @@
++/**
++ *
++ * @package phpBB Extension - Favicon Notifications
++ * @copyright (c) 2016 kasimi
++ * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
++ *
++ */
++head.ready(function(){jQuery(function(i){var n=new Favico({bgColor:"#d00",textColor:"#fff",fontFamily:"sans-serif",fontStyle:"bold",type:"circle",position:"down",animation:"popFade"}),o=function(i){n.badge(i)},t=parseInt(i("em","#notification_list_button").html());o(t);var a=phpbb.markNotifications;phpbb.markNotifications=function(i,n){return o(n),a(i,n)},i(phpbb).on("kasimi_faviconnotifications_update",function(i,n){o(n)})})});
+\ No newline at end of file
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\kasimi\\faviconnotifications/styles/FLATBOOTS/template/event/overall_header_head_append.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\kasimi\\faviconnotifications/styles/FLATBOOTS/template/event/overall_header_head_append.html"
+new file mode 100644
+index 000000000..7c674b05d
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\kasimi\\faviconnotifications/styles/FLATBOOTS/template/event/overall_header_head_append.html"
+@@ -0,0 +1,4 @@
++<!-- IF S_USER_LOGGED_IN and not S_IS_BOT -->
++	<!-- INCLUDEJS js/favico-0.3.10.min.js -->
++	<!-- INCLUDEJS js/faviconnotifications.js -->
++<!-- ENDIF -->
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\kasimi\\faviconnotifications/styles/FLATBOOTS/template/js/favico-0.3.10.min.bak.js" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\kasimi\\faviconnotifications/styles/FLATBOOTS/template/js/favico-0.3.10.min.bak.js"
+new file mode 100644
+index 000000000..cd411658b
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\kasimi\\faviconnotifications/styles/FLATBOOTS/template/js/favico-0.3.10.min.bak.js"
+@@ -0,0 +1,7 @@
++/**
++ * @license MIT
++ * @fileOverview Favico animations
++ * @author Miroslav Magda, http://blog.ejci.net
++ * @version 0.3.10
++ */
++!function(){var e=function(e){"use strict";function t(e){if(e.paused||e.ended||g)return!1;try{f.clearRect(0,0,s,l),f.drawImage(e,0,0,s,l)}catch(o){}p=setTimeout(function(){t(e)},S.duration),O.setIcon(h)}function o(e){var t=/^#?([a-f\d])([a-f\d])([a-f\d])$/i;e=e.replace(t,function(e,t,o,n){return t+t+o+o+n+n});var o=/^#?([a-f\d]{2})([a-f\d]{2})([a-f\d]{2})$/i.exec(e);return o?{r:parseInt(o[1],16),g:parseInt(o[2],16),b:parseInt(o[3],16)}:!1}function n(e,t){var o,n={};for(o in e)n[o]=e[o];for(o in t)n[o]=t[o];return n}function r(){return b.hidden||b.msHidden||b.webkitHidden||b.mozHidden}e=e?e:{};var i,a,l,s,h,f,c,d,u,y,w,g,x,m,p,b,v={bgColor:"#d00",textColor:"#fff",fontFamily:"sans-serif",fontStyle:"bold",type:"circle",position:"down",animation:"slide",elementId:!1,dataUrl:!1,win:window};x={},x.ff="undefined"!=typeof InstallTrigger,x.chrome=!!window.chrome,x.opera=!!window.opera||navigator.userAgent.indexOf("Opera")>=0,x.ie=/*@cc_on!@*/!1,x.safari=Object.prototype.toString.call(window.HTMLElement).indexOf("Constructor")>0,x.supported=x.chrome||x.ff||x.opera;var C=[];w=function(){},d=g=!1;var E=function(){i=n(v,e),i.bgColor=o(i.bgColor),i.textColor=o(i.textColor),i.position=i.position.toLowerCase(),i.animation=S.types[""+i.animation]?i.animation:v.animation,b=i.win.document;var t=i.position.indexOf("up")>-1,r=i.position.indexOf("left")>-1;if(t||r)for(var d=0;d<S.types[""+i.animation].length;d++){var u=S.types[""+i.animation][d];t&&(u.y=u.y<.6?u.y-.4:u.y-2*u.y+(1-u.w)),r&&(u.x=u.x<.6?u.x-.4:u.x-2*u.x+(1-u.h)),S.types[""+i.animation][d]=u}i.type=A[""+i.type]?i.type:v.type,a=O.getIcon(),h=document.createElement("canvas"),c=document.createElement("img"),a.hasAttribute("href")?(c.setAttribute("crossOrigin","anonymous"),c.onload=function(){l=c.height>0?c.height:32,s=c.width>0?c.width:32,h.height=l,h.width=s,f=h.getContext("2d"),M.ready()},c.setAttribute("src",a.getAttribute("href"))):(c.onload=function(){l=32,s=32,c.height=l,c.width=s,h.height=l,h.width=s,f=h.getContext("2d"),M.ready()},c.setAttribute("src",""))},M={};M.ready=function(){d=!0,M.reset(),w()},M.reset=function(){d&&(C=[],u=!1,y=!1,f.clearRect(0,0,s,l),f.drawImage(c,0,0,s,l),O.setIcon(h),window.clearTimeout(m),window.clearTimeout(p))},M.start=function(){if(d&&!y){var e=function(){u=C[0],y=!1,C.length>0&&(C.shift(),M.start())};if(C.length>0){y=!0;var t=function(){["type","animation","bgColor","textColor","fontFamily","fontStyle"].forEach(function(e){e in C[0].options&&(i[e]=C[0].options[e])}),S.run(C[0].options,function(){e()},!1)};u?S.run(u.options,function(){t()},!0):t()}}};var A={},I=function(e){return e.n="number"==typeof e.n?Math.abs(0|e.n):e.n,e.x=s*e.x,e.y=l*e.y,e.w=s*e.w,e.h=l*e.h,e.len=(""+e.n).length,e};A.circle=function(e){e=I(e);var t=!1;2===e.len?(e.x=e.x-.4*e.w,e.w=1.4*e.w,t=!0):e.len>=3&&(e.x=e.x-.65*e.w,e.w=1.65*e.w,t=!0),f.clearRect(0,0,s,l),f.drawImage(c,0,0,s,l),f.beginPath(),f.font=i.fontStyle+" "+Math.floor(e.h*(e.n>99?.85:1))+"px "+i.fontFamily,f.textAlign="center",t?(f.moveTo(e.x+e.w/2,e.y),f.lineTo(e.x+e.w-e.h/2,e.y),f.quadraticCurveTo(e.x+e.w,e.y,e.x+e.w,e.y+e.h/2),f.lineTo(e.x+e.w,e.y+e.h-e.h/2),f.quadraticCurveTo(e.x+e.w,e.y+e.h,e.x+e.w-e.h/2,e.y+e.h),f.lineTo(e.x+e.h/2,e.y+e.h),f.quadraticCurveTo(e.x,e.y+e.h,e.x,e.y+e.h-e.h/2),f.lineTo(e.x,e.y+e.h/2),f.quadraticCurveTo(e.x,e.y,e.x+e.h/2,e.y)):f.arc(e.x+e.w/2,e.y+e.h/2,e.h/2,0,2*Math.PI),f.fillStyle="rgba("+i.bgColor.r+","+i.bgColor.g+","+i.bgColor.b+","+e.o+")",f.fill(),f.closePath(),f.beginPath(),f.stroke(),f.fillStyle="rgba("+i.textColor.r+","+i.textColor.g+","+i.textColor.b+","+e.o+")","number"==typeof e.n&&e.n>999?f.fillText((e.n>9999?9:Math.floor(e.n/1e3))+"k+",Math.floor(e.x+e.w/2),Math.floor(e.y+e.h-.2*e.h)):f.fillText(e.n,Math.floor(e.x+e.w/2),Math.floor(e.y+e.h-.15*e.h)),f.closePath()},A.rectangle=function(e){e=I(e);var t=!1;2===e.len?(e.x=e.x-.4*e.w,e.w=1.4*e.w,t=!0):e.len>=3&&(e.x=e.x-.65*e.w,e.w=1.65*e.w,t=!0),f.clearRect(0,0,s,l),f.drawImage(c,0,0,s,l),f.beginPath(),f.font=i.fontStyle+" "+Math.floor(e.h*(e.n>99?.9:1))+"px "+i.fontFamily,f.textAlign="center",f.fillStyle="rgba("+i.bgColor.r+","+i.bgColor.g+","+i.bgColor.b+","+e.o+")",f.fillRect(e.x,e.y,e.w,e.h),f.fillStyle="rgba("+i.textColor.r+","+i.textColor.g+","+i.textColor.b+","+e.o+")","number"==typeof e.n&&e.n>999?f.fillText((e.n>9999?9:Math.floor(e.n/1e3))+"k+",Math.floor(e.x+e.w/2),Math.floor(e.y+e.h-.2*e.h)):f.fillText(e.n,Math.floor(e.x+e.w/2),Math.floor(e.y+e.h-.15*e.h)),f.closePath()};var T=function(e,t){t=("string"==typeof t?{animation:t}:t)||{},w=function(){try{if("number"==typeof e?e>0:""!==e){var n={type:"badge",options:{n:e}};if("animation"in t&&S.types[""+t.animation]&&(n.options.animation=""+t.animation),"type"in t&&A[""+t.type]&&(n.options.type=""+t.type),["bgColor","textColor"].forEach(function(e){e in t&&(n.options[e]=o(t[e]))}),["fontStyle","fontFamily"].forEach(function(e){e in t&&(n.options[e]=t[e])}),C.push(n),C.length>100)throw new Error("Too many badges requests in queue.");M.start()}else M.reset()}catch(r){throw new Error("Error setting badge. Message: "+r.message)}},d&&w()},U=function(e){w=function(){try{var t=e.width,o=e.height,n=document.createElement("img"),r=o/l>t/s?t/s:o/l;n.setAttribute("crossOrigin","anonymous"),n.onload=function(){f.clearRect(0,0,s,l),f.drawImage(n,0,0,s,l),O.setIcon(h)},n.setAttribute("src",e.getAttribute("src")),n.height=o/r,n.width=t/r}catch(i){throw new Error("Error setting image. Message: "+i.message)}},d&&w()},R=function(e){w=function(){try{if("stop"===e)return g=!0,M.reset(),void(g=!1);e.addEventListener("play",function(){t(this)},!1)}catch(o){throw new Error("Error setting video. Message: "+o.message)}},d&&w()},L=function(e){if(window.URL&&window.URL.createObjectURL||(window.URL=window.URL||{},window.URL.createObjectURL=function(e){return e}),x.supported){var o=!1;navigator.getUserMedia=navigator.getUserMedia||navigator.oGetUserMedia||navigator.msGetUserMedia||navigator.mozGetUserMedia||navigator.webkitGetUserMedia,w=function(){try{if("stop"===e)return g=!0,M.reset(),void(g=!1);o=document.createElement("video"),o.width=s,o.height=l,navigator.getUserMedia({video:!0,audio:!1},function(e){o.src=URL.createObjectURL(e),o.play(),t(o)},function(){})}catch(n){throw new Error("Error setting webcam. Message: "+n.message)}},d&&w()}},O={};O.getIcon=function(){var e=!1,t=function(){for(var e=b.getElementsByTagName("head")[0].getElementsByTagName("link"),t=e.length,o=t-1;o>=0;o--)if(/(^|\s)icon(\s|$)/i.test(e[o].getAttribute("rel")))return e[o];return!1};return i.element?e=i.element:i.elementId?(e=b.getElementById(i.elementId),e.setAttribute("href",e.getAttribute("src"))):(e=t(),e===!1&&(e=b.createElement("link"),e.setAttribute("rel","icon"),b.getElementsByTagName("head")[0].appendChild(e))),e.setAttribute("type","image/png"),e},O.setIcon=function(e){var t=e.toDataURL("image/png");if(i.dataUrl&&i.dataUrl(t),i.element)i.element.setAttribute("href",t),i.element.setAttribute("src",t);else if(i.elementId){var o=b.getElementById(i.elementId);o.setAttribute("href",t),o.setAttribute("src",t)}else if(x.ff||x.opera){var n=a;a=b.createElement("link"),x.opera&&a.setAttribute("rel","icon"),a.setAttribute("rel","icon"),a.setAttribute("type","image/png"),b.getElementsByTagName("head")[0].appendChild(a),a.setAttribute("href",t),n.parentNode&&n.parentNode.removeChild(n)}else a.setAttribute("href",t)};var S={};return S.duration=40,S.types={},S.types.fade=[{x:.4,y:.4,w:.6,h:.6,o:0},{x:.4,y:.4,w:.6,h:.6,o:.1},{x:.4,y:.4,w:.6,h:.6,o:.2},{x:.4,y:.4,w:.6,h:.6,o:.3},{x:.4,y:.4,w:.6,h:.6,o:.4},{x:.4,y:.4,w:.6,h:.6,o:.5},{x:.4,y:.4,w:.6,h:.6,o:.6},{x:.4,y:.4,w:.6,h:.6,o:.7},{x:.4,y:.4,w:.6,h:.6,o:.8},{x:.4,y:.4,w:.6,h:.6,o:.9},{x:.4,y:.4,w:.6,h:.6,o:1}],S.types.none=[{x:.4,y:.4,w:.6,h:.6,o:1}],S.types.pop=[{x:1,y:1,w:0,h:0,o:1},{x:.9,y:.9,w:.1,h:.1,o:1},{x:.8,y:.8,w:.2,h:.2,o:1},{x:.7,y:.7,w:.3,h:.3,o:1},{x:.6,y:.6,w:.4,h:.4,o:1},{x:.5,y:.5,w:.5,h:.5,o:1},{x:.4,y:.4,w:.6,h:.6,o:1}],S.types.popFade=[{x:.75,y:.75,w:0,h:0,o:0},{x:.65,y:.65,w:.1,h:.1,o:.2},{x:.6,y:.6,w:.2,h:.2,o:.4},{x:.55,y:.55,w:.3,h:.3,o:.6},{x:.5,y:.5,w:.4,h:.4,o:.8},{x:.45,y:.45,w:.5,h:.5,o:.9},{x:.4,y:.4,w:.6,h:.6,o:1}],S.types.slide=[{x:.4,y:1,w:.6,h:.6,o:1},{x:.4,y:.9,w:.6,h:.6,o:1},{x:.4,y:.9,w:.6,h:.6,o:1},{x:.4,y:.8,w:.6,h:.6,o:1},{x:.4,y:.7,w:.6,h:.6,o:1},{x:.4,y:.6,w:.6,h:.6,o:1},{x:.4,y:.5,w:.6,h:.6,o:1},{x:.4,y:.4,w:.6,h:.6,o:1}],S.run=function(e,t,o,a){var l=S.types[r()?"none":i.animation];return a=o===!0?"undefined"!=typeof a?a:l.length-1:"undefined"!=typeof a?a:0,t=t?t:function(){},a<l.length&&a>=0?(A[i.type](n(e,l[a])),m=setTimeout(function(){o?a-=1:a+=1,S.run(e,t,o,a)},S.duration),O.setIcon(h),void 0):void t()},E(),{badge:T,video:R,image:U,webcam:L,reset:M.reset,browser:{supported:x.supported}}};"undefined"!=typeof define&&define.amd?define([],function(){return e}):"undefined"!=typeof module&&module.exports?module.exports=e:this.Favico=e}();
+\ No newline at end of file
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\kasimi\\faviconnotifications/styles/FLATBOOTS/template/js/favico-0.3.10.min.js" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\kasimi\\faviconnotifications/styles/FLATBOOTS/template/js/favico-0.3.10.min.js"
+new file mode 100644
+index 000000000..66ccf4740
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\kasimi\\faviconnotifications/styles/FLATBOOTS/template/js/favico-0.3.10.min.js"
+@@ -0,0 +1,7 @@
++/**
++ * @license MIT
++ * @fileOverview Favico animations
++ * @author Miroslav Magda, http://blog.ejci.net
++ * @version 0.3.10
++ */
++!function(){var e=function(e){"use strict";function t(e){if(e.paused||e.ended||w)return!1;try{h.clearRect(0,0,l,a),h.drawImage(e,0,0,l,a)}catch(e){}m=setTimeout(function(){t(e)},I.duration),A.setIcon(s)}function o(e){e=e.replace(/^#?([a-f\d])([a-f\d])([a-f\d])$/i,function(e,t,o,n){return t+t+o+o+n+n});var t=/^#?([a-f\d]{2})([a-f\d]{2})([a-f\d]{2})$/i.exec(e);return!!t&&{r:parseInt(t[1],16),g:parseInt(t[2],16),b:parseInt(t[3],16)}}function n(e,t){var o,n={};for(o in e)n[o]=e[o];for(o in t)n[o]=t[o];return n}e=e||{};var r,i,a,l,s,h,f,c,d,u,y,w,g,x,m,p,b={bgColor:"#d00",textColor:"#fff",fontFamily:"sans-serif",fontStyle:"bold",type:"circle",position:"down",animation:"slide",elementId:!1,dataUrl:!1,win:window};(g={}).ff="undefined"!=typeof InstallTrigger,g.chrome=!!window.chrome,g.opera=!!window.opera||navigator.userAgent.indexOf("Opera")>=0,g.ie=!1,g.safari=Object.prototype.toString.call(window.HTMLElement).indexOf("Constructor")>0,g.supported=g.chrome||g.ff||g.opera;var v=[];y=function(){},c=w=!1;var C={ready:function(){c=!0,C.reset(),y()},reset:function(){c&&(v=[],d=!1,u=!1,h.clearRect(0,0,l,a),h.drawImage(f,0,0,l,a),A.setIcon(s),window.clearTimeout(x),window.clearTimeout(m))}};C.start=function(){if(c&&!u){if(v.length>0){u=!0;var e=function(){["type","animation","bgColor","textColor","fontFamily","fontStyle"].forEach(function(e){e in v[0].options&&(r[e]=v[0].options[e])}),I.run(v[0].options,function(){d=v[0],u=!1,v.length>0&&(v.shift(),C.start())},!1)};d?I.run(d.options,function(){e()},!0):e()}}};var E={},M=function(e){return e.n="number"==typeof e.n?Math.abs(0|e.n):e.n,e.x=l*e.x,e.y=a*e.y,e.w=l*e.w,e.h=a*e.h,e.len=(""+e.n).length,e};E.circle=function(e){var t=!1;2===(e=M(e)).len?(e.x=e.x-.4*e.w,e.w=1.4*e.w,t=!0):e.len>=3&&(e.x=e.x-.65*e.w,e.w=1.65*e.w,t=!0),h.clearRect(0,0,l,a),h.drawImage(f,0,0,l,a),h.beginPath(),h.font=r.fontStyle+" "+Math.floor(e.h*(e.n>99?.85:1))+"px "+r.fontFamily,h.textAlign="center",t?(h.moveTo(e.x+e.w/2,e.y),h.lineTo(e.x+e.w-e.h/2,e.y),h.quadraticCurveTo(e.x+e.w,e.y,e.x+e.w,e.y+e.h/2),h.lineTo(e.x+e.w,e.y+e.h-e.h/2),h.quadraticCurveTo(e.x+e.w,e.y+e.h,e.x+e.w-e.h/2,e.y+e.h),h.lineTo(e.x+e.h/2,e.y+e.h),h.quadraticCurveTo(e.x,e.y+e.h,e.x,e.y+e.h-e.h/2),h.lineTo(e.x,e.y+e.h/2),h.quadraticCurveTo(e.x,e.y,e.x+e.h/2,e.y)):h.arc(e.x+e.w/2,e.y+e.h/2,e.h/2,0,2*Math.PI),h.fillStyle="rgba("+r.bgColor.r+","+r.bgColor.g+","+r.bgColor.b+","+e.o+")",h.fill(),h.closePath(),h.beginPath(),h.stroke(),h.fillStyle="rgba("+r.textColor.r+","+r.textColor.g+","+r.textColor.b+","+e.o+")","number"==typeof e.n&&e.n>999?h.fillText((e.n>9999?9:Math.floor(e.n/1e3))+"k+",Math.floor(e.x+e.w/2),Math.floor(e.y+e.h-.2*e.h)):h.fillText(e.n,Math.floor(e.x+e.w/2),Math.floor(e.y+e.h-.15*e.h)),h.closePath()},E.rectangle=function(e){2===(e=M(e)).len?(e.x=e.x-.4*e.w,e.w=1.4*e.w):e.len>=3&&(e.x=e.x-.65*e.w,e.w=1.65*e.w),h.clearRect(0,0,l,a),h.drawImage(f,0,0,l,a),h.beginPath(),h.font=r.fontStyle+" "+Math.floor(e.h*(e.n>99?.9:1))+"px "+r.fontFamily,h.textAlign="center",h.fillStyle="rgba("+r.bgColor.r+","+r.bgColor.g+","+r.bgColor.b+","+e.o+")",h.fillRect(e.x,e.y,e.w,e.h),h.fillStyle="rgba("+r.textColor.r+","+r.textColor.g+","+r.textColor.b+","+e.o+")","number"==typeof e.n&&e.n>999?h.fillText((e.n>9999?9:Math.floor(e.n/1e3))+"k+",Math.floor(e.x+e.w/2),Math.floor(e.y+e.h-.2*e.h)):h.fillText(e.n,Math.floor(e.x+e.w/2),Math.floor(e.y+e.h-.15*e.h)),h.closePath()};var A={getIcon:function(){var e=!1;return r.element?e=r.element:r.elementId?(e=p.getElementById(r.elementId)).setAttribute("href",e.getAttribute("src")):!1===(e=function(){for(var e=p.getElementsByTagName("head")[0].getElementsByTagName("link"),t=e.length-1;t>=0;t--)if(/(^|\s)icon(\s|$)/i.test(e[t].getAttribute("rel")))return e[t];return!1}())&&((e=p.createElement("link")).setAttribute("rel","icon"),p.getElementsByTagName("head")[0].appendChild(e)),e.setAttribute("type","image/png"),e},setIcon:function(e){var t=e.toDataURL("image/png");if(r.dataUrl&&r.dataUrl(t),r.element)r.element.setAttribute("href",t),r.element.setAttribute("src",t);else if(r.elementId){var o=p.getElementById(r.elementId);o.setAttribute("href",t),o.setAttribute("src",t)}else if(g.ff||g.opera){var n=i;i=p.createElement("link"),g.opera&&i.setAttribute("rel","icon"),i.setAttribute("rel","icon"),i.setAttribute("type","image/png"),p.getElementsByTagName("head")[0].appendChild(i),i.setAttribute("href",t),n.parentNode&&n.parentNode.removeChild(n)}else i.setAttribute("href",t)}},I={duration:40,types:{}};return I.types.fade=[{x:.4,y:.4,w:.6,h:.6,o:0},{x:.4,y:.4,w:.6,h:.6,o:.1},{x:.4,y:.4,w:.6,h:.6,o:.2},{x:.4,y:.4,w:.6,h:.6,o:.3},{x:.4,y:.4,w:.6,h:.6,o:.4},{x:.4,y:.4,w:.6,h:.6,o:.5},{x:.4,y:.4,w:.6,h:.6,o:.6},{x:.4,y:.4,w:.6,h:.6,o:.7},{x:.4,y:.4,w:.6,h:.6,o:.8},{x:.4,y:.4,w:.6,h:.6,o:.9},{x:.4,y:.4,w:.6,h:.6,o:1}],I.types.none=[{x:.4,y:.4,w:.6,h:.6,o:1}],I.types.pop=[{x:1,y:1,w:0,h:0,o:1},{x:.9,y:.9,w:.1,h:.1,o:1},{x:.8,y:.8,w:.2,h:.2,o:1},{x:.7,y:.7,w:.3,h:.3,o:1},{x:.6,y:.6,w:.4,h:.4,o:1},{x:.5,y:.5,w:.5,h:.5,o:1},{x:.4,y:.4,w:.6,h:.6,o:1}],I.types.popFade=[{x:.75,y:.75,w:0,h:0,o:0},{x:.65,y:.65,w:.1,h:.1,o:.2},{x:.6,y:.6,w:.2,h:.2,o:.4},{x:.55,y:.55,w:.3,h:.3,o:.6},{x:.5,y:.5,w:.4,h:.4,o:.8},{x:.45,y:.45,w:.5,h:.5,o:.9},{x:.4,y:.4,w:.6,h:.6,o:1}],I.types.slide=[{x:.4,y:1,w:.6,h:.6,o:1},{x:.4,y:.9,w:.6,h:.6,o:1},{x:.4,y:.9,w:.6,h:.6,o:1},{x:.4,y:.8,w:.6,h:.6,o:1},{x:.4,y:.7,w:.6,h:.6,o:1},{x:.4,y:.6,w:.6,h:.6,o:1},{x:.4,y:.5,w:.6,h:.6,o:1},{x:.4,y:.4,w:.6,h:.6,o:1}],I.run=function(e,t,o,i){var a=I.types[p.hidden||p.msHidden||p.webkitHidden||p.mozHidden?"none":r.animation];return i=!0===o?void 0!==i?i:a.length-1:void 0!==i?i:0,t=t||function(){},i<a.length&&i>=0?(E[r.type](n(e,a[i])),x=setTimeout(function(){o?i-=1:i+=1,I.run(e,t,o,i)},I.duration),void A.setIcon(s)):void t()},function(){(r=n(b,e)).bgColor=o(r.bgColor),r.textColor=o(r.textColor),r.position=r.position.toLowerCase(),r.animation=I.types[""+r.animation]?r.animation:b.animation,p=r.win.document;var t=r.position.indexOf("up")>-1,c=r.position.indexOf("left")>-1;if(t||c)for(var d=0;d<I.types[""+r.animation].length;d++){var u=I.types[""+r.animation][d];t&&(u.y=u.y<.6?u.y-.4:u.y-2*u.y+(1-u.w)),c&&(u.x=u.x<.6?u.x-.4:u.x-2*u.x+(1-u.h)),I.types[""+r.animation][d]=u}r.type=E[""+r.type]?r.type:b.type,i=A.getIcon(),s=document.createElement("canvas"),f=document.createElement("img"),i.hasAttribute("href")?(f.setAttribute("crossOrigin","anonymous"),f.onload=function(){a=f.height>0?f.height:32,l=f.width>0?f.width:32,s.height=a,s.width=l,h=s.getContext("2d"),C.ready()},f.setAttribute("src",i.getAttribute("href"))):(f.onload=function(){a=32,l=32,f.height=a,f.width=l,s.height=a,s.width=l,h=s.getContext("2d"),C.ready()},f.setAttribute("src",""))}(),{badge:function(e,t){t=("string"==typeof t?{animation:t}:t)||{},y=function(){try{if("number"==typeof e?e>0:""!==e){var n={type:"badge",options:{n:e}};if("animation"in t&&I.types[""+t.animation]&&(n.options.animation=""+t.animation),"type"in t&&E[""+t.type]&&(n.options.type=""+t.type),["bgColor","textColor"].forEach(function(e){e in t&&(n.options[e]=o(t[e]))}),["fontStyle","fontFamily"].forEach(function(e){e in t&&(n.options[e]=t[e])}),v.push(n),v.length>100)throw new Error("Too many badges requests in queue.");C.start()}else C.reset()}catch(e){throw new Error("Error setting badge. Message: "+e.message)}},c&&y()},video:function(e){y=function(){try{if("stop"===e)return w=!0,C.reset(),void(w=!1);e.addEventListener("play",function(){t(this)},!1)}catch(e){throw new Error("Error setting video. Message: "+e.message)}},c&&y()},image:function(e){y=function(){try{var t=e.width,o=e.height,n=document.createElement("img"),r=o/a>t/l?t/l:o/a;n.setAttribute("crossOrigin","anonymous"),n.onload=function(){h.clearRect(0,0,l,a),h.drawImage(n,0,0,l,a),A.setIcon(s)},n.setAttribute("src",e.getAttribute("src")),n.height=o/r,n.width=t/r}catch(e){throw new Error("Error setting image. Message: "+e.message)}},c&&y()},webcam:function(e){if(window.URL&&window.URL.createObjectURL||(window.URL=window.URL||{},window.URL.createObjectURL=function(e){return e}),g.supported){var o=!1;navigator.getUserMedia=navigator.getUserMedia||navigator.oGetUserMedia||navigator.msGetUserMedia||navigator.mozGetUserMedia||navigator.webkitGetUserMedia,y=function(){try{if("stop"===e)return w=!0,C.reset(),void(w=!1);(o=document.createElement("video")).width=l,o.height=a,navigator.getUserMedia({video:!0,audio:!1},function(e){o.src=URL.createObjectURL(e),o.play(),t(o)},function(){})}catch(e){throw new Error("Error setting webcam. Message: "+e.message)}},c&&y()}},reset:C.reset,browser:{supported:g.supported}}};"undefined"!=typeof define&&define.amd?define([],function(){return e}):"undefined"!=typeof module&&module.exports?module.exports=e:this.Favico=e}();
+\ No newline at end of file
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\kasimi\\faviconnotifications/styles/FLATBOOTS/template/js/faviconnotifications.bak.js" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\kasimi\\faviconnotifications/styles/FLATBOOTS/template/js/faviconnotifications.bak.js"
+new file mode 100644
+index 000000000..15165fc80
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\kasimi\\faviconnotifications/styles/FLATBOOTS/template/js/faviconnotifications.bak.js"
+@@ -0,0 +1,41 @@
++/**
++ *
++ * @package phpBB Extension - Favicon Notifications
++ * @copyright (c) 2016 kasimi
++ * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
++ *
++ */
++head.ready(function () {
++jQuery(function($) {
++	// Initialize favicon
++	var favicon = new Favico({
++		bgColor		: '#d00',
++		textColor	: '#fff',
++		fontFamily	: 'sans-serif',
++		fontStyle	: 'bold',
++		type		: 'circle',
++		position	: 'down',
++		animation	: 'popFade'
++	});
++
++	var setUnreadNotificationsCount = function(count) {
++		favicon.badge(count);
++	};
++
++	// Set initial notifications count
++	var unreadCount = parseInt($('em', '#notification_list_button').html());
++	setUnreadNotificationsCount(unreadCount);
++
++	// Update notifications count when marking notifications read
++	var phpbbMarkNotifications = phpbb.markNotifications;
++	phpbb.markNotifications = function($popup, unreadCount) {
++		setUnreadNotificationsCount(unreadCount);
++		return phpbbMarkNotifications($popup, unreadCount);
++	};
++
++	// Listen to notifications count updates from extensions
++	$(phpbb).on('kasimi_faviconnotifications_update', function(event, notificationsCount) {
++		setUnreadNotificationsCount(notificationsCount);
++	});
++});
++});
+\ No newline at end of file
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\kasimi\\faviconnotifications/styles/FLATBOOTS/template/js/faviconnotifications.js" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\kasimi\\faviconnotifications/styles/FLATBOOTS/template/js/faviconnotifications.js"
+new file mode 100644
+index 000000000..21f4d69dc
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\kasimi\\faviconnotifications/styles/FLATBOOTS/template/js/faviconnotifications.js"
+@@ -0,0 +1,8 @@
++/**
++ *
++ * @package phpBB Extension - Favicon Notifications
++ * @copyright (c) 2016 kasimi
++ * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
++ *
++ */
++head.ready(function(){jQuery(function(i){var n=new Favico({bgColor:"#d00",textColor:"#fff",fontFamily:"sans-serif",fontStyle:"bold",type:"circle",position:"down",animation:"popFade"}),o=function(i){n.badge(i)},t=parseInt(i("em","#notification_list_button").html());o(t);var a=phpbb.markNotifications;phpbb.markNotifications=function(i,n){return o(n),a(i,n)},i(phpbb).on("kasimi_faviconnotifications_update",function(i,n){o(n)})})});
+\ No newline at end of file
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\kasimi\\faviconnotifications/styles/all/template/event/overall_header_head_append.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\kasimi\\faviconnotifications/styles/all/template/event/overall_header_head_append.html"
+index c13078643..7c674b05d 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\kasimi\\faviconnotifications/styles/all/template/event/overall_header_head_append.html"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\kasimi\\faviconnotifications/styles/all/template/event/overall_header_head_append.html"
+@@ -1,4 +1,4 @@
+-{% if S_USER_LOGGED_IN and not S_IS_BOT %}
+-	{% INCLUDEJS 'js/favico-0.3.10.dev.js' %}
+-	{% INCLUDEJS 'js/faviconnotifications.js' %}
+-{% endif %}
++<!-- IF S_USER_LOGGED_IN and not S_IS_BOT -->
++	<!-- INCLUDEJS js/favico-0.3.10.min.js -->
++	<!-- INCLUDEJS js/faviconnotifications.js -->
++<!-- ENDIF -->
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\kasimi\\faviconnotifications/styles/all/template/js/favico-0.3.10.dev.js" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\kasimi\\faviconnotifications/styles/all/template/js/favico-0.3.10.dev.js"
+deleted file mode 100644
+index 2a501e539..000000000
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\kasimi\\faviconnotifications/styles/all/template/js/favico-0.3.10.dev.js"
++++ /dev/null
+@@ -1,905 +0,0 @@
+-/**
+- * @license MIT or GPL-2.0
+- * @fileOverview Favico animations
+- * @author Miroslav Magda, http://blog.ejci.net
+- * @source: https://github.com/ejci/favico.js
+- * @version 0.3.10
+- */
+-
+-/**
+- * Create new favico instance
+- * @param {Object} Options
+- * @return {Object} Favico object
+- * @example
+- * var favico = new Favico({
+- *    bgColor : '#d00',
+- *    textColor : '#fff',
+- *    fontFamily : 'sans-serif',
+- *    fontStyle : 'bold',
+- *    type : 'circle',
+- *    position : 'down',
+- *    animation : 'slide',
+- *    elementId: false,
+- *    element: null,
+- *    dataUrl: function(url){},
+- *    win: window
+- * });
+- */
+-(function () {
+-
+-	var Favico = (function (opt) {
+-		'use strict';
+-		opt = (opt) ? opt : {};
+-		var _def = {
+-			bgColor: '#d00',
+-			textColor: '#fff',
+-			fontFamily: 'sans-serif', //Arial,Verdana,Times New Roman,serif,sans-serif,...
+-			fontStyle: 'bold', //normal,italic,oblique,bold,bolder,lighter,100,200,300,400,500,600,700,800,900
+-			type: 'circle',
+-			position: 'down', // down, up, left, leftup (upleft)
+-			animation: 'slide',
+-			elementId: false,
+-			element: null,
+-			dataUrl: false,
+-			win: window
+-		};
+-		var _opt, _orig, _h, _w, _canvas, _context, _img, _ready, _lastBadge, _running, _readyCb, _stop, _browser, _animTimeout, _drawTimeout, _doc;
+-
+-		_browser = {};
+-		_browser.ff = typeof InstallTrigger != 'undefined';
+-		_browser.chrome = !!window.chrome;
+-		_browser.opera = !!window.opera || navigator.userAgent.indexOf('Opera') >= 0;
+-		_browser.ie = /*@cc_on!@*/false;
+-		_browser.safari = Object.prototype.toString.call(window.HTMLElement).indexOf('Constructor') > 0;
+-		_browser.supported = (_browser.chrome || _browser.ff || _browser.opera);
+-
+-		var _queue = [];
+-		_readyCb = function () {
+-		};
+-		_ready = _stop = false;
+-		/**
+-		 * Initialize favico
+-		 */
+-		var init = function () {
+-			//merge initial options
+-			_opt = merge(_def, opt);
+-			_opt.bgColor = hexToRgb(_opt.bgColor);
+-			_opt.textColor = hexToRgb(_opt.textColor);
+-			_opt.position = _opt.position.toLowerCase();
+-			_opt.animation = (animation.types['' + _opt.animation]) ? _opt.animation : _def.animation;
+-
+-			_doc = _opt.win.document;
+-
+-			var isUp = _opt.position.indexOf('up') > -1;
+-			var isLeft = _opt.position.indexOf('left') > -1;
+-
+-			//transform the animations
+-			if (isUp || isLeft) {
+-				for (var a in animation.types) {
+-					for (var i = 0; i < animation.types[a].length; i++) {
+-						var step = animation.types[a][i];
+-
+-						if (isUp) {
+-							if (step.y < 0.6) {
+-								step.y = step.y - 0.4;
+-							} else {
+-								step.y = step.y - 2 * step.y + (1 - step.w);
+-							}
+-						}
+-
+-						if (isLeft) {
+-							if (step.x < 0.6) {
+-								step.x = step.x - 0.4;
+-							} else {
+-								step.x = step.x - 2 * step.x + (1 - step.h);
+-							}
+-						}
+-
+-						animation.types[a][i] = step;
+-					}
+-				}
+-			}
+-			_opt.type = (type['' + _opt.type]) ? _opt.type : _def.type;
+-
+-			_orig = link. getIcons();
+-			//create temp canvas
+-			_canvas = document.createElement('canvas');
+-			//create temp image
+-			_img = document.createElement('img');
+-			var lastIcon = _orig[_orig.length - 1];
+-			if (lastIcon.hasAttribute('href')) {
+-				_img.setAttribute('crossOrigin', 'anonymous');
+-				//get width/height
+-				_img.onload = function () {
+-					_h = (_img.height > 0) ? _img.height : 32;
+-					_w = (_img.width > 0) ? _img.width : 32;
+-					_canvas.height = _h;
+-					_canvas.width = _w;
+-					_context = _canvas.getContext('2d');
+-					icon.ready();
+-				};
+-				_img.setAttribute('src', lastIcon.getAttribute('href'));
+-			} else {
+-				_h = 32;
+-				_w = 32;
+-				_img.height = _h;
+-				_img.width = _w;
+-				_canvas.height = _h;
+-				_canvas.width = _w;
+-				_context = _canvas.getContext('2d');
+-				icon.ready();
+-			}
+-
+-		};
+-		/**
+-		 * Icon namespace
+-		 */
+-		var icon = {};
+-		/**
+-		 * Icon is ready (reset icon) and start animation (if ther is any)
+-		 */
+-		icon.ready = function () {
+-			_ready = true;
+-			icon.reset();
+-			_readyCb();
+-		};
+-		/**
+-		 * Reset icon to default state
+-		 */
+-		icon.reset = function () {
+-			//reset
+-			if (!_ready) {
+-				return;
+-			}
+-			_queue = [];
+-			_lastBadge = false;
+-			_running = false;
+-			_context.clearRect(0, 0, _w, _h);
+-			_context.drawImage(_img, 0, 0, _w, _h);
+-			//_stop=true;
+-			link.setIcon(_canvas);
+-			//webcam('stop');
+-			//video('stop');
+-			window.clearTimeout(_animTimeout);
+-			window.clearTimeout(_drawTimeout);
+-		};
+-		/**
+-		 * Start animation
+-		 */
+-		icon.start = function () {
+-			if (!_ready || _running) {
+-				return;
+-			}
+-			var finished = function () {
+-				_lastBadge = _queue[0];
+-				_running = false;
+-				if (_queue.length > 0) {
+-					_queue.shift();
+-					icon.start();
+-				} else {
+-
+-				}
+-			};
+-			if (_queue.length > 0) {
+-				_running = true;
+-				var run = function () {
+-					// apply options for this animation
+-					['type', 'animation', 'bgColor', 'textColor', 'fontFamily', 'fontStyle'].forEach(function (a) {
+-						if (a in _queue[0].options) {
+-							_opt[a] = _queue[0].options[a];
+-						}
+-					});
+-					animation.run(_queue[0].options, function () {
+-						finished();
+-					}, false);
+-				};
+-				if (_lastBadge) {
+-					animation.run(_lastBadge.options, function () {
+-						run();
+-					}, true);
+-				} else {
+-					run();
+-				}
+-			}
+-		};
+-
+-		/**
+-		 * Badge types
+-		 */
+-		var type = {};
+-		var options = function (opt) {
+-			opt.n = ((typeof opt.n) === 'number') ? Math.abs(opt.n | 0) : opt.n;
+-			opt.x = _w * opt.x;
+-			opt.y = _h * opt.y;
+-			opt.w = _w * opt.w;
+-			opt.h = _h * opt.h;
+-			opt.len = ("" + opt.n).length;
+-			return opt;
+-		};
+-		/**
+-		 * Generate circle
+-		 * @param {Object} opt Badge options
+-		 */
+-		type.circle = function (opt) {
+-			opt = options(opt);
+-			var more = false;
+-			if (opt.len === 2) {
+-				opt.x = opt.x - opt.w * 0.4;
+-				opt.w = opt.w * 1.4;
+-				more = true;
+-			} else if (opt.len >= 3) {
+-				opt.x = opt.x - opt.w * 0.65;
+-				opt.w = opt.w * 1.65;
+-				more = true;
+-			}
+-			_context.clearRect(0, 0, _w, _h);
+-			_context.drawImage(_img, 0, 0, _w, _h);
+-			_context.beginPath();
+-			_context.font = _opt.fontStyle + " " + Math.floor(opt.h * (opt.n > 99 ? 0.85 : 1)) + "px " + _opt.fontFamily;
+-			_context.textAlign = 'center';
+-			if (more) {
+-				_context.moveTo(opt.x + opt.w / 2, opt.y);
+-				_context.lineTo(opt.x + opt.w - opt.h / 2, opt.y);
+-				_context.quadraticCurveTo(opt.x + opt.w, opt.y, opt.x + opt.w, opt.y + opt.h / 2);
+-				_context.lineTo(opt.x + opt.w, opt.y + opt.h - opt.h / 2);
+-				_context.quadraticCurveTo(opt.x + opt.w, opt.y + opt.h, opt.x + opt.w - opt.h / 2, opt.y + opt.h);
+-				_context.lineTo(opt.x + opt.h / 2, opt.y + opt.h);
+-				_context.quadraticCurveTo(opt.x, opt.y + opt.h, opt.x, opt.y + opt.h - opt.h / 2);
+-				_context.lineTo(opt.x, opt.y + opt.h / 2);
+-				_context.quadraticCurveTo(opt.x, opt.y, opt.x + opt.h / 2, opt.y);
+-			} else {
+-				_context.arc(opt.x + opt.w / 2, opt.y + opt.h / 2, opt.h / 2, 0, 2 * Math.PI);
+-			}
+-			_context.fillStyle = 'rgba(' + _opt.bgColor.r + ',' + _opt.bgColor.g + ',' + _opt.bgColor.b + ',' + opt.o + ')';
+-			_context.fill();
+-			_context.closePath();
+-			_context.beginPath();
+-			_context.stroke();
+-			_context.fillStyle = 'rgba(' + _opt.textColor.r + ',' + _opt.textColor.g + ',' + _opt.textColor.b + ',' + opt.o + ')';
+-			//_context.fillText((more) ? '9+' : opt.n, Math.floor(opt.x + opt.w / 2), Math.floor(opt.y + opt.h - opt.h * 0.15));
+-			if ((typeof opt.n) === 'number' && opt.n > 999) {
+-				_context.fillText(((opt.n > 9999) ? 9 : Math.floor(opt.n / 1000)) + 'k+', Math.floor(opt.x + opt.w / 2), Math.floor(opt.y + opt.h - opt.h * 0.2));
+-			} else {
+-				_context.fillText(opt.n, Math.floor(opt.x + opt.w / 2), Math.floor(opt.y + opt.h - opt.h * 0.15));
+-			}
+-			_context.closePath();
+-		};
+-		/**
+-		 * Generate rectangle
+-		 * @param {Object} opt Badge options
+-		 */
+-		type.rectangle = function (opt) {
+-			opt = options(opt);
+-			var more = false;
+-			if (opt.len === 2) {
+-				opt.x = opt.x - opt.w * 0.4;
+-				opt.w = opt.w * 1.4;
+-				more = true;
+-			} else if (opt.len >= 3) {
+-				opt.x = opt.x - opt.w * 0.65;
+-				opt.w = opt.w * 1.65;
+-				more = true;
+-			}
+-			_context.clearRect(0, 0, _w, _h);
+-			_context.drawImage(_img, 0, 0, _w, _h);
+-			_context.beginPath();
+-			_context.font = _opt.fontStyle + " " + Math.floor(opt.h * (opt.n > 99 ? 0.9 : 1)) + "px " + _opt.fontFamily;
+-			_context.textAlign = 'center';
+-			_context.fillStyle = 'rgba(' + _opt.bgColor.r + ',' + _opt.bgColor.g + ',' + _opt.bgColor.b + ',' + opt.o + ')';
+-			_context.fillRect(opt.x, opt.y, opt.w, opt.h);
+-			_context.fillStyle = 'rgba(' + _opt.textColor.r + ',' + _opt.textColor.g + ',' + _opt.textColor.b + ',' + opt.o + ')';
+-			//_context.fillText((more) ? '9+' : opt.n, Math.floor(opt.x + opt.w / 2), Math.floor(opt.y + opt.h - opt.h * 0.15));
+-			if ((typeof opt.n) === 'number' && opt.n > 999) {
+-				_context.fillText(((opt.n > 9999) ? 9 : Math.floor(opt.n / 1000)) + 'k+', Math.floor(opt.x + opt.w / 2), Math.floor(opt.y + opt.h - opt.h * 0.2));
+-			} else {
+-				_context.fillText(opt.n, Math.floor(opt.x + opt.w / 2), Math.floor(opt.y + opt.h - opt.h * 0.15));
+-			}
+-			_context.closePath();
+-		};
+-
+-		/**
+-		 * Set badge
+-		 */
+-		var badge = function (number, opts) {
+-			opts = ((typeof opts) === 'string' ? {
+-				animation: opts
+-			} : opts) || {};
+-			_readyCb = function () {
+-				try {
+-					if (typeof (number) === 'number' ? (number > 0) : (number !== '')) {
+-						var q = {
+-							type: 'badge',
+-							options: {
+-								n: number
+-							}
+-						};
+-						if ('animation' in opts && animation.types['' + opts.animation]) {
+-							q.options.animation = '' + opts.animation;
+-						}
+-						if ('type' in opts && type['' + opts.type]) {
+-							q.options.type = '' + opts.type;
+-						}
+-						['bgColor', 'textColor'].forEach(function (o) {
+-							if (o in opts) {
+-								q.options[o] = hexToRgb(opts[o]);
+-							}
+-						});
+-						['fontStyle', 'fontFamily'].forEach(function (o) {
+-							if (o in opts) {
+-								q.options[o] = opts[o];
+-							}
+-						});
+-						_queue.push(q);
+-						if (_queue.length > 100) {
+-							throw new Error('Too many badges requests in queue.');
+-						}
+-						icon.start();
+-					} else {
+-						icon.reset();
+-					}
+-				} catch (e) {
+-					throw new Error('Error setting badge. Message: ' + e.message);
+-				}
+-			};
+-			if (_ready) {
+-				_readyCb();
+-			}
+-		};
+-
+-		/**
+-		 * Set image as icon
+-		 */
+-		var image = function (imageElement) {
+-			_readyCb = function () {
+-				try {
+-					var w = imageElement.width;
+-					var h = imageElement.height;
+-					var newImg = document.createElement('img');
+-					var ratio = (w / _w < h / _h) ? (w / _w) : (h / _h);
+-					newImg.setAttribute('crossOrigin', 'anonymous');
+-					newImg.onload=function(){
+-						_context.clearRect(0, 0, _w, _h);
+-						_context.drawImage(newImg, 0, 0, _w, _h);
+-						link.setIcon(_canvas);
+-					};
+-					newImg.setAttribute('src', imageElement.getAttribute('src'));
+-					newImg.height = (h / ratio);
+-					newImg.width = (w / ratio);
+-				} catch (e) {
+-					throw new Error('Error setting image. Message: ' + e.message);
+-				}
+-			};
+-			if (_ready) {
+-				_readyCb();
+-			}
+-		};
+-		/**
+-		 * Set the icon from a source url. Won't work with badges.
+-		 */
+-		var rawImageSrc = function (url) {
+-			_readyCb = function() {
+-				link.setIconSrc(url);
+-			};
+-			if (_ready) {
+-				_readyCb();
+-			}
+-		};
+-		/**
+-		 * Set video as icon
+-		 */
+-		var video = function (videoElement) {
+-			_readyCb = function () {
+-				try {
+-					if (videoElement === 'stop') {
+-						_stop = true;
+-						icon.reset();
+-						_stop = false;
+-						return;
+-					}
+-					//var w = videoElement.width;
+-					//var h = videoElement.height;
+-					//var ratio = (w / _w < h / _h) ? (w / _w) : (h / _h);
+-					videoElement.addEventListener('play', function () {
+-						drawVideo(this);
+-					}, false);
+-
+-				} catch (e) {
+-					throw new Error('Error setting video. Message: ' + e.message);
+-				}
+-			};
+-			if (_ready) {
+-				_readyCb();
+-			}
+-		};
+-		/**
+-		 * Set video as icon
+-		 */
+-		var webcam = function (action) {
+-			//UR
+-			if (!window.URL || !window.URL.createObjectURL) {
+-				window.URL = window.URL || {};
+-				window.URL.createObjectURL = function (obj) {
+-					return obj;
+-				};
+-			}
+-			if (_browser.supported) {
+-				var newVideo = false;
+-				navigator.getUserMedia = navigator.getUserMedia || navigator.oGetUserMedia || navigator.msGetUserMedia || navigator.mozGetUserMedia || navigator.webkitGetUserMedia;
+-				_readyCb = function () {
+-					try {
+-						if (action === 'stop') {
+-							_stop = true;
+-							icon.reset();
+-							_stop = false;
+-							return;
+-						}
+-						newVideo = document.createElement('video');
+-						newVideo.width = _w;
+-						newVideo.height = _h;
+-						navigator.getUserMedia({
+-							video: true,
+-							audio: false
+-						}, function (stream) {
+-							newVideo.src = URL.createObjectURL(stream);
+-							newVideo.play();
+-							drawVideo(newVideo);
+-						}, function () {
+-						});
+-					} catch (e) {
+-						throw new Error('Error setting webcam. Message: ' + e.message);
+-					}
+-				};
+-				if (_ready) {
+-					_readyCb();
+-				}
+-			}
+-
+-		};
+-
+-		var setOpt = function (key, value) {
+-			var opts = key;
+-			if (!(value == null && Object.prototype.toString.call(key) == '[object Object]')) {
+-				opts = {};
+-				opts[key] = value;
+-			}
+-
+-			var keys = Object.keys(opts);
+-			for (var i = 0; i < keys.length; i++) {
+-				if (keys[i] == 'bgColor' || keys[i] == 'textColor') {
+-					_opt[keys[i]] = hexToRgb(opts[keys[i]]);
+-				} else {
+-					_opt[keys[i]] = opts[keys[i]];
+-				}
+-			}
+-
+-			_queue.push(_lastBadge);
+-			icon.start();
+-		};
+-
+-		/**
+-		 * Draw video to context and repeat :)
+-		 */
+-		function drawVideo(video) {
+-			if (video.paused || video.ended || _stop) {
+-				return false;
+-			}
+-			//nasty hack for FF webcam (Thanks to Julian Ćwirko, kontakt@redsunmedia.pl)
+-			try {
+-				_context.clearRect(0, 0, _w, _h);
+-				_context.drawImage(video, 0, 0, _w, _h);
+-			} catch (e) {
+-
+-			}
+-			_drawTimeout = setTimeout(function () {
+-				drawVideo(video);
+-			}, animation.duration);
+-			link.setIcon(_canvas);
+-		}
+-
+-		var link = {};
+-		/**
+-		 * Get icons from HEAD tag or create a new <link> element
+-		 */
+-		link.getIcons = function () {
+-			var elms = [];
+-			//get link element
+-			var getLinks = function () {
+-				var icons = [];
+-				var links = _doc.getElementsByTagName('head')[0].getElementsByTagName('link');
+-				for (var i = 0; i < links.length; i++) {
+-					if ((/(^|\s)icon(\s|$)/i).test(links[i].getAttribute('rel'))) {
+-						icons.push(links[i]);
+-					}
+-				}
+-				return icons;
+-			};
+-			if (_opt.element) {
+-				elms = [_opt.element];
+-			} else if (_opt.elementId) {
+-				//if img element identified by elementId
+-				elms = [_doc.getElementById(_opt.elementId)];
+-				elms[0].setAttribute('href', elms[0].getAttribute('src'));
+-			} else {
+-				//if link element
+-				elms = getLinks();
+-				if (elms.length === 0) {
+-					elms = [_doc.createElement('link')];
+-					elms[0].setAttribute('rel', 'icon');
+-					_doc.getElementsByTagName('head')[0].appendChild(elms[0]);
+-				}
+-			}
+-			elms.forEach(function(item) {
+-				item.setAttribute('type', 'image/png');
+-			});
+-			return elms;
+-		};
+-		link.setIcon = function (canvas) {
+-			setTimeout(function() {
+-				var url = canvas.toDataURL('image/png');
+-				link.setIconSrc(url);
+-			}, 0);
+-		};
+-		link.setIconSrc = function (url) {
+-			if (_opt.dataUrl) {
+-				//if using custom exporter
+-				_opt.dataUrl(url);
+-			}
+-			if (_opt.element) {
+-				_opt.element.setAttribute('href', url);
+-				_opt.element.setAttribute('src', url);
+-			} else if (_opt.elementId) {
+-				//if is attached to element (image)
+-				var elm = _doc.getElementById(_opt.elementId);
+-				elm.setAttribute('href', url);
+-				elm.setAttribute('src', url);
+-			} else {
+-				//if is attached to fav icon
+-				if (_browser.ff || _browser.opera) {
+-					//for FF we need to "recreate" element, atach to dom and remove old <link>
+-					//var originalType = _orig.getAttribute('rel');
+-					var old = _orig[_orig.length - 1];
+-					var newIcon = _doc.createElement('link');
+-					_orig = [newIcon];
+-					//_orig.setAttribute('rel', originalType);
+-					if (_browser.opera) {
+-						newIcon.setAttribute('rel', 'icon');
+-					}
+-					newIcon.setAttribute('rel', 'icon');
+-					newIcon.setAttribute('type', 'image/png');
+-					_doc.getElementsByTagName('head')[0].appendChild(newIcon);
+-					newIcon.setAttribute('href', url);
+-					if (old.parentNode) {
+-						old.parentNode.removeChild(old);
+-					}
+-				} else {
+-					_orig.forEach(function(icon) {
+-						icon.setAttribute('href', url);
+-					});
+-				}
+-			}
+-		};
+-
+-		//http://stackoverflow.com/questions/5623838/rgb-to-hex-and-hex-to-rgb#answer-5624139
+-		//HEX to RGB convertor
+-		function hexToRgb(hex) {
+-			var shorthandRegex = /^#?([a-f\d])([a-f\d])([a-f\d])$/i;
+-			hex = hex.replace(shorthandRegex, function (m, r, g, b) {
+-				return r + r + g + g + b + b;
+-			});
+-			var result = /^#?([a-f\d]{2})([a-f\d]{2})([a-f\d]{2})$/i.exec(hex);
+-			return result ? {
+-				r: parseInt(result[1], 16),
+-				g: parseInt(result[2], 16),
+-				b: parseInt(result[3], 16)
+-			} : false;
+-		}
+-
+-		/**
+-		 * Merge options
+-		 */
+-		function merge(def, opt) {
+-			var mergedOpt = {};
+-			var attrname;
+-			for (attrname in def) {
+-				mergedOpt[attrname] = def[attrname];
+-			}
+-			for (attrname in opt) {
+-				mergedOpt[attrname] = opt[attrname];
+-			}
+-			return mergedOpt;
+-		}
+-
+-		/**
+-		 * Cross-browser page visibility shim
+-		 * http://stackoverflow.com/questions/12536562/detect-whether-a-window-is-visible
+-		 */
+-		function isPageHidden() {
+-			return _doc.hidden || _doc.msHidden || _doc.webkitHidden || _doc.mozHidden;
+-		}
+-
+-		/**
+-		 * @namespace animation
+-		 */
+-		var animation = {};
+-		/**
+-		 * Animation "frame" duration
+-		 */
+-		animation.duration = 40;
+-		/**
+-		 * Animation types (none,fade,pop,slide)
+-		 */
+-		animation.types = {};
+-		animation.types.fade = [{
+-			x: 0.4,
+-			y: 0.4,
+-			w: 0.6,
+-			h: 0.6,
+-			o: 0.0
+-		}, {
+-				x: 0.4,
+-				y: 0.4,
+-				w: 0.6,
+-				h: 0.6,
+-				o: 0.1
+-			}, {
+-				x: 0.4,
+-				y: 0.4,
+-				w: 0.6,
+-				h: 0.6,
+-				o: 0.2
+-			}, {
+-				x: 0.4,
+-				y: 0.4,
+-				w: 0.6,
+-				h: 0.6,
+-				o: 0.3
+-			}, {
+-				x: 0.4,
+-				y: 0.4,
+-				w: 0.6,
+-				h: 0.6,
+-				o: 0.4
+-			}, {
+-				x: 0.4,
+-				y: 0.4,
+-				w: 0.6,
+-				h: 0.6,
+-				o: 0.5
+-			}, {
+-				x: 0.4,
+-				y: 0.4,
+-				w: 0.6,
+-				h: 0.6,
+-				o: 0.6
+-			}, {
+-				x: 0.4,
+-				y: 0.4,
+-				w: 0.6,
+-				h: 0.6,
+-				o: 0.7
+-			}, {
+-				x: 0.4,
+-				y: 0.4,
+-				w: 0.6,
+-				h: 0.6,
+-				o: 0.8
+-			}, {
+-				x: 0.4,
+-				y: 0.4,
+-				w: 0.6,
+-				h: 0.6,
+-				o: 0.9
+-			}, {
+-				x: 0.4,
+-				y: 0.4,
+-				w: 0.6,
+-				h: 0.6,
+-				o: 1.0
+-			}];
+-		animation.types.none = [{
+-			x: 0.4,
+-			y: 0.4,
+-			w: 0.6,
+-			h: 0.6,
+-			o: 1
+-		}];
+-		animation.types.pop = [{
+-			x: 1,
+-			y: 1,
+-			w: 0,
+-			h: 0,
+-			o: 1
+-		}, {
+-				x: 0.9,
+-				y: 0.9,
+-				w: 0.1,
+-				h: 0.1,
+-				o: 1
+-			}, {
+-				x: 0.8,
+-				y: 0.8,
+-				w: 0.2,
+-				h: 0.2,
+-				o: 1
+-			}, {
+-				x: 0.7,
+-				y: 0.7,
+-				w: 0.3,
+-				h: 0.3,
+-				o: 1
+-			}, {
+-				x: 0.6,
+-				y: 0.6,
+-				w: 0.4,
+-				h: 0.4,
+-				o: 1
+-			}, {
+-				x: 0.5,
+-				y: 0.5,
+-				w: 0.5,
+-				h: 0.5,
+-				o: 1
+-			}, {
+-				x: 0.4,
+-				y: 0.4,
+-				w: 0.6,
+-				h: 0.6,
+-				o: 1
+-			}];
+-		animation.types.popFade = [{
+-			x: 0.75,
+-			y: 0.75,
+-			w: 0,
+-			h: 0,
+-			o: 0
+-		}, {
+-				x: 0.65,
+-				y: 0.65,
+-				w: 0.1,
+-				h: 0.1,
+-				o: 0.2
+-			}, {
+-				x: 0.6,
+-				y: 0.6,
+-				w: 0.2,
+-				h: 0.2,
+-				o: 0.4
+-			}, {
+-				x: 0.55,
+-				y: 0.55,
+-				w: 0.3,
+-				h: 0.3,
+-				o: 0.6
+-			}, {
+-				x: 0.50,
+-				y: 0.50,
+-				w: 0.4,
+-				h: 0.4,
+-				o: 0.8
+-			}, {
+-				x: 0.45,
+-				y: 0.45,
+-				w: 0.5,
+-				h: 0.5,
+-				o: 0.9
+-			}, {
+-				x: 0.4,
+-				y: 0.4,
+-				w: 0.6,
+-				h: 0.6,
+-				o: 1
+-			}];
+-		animation.types.slide = [{
+-			x: 0.4,
+-			y: 1,
+-			w: 0.6,
+-			h: 0.6,
+-			o: 1
+-		}, {
+-				x: 0.4,
+-				y: 0.9,
+-				w: 0.6,
+-				h: 0.6,
+-				o: 1
+-			}, {
+-				x: 0.4,
+-				y: 0.9,
+-				w: 0.6,
+-				h: 0.6,
+-				o: 1
+-			}, {
+-				x: 0.4,
+-				y: 0.8,
+-				w: 0.6,
+-				h: 0.6,
+-				o: 1
+-			}, {
+-				x: 0.4,
+-				y: 0.7,
+-				w: 0.6,
+-				h: 0.6,
+-				o: 1
+-			}, {
+-				x: 0.4,
+-				y: 0.6,
+-				w: 0.6,
+-				h: 0.6,
+-				o: 1
+-			}, {
+-				x: 0.4,
+-				y: 0.5,
+-				w: 0.6,
+-				h: 0.6,
+-				o: 1
+-			}, {
+-				x: 0.4,
+-				y: 0.4,
+-				w: 0.6,
+-				h: 0.6,
+-				o: 1
+-			}];
+-		/**
+-		 * Run animation
+-		 * @param {Object} opt Animation options
+-		 * @param {Object} cb Callabak after all steps are done
+-		 * @param {Object} revert Reverse order? true|false
+-		 * @param {Object} step Optional step number (frame bumber)
+-		 */
+-		animation.run = function (opt, cb, revert, step) {
+-			var animationType = animation.types[isPageHidden() ? 'none' : _opt.animation];
+-			if (revert === true) {
+-				step = (typeof step !== 'undefined') ? step : animationType.length - 1;
+-			} else {
+-				step = (typeof step !== 'undefined') ? step : 0;
+-			}
+-			cb = (cb) ? cb : function () {
+-			};
+-			if ((step < animationType.length) && (step >= 0)) {
+-				type[_opt.type](merge(opt, animationType[step]));
+-				_animTimeout = setTimeout(function () {
+-					if (revert) {
+-						step = step - 1;
+-					} else {
+-						step = step + 1;
+-					}
+-					animation.run(opt, cb, revert, step);
+-				}, animation.duration);
+-
+-				link.setIcon(_canvas);
+-			} else {
+-				cb();
+-				return;
+-			}
+-		};
+-		//auto init
+-		init();
+-		return {
+-			badge: badge,
+-			video: video,
+-			image: image,
+-			rawImageSrc: rawImageSrc,
+-			webcam: webcam,
+-			setOpt: setOpt,
+-			reset: icon.reset,
+-			browser: {
+-				supported: _browser.supported
+-			}
+-		};
+-	});
+-
+-	// AMD / RequireJS
+-	if (typeof define !== 'undefined' && define.amd) {
+-		define([], function () {
+-			return Favico;
+-		});
+-	}
+-	// CommonJS
+-	else if (typeof module !== 'undefined' && module.exports) {
+-		module.exports = Favico;
+-	}
+-	// included directly via <script> tag
+-	else {
+-		this.Favico = Favico;
+-	}
+-
+-})();
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\kasimi\\faviconnotifications/styles/all/template/js/favico-0.3.10.min.bak.js" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\kasimi\\faviconnotifications/styles/all/template/js/favico-0.3.10.min.bak.js"
+new file mode 100644
+index 000000000..cd411658b
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\kasimi\\faviconnotifications/styles/all/template/js/favico-0.3.10.min.bak.js"
+@@ -0,0 +1,7 @@
++/**
++ * @license MIT
++ * @fileOverview Favico animations
++ * @author Miroslav Magda, http://blog.ejci.net
++ * @version 0.3.10
++ */
++!function(){var e=function(e){"use strict";function t(e){if(e.paused||e.ended||g)return!1;try{f.clearRect(0,0,s,l),f.drawImage(e,0,0,s,l)}catch(o){}p=setTimeout(function(){t(e)},S.duration),O.setIcon(h)}function o(e){var t=/^#?([a-f\d])([a-f\d])([a-f\d])$/i;e=e.replace(t,function(e,t,o,n){return t+t+o+o+n+n});var o=/^#?([a-f\d]{2})([a-f\d]{2})([a-f\d]{2})$/i.exec(e);return o?{r:parseInt(o[1],16),g:parseInt(o[2],16),b:parseInt(o[3],16)}:!1}function n(e,t){var o,n={};for(o in e)n[o]=e[o];for(o in t)n[o]=t[o];return n}function r(){return b.hidden||b.msHidden||b.webkitHidden||b.mozHidden}e=e?e:{};var i,a,l,s,h,f,c,d,u,y,w,g,x,m,p,b,v={bgColor:"#d00",textColor:"#fff",fontFamily:"sans-serif",fontStyle:"bold",type:"circle",position:"down",animation:"slide",elementId:!1,dataUrl:!1,win:window};x={},x.ff="undefined"!=typeof InstallTrigger,x.chrome=!!window.chrome,x.opera=!!window.opera||navigator.userAgent.indexOf("Opera")>=0,x.ie=/*@cc_on!@*/!1,x.safari=Object.prototype.toString.call(window.HTMLElement).indexOf("Constructor")>0,x.supported=x.chrome||x.ff||x.opera;var C=[];w=function(){},d=g=!1;var E=function(){i=n(v,e),i.bgColor=o(i.bgColor),i.textColor=o(i.textColor),i.position=i.position.toLowerCase(),i.animation=S.types[""+i.animation]?i.animation:v.animation,b=i.win.document;var t=i.position.indexOf("up")>-1,r=i.position.indexOf("left")>-1;if(t||r)for(var d=0;d<S.types[""+i.animation].length;d++){var u=S.types[""+i.animation][d];t&&(u.y=u.y<.6?u.y-.4:u.y-2*u.y+(1-u.w)),r&&(u.x=u.x<.6?u.x-.4:u.x-2*u.x+(1-u.h)),S.types[""+i.animation][d]=u}i.type=A[""+i.type]?i.type:v.type,a=O.getIcon(),h=document.createElement("canvas"),c=document.createElement("img"),a.hasAttribute("href")?(c.setAttribute("crossOrigin","anonymous"),c.onload=function(){l=c.height>0?c.height:32,s=c.width>0?c.width:32,h.height=l,h.width=s,f=h.getContext("2d"),M.ready()},c.setAttribute("src",a.getAttribute("href"))):(c.onload=function(){l=32,s=32,c.height=l,c.width=s,h.height=l,h.width=s,f=h.getContext("2d"),M.ready()},c.setAttribute("src",""))},M={};M.ready=function(){d=!0,M.reset(),w()},M.reset=function(){d&&(C=[],u=!1,y=!1,f.clearRect(0,0,s,l),f.drawImage(c,0,0,s,l),O.setIcon(h),window.clearTimeout(m),window.clearTimeout(p))},M.start=function(){if(d&&!y){var e=function(){u=C[0],y=!1,C.length>0&&(C.shift(),M.start())};if(C.length>0){y=!0;var t=function(){["type","animation","bgColor","textColor","fontFamily","fontStyle"].forEach(function(e){e in C[0].options&&(i[e]=C[0].options[e])}),S.run(C[0].options,function(){e()},!1)};u?S.run(u.options,function(){t()},!0):t()}}};var A={},I=function(e){return e.n="number"==typeof e.n?Math.abs(0|e.n):e.n,e.x=s*e.x,e.y=l*e.y,e.w=s*e.w,e.h=l*e.h,e.len=(""+e.n).length,e};A.circle=function(e){e=I(e);var t=!1;2===e.len?(e.x=e.x-.4*e.w,e.w=1.4*e.w,t=!0):e.len>=3&&(e.x=e.x-.65*e.w,e.w=1.65*e.w,t=!0),f.clearRect(0,0,s,l),f.drawImage(c,0,0,s,l),f.beginPath(),f.font=i.fontStyle+" "+Math.floor(e.h*(e.n>99?.85:1))+"px "+i.fontFamily,f.textAlign="center",t?(f.moveTo(e.x+e.w/2,e.y),f.lineTo(e.x+e.w-e.h/2,e.y),f.quadraticCurveTo(e.x+e.w,e.y,e.x+e.w,e.y+e.h/2),f.lineTo(e.x+e.w,e.y+e.h-e.h/2),f.quadraticCurveTo(e.x+e.w,e.y+e.h,e.x+e.w-e.h/2,e.y+e.h),f.lineTo(e.x+e.h/2,e.y+e.h),f.quadraticCurveTo(e.x,e.y+e.h,e.x,e.y+e.h-e.h/2),f.lineTo(e.x,e.y+e.h/2),f.quadraticCurveTo(e.x,e.y,e.x+e.h/2,e.y)):f.arc(e.x+e.w/2,e.y+e.h/2,e.h/2,0,2*Math.PI),f.fillStyle="rgba("+i.bgColor.r+","+i.bgColor.g+","+i.bgColor.b+","+e.o+")",f.fill(),f.closePath(),f.beginPath(),f.stroke(),f.fillStyle="rgba("+i.textColor.r+","+i.textColor.g+","+i.textColor.b+","+e.o+")","number"==typeof e.n&&e.n>999?f.fillText((e.n>9999?9:Math.floor(e.n/1e3))+"k+",Math.floor(e.x+e.w/2),Math.floor(e.y+e.h-.2*e.h)):f.fillText(e.n,Math.floor(e.x+e.w/2),Math.floor(e.y+e.h-.15*e.h)),f.closePath()},A.rectangle=function(e){e=I(e);var t=!1;2===e.len?(e.x=e.x-.4*e.w,e.w=1.4*e.w,t=!0):e.len>=3&&(e.x=e.x-.65*e.w,e.w=1.65*e.w,t=!0),f.clearRect(0,0,s,l),f.drawImage(c,0,0,s,l),f.beginPath(),f.font=i.fontStyle+" "+Math.floor(e.h*(e.n>99?.9:1))+"px "+i.fontFamily,f.textAlign="center",f.fillStyle="rgba("+i.bgColor.r+","+i.bgColor.g+","+i.bgColor.b+","+e.o+")",f.fillRect(e.x,e.y,e.w,e.h),f.fillStyle="rgba("+i.textColor.r+","+i.textColor.g+","+i.textColor.b+","+e.o+")","number"==typeof e.n&&e.n>999?f.fillText((e.n>9999?9:Math.floor(e.n/1e3))+"k+",Math.floor(e.x+e.w/2),Math.floor(e.y+e.h-.2*e.h)):f.fillText(e.n,Math.floor(e.x+e.w/2),Math.floor(e.y+e.h-.15*e.h)),f.closePath()};var T=function(e,t){t=("string"==typeof t?{animation:t}:t)||{},w=function(){try{if("number"==typeof e?e>0:""!==e){var n={type:"badge",options:{n:e}};if("animation"in t&&S.types[""+t.animation]&&(n.options.animation=""+t.animation),"type"in t&&A[""+t.type]&&(n.options.type=""+t.type),["bgColor","textColor"].forEach(function(e){e in t&&(n.options[e]=o(t[e]))}),["fontStyle","fontFamily"].forEach(function(e){e in t&&(n.options[e]=t[e])}),C.push(n),C.length>100)throw new Error("Too many badges requests in queue.");M.start()}else M.reset()}catch(r){throw new Error("Error setting badge. Message: "+r.message)}},d&&w()},U=function(e){w=function(){try{var t=e.width,o=e.height,n=document.createElement("img"),r=o/l>t/s?t/s:o/l;n.setAttribute("crossOrigin","anonymous"),n.onload=function(){f.clearRect(0,0,s,l),f.drawImage(n,0,0,s,l),O.setIcon(h)},n.setAttribute("src",e.getAttribute("src")),n.height=o/r,n.width=t/r}catch(i){throw new Error("Error setting image. Message: "+i.message)}},d&&w()},R=function(e){w=function(){try{if("stop"===e)return g=!0,M.reset(),void(g=!1);e.addEventListener("play",function(){t(this)},!1)}catch(o){throw new Error("Error setting video. Message: "+o.message)}},d&&w()},L=function(e){if(window.URL&&window.URL.createObjectURL||(window.URL=window.URL||{},window.URL.createObjectURL=function(e){return e}),x.supported){var o=!1;navigator.getUserMedia=navigator.getUserMedia||navigator.oGetUserMedia||navigator.msGetUserMedia||navigator.mozGetUserMedia||navigator.webkitGetUserMedia,w=function(){try{if("stop"===e)return g=!0,M.reset(),void(g=!1);o=document.createElement("video"),o.width=s,o.height=l,navigator.getUserMedia({video:!0,audio:!1},function(e){o.src=URL.createObjectURL(e),o.play(),t(o)},function(){})}catch(n){throw new Error("Error setting webcam. Message: "+n.message)}},d&&w()}},O={};O.getIcon=function(){var e=!1,t=function(){for(var e=b.getElementsByTagName("head")[0].getElementsByTagName("link"),t=e.length,o=t-1;o>=0;o--)if(/(^|\s)icon(\s|$)/i.test(e[o].getAttribute("rel")))return e[o];return!1};return i.element?e=i.element:i.elementId?(e=b.getElementById(i.elementId),e.setAttribute("href",e.getAttribute("src"))):(e=t(),e===!1&&(e=b.createElement("link"),e.setAttribute("rel","icon"),b.getElementsByTagName("head")[0].appendChild(e))),e.setAttribute("type","image/png"),e},O.setIcon=function(e){var t=e.toDataURL("image/png");if(i.dataUrl&&i.dataUrl(t),i.element)i.element.setAttribute("href",t),i.element.setAttribute("src",t);else if(i.elementId){var o=b.getElementById(i.elementId);o.setAttribute("href",t),o.setAttribute("src",t)}else if(x.ff||x.opera){var n=a;a=b.createElement("link"),x.opera&&a.setAttribute("rel","icon"),a.setAttribute("rel","icon"),a.setAttribute("type","image/png"),b.getElementsByTagName("head")[0].appendChild(a),a.setAttribute("href",t),n.parentNode&&n.parentNode.removeChild(n)}else a.setAttribute("href",t)};var S={};return S.duration=40,S.types={},S.types.fade=[{x:.4,y:.4,w:.6,h:.6,o:0},{x:.4,y:.4,w:.6,h:.6,o:.1},{x:.4,y:.4,w:.6,h:.6,o:.2},{x:.4,y:.4,w:.6,h:.6,o:.3},{x:.4,y:.4,w:.6,h:.6,o:.4},{x:.4,y:.4,w:.6,h:.6,o:.5},{x:.4,y:.4,w:.6,h:.6,o:.6},{x:.4,y:.4,w:.6,h:.6,o:.7},{x:.4,y:.4,w:.6,h:.6,o:.8},{x:.4,y:.4,w:.6,h:.6,o:.9},{x:.4,y:.4,w:.6,h:.6,o:1}],S.types.none=[{x:.4,y:.4,w:.6,h:.6,o:1}],S.types.pop=[{x:1,y:1,w:0,h:0,o:1},{x:.9,y:.9,w:.1,h:.1,o:1},{x:.8,y:.8,w:.2,h:.2,o:1},{x:.7,y:.7,w:.3,h:.3,o:1},{x:.6,y:.6,w:.4,h:.4,o:1},{x:.5,y:.5,w:.5,h:.5,o:1},{x:.4,y:.4,w:.6,h:.6,o:1}],S.types.popFade=[{x:.75,y:.75,w:0,h:0,o:0},{x:.65,y:.65,w:.1,h:.1,o:.2},{x:.6,y:.6,w:.2,h:.2,o:.4},{x:.55,y:.55,w:.3,h:.3,o:.6},{x:.5,y:.5,w:.4,h:.4,o:.8},{x:.45,y:.45,w:.5,h:.5,o:.9},{x:.4,y:.4,w:.6,h:.6,o:1}],S.types.slide=[{x:.4,y:1,w:.6,h:.6,o:1},{x:.4,y:.9,w:.6,h:.6,o:1},{x:.4,y:.9,w:.6,h:.6,o:1},{x:.4,y:.8,w:.6,h:.6,o:1},{x:.4,y:.7,w:.6,h:.6,o:1},{x:.4,y:.6,w:.6,h:.6,o:1},{x:.4,y:.5,w:.6,h:.6,o:1},{x:.4,y:.4,w:.6,h:.6,o:1}],S.run=function(e,t,o,a){var l=S.types[r()?"none":i.animation];return a=o===!0?"undefined"!=typeof a?a:l.length-1:"undefined"!=typeof a?a:0,t=t?t:function(){},a<l.length&&a>=0?(A[i.type](n(e,l[a])),m=setTimeout(function(){o?a-=1:a+=1,S.run(e,t,o,a)},S.duration),O.setIcon(h),void 0):void t()},E(),{badge:T,video:R,image:U,webcam:L,reset:M.reset,browser:{supported:x.supported}}};"undefined"!=typeof define&&define.amd?define([],function(){return e}):"undefined"!=typeof module&&module.exports?module.exports=e:this.Favico=e}();
+\ No newline at end of file
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\kasimi\\faviconnotifications/styles/all/template/js/favico-0.3.10.min.js" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\kasimi\\faviconnotifications/styles/all/template/js/favico-0.3.10.min.js"
+new file mode 100644
+index 000000000..66ccf4740
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\kasimi\\faviconnotifications/styles/all/template/js/favico-0.3.10.min.js"
+@@ -0,0 +1,7 @@
++/**
++ * @license MIT
++ * @fileOverview Favico animations
++ * @author Miroslav Magda, http://blog.ejci.net
++ * @version 0.3.10
++ */
++!function(){var e=function(e){"use strict";function t(e){if(e.paused||e.ended||w)return!1;try{h.clearRect(0,0,l,a),h.drawImage(e,0,0,l,a)}catch(e){}m=setTimeout(function(){t(e)},I.duration),A.setIcon(s)}function o(e){e=e.replace(/^#?([a-f\d])([a-f\d])([a-f\d])$/i,function(e,t,o,n){return t+t+o+o+n+n});var t=/^#?([a-f\d]{2})([a-f\d]{2})([a-f\d]{2})$/i.exec(e);return!!t&&{r:parseInt(t[1],16),g:parseInt(t[2],16),b:parseInt(t[3],16)}}function n(e,t){var o,n={};for(o in e)n[o]=e[o];for(o in t)n[o]=t[o];return n}e=e||{};var r,i,a,l,s,h,f,c,d,u,y,w,g,x,m,p,b={bgColor:"#d00",textColor:"#fff",fontFamily:"sans-serif",fontStyle:"bold",type:"circle",position:"down",animation:"slide",elementId:!1,dataUrl:!1,win:window};(g={}).ff="undefined"!=typeof InstallTrigger,g.chrome=!!window.chrome,g.opera=!!window.opera||navigator.userAgent.indexOf("Opera")>=0,g.ie=!1,g.safari=Object.prototype.toString.call(window.HTMLElement).indexOf("Constructor")>0,g.supported=g.chrome||g.ff||g.opera;var v=[];y=function(){},c=w=!1;var C={ready:function(){c=!0,C.reset(),y()},reset:function(){c&&(v=[],d=!1,u=!1,h.clearRect(0,0,l,a),h.drawImage(f,0,0,l,a),A.setIcon(s),window.clearTimeout(x),window.clearTimeout(m))}};C.start=function(){if(c&&!u){if(v.length>0){u=!0;var e=function(){["type","animation","bgColor","textColor","fontFamily","fontStyle"].forEach(function(e){e in v[0].options&&(r[e]=v[0].options[e])}),I.run(v[0].options,function(){d=v[0],u=!1,v.length>0&&(v.shift(),C.start())},!1)};d?I.run(d.options,function(){e()},!0):e()}}};var E={},M=function(e){return e.n="number"==typeof e.n?Math.abs(0|e.n):e.n,e.x=l*e.x,e.y=a*e.y,e.w=l*e.w,e.h=a*e.h,e.len=(""+e.n).length,e};E.circle=function(e){var t=!1;2===(e=M(e)).len?(e.x=e.x-.4*e.w,e.w=1.4*e.w,t=!0):e.len>=3&&(e.x=e.x-.65*e.w,e.w=1.65*e.w,t=!0),h.clearRect(0,0,l,a),h.drawImage(f,0,0,l,a),h.beginPath(),h.font=r.fontStyle+" "+Math.floor(e.h*(e.n>99?.85:1))+"px "+r.fontFamily,h.textAlign="center",t?(h.moveTo(e.x+e.w/2,e.y),h.lineTo(e.x+e.w-e.h/2,e.y),h.quadraticCurveTo(e.x+e.w,e.y,e.x+e.w,e.y+e.h/2),h.lineTo(e.x+e.w,e.y+e.h-e.h/2),h.quadraticCurveTo(e.x+e.w,e.y+e.h,e.x+e.w-e.h/2,e.y+e.h),h.lineTo(e.x+e.h/2,e.y+e.h),h.quadraticCurveTo(e.x,e.y+e.h,e.x,e.y+e.h-e.h/2),h.lineTo(e.x,e.y+e.h/2),h.quadraticCurveTo(e.x,e.y,e.x+e.h/2,e.y)):h.arc(e.x+e.w/2,e.y+e.h/2,e.h/2,0,2*Math.PI),h.fillStyle="rgba("+r.bgColor.r+","+r.bgColor.g+","+r.bgColor.b+","+e.o+")",h.fill(),h.closePath(),h.beginPath(),h.stroke(),h.fillStyle="rgba("+r.textColor.r+","+r.textColor.g+","+r.textColor.b+","+e.o+")","number"==typeof e.n&&e.n>999?h.fillText((e.n>9999?9:Math.floor(e.n/1e3))+"k+",Math.floor(e.x+e.w/2),Math.floor(e.y+e.h-.2*e.h)):h.fillText(e.n,Math.floor(e.x+e.w/2),Math.floor(e.y+e.h-.15*e.h)),h.closePath()},E.rectangle=function(e){2===(e=M(e)).len?(e.x=e.x-.4*e.w,e.w=1.4*e.w):e.len>=3&&(e.x=e.x-.65*e.w,e.w=1.65*e.w),h.clearRect(0,0,l,a),h.drawImage(f,0,0,l,a),h.beginPath(),h.font=r.fontStyle+" "+Math.floor(e.h*(e.n>99?.9:1))+"px "+r.fontFamily,h.textAlign="center",h.fillStyle="rgba("+r.bgColor.r+","+r.bgColor.g+","+r.bgColor.b+","+e.o+")",h.fillRect(e.x,e.y,e.w,e.h),h.fillStyle="rgba("+r.textColor.r+","+r.textColor.g+","+r.textColor.b+","+e.o+")","number"==typeof e.n&&e.n>999?h.fillText((e.n>9999?9:Math.floor(e.n/1e3))+"k+",Math.floor(e.x+e.w/2),Math.floor(e.y+e.h-.2*e.h)):h.fillText(e.n,Math.floor(e.x+e.w/2),Math.floor(e.y+e.h-.15*e.h)),h.closePath()};var A={getIcon:function(){var e=!1;return r.element?e=r.element:r.elementId?(e=p.getElementById(r.elementId)).setAttribute("href",e.getAttribute("src")):!1===(e=function(){for(var e=p.getElementsByTagName("head")[0].getElementsByTagName("link"),t=e.length-1;t>=0;t--)if(/(^|\s)icon(\s|$)/i.test(e[t].getAttribute("rel")))return e[t];return!1}())&&((e=p.createElement("link")).setAttribute("rel","icon"),p.getElementsByTagName("head")[0].appendChild(e)),e.setAttribute("type","image/png"),e},setIcon:function(e){var t=e.toDataURL("image/png");if(r.dataUrl&&r.dataUrl(t),r.element)r.element.setAttribute("href",t),r.element.setAttribute("src",t);else if(r.elementId){var o=p.getElementById(r.elementId);o.setAttribute("href",t),o.setAttribute("src",t)}else if(g.ff||g.opera){var n=i;i=p.createElement("link"),g.opera&&i.setAttribute("rel","icon"),i.setAttribute("rel","icon"),i.setAttribute("type","image/png"),p.getElementsByTagName("head")[0].appendChild(i),i.setAttribute("href",t),n.parentNode&&n.parentNode.removeChild(n)}else i.setAttribute("href",t)}},I={duration:40,types:{}};return I.types.fade=[{x:.4,y:.4,w:.6,h:.6,o:0},{x:.4,y:.4,w:.6,h:.6,o:.1},{x:.4,y:.4,w:.6,h:.6,o:.2},{x:.4,y:.4,w:.6,h:.6,o:.3},{x:.4,y:.4,w:.6,h:.6,o:.4},{x:.4,y:.4,w:.6,h:.6,o:.5},{x:.4,y:.4,w:.6,h:.6,o:.6},{x:.4,y:.4,w:.6,h:.6,o:.7},{x:.4,y:.4,w:.6,h:.6,o:.8},{x:.4,y:.4,w:.6,h:.6,o:.9},{x:.4,y:.4,w:.6,h:.6,o:1}],I.types.none=[{x:.4,y:.4,w:.6,h:.6,o:1}],I.types.pop=[{x:1,y:1,w:0,h:0,o:1},{x:.9,y:.9,w:.1,h:.1,o:1},{x:.8,y:.8,w:.2,h:.2,o:1},{x:.7,y:.7,w:.3,h:.3,o:1},{x:.6,y:.6,w:.4,h:.4,o:1},{x:.5,y:.5,w:.5,h:.5,o:1},{x:.4,y:.4,w:.6,h:.6,o:1}],I.types.popFade=[{x:.75,y:.75,w:0,h:0,o:0},{x:.65,y:.65,w:.1,h:.1,o:.2},{x:.6,y:.6,w:.2,h:.2,o:.4},{x:.55,y:.55,w:.3,h:.3,o:.6},{x:.5,y:.5,w:.4,h:.4,o:.8},{x:.45,y:.45,w:.5,h:.5,o:.9},{x:.4,y:.4,w:.6,h:.6,o:1}],I.types.slide=[{x:.4,y:1,w:.6,h:.6,o:1},{x:.4,y:.9,w:.6,h:.6,o:1},{x:.4,y:.9,w:.6,h:.6,o:1},{x:.4,y:.8,w:.6,h:.6,o:1},{x:.4,y:.7,w:.6,h:.6,o:1},{x:.4,y:.6,w:.6,h:.6,o:1},{x:.4,y:.5,w:.6,h:.6,o:1},{x:.4,y:.4,w:.6,h:.6,o:1}],I.run=function(e,t,o,i){var a=I.types[p.hidden||p.msHidden||p.webkitHidden||p.mozHidden?"none":r.animation];return i=!0===o?void 0!==i?i:a.length-1:void 0!==i?i:0,t=t||function(){},i<a.length&&i>=0?(E[r.type](n(e,a[i])),x=setTimeout(function(){o?i-=1:i+=1,I.run(e,t,o,i)},I.duration),void A.setIcon(s)):void t()},function(){(r=n(b,e)).bgColor=o(r.bgColor),r.textColor=o(r.textColor),r.position=r.position.toLowerCase(),r.animation=I.types[""+r.animation]?r.animation:b.animation,p=r.win.document;var t=r.position.indexOf("up")>-1,c=r.position.indexOf("left")>-1;if(t||c)for(var d=0;d<I.types[""+r.animation].length;d++){var u=I.types[""+r.animation][d];t&&(u.y=u.y<.6?u.y-.4:u.y-2*u.y+(1-u.w)),c&&(u.x=u.x<.6?u.x-.4:u.x-2*u.x+(1-u.h)),I.types[""+r.animation][d]=u}r.type=E[""+r.type]?r.type:b.type,i=A.getIcon(),s=document.createElement("canvas"),f=document.createElement("img"),i.hasAttribute("href")?(f.setAttribute("crossOrigin","anonymous"),f.onload=function(){a=f.height>0?f.height:32,l=f.width>0?f.width:32,s.height=a,s.width=l,h=s.getContext("2d"),C.ready()},f.setAttribute("src",i.getAttribute("href"))):(f.onload=function(){a=32,l=32,f.height=a,f.width=l,s.height=a,s.width=l,h=s.getContext("2d"),C.ready()},f.setAttribute("src",""))}(),{badge:function(e,t){t=("string"==typeof t?{animation:t}:t)||{},y=function(){try{if("number"==typeof e?e>0:""!==e){var n={type:"badge",options:{n:e}};if("animation"in t&&I.types[""+t.animation]&&(n.options.animation=""+t.animation),"type"in t&&E[""+t.type]&&(n.options.type=""+t.type),["bgColor","textColor"].forEach(function(e){e in t&&(n.options[e]=o(t[e]))}),["fontStyle","fontFamily"].forEach(function(e){e in t&&(n.options[e]=t[e])}),v.push(n),v.length>100)throw new Error("Too many badges requests in queue.");C.start()}else C.reset()}catch(e){throw new Error("Error setting badge. Message: "+e.message)}},c&&y()},video:function(e){y=function(){try{if("stop"===e)return w=!0,C.reset(),void(w=!1);e.addEventListener("play",function(){t(this)},!1)}catch(e){throw new Error("Error setting video. Message: "+e.message)}},c&&y()},image:function(e){y=function(){try{var t=e.width,o=e.height,n=document.createElement("img"),r=o/a>t/l?t/l:o/a;n.setAttribute("crossOrigin","anonymous"),n.onload=function(){h.clearRect(0,0,l,a),h.drawImage(n,0,0,l,a),A.setIcon(s)},n.setAttribute("src",e.getAttribute("src")),n.height=o/r,n.width=t/r}catch(e){throw new Error("Error setting image. Message: "+e.message)}},c&&y()},webcam:function(e){if(window.URL&&window.URL.createObjectURL||(window.URL=window.URL||{},window.URL.createObjectURL=function(e){return e}),g.supported){var o=!1;navigator.getUserMedia=navigator.getUserMedia||navigator.oGetUserMedia||navigator.msGetUserMedia||navigator.mozGetUserMedia||navigator.webkitGetUserMedia,y=function(){try{if("stop"===e)return w=!0,C.reset(),void(w=!1);(o=document.createElement("video")).width=l,o.height=a,navigator.getUserMedia({video:!0,audio:!1},function(e){o.src=URL.createObjectURL(e),o.play(),t(o)},function(){})}catch(e){throw new Error("Error setting webcam. Message: "+e.message)}},c&&y()}},reset:C.reset,browser:{supported:g.supported}}};"undefined"!=typeof define&&define.amd?define([],function(){return e}):"undefined"!=typeof module&&module.exports?module.exports=e:this.Favico=e}();
+\ No newline at end of file
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\kasimi\\faviconnotifications/styles/all/template/js/faviconnotifications.bak.js" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\kasimi\\faviconnotifications/styles/all/template/js/faviconnotifications.bak.js"
+new file mode 100644
+index 000000000..15165fc80
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\kasimi\\faviconnotifications/styles/all/template/js/faviconnotifications.bak.js"
+@@ -0,0 +1,41 @@
++/**
++ *
++ * @package phpBB Extension - Favicon Notifications
++ * @copyright (c) 2016 kasimi
++ * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
++ *
++ */
++head.ready(function () {
++jQuery(function($) {
++	// Initialize favicon
++	var favicon = new Favico({
++		bgColor		: '#d00',
++		textColor	: '#fff',
++		fontFamily	: 'sans-serif',
++		fontStyle	: 'bold',
++		type		: 'circle',
++		position	: 'down',
++		animation	: 'popFade'
++	});
++
++	var setUnreadNotificationsCount = function(count) {
++		favicon.badge(count);
++	};
++
++	// Set initial notifications count
++	var unreadCount = parseInt($('em', '#notification_list_button').html());
++	setUnreadNotificationsCount(unreadCount);
++
++	// Update notifications count when marking notifications read
++	var phpbbMarkNotifications = phpbb.markNotifications;
++	phpbb.markNotifications = function($popup, unreadCount) {
++		setUnreadNotificationsCount(unreadCount);
++		return phpbbMarkNotifications($popup, unreadCount);
++	};
++
++	// Listen to notifications count updates from extensions
++	$(phpbb).on('kasimi_faviconnotifications_update', function(event, notificationsCount) {
++		setUnreadNotificationsCount(notificationsCount);
++	});
++});
++});
+\ No newline at end of file
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\kasimi\\faviconnotifications/styles/all/template/js/faviconnotifications.js" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\kasimi\\faviconnotifications/styles/all/template/js/faviconnotifications.js"
+index 6cd9ad975..4c0ae6b64 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\kasimi\\faviconnotifications/styles/all/template/js/faviconnotifications.js"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\kasimi\\faviconnotifications/styles/all/template/js/faviconnotifications.js"
+@@ -1,43 +1,8 @@
+ /**
+  *
+  * @package phpBB Extension - Favicon Notifications
+- * @copyright (c) 2016 kasimi - https://kasimi.net
++ * @copyright (c) 2016 kasimi
+  * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
+  *
+  */
+-
+-jQuery(function($) {
+-
+-	'use strict';
+-
+-	// Initialize favicon
+-	let favicon = new Favico({
+-		bgColor		: '#d00',
+-		textColor	: '#fff',
+-		fontFamily	: 'sans-serif',
+-		fontStyle	: 'bold',
+-		type		: 'circle',
+-		position	: 'up',
+-		animation	: 'popFade',
+-	});
+-
+-	let setUnreadNotificationsCount = function(count) {
+-		favicon.badge(count);
+-	};
+-
+-	// Set initial notifications count
+-	let unreadCount = parseInt($('strong', '#notification_list_button').html());
+-	setUnreadNotificationsCount(unreadCount);
+-
+-	// Update notifications count when marking notifications read
+-	let phpbbMarkNotifications = phpbb.markNotifications;
+-	phpbb.markNotifications = function($popup, unreadCount) {
+-		setUnreadNotificationsCount(unreadCount);
+-		return phpbbMarkNotifications($popup, unreadCount);
+-	};
+-
+-	// Listen to notifications count updates from extensions
+-	$(phpbb).on('kasimi_faviconnotifications_update', function(event, notificationsCount) {
+-		setUnreadNotificationsCount(notificationsCount);
+-	});
+-});
++jQuery(function(i){var n=new Favico({bgColor:"#d00",textColor:"#fff",fontFamily:"sans-serif",fontStyle:"bold",type:"circle",position:"down",animation:"popFade"}),o=function(i){n.badge(i)},t=parseInt(i("em","#notification_list_button").html());o(t);var a=phpbb.markNotifications;phpbb.markNotifications=function(i,n){return o(n),a(i,n)},i(phpbb).on("kasimi_faviconnotifications_update",function(i,n){o(n)})})
+\ No newline at end of file
diff --git "[FORUM_EXT]/kasimi\\faviconnotifications/diff_nospace.tmp" "[FORUM_EXT]/kasimi\\faviconnotifications/diff_nospace.tmp"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/kasimi\\faviconnotifications/diff_nospace.tmp"
@@ -0,0 +1,1245 @@
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\kasimi\\faviconnotifications/composer.json" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\kasimi\\faviconnotifications/composer.json"
+index d1ef011e4..be1fdfeb7 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\kasimi\\faviconnotifications/composer.json"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\kasimi\\faviconnotifications/composer.json"
+@@ -3,19 +3,20 @@
+     "type": "phpbb-extension",
+     "description": "Displays the number of new notifications in the favicon",
+     "homepage": "https://github.com/kasimi",
+-    "version": "1.0.1",
+-    "time": "2020-02-19",
+-    "license": "GPL-2.0-only",
++    "version": "1.0.0",
++    "time": "2016-08-23",
++    "license": "GPL-2.0",
+     "authors": [
+         {
+             "name": "kasimi",
+-            "email": "mail@kasimi.net",
+-            "homepage": "https://kasimi.net",
+-            "role": "Extension Developer"
++            "email": "",
++            "homepage": "https://www.phpbb.com/community/memberlist.php?mode=viewprofile&u=1330603",
++            "role": "Lead Developer"
+         }
+     ],
+     "require": {
+-        "php": ">=5.3.3"
++        "php": ">=5.3.3",
++        "phpbb/phpbb": ">=3.1.0@dev"
+     },
+     "extra": {
+         "display-name": "Favicon Notifications",
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\kasimi\\faviconnotifications/diff_full.tmp" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\kasimi\\faviconnotifications/diff_full.tmp"
+new file mode 100644
+index 000000000..2aa819f01
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\kasimi\\faviconnotifications/diff_full.tmp"
+@@ -0,0 +1,1295 @@
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\kasimi\\faviconnotifications/composer.json" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\kasimi\\faviconnotifications/composer.json"
++index d1ef011e4..be1fdfeb7 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\kasimi\\faviconnotifications/composer.json"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\kasimi\\faviconnotifications/composer.json"
++@@ -3,19 +3,20 @@
++     "type": "phpbb-extension",
++     "description": "Displays the number of new notifications in the favicon",
++     "homepage": "https://github.com/kasimi",
++-    "version": "1.0.1",
++-    "time": "2020-02-19",
++-    "license": "GPL-2.0-only",
+++    "version": "1.0.0",
+++    "time": "2016-08-23",
+++    "license": "GPL-2.0",
++     "authors": [
++         {
++             "name": "kasimi",
++-            "email": "mail@kasimi.net",
++-            "homepage": "https://kasimi.net",
++-            "role": "Extension Developer"
+++            "email": "",
+++            "homepage": "https://www.phpbb.com/community/memberlist.php?mode=viewprofile&u=1330603",
+++            "role": "Lead Developer"
++         }
++     ],
++     "require": {
++-        "php": ">=5.3.3"
+++        "php": ">=5.3.3",
+++        "phpbb/phpbb": ">=3.1.0@dev"
++     },
++     "extra": {
++         "display-name": "Favicon Notifications",
++@@ -28,4 +29,4 @@
++             "filename": "version_check"
++         }
++     }
++-}
+++}
++\ No newline at end of file
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\kasimi\\faviconnotifications/diff_full.tmp" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\kasimi\\faviconnotifications/diff_full.tmp"
++new file mode 100644
++index 000000000..e69de29bb
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\kasimi\\faviconnotifications/styles/BBOOTS/template/event/overall_header_head_append.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\kasimi\\faviconnotifications/styles/BBOOTS/template/event/overall_header_head_append.html"
++new file mode 100644
++index 000000000..7c674b05d
++--- /dev/null
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\kasimi\\faviconnotifications/styles/BBOOTS/template/event/overall_header_head_append.html"
++@@ -0,0 +1,4 @@
+++<!-- IF S_USER_LOGGED_IN and not S_IS_BOT -->
+++	<!-- INCLUDEJS js/favico-0.3.10.min.js -->
+++	<!-- INCLUDEJS js/faviconnotifications.js -->
+++<!-- ENDIF -->
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\kasimi\\faviconnotifications/styles/BBOOTS/template/js/favico-0.3.10.min.bak.js" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\kasimi\\faviconnotifications/styles/BBOOTS/template/js/favico-0.3.10.min.bak.js"
++new file mode 100644
++index 000000000..cd411658b
++--- /dev/null
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\kasimi\\faviconnotifications/styles/BBOOTS/template/js/favico-0.3.10.min.bak.js"
++@@ -0,0 +1,7 @@
+++/**
+++ * @license MIT
+++ * @fileOverview Favico animations
+++ * @author Miroslav Magda, http://blog.ejci.net
+++ * @version 0.3.10
+++ */
+++!function(){var e=function(e){"use strict";function t(e){if(e.paused||e.ended||g)return!1;try{f.clearRect(0,0,s,l),f.drawImage(e,0,0,s,l)}catch(o){}p=setTimeout(function(){t(e)},S.duration),O.setIcon(h)}function o(e){var t=/^#?([a-f\d])([a-f\d])([a-f\d])$/i;e=e.replace(t,function(e,t,o,n){return t+t+o+o+n+n});var o=/^#?([a-f\d]{2})([a-f\d]{2})([a-f\d]{2})$/i.exec(e);return o?{r:parseInt(o[1],16),g:parseInt(o[2],16),b:parseInt(o[3],16)}:!1}function n(e,t){var o,n={};for(o in e)n[o]=e[o];for(o in t)n[o]=t[o];return n}function r(){return b.hidden||b.msHidden||b.webkitHidden||b.mozHidden}e=e?e:{};var i,a,l,s,h,f,c,d,u,y,w,g,x,m,p,b,v={bgColor:"#d00",textColor:"#fff",fontFamily:"sans-serif",fontStyle:"bold",type:"circle",position:"down",animation:"slide",elementId:!1,dataUrl:!1,win:window};x={},x.ff="undefined"!=typeof InstallTrigger,x.chrome=!!window.chrome,x.opera=!!window.opera||navigator.userAgent.indexOf("Opera")>=0,x.ie=/*@cc_on!@*/!1,x.safari=Object.prototype.toString.call(window.HTMLElement).indexOf("Constructor")>0,x.supported=x.chrome||x.ff||x.opera;var C=[];w=function(){},d=g=!1;var E=function(){i=n(v,e),i.bgColor=o(i.bgColor),i.textColor=o(i.textColor),i.position=i.position.toLowerCase(),i.animation=S.types[""+i.animation]?i.animation:v.animation,b=i.win.document;var t=i.position.indexOf("up")>-1,r=i.position.indexOf("left")>-1;if(t||r)for(var d=0;d<S.types[""+i.animation].length;d++){var u=S.types[""+i.animation][d];t&&(u.y=u.y<.6?u.y-.4:u.y-2*u.y+(1-u.w)),r&&(u.x=u.x<.6?u.x-.4:u.x-2*u.x+(1-u.h)),S.types[""+i.animation][d]=u}i.type=A[""+i.type]?i.type:v.type,a=O.getIcon(),h=document.createElement("canvas"),c=document.createElement("img"),a.hasAttribute("href")?(c.setAttribute("crossOrigin","anonymous"),c.onload=function(){l=c.height>0?c.height:32,s=c.width>0?c.width:32,h.height=l,h.width=s,f=h.getContext("2d"),M.ready()},c.setAttribute("src",a.getAttribute("href"))):(c.onload=function(){l=32,s=32,c.height=l,c.width=s,h.height=l,h.width=s,f=h.getContext("2d"),M.ready()},c.setAttribute("src",""))},M={};M.ready=function(){d=!0,M.reset(),w()},M.reset=function(){d&&(C=[],u=!1,y=!1,f.clearRect(0,0,s,l),f.drawImage(c,0,0,s,l),O.setIcon(h),window.clearTimeout(m),window.clearTimeout(p))},M.start=function(){if(d&&!y){var e=function(){u=C[0],y=!1,C.length>0&&(C.shift(),M.start())};if(C.length>0){y=!0;var t=function(){["type","animation","bgColor","textColor","fontFamily","fontStyle"].forEach(function(e){e in C[0].options&&(i[e]=C[0].options[e])}),S.run(C[0].options,function(){e()},!1)};u?S.run(u.options,function(){t()},!0):t()}}};var A={},I=function(e){return e.n="number"==typeof e.n?Math.abs(0|e.n):e.n,e.x=s*e.x,e.y=l*e.y,e.w=s*e.w,e.h=l*e.h,e.len=(""+e.n).length,e};A.circle=function(e){e=I(e);var t=!1;2===e.len?(e.x=e.x-.4*e.w,e.w=1.4*e.w,t=!0):e.len>=3&&(e.x=e.x-.65*e.w,e.w=1.65*e.w,t=!0),f.clearRect(0,0,s,l),f.drawImage(c,0,0,s,l),f.beginPath(),f.font=i.fontStyle+" "+Math.floor(e.h*(e.n>99?.85:1))+"px "+i.fontFamily,f.textAlign="center",t?(f.moveTo(e.x+e.w/2,e.y),f.lineTo(e.x+e.w-e.h/2,e.y),f.quadraticCurveTo(e.x+e.w,e.y,e.x+e.w,e.y+e.h/2),f.lineTo(e.x+e.w,e.y+e.h-e.h/2),f.quadraticCurveTo(e.x+e.w,e.y+e.h,e.x+e.w-e.h/2,e.y+e.h),f.lineTo(e.x+e.h/2,e.y+e.h),f.quadraticCurveTo(e.x,e.y+e.h,e.x,e.y+e.h-e.h/2),f.lineTo(e.x,e.y+e.h/2),f.quadraticCurveTo(e.x,e.y,e.x+e.h/2,e.y)):f.arc(e.x+e.w/2,e.y+e.h/2,e.h/2,0,2*Math.PI),f.fillStyle="rgba("+i.bgColor.r+","+i.bgColor.g+","+i.bgColor.b+","+e.o+")",f.fill(),f.closePath(),f.beginPath(),f.stroke(),f.fillStyle="rgba("+i.textColor.r+","+i.textColor.g+","+i.textColor.b+","+e.o+")","number"==typeof e.n&&e.n>999?f.fillText((e.n>9999?9:Math.floor(e.n/1e3))+"k+",Math.floor(e.x+e.w/2),Math.floor(e.y+e.h-.2*e.h)):f.fillText(e.n,Math.floor(e.x+e.w/2),Math.floor(e.y+e.h-.15*e.h)),f.closePath()},A.rectangle=function(e){e=I(e);var t=!1;2===e.len?(e.x=e.x-.4*e.w,e.w=1.4*e.w,t=!0):e.len>=3&&(e.x=e.x-.65*e.w,e.w=1.65*e.w,t=!0),f.clearRect(0,0,s,l),f.drawImage(c,0,0,s,l),f.beginPath(),f.font=i.fontStyle+" "+Math.floor(e.h*(e.n>99?.9:1))+"px "+i.fontFamily,f.textAlign="center",f.fillStyle="rgba("+i.bgColor.r+","+i.bgColor.g+","+i.bgColor.b+","+e.o+")",f.fillRect(e.x,e.y,e.w,e.h),f.fillStyle="rgba("+i.textColor.r+","+i.textColor.g+","+i.textColor.b+","+e.o+")","number"==typeof e.n&&e.n>999?f.fillText((e.n>9999?9:Math.floor(e.n/1e3))+"k+",Math.floor(e.x+e.w/2),Math.floor(e.y+e.h-.2*e.h)):f.fillText(e.n,Math.floor(e.x+e.w/2),Math.floor(e.y+e.h-.15*e.h)),f.closePath()};var T=function(e,t){t=("string"==typeof t?{animation:t}:t)||{},w=function(){try{if("number"==typeof e?e>0:""!==e){var n={type:"badge",options:{n:e}};if("animation"in t&&S.types[""+t.animation]&&(n.options.animation=""+t.animation),"type"in t&&A[""+t.type]&&(n.options.type=""+t.type),["bgColor","textColor"].forEach(function(e){e in t&&(n.options[e]=o(t[e]))}),["fontStyle","fontFamily"].forEach(function(e){e in t&&(n.options[e]=t[e])}),C.push(n),C.length>100)throw new Error("Too many badges requests in queue.");M.start()}else M.reset()}catch(r){throw new Error("Error setting badge. Message: "+r.message)}},d&&w()},U=function(e){w=function(){try{var t=e.width,o=e.height,n=document.createElement("img"),r=o/l>t/s?t/s:o/l;n.setAttribute("crossOrigin","anonymous"),n.onload=function(){f.clearRect(0,0,s,l),f.drawImage(n,0,0,s,l),O.setIcon(h)},n.setAttribute("src",e.getAttribute("src")),n.height=o/r,n.width=t/r}catch(i){throw new Error("Error setting image. Message: "+i.message)}},d&&w()},R=function(e){w=function(){try{if("stop"===e)return g=!0,M.reset(),void(g=!1);e.addEventListener("play",function(){t(this)},!1)}catch(o){throw new Error("Error setting video. Message: "+o.message)}},d&&w()},L=function(e){if(window.URL&&window.URL.createObjectURL||(window.URL=window.URL||{},window.URL.createObjectURL=function(e){return e}),x.supported){var o=!1;navigator.getUserMedia=navigator.getUserMedia||navigator.oGetUserMedia||navigator.msGetUserMedia||navigator.mozGetUserMedia||navigator.webkitGetUserMedia,w=function(){try{if("stop"===e)return g=!0,M.reset(),void(g=!1);o=document.createElement("video"),o.width=s,o.height=l,navigator.getUserMedia({video:!0,audio:!1},function(e){o.src=URL.createObjectURL(e),o.play(),t(o)},function(){})}catch(n){throw new Error("Error setting webcam. Message: "+n.message)}},d&&w()}},O={};O.getIcon=function(){var e=!1,t=function(){for(var e=b.getElementsByTagName("head")[0].getElementsByTagName("link"),t=e.length,o=t-1;o>=0;o--)if(/(^|\s)icon(\s|$)/i.test(e[o].getAttribute("rel")))return e[o];return!1};return i.element?e=i.element:i.elementId?(e=b.getElementById(i.elementId),e.setAttribute("href",e.getAttribute("src"))):(e=t(),e===!1&&(e=b.createElement("link"),e.setAttribute("rel","icon"),b.getElementsByTagName("head")[0].appendChild(e))),e.setAttribute("type","image/png"),e},O.setIcon=function(e){var t=e.toDataURL("image/png");if(i.dataUrl&&i.dataUrl(t),i.element)i.element.setAttribute("href",t),i.element.setAttribute("src",t);else if(i.elementId){var o=b.getElementById(i.elementId);o.setAttribute("href",t),o.setAttribute("src",t)}else if(x.ff||x.opera){var n=a;a=b.createElement("link"),x.opera&&a.setAttribute("rel","icon"),a.setAttribute("rel","icon"),a.setAttribute("type","image/png"),b.getElementsByTagName("head")[0].appendChild(a),a.setAttribute("href",t),n.parentNode&&n.parentNode.removeChild(n)}else a.setAttribute("href",t)};var S={};return S.duration=40,S.types={},S.types.fade=[{x:.4,y:.4,w:.6,h:.6,o:0},{x:.4,y:.4,w:.6,h:.6,o:.1},{x:.4,y:.4,w:.6,h:.6,o:.2},{x:.4,y:.4,w:.6,h:.6,o:.3},{x:.4,y:.4,w:.6,h:.6,o:.4},{x:.4,y:.4,w:.6,h:.6,o:.5},{x:.4,y:.4,w:.6,h:.6,o:.6},{x:.4,y:.4,w:.6,h:.6,o:.7},{x:.4,y:.4,w:.6,h:.6,o:.8},{x:.4,y:.4,w:.6,h:.6,o:.9},{x:.4,y:.4,w:.6,h:.6,o:1}],S.types.none=[{x:.4,y:.4,w:.6,h:.6,o:1}],S.types.pop=[{x:1,y:1,w:0,h:0,o:1},{x:.9,y:.9,w:.1,h:.1,o:1},{x:.8,y:.8,w:.2,h:.2,o:1},{x:.7,y:.7,w:.3,h:.3,o:1},{x:.6,y:.6,w:.4,h:.4,o:1},{x:.5,y:.5,w:.5,h:.5,o:1},{x:.4,y:.4,w:.6,h:.6,o:1}],S.types.popFade=[{x:.75,y:.75,w:0,h:0,o:0},{x:.65,y:.65,w:.1,h:.1,o:.2},{x:.6,y:.6,w:.2,h:.2,o:.4},{x:.55,y:.55,w:.3,h:.3,o:.6},{x:.5,y:.5,w:.4,h:.4,o:.8},{x:.45,y:.45,w:.5,h:.5,o:.9},{x:.4,y:.4,w:.6,h:.6,o:1}],S.types.slide=[{x:.4,y:1,w:.6,h:.6,o:1},{x:.4,y:.9,w:.6,h:.6,o:1},{x:.4,y:.9,w:.6,h:.6,o:1},{x:.4,y:.8,w:.6,h:.6,o:1},{x:.4,y:.7,w:.6,h:.6,o:1},{x:.4,y:.6,w:.6,h:.6,o:1},{x:.4,y:.5,w:.6,h:.6,o:1},{x:.4,y:.4,w:.6,h:.6,o:1}],S.run=function(e,t,o,a){var l=S.types[r()?"none":i.animation];return a=o===!0?"undefined"!=typeof a?a:l.length-1:"undefined"!=typeof a?a:0,t=t?t:function(){},a<l.length&&a>=0?(A[i.type](n(e,l[a])),m=setTimeout(function(){o?a-=1:a+=1,S.run(e,t,o,a)},S.duration),O.setIcon(h),void 0):void t()},E(),{badge:T,video:R,image:U,webcam:L,reset:M.reset,browser:{supported:x.supported}}};"undefined"!=typeof define&&define.amd?define([],function(){return e}):"undefined"!=typeof module&&module.exports?module.exports=e:this.Favico=e}();
++\ No newline at end of file
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\kasimi\\faviconnotifications/styles/BBOOTS/template/js/favico-0.3.10.min.js" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\kasimi\\faviconnotifications/styles/BBOOTS/template/js/favico-0.3.10.min.js"
++new file mode 100644
++index 000000000..66ccf4740
++--- /dev/null
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\kasimi\\faviconnotifications/styles/BBOOTS/template/js/favico-0.3.10.min.js"
++@@ -0,0 +1,7 @@
+++/**
+++ * @license MIT
+++ * @fileOverview Favico animations
+++ * @author Miroslav Magda, http://blog.ejci.net
+++ * @version 0.3.10
+++ */
+++!function(){var e=function(e){"use strict";function t(e){if(e.paused||e.ended||w)return!1;try{h.clearRect(0,0,l,a),h.drawImage(e,0,0,l,a)}catch(e){}m=setTimeout(function(){t(e)},I.duration),A.setIcon(s)}function o(e){e=e.replace(/^#?([a-f\d])([a-f\d])([a-f\d])$/i,function(e,t,o,n){return t+t+o+o+n+n});var t=/^#?([a-f\d]{2})([a-f\d]{2})([a-f\d]{2})$/i.exec(e);return!!t&&{r:parseInt(t[1],16),g:parseInt(t[2],16),b:parseInt(t[3],16)}}function n(e,t){var o,n={};for(o in e)n[o]=e[o];for(o in t)n[o]=t[o];return n}e=e||{};var r,i,a,l,s,h,f,c,d,u,y,w,g,x,m,p,b={bgColor:"#d00",textColor:"#fff",fontFamily:"sans-serif",fontStyle:"bold",type:"circle",position:"down",animation:"slide",elementId:!1,dataUrl:!1,win:window};(g={}).ff="undefined"!=typeof InstallTrigger,g.chrome=!!window.chrome,g.opera=!!window.opera||navigator.userAgent.indexOf("Opera")>=0,g.ie=!1,g.safari=Object.prototype.toString.call(window.HTMLElement).indexOf("Constructor")>0,g.supported=g.chrome||g.ff||g.opera;var v=[];y=function(){},c=w=!1;var C={ready:function(){c=!0,C.reset(),y()},reset:function(){c&&(v=[],d=!1,u=!1,h.clearRect(0,0,l,a),h.drawImage(f,0,0,l,a),A.setIcon(s),window.clearTimeout(x),window.clearTimeout(m))}};C.start=function(){if(c&&!u){if(v.length>0){u=!0;var e=function(){["type","animation","bgColor","textColor","fontFamily","fontStyle"].forEach(function(e){e in v[0].options&&(r[e]=v[0].options[e])}),I.run(v[0].options,function(){d=v[0],u=!1,v.length>0&&(v.shift(),C.start())},!1)};d?I.run(d.options,function(){e()},!0):e()}}};var E={},M=function(e){return e.n="number"==typeof e.n?Math.abs(0|e.n):e.n,e.x=l*e.x,e.y=a*e.y,e.w=l*e.w,e.h=a*e.h,e.len=(""+e.n).length,e};E.circle=function(e){var t=!1;2===(e=M(e)).len?(e.x=e.x-.4*e.w,e.w=1.4*e.w,t=!0):e.len>=3&&(e.x=e.x-.65*e.w,e.w=1.65*e.w,t=!0),h.clearRect(0,0,l,a),h.drawImage(f,0,0,l,a),h.beginPath(),h.font=r.fontStyle+" "+Math.floor(e.h*(e.n>99?.85:1))+"px "+r.fontFamily,h.textAlign="center",t?(h.moveTo(e.x+e.w/2,e.y),h.lineTo(e.x+e.w-e.h/2,e.y),h.quadraticCurveTo(e.x+e.w,e.y,e.x+e.w,e.y+e.h/2),h.lineTo(e.x+e.w,e.y+e.h-e.h/2),h.quadraticCurveTo(e.x+e.w,e.y+e.h,e.x+e.w-e.h/2,e.y+e.h),h.lineTo(e.x+e.h/2,e.y+e.h),h.quadraticCurveTo(e.x,e.y+e.h,e.x,e.y+e.h-e.h/2),h.lineTo(e.x,e.y+e.h/2),h.quadraticCurveTo(e.x,e.y,e.x+e.h/2,e.y)):h.arc(e.x+e.w/2,e.y+e.h/2,e.h/2,0,2*Math.PI),h.fillStyle="rgba("+r.bgColor.r+","+r.bgColor.g+","+r.bgColor.b+","+e.o+")",h.fill(),h.closePath(),h.beginPath(),h.stroke(),h.fillStyle="rgba("+r.textColor.r+","+r.textColor.g+","+r.textColor.b+","+e.o+")","number"==typeof e.n&&e.n>999?h.fillText((e.n>9999?9:Math.floor(e.n/1e3))+"k+",Math.floor(e.x+e.w/2),Math.floor(e.y+e.h-.2*e.h)):h.fillText(e.n,Math.floor(e.x+e.w/2),Math.floor(e.y+e.h-.15*e.h)),h.closePath()},E.rectangle=function(e){2===(e=M(e)).len?(e.x=e.x-.4*e.w,e.w=1.4*e.w):e.len>=3&&(e.x=e.x-.65*e.w,e.w=1.65*e.w),h.clearRect(0,0,l,a),h.drawImage(f,0,0,l,a),h.beginPath(),h.font=r.fontStyle+" "+Math.floor(e.h*(e.n>99?.9:1))+"px "+r.fontFamily,h.textAlign="center",h.fillStyle="rgba("+r.bgColor.r+","+r.bgColor.g+","+r.bgColor.b+","+e.o+")",h.fillRect(e.x,e.y,e.w,e.h),h.fillStyle="rgba("+r.textColor.r+","+r.textColor.g+","+r.textColor.b+","+e.o+")","number"==typeof e.n&&e.n>999?h.fillText((e.n>9999?9:Math.floor(e.n/1e3))+"k+",Math.floor(e.x+e.w/2),Math.floor(e.y+e.h-.2*e.h)):h.fillText(e.n,Math.floor(e.x+e.w/2),Math.floor(e.y+e.h-.15*e.h)),h.closePath()};var A={getIcon:function(){var e=!1;return r.element?e=r.element:r.elementId?(e=p.getElementById(r.elementId)).setAttribute("href",e.getAttribute("src")):!1===(e=function(){for(var e=p.getElementsByTagName("head")[0].getElementsByTagName("link"),t=e.length-1;t>=0;t--)if(/(^|\s)icon(\s|$)/i.test(e[t].getAttribute("rel")))return e[t];return!1}())&&((e=p.createElement("link")).setAttribute("rel","icon"),p.getElementsByTagName("head")[0].appendChild(e)),e.setAttribute("type","image/png"),e},setIcon:function(e){var t=e.toDataURL("image/png");if(r.dataUrl&&r.dataUrl(t),r.element)r.element.setAttribute("href",t),r.element.setAttribute("src",t);else if(r.elementId){var o=p.getElementById(r.elementId);o.setAttribute("href",t),o.setAttribute("src",t)}else if(g.ff||g.opera){var n=i;i=p.createElement("link"),g.opera&&i.setAttribute("rel","icon"),i.setAttribute("rel","icon"),i.setAttribute("type","image/png"),p.getElementsByTagName("head")[0].appendChild(i),i.setAttribute("href",t),n.parentNode&&n.parentNode.removeChild(n)}else i.setAttribute("href",t)}},I={duration:40,types:{}};return I.types.fade=[{x:.4,y:.4,w:.6,h:.6,o:0},{x:.4,y:.4,w:.6,h:.6,o:.1},{x:.4,y:.4,w:.6,h:.6,o:.2},{x:.4,y:.4,w:.6,h:.6,o:.3},{x:.4,y:.4,w:.6,h:.6,o:.4},{x:.4,y:.4,w:.6,h:.6,o:.5},{x:.4,y:.4,w:.6,h:.6,o:.6},{x:.4,y:.4,w:.6,h:.6,o:.7},{x:.4,y:.4,w:.6,h:.6,o:.8},{x:.4,y:.4,w:.6,h:.6,o:.9},{x:.4,y:.4,w:.6,h:.6,o:1}],I.types.none=[{x:.4,y:.4,w:.6,h:.6,o:1}],I.types.pop=[{x:1,y:1,w:0,h:0,o:1},{x:.9,y:.9,w:.1,h:.1,o:1},{x:.8,y:.8,w:.2,h:.2,o:1},{x:.7,y:.7,w:.3,h:.3,o:1},{x:.6,y:.6,w:.4,h:.4,o:1},{x:.5,y:.5,w:.5,h:.5,o:1},{x:.4,y:.4,w:.6,h:.6,o:1}],I.types.popFade=[{x:.75,y:.75,w:0,h:0,o:0},{x:.65,y:.65,w:.1,h:.1,o:.2},{x:.6,y:.6,w:.2,h:.2,o:.4},{x:.55,y:.55,w:.3,h:.3,o:.6},{x:.5,y:.5,w:.4,h:.4,o:.8},{x:.45,y:.45,w:.5,h:.5,o:.9},{x:.4,y:.4,w:.6,h:.6,o:1}],I.types.slide=[{x:.4,y:1,w:.6,h:.6,o:1},{x:.4,y:.9,w:.6,h:.6,o:1},{x:.4,y:.9,w:.6,h:.6,o:1},{x:.4,y:.8,w:.6,h:.6,o:1},{x:.4,y:.7,w:.6,h:.6,o:1},{x:.4,y:.6,w:.6,h:.6,o:1},{x:.4,y:.5,w:.6,h:.6,o:1},{x:.4,y:.4,w:.6,h:.6,o:1}],I.run=function(e,t,o,i){var a=I.types[p.hidden||p.msHidden||p.webkitHidden||p.mozHidden?"none":r.animation];return i=!0===o?void 0!==i?i:a.length-1:void 0!==i?i:0,t=t||function(){},i<a.length&&i>=0?(E[r.type](n(e,a[i])),x=setTimeout(function(){o?i-=1:i+=1,I.run(e,t,o,i)},I.duration),void A.setIcon(s)):void t()},function(){(r=n(b,e)).bgColor=o(r.bgColor),r.textColor=o(r.textColor),r.position=r.position.toLowerCase(),r.animation=I.types[""+r.animation]?r.animation:b.animation,p=r.win.document;var t=r.position.indexOf("up")>-1,c=r.position.indexOf("left")>-1;if(t||c)for(var d=0;d<I.types[""+r.animation].length;d++){var u=I.types[""+r.animation][d];t&&(u.y=u.y<.6?u.y-.4:u.y-2*u.y+(1-u.w)),c&&(u.x=u.x<.6?u.x-.4:u.x-2*u.x+(1-u.h)),I.types[""+r.animation][d]=u}r.type=E[""+r.type]?r.type:b.type,i=A.getIcon(),s=document.createElement("canvas"),f=document.createElement("img"),i.hasAttribute("href")?(f.setAttribute("crossOrigin","anonymous"),f.onload=function(){a=f.height>0?f.height:32,l=f.width>0?f.width:32,s.height=a,s.width=l,h=s.getContext("2d"),C.ready()},f.setAttribute("src",i.getAttribute("href"))):(f.onload=function(){a=32,l=32,f.height=a,f.width=l,s.height=a,s.width=l,h=s.getContext("2d"),C.ready()},f.setAttribute("src",""))}(),{badge:function(e,t){t=("string"==typeof t?{animation:t}:t)||{},y=function(){try{if("number"==typeof e?e>0:""!==e){var n={type:"badge",options:{n:e}};if("animation"in t&&I.types[""+t.animation]&&(n.options.animation=""+t.animation),"type"in t&&E[""+t.type]&&(n.options.type=""+t.type),["bgColor","textColor"].forEach(function(e){e in t&&(n.options[e]=o(t[e]))}),["fontStyle","fontFamily"].forEach(function(e){e in t&&(n.options[e]=t[e])}),v.push(n),v.length>100)throw new Error("Too many badges requests in queue.");C.start()}else C.reset()}catch(e){throw new Error("Error setting badge. Message: "+e.message)}},c&&y()},video:function(e){y=function(){try{if("stop"===e)return w=!0,C.reset(),void(w=!1);e.addEventListener("play",function(){t(this)},!1)}catch(e){throw new Error("Error setting video. Message: "+e.message)}},c&&y()},image:function(e){y=function(){try{var t=e.width,o=e.height,n=document.createElement("img"),r=o/a>t/l?t/l:o/a;n.setAttribute("crossOrigin","anonymous"),n.onload=function(){h.clearRect(0,0,l,a),h.drawImage(n,0,0,l,a),A.setIcon(s)},n.setAttribute("src",e.getAttribute("src")),n.height=o/r,n.width=t/r}catch(e){throw new Error("Error setting image. Message: "+e.message)}},c&&y()},webcam:function(e){if(window.URL&&window.URL.createObjectURL||(window.URL=window.URL||{},window.URL.createObjectURL=function(e){return e}),g.supported){var o=!1;navigator.getUserMedia=navigator.getUserMedia||navigator.oGetUserMedia||navigator.msGetUserMedia||navigator.mozGetUserMedia||navigator.webkitGetUserMedia,y=function(){try{if("stop"===e)return w=!0,C.reset(),void(w=!1);(o=document.createElement("video")).width=l,o.height=a,navigator.getUserMedia({video:!0,audio:!1},function(e){o.src=URL.createObjectURL(e),o.play(),t(o)},function(){})}catch(e){throw new Error("Error setting webcam. Message: "+e.message)}},c&&y()}},reset:C.reset,browser:{supported:g.supported}}};"undefined"!=typeof define&&define.amd?define([],function(){return e}):"undefined"!=typeof module&&module.exports?module.exports=e:this.Favico=e}();
++\ No newline at end of file
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\kasimi\\faviconnotifications/styles/BBOOTS/template/js/faviconnotifications.bak.js" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\kasimi\\faviconnotifications/styles/BBOOTS/template/js/faviconnotifications.bak.js"
++new file mode 100644
++index 000000000..15165fc80
++--- /dev/null
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\kasimi\\faviconnotifications/styles/BBOOTS/template/js/faviconnotifications.bak.js"
++@@ -0,0 +1,41 @@
+++/**
+++ *
+++ * @package phpBB Extension - Favicon Notifications
+++ * @copyright (c) 2016 kasimi
+++ * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
+++ *
+++ */
+++head.ready(function () {
+++jQuery(function($) {
+++	// Initialize favicon
+++	var favicon = new Favico({
+++		bgColor		: '#d00',
+++		textColor	: '#fff',
+++		fontFamily	: 'sans-serif',
+++		fontStyle	: 'bold',
+++		type		: 'circle',
+++		position	: 'down',
+++		animation	: 'popFade'
+++	});
+++
+++	var setUnreadNotificationsCount = function(count) {
+++		favicon.badge(count);
+++	};
+++
+++	// Set initial notifications count
+++	var unreadCount = parseInt($('em', '#notification_list_button').html());
+++	setUnreadNotificationsCount(unreadCount);
+++
+++	// Update notifications count when marking notifications read
+++	var phpbbMarkNotifications = phpbb.markNotifications;
+++	phpbb.markNotifications = function($popup, unreadCount) {
+++		setUnreadNotificationsCount(unreadCount);
+++		return phpbbMarkNotifications($popup, unreadCount);
+++	};
+++
+++	// Listen to notifications count updates from extensions
+++	$(phpbb).on('kasimi_faviconnotifications_update', function(event, notificationsCount) {
+++		setUnreadNotificationsCount(notificationsCount);
+++	});
+++});
+++});
++\ No newline at end of file
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\kasimi\\faviconnotifications/styles/BBOOTS/template/js/faviconnotifications.js" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\kasimi\\faviconnotifications/styles/BBOOTS/template/js/faviconnotifications.js"
++new file mode 100644
++index 000000000..21f4d69dc
++--- /dev/null
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\kasimi\\faviconnotifications/styles/BBOOTS/template/js/faviconnotifications.js"
++@@ -0,0 +1,8 @@
+++/**
+++ *
+++ * @package phpBB Extension - Favicon Notifications
+++ * @copyright (c) 2016 kasimi
+++ * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
+++ *
+++ */
+++head.ready(function(){jQuery(function(i){var n=new Favico({bgColor:"#d00",textColor:"#fff",fontFamily:"sans-serif",fontStyle:"bold",type:"circle",position:"down",animation:"popFade"}),o=function(i){n.badge(i)},t=parseInt(i("em","#notification_list_button").html());o(t);var a=phpbb.markNotifications;phpbb.markNotifications=function(i,n){return o(n),a(i,n)},i(phpbb).on("kasimi_faviconnotifications_update",function(i,n){o(n)})})});
++\ No newline at end of file
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\kasimi\\faviconnotifications/styles/FLATBOOTS/template/event/overall_header_head_append.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\kasimi\\faviconnotifications/styles/FLATBOOTS/template/event/overall_header_head_append.html"
++new file mode 100644
++index 000000000..7c674b05d
++--- /dev/null
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\kasimi\\faviconnotifications/styles/FLATBOOTS/template/event/overall_header_head_append.html"
++@@ -0,0 +1,4 @@
+++<!-- IF S_USER_LOGGED_IN and not S_IS_BOT -->
+++	<!-- INCLUDEJS js/favico-0.3.10.min.js -->
+++	<!-- INCLUDEJS js/faviconnotifications.js -->
+++<!-- ENDIF -->
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\kasimi\\faviconnotifications/styles/FLATBOOTS/template/js/favico-0.3.10.min.bak.js" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\kasimi\\faviconnotifications/styles/FLATBOOTS/template/js/favico-0.3.10.min.bak.js"
++new file mode 100644
++index 000000000..cd411658b
++--- /dev/null
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\kasimi\\faviconnotifications/styles/FLATBOOTS/template/js/favico-0.3.10.min.bak.js"
++@@ -0,0 +1,7 @@
+++/**
+++ * @license MIT
+++ * @fileOverview Favico animations
+++ * @author Miroslav Magda, http://blog.ejci.net
+++ * @version 0.3.10
+++ */
+++!function(){var e=function(e){"use strict";function t(e){if(e.paused||e.ended||g)return!1;try{f.clearRect(0,0,s,l),f.drawImage(e,0,0,s,l)}catch(o){}p=setTimeout(function(){t(e)},S.duration),O.setIcon(h)}function o(e){var t=/^#?([a-f\d])([a-f\d])([a-f\d])$/i;e=e.replace(t,function(e,t,o,n){return t+t+o+o+n+n});var o=/^#?([a-f\d]{2})([a-f\d]{2})([a-f\d]{2})$/i.exec(e);return o?{r:parseInt(o[1],16),g:parseInt(o[2],16),b:parseInt(o[3],16)}:!1}function n(e,t){var o,n={};for(o in e)n[o]=e[o];for(o in t)n[o]=t[o];return n}function r(){return b.hidden||b.msHidden||b.webkitHidden||b.mozHidden}e=e?e:{};var i,a,l,s,h,f,c,d,u,y,w,g,x,m,p,b,v={bgColor:"#d00",textColor:"#fff",fontFamily:"sans-serif",fontStyle:"bold",type:"circle",position:"down",animation:"slide",elementId:!1,dataUrl:!1,win:window};x={},x.ff="undefined"!=typeof InstallTrigger,x.chrome=!!window.chrome,x.opera=!!window.opera||navigator.userAgent.indexOf("Opera")>=0,x.ie=/*@cc_on!@*/!1,x.safari=Object.prototype.toString.call(window.HTMLElement).indexOf("Constructor")>0,x.supported=x.chrome||x.ff||x.opera;var C=[];w=function(){},d=g=!1;var E=function(){i=n(v,e),i.bgColor=o(i.bgColor),i.textColor=o(i.textColor),i.position=i.position.toLowerCase(),i.animation=S.types[""+i.animation]?i.animation:v.animation,b=i.win.document;var t=i.position.indexOf("up")>-1,r=i.position.indexOf("left")>-1;if(t||r)for(var d=0;d<S.types[""+i.animation].length;d++){var u=S.types[""+i.animation][d];t&&(u.y=u.y<.6?u.y-.4:u.y-2*u.y+(1-u.w)),r&&(u.x=u.x<.6?u.x-.4:u.x-2*u.x+(1-u.h)),S.types[""+i.animation][d]=u}i.type=A[""+i.type]?i.type:v.type,a=O.getIcon(),h=document.createElement("canvas"),c=document.createElement("img"),a.hasAttribute("href")?(c.setAttribute("crossOrigin","anonymous"),c.onload=function(){l=c.height>0?c.height:32,s=c.width>0?c.width:32,h.height=l,h.width=s,f=h.getContext("2d"),M.ready()},c.setAttribute("src",a.getAttribute("href"))):(c.onload=function(){l=32,s=32,c.height=l,c.width=s,h.height=l,h.width=s,f=h.getContext("2d"),M.ready()},c.setAttribute("src",""))},M={};M.ready=function(){d=!0,M.reset(),w()},M.reset=function(){d&&(C=[],u=!1,y=!1,f.clearRect(0,0,s,l),f.drawImage(c,0,0,s,l),O.setIcon(h),window.clearTimeout(m),window.clearTimeout(p))},M.start=function(){if(d&&!y){var e=function(){u=C[0],y=!1,C.length>0&&(C.shift(),M.start())};if(C.length>0){y=!0;var t=function(){["type","animation","bgColor","textColor","fontFamily","fontStyle"].forEach(function(e){e in C[0].options&&(i[e]=C[0].options[e])}),S.run(C[0].options,function(){e()},!1)};u?S.run(u.options,function(){t()},!0):t()}}};var A={},I=function(e){return e.n="number"==typeof e.n?Math.abs(0|e.n):e.n,e.x=s*e.x,e.y=l*e.y,e.w=s*e.w,e.h=l*e.h,e.len=(""+e.n).length,e};A.circle=function(e){e=I(e);var t=!1;2===e.len?(e.x=e.x-.4*e.w,e.w=1.4*e.w,t=!0):e.len>=3&&(e.x=e.x-.65*e.w,e.w=1.65*e.w,t=!0),f.clearRect(0,0,s,l),f.drawImage(c,0,0,s,l),f.beginPath(),f.font=i.fontStyle+" "+Math.floor(e.h*(e.n>99?.85:1))+"px "+i.fontFamily,f.textAlign="center",t?(f.moveTo(e.x+e.w/2,e.y),f.lineTo(e.x+e.w-e.h/2,e.y),f.quadraticCurveTo(e.x+e.w,e.y,e.x+e.w,e.y+e.h/2),f.lineTo(e.x+e.w,e.y+e.h-e.h/2),f.quadraticCurveTo(e.x+e.w,e.y+e.h,e.x+e.w-e.h/2,e.y+e.h),f.lineTo(e.x+e.h/2,e.y+e.h),f.quadraticCurveTo(e.x,e.y+e.h,e.x,e.y+e.h-e.h/2),f.lineTo(e.x,e.y+e.h/2),f.quadraticCurveTo(e.x,e.y,e.x+e.h/2,e.y)):f.arc(e.x+e.w/2,e.y+e.h/2,e.h/2,0,2*Math.PI),f.fillStyle="rgba("+i.bgColor.r+","+i.bgColor.g+","+i.bgColor.b+","+e.o+")",f.fill(),f.closePath(),f.beginPath(),f.stroke(),f.fillStyle="rgba("+i.textColor.r+","+i.textColor.g+","+i.textColor.b+","+e.o+")","number"==typeof e.n&&e.n>999?f.fillText((e.n>9999?9:Math.floor(e.n/1e3))+"k+",Math.floor(e.x+e.w/2),Math.floor(e.y+e.h-.2*e.h)):f.fillText(e.n,Math.floor(e.x+e.w/2),Math.floor(e.y+e.h-.15*e.h)),f.closePath()},A.rectangle=function(e){e=I(e);var t=!1;2===e.len?(e.x=e.x-.4*e.w,e.w=1.4*e.w,t=!0):e.len>=3&&(e.x=e.x-.65*e.w,e.w=1.65*e.w,t=!0),f.clearRect(0,0,s,l),f.drawImage(c,0,0,s,l),f.beginPath(),f.font=i.fontStyle+" "+Math.floor(e.h*(e.n>99?.9:1))+"px "+i.fontFamily,f.textAlign="center",f.fillStyle="rgba("+i.bgColor.r+","+i.bgColor.g+","+i.bgColor.b+","+e.o+")",f.fillRect(e.x,e.y,e.w,e.h),f.fillStyle="rgba("+i.textColor.r+","+i.textColor.g+","+i.textColor.b+","+e.o+")","number"==typeof e.n&&e.n>999?f.fillText((e.n>9999?9:Math.floor(e.n/1e3))+"k+",Math.floor(e.x+e.w/2),Math.floor(e.y+e.h-.2*e.h)):f.fillText(e.n,Math.floor(e.x+e.w/2),Math.floor(e.y+e.h-.15*e.h)),f.closePath()};var T=function(e,t){t=("string"==typeof t?{animation:t}:t)||{},w=function(){try{if("number"==typeof e?e>0:""!==e){var n={type:"badge",options:{n:e}};if("animation"in t&&S.types[""+t.animation]&&(n.options.animation=""+t.animation),"type"in t&&A[""+t.type]&&(n.options.type=""+t.type),["bgColor","textColor"].forEach(function(e){e in t&&(n.options[e]=o(t[e]))}),["fontStyle","fontFamily"].forEach(function(e){e in t&&(n.options[e]=t[e])}),C.push(n),C.length>100)throw new Error("Too many badges requests in queue.");M.start()}else M.reset()}catch(r){throw new Error("Error setting badge. Message: "+r.message)}},d&&w()},U=function(e){w=function(){try{var t=e.width,o=e.height,n=document.createElement("img"),r=o/l>t/s?t/s:o/l;n.setAttribute("crossOrigin","anonymous"),n.onload=function(){f.clearRect(0,0,s,l),f.drawImage(n,0,0,s,l),O.setIcon(h)},n.setAttribute("src",e.getAttribute("src")),n.height=o/r,n.width=t/r}catch(i){throw new Error("Error setting image. Message: "+i.message)}},d&&w()},R=function(e){w=function(){try{if("stop"===e)return g=!0,M.reset(),void(g=!1);e.addEventListener("play",function(){t(this)},!1)}catch(o){throw new Error("Error setting video. Message: "+o.message)}},d&&w()},L=function(e){if(window.URL&&window.URL.createObjectURL||(window.URL=window.URL||{},window.URL.createObjectURL=function(e){return e}),x.supported){var o=!1;navigator.getUserMedia=navigator.getUserMedia||navigator.oGetUserMedia||navigator.msGetUserMedia||navigator.mozGetUserMedia||navigator.webkitGetUserMedia,w=function(){try{if("stop"===e)return g=!0,M.reset(),void(g=!1);o=document.createElement("video"),o.width=s,o.height=l,navigator.getUserMedia({video:!0,audio:!1},function(e){o.src=URL.createObjectURL(e),o.play(),t(o)},function(){})}catch(n){throw new Error("Error setting webcam. Message: "+n.message)}},d&&w()}},O={};O.getIcon=function(){var e=!1,t=function(){for(var e=b.getElementsByTagName("head")[0].getElementsByTagName("link"),t=e.length,o=t-1;o>=0;o--)if(/(^|\s)icon(\s|$)/i.test(e[o].getAttribute("rel")))return e[o];return!1};return i.element?e=i.element:i.elementId?(e=b.getElementById(i.elementId),e.setAttribute("href",e.getAttribute("src"))):(e=t(),e===!1&&(e=b.createElement("link"),e.setAttribute("rel","icon"),b.getElementsByTagName("head")[0].appendChild(e))),e.setAttribute("type","image/png"),e},O.setIcon=function(e){var t=e.toDataURL("image/png");if(i.dataUrl&&i.dataUrl(t),i.element)i.element.setAttribute("href",t),i.element.setAttribute("src",t);else if(i.elementId){var o=b.getElementById(i.elementId);o.setAttribute("href",t),o.setAttribute("src",t)}else if(x.ff||x.opera){var n=a;a=b.createElement("link"),x.opera&&a.setAttribute("rel","icon"),a.setAttribute("rel","icon"),a.setAttribute("type","image/png"),b.getElementsByTagName("head")[0].appendChild(a),a.setAttribute("href",t),n.parentNode&&n.parentNode.removeChild(n)}else a.setAttribute("href",t)};var S={};return S.duration=40,S.types={},S.types.fade=[{x:.4,y:.4,w:.6,h:.6,o:0},{x:.4,y:.4,w:.6,h:.6,o:.1},{x:.4,y:.4,w:.6,h:.6,o:.2},{x:.4,y:.4,w:.6,h:.6,o:.3},{x:.4,y:.4,w:.6,h:.6,o:.4},{x:.4,y:.4,w:.6,h:.6,o:.5},{x:.4,y:.4,w:.6,h:.6,o:.6},{x:.4,y:.4,w:.6,h:.6,o:.7},{x:.4,y:.4,w:.6,h:.6,o:.8},{x:.4,y:.4,w:.6,h:.6,o:.9},{x:.4,y:.4,w:.6,h:.6,o:1}],S.types.none=[{x:.4,y:.4,w:.6,h:.6,o:1}],S.types.pop=[{x:1,y:1,w:0,h:0,o:1},{x:.9,y:.9,w:.1,h:.1,o:1},{x:.8,y:.8,w:.2,h:.2,o:1},{x:.7,y:.7,w:.3,h:.3,o:1},{x:.6,y:.6,w:.4,h:.4,o:1},{x:.5,y:.5,w:.5,h:.5,o:1},{x:.4,y:.4,w:.6,h:.6,o:1}],S.types.popFade=[{x:.75,y:.75,w:0,h:0,o:0},{x:.65,y:.65,w:.1,h:.1,o:.2},{x:.6,y:.6,w:.2,h:.2,o:.4},{x:.55,y:.55,w:.3,h:.3,o:.6},{x:.5,y:.5,w:.4,h:.4,o:.8},{x:.45,y:.45,w:.5,h:.5,o:.9},{x:.4,y:.4,w:.6,h:.6,o:1}],S.types.slide=[{x:.4,y:1,w:.6,h:.6,o:1},{x:.4,y:.9,w:.6,h:.6,o:1},{x:.4,y:.9,w:.6,h:.6,o:1},{x:.4,y:.8,w:.6,h:.6,o:1},{x:.4,y:.7,w:.6,h:.6,o:1},{x:.4,y:.6,w:.6,h:.6,o:1},{x:.4,y:.5,w:.6,h:.6,o:1},{x:.4,y:.4,w:.6,h:.6,o:1}],S.run=function(e,t,o,a){var l=S.types[r()?"none":i.animation];return a=o===!0?"undefined"!=typeof a?a:l.length-1:"undefined"!=typeof a?a:0,t=t?t:function(){},a<l.length&&a>=0?(A[i.type](n(e,l[a])),m=setTimeout(function(){o?a-=1:a+=1,S.run(e,t,o,a)},S.duration),O.setIcon(h),void 0):void t()},E(),{badge:T,video:R,image:U,webcam:L,reset:M.reset,browser:{supported:x.supported}}};"undefined"!=typeof define&&define.amd?define([],function(){return e}):"undefined"!=typeof module&&module.exports?module.exports=e:this.Favico=e}();
++\ No newline at end of file
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\kasimi\\faviconnotifications/styles/FLATBOOTS/template/js/favico-0.3.10.min.js" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\kasimi\\faviconnotifications/styles/FLATBOOTS/template/js/favico-0.3.10.min.js"
++new file mode 100644
++index 000000000..66ccf4740
++--- /dev/null
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\kasimi\\faviconnotifications/styles/FLATBOOTS/template/js/favico-0.3.10.min.js"
++@@ -0,0 +1,7 @@
+++/**
+++ * @license MIT
+++ * @fileOverview Favico animations
+++ * @author Miroslav Magda, http://blog.ejci.net
+++ * @version 0.3.10
+++ */
+++!function(){var e=function(e){"use strict";function t(e){if(e.paused||e.ended||w)return!1;try{h.clearRect(0,0,l,a),h.drawImage(e,0,0,l,a)}catch(e){}m=setTimeout(function(){t(e)},I.duration),A.setIcon(s)}function o(e){e=e.replace(/^#?([a-f\d])([a-f\d])([a-f\d])$/i,function(e,t,o,n){return t+t+o+o+n+n});var t=/^#?([a-f\d]{2})([a-f\d]{2})([a-f\d]{2})$/i.exec(e);return!!t&&{r:parseInt(t[1],16),g:parseInt(t[2],16),b:parseInt(t[3],16)}}function n(e,t){var o,n={};for(o in e)n[o]=e[o];for(o in t)n[o]=t[o];return n}e=e||{};var r,i,a,l,s,h,f,c,d,u,y,w,g,x,m,p,b={bgColor:"#d00",textColor:"#fff",fontFamily:"sans-serif",fontStyle:"bold",type:"circle",position:"down",animation:"slide",elementId:!1,dataUrl:!1,win:window};(g={}).ff="undefined"!=typeof InstallTrigger,g.chrome=!!window.chrome,g.opera=!!window.opera||navigator.userAgent.indexOf("Opera")>=0,g.ie=!1,g.safari=Object.prototype.toString.call(window.HTMLElement).indexOf("Constructor")>0,g.supported=g.chrome||g.ff||g.opera;var v=[];y=function(){},c=w=!1;var C={ready:function(){c=!0,C.reset(),y()},reset:function(){c&&(v=[],d=!1,u=!1,h.clearRect(0,0,l,a),h.drawImage(f,0,0,l,a),A.setIcon(s),window.clearTimeout(x),window.clearTimeout(m))}};C.start=function(){if(c&&!u){if(v.length>0){u=!0;var e=function(){["type","animation","bgColor","textColor","fontFamily","fontStyle"].forEach(function(e){e in v[0].options&&(r[e]=v[0].options[e])}),I.run(v[0].options,function(){d=v[0],u=!1,v.length>0&&(v.shift(),C.start())},!1)};d?I.run(d.options,function(){e()},!0):e()}}};var E={},M=function(e){return e.n="number"==typeof e.n?Math.abs(0|e.n):e.n,e.x=l*e.x,e.y=a*e.y,e.w=l*e.w,e.h=a*e.h,e.len=(""+e.n).length,e};E.circle=function(e){var t=!1;2===(e=M(e)).len?(e.x=e.x-.4*e.w,e.w=1.4*e.w,t=!0):e.len>=3&&(e.x=e.x-.65*e.w,e.w=1.65*e.w,t=!0),h.clearRect(0,0,l,a),h.drawImage(f,0,0,l,a),h.beginPath(),h.font=r.fontStyle+" "+Math.floor(e.h*(e.n>99?.85:1))+"px "+r.fontFamily,h.textAlign="center",t?(h.moveTo(e.x+e.w/2,e.y),h.lineTo(e.x+e.w-e.h/2,e.y),h.quadraticCurveTo(e.x+e.w,e.y,e.x+e.w,e.y+e.h/2),h.lineTo(e.x+e.w,e.y+e.h-e.h/2),h.quadraticCurveTo(e.x+e.w,e.y+e.h,e.x+e.w-e.h/2,e.y+e.h),h.lineTo(e.x+e.h/2,e.y+e.h),h.quadraticCurveTo(e.x,e.y+e.h,e.x,e.y+e.h-e.h/2),h.lineTo(e.x,e.y+e.h/2),h.quadraticCurveTo(e.x,e.y,e.x+e.h/2,e.y)):h.arc(e.x+e.w/2,e.y+e.h/2,e.h/2,0,2*Math.PI),h.fillStyle="rgba("+r.bgColor.r+","+r.bgColor.g+","+r.bgColor.b+","+e.o+")",h.fill(),h.closePath(),h.beginPath(),h.stroke(),h.fillStyle="rgba("+r.textColor.r+","+r.textColor.g+","+r.textColor.b+","+e.o+")","number"==typeof e.n&&e.n>999?h.fillText((e.n>9999?9:Math.floor(e.n/1e3))+"k+",Math.floor(e.x+e.w/2),Math.floor(e.y+e.h-.2*e.h)):h.fillText(e.n,Math.floor(e.x+e.w/2),Math.floor(e.y+e.h-.15*e.h)),h.closePath()},E.rectangle=function(e){2===(e=M(e)).len?(e.x=e.x-.4*e.w,e.w=1.4*e.w):e.len>=3&&(e.x=e.x-.65*e.w,e.w=1.65*e.w),h.clearRect(0,0,l,a),h.drawImage(f,0,0,l,a),h.beginPath(),h.font=r.fontStyle+" "+Math.floor(e.h*(e.n>99?.9:1))+"px "+r.fontFamily,h.textAlign="center",h.fillStyle="rgba("+r.bgColor.r+","+r.bgColor.g+","+r.bgColor.b+","+e.o+")",h.fillRect(e.x,e.y,e.w,e.h),h.fillStyle="rgba("+r.textColor.r+","+r.textColor.g+","+r.textColor.b+","+e.o+")","number"==typeof e.n&&e.n>999?h.fillText((e.n>9999?9:Math.floor(e.n/1e3))+"k+",Math.floor(e.x+e.w/2),Math.floor(e.y+e.h-.2*e.h)):h.fillText(e.n,Math.floor(e.x+e.w/2),Math.floor(e.y+e.h-.15*e.h)),h.closePath()};var A={getIcon:function(){var e=!1;return r.element?e=r.element:r.elementId?(e=p.getElementById(r.elementId)).setAttribute("href",e.getAttribute("src")):!1===(e=function(){for(var e=p.getElementsByTagName("head")[0].getElementsByTagName("link"),t=e.length-1;t>=0;t--)if(/(^|\s)icon(\s|$)/i.test(e[t].getAttribute("rel")))return e[t];return!1}())&&((e=p.createElement("link")).setAttribute("rel","icon"),p.getElementsByTagName("head")[0].appendChild(e)),e.setAttribute("type","image/png"),e},setIcon:function(e){var t=e.toDataURL("image/png");if(r.dataUrl&&r.dataUrl(t),r.element)r.element.setAttribute("href",t),r.element.setAttribute("src",t);else if(r.elementId){var o=p.getElementById(r.elementId);o.setAttribute("href",t),o.setAttribute("src",t)}else if(g.ff||g.opera){var n=i;i=p.createElement("link"),g.opera&&i.setAttribute("rel","icon"),i.setAttribute("rel","icon"),i.setAttribute("type","image/png"),p.getElementsByTagName("head")[0].appendChild(i),i.setAttribute("href",t),n.parentNode&&n.parentNode.removeChild(n)}else i.setAttribute("href",t)}},I={duration:40,types:{}};return I.types.fade=[{x:.4,y:.4,w:.6,h:.6,o:0},{x:.4,y:.4,w:.6,h:.6,o:.1},{x:.4,y:.4,w:.6,h:.6,o:.2},{x:.4,y:.4,w:.6,h:.6,o:.3},{x:.4,y:.4,w:.6,h:.6,o:.4},{x:.4,y:.4,w:.6,h:.6,o:.5},{x:.4,y:.4,w:.6,h:.6,o:.6},{x:.4,y:.4,w:.6,h:.6,o:.7},{x:.4,y:.4,w:.6,h:.6,o:.8},{x:.4,y:.4,w:.6,h:.6,o:.9},{x:.4,y:.4,w:.6,h:.6,o:1}],I.types.none=[{x:.4,y:.4,w:.6,h:.6,o:1}],I.types.pop=[{x:1,y:1,w:0,h:0,o:1},{x:.9,y:.9,w:.1,h:.1,o:1},{x:.8,y:.8,w:.2,h:.2,o:1},{x:.7,y:.7,w:.3,h:.3,o:1},{x:.6,y:.6,w:.4,h:.4,o:1},{x:.5,y:.5,w:.5,h:.5,o:1},{x:.4,y:.4,w:.6,h:.6,o:1}],I.types.popFade=[{x:.75,y:.75,w:0,h:0,o:0},{x:.65,y:.65,w:.1,h:.1,o:.2},{x:.6,y:.6,w:.2,h:.2,o:.4},{x:.55,y:.55,w:.3,h:.3,o:.6},{x:.5,y:.5,w:.4,h:.4,o:.8},{x:.45,y:.45,w:.5,h:.5,o:.9},{x:.4,y:.4,w:.6,h:.6,o:1}],I.types.slide=[{x:.4,y:1,w:.6,h:.6,o:1},{x:.4,y:.9,w:.6,h:.6,o:1},{x:.4,y:.9,w:.6,h:.6,o:1},{x:.4,y:.8,w:.6,h:.6,o:1},{x:.4,y:.7,w:.6,h:.6,o:1},{x:.4,y:.6,w:.6,h:.6,o:1},{x:.4,y:.5,w:.6,h:.6,o:1},{x:.4,y:.4,w:.6,h:.6,o:1}],I.run=function(e,t,o,i){var a=I.types[p.hidden||p.msHidden||p.webkitHidden||p.mozHidden?"none":r.animation];return i=!0===o?void 0!==i?i:a.length-1:void 0!==i?i:0,t=t||function(){},i<a.length&&i>=0?(E[r.type](n(e,a[i])),x=setTimeout(function(){o?i-=1:i+=1,I.run(e,t,o,i)},I.duration),void A.setIcon(s)):void t()},function(){(r=n(b,e)).bgColor=o(r.bgColor),r.textColor=o(r.textColor),r.position=r.position.toLowerCase(),r.animation=I.types[""+r.animation]?r.animation:b.animation,p=r.win.document;var t=r.position.indexOf("up")>-1,c=r.position.indexOf("left")>-1;if(t||c)for(var d=0;d<I.types[""+r.animation].length;d++){var u=I.types[""+r.animation][d];t&&(u.y=u.y<.6?u.y-.4:u.y-2*u.y+(1-u.w)),c&&(u.x=u.x<.6?u.x-.4:u.x-2*u.x+(1-u.h)),I.types[""+r.animation][d]=u}r.type=E[""+r.type]?r.type:b.type,i=A.getIcon(),s=document.createElement("canvas"),f=document.createElement("img"),i.hasAttribute("href")?(f.setAttribute("crossOrigin","anonymous"),f.onload=function(){a=f.height>0?f.height:32,l=f.width>0?f.width:32,s.height=a,s.width=l,h=s.getContext("2d"),C.ready()},f.setAttribute("src",i.getAttribute("href"))):(f.onload=function(){a=32,l=32,f.height=a,f.width=l,s.height=a,s.width=l,h=s.getContext("2d"),C.ready()},f.setAttribute("src",""))}(),{badge:function(e,t){t=("string"==typeof t?{animation:t}:t)||{},y=function(){try{if("number"==typeof e?e>0:""!==e){var n={type:"badge",options:{n:e}};if("animation"in t&&I.types[""+t.animation]&&(n.options.animation=""+t.animation),"type"in t&&E[""+t.type]&&(n.options.type=""+t.type),["bgColor","textColor"].forEach(function(e){e in t&&(n.options[e]=o(t[e]))}),["fontStyle","fontFamily"].forEach(function(e){e in t&&(n.options[e]=t[e])}),v.push(n),v.length>100)throw new Error("Too many badges requests in queue.");C.start()}else C.reset()}catch(e){throw new Error("Error setting badge. Message: "+e.message)}},c&&y()},video:function(e){y=function(){try{if("stop"===e)return w=!0,C.reset(),void(w=!1);e.addEventListener("play",function(){t(this)},!1)}catch(e){throw new Error("Error setting video. Message: "+e.message)}},c&&y()},image:function(e){y=function(){try{var t=e.width,o=e.height,n=document.createElement("img"),r=o/a>t/l?t/l:o/a;n.setAttribute("crossOrigin","anonymous"),n.onload=function(){h.clearRect(0,0,l,a),h.drawImage(n,0,0,l,a),A.setIcon(s)},n.setAttribute("src",e.getAttribute("src")),n.height=o/r,n.width=t/r}catch(e){throw new Error("Error setting image. Message: "+e.message)}},c&&y()},webcam:function(e){if(window.URL&&window.URL.createObjectURL||(window.URL=window.URL||{},window.URL.createObjectURL=function(e){return e}),g.supported){var o=!1;navigator.getUserMedia=navigator.getUserMedia||navigator.oGetUserMedia||navigator.msGetUserMedia||navigator.mozGetUserMedia||navigator.webkitGetUserMedia,y=function(){try{if("stop"===e)return w=!0,C.reset(),void(w=!1);(o=document.createElement("video")).width=l,o.height=a,navigator.getUserMedia({video:!0,audio:!1},function(e){o.src=URL.createObjectURL(e),o.play(),t(o)},function(){})}catch(e){throw new Error("Error setting webcam. Message: "+e.message)}},c&&y()}},reset:C.reset,browser:{supported:g.supported}}};"undefined"!=typeof define&&define.amd?define([],function(){return e}):"undefined"!=typeof module&&module.exports?module.exports=e:this.Favico=e}();
++\ No newline at end of file
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\kasimi\\faviconnotifications/styles/FLATBOOTS/template/js/faviconnotifications.bak.js" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\kasimi\\faviconnotifications/styles/FLATBOOTS/template/js/faviconnotifications.bak.js"
++new file mode 100644
++index 000000000..15165fc80
++--- /dev/null
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\kasimi\\faviconnotifications/styles/FLATBOOTS/template/js/faviconnotifications.bak.js"
++@@ -0,0 +1,41 @@
+++/**
+++ *
+++ * @package phpBB Extension - Favicon Notifications
+++ * @copyright (c) 2016 kasimi
+++ * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
+++ *
+++ */
+++head.ready(function () {
+++jQuery(function($) {
+++	// Initialize favicon
+++	var favicon = new Favico({
+++		bgColor		: '#d00',
+++		textColor	: '#fff',
+++		fontFamily	: 'sans-serif',
+++		fontStyle	: 'bold',
+++		type		: 'circle',
+++		position	: 'down',
+++		animation	: 'popFade'
+++	});
+++
+++	var setUnreadNotificationsCount = function(count) {
+++		favicon.badge(count);
+++	};
+++
+++	// Set initial notifications count
+++	var unreadCount = parseInt($('em', '#notification_list_button').html());
+++	setUnreadNotificationsCount(unreadCount);
+++
+++	// Update notifications count when marking notifications read
+++	var phpbbMarkNotifications = phpbb.markNotifications;
+++	phpbb.markNotifications = function($popup, unreadCount) {
+++		setUnreadNotificationsCount(unreadCount);
+++		return phpbbMarkNotifications($popup, unreadCount);
+++	};
+++
+++	// Listen to notifications count updates from extensions
+++	$(phpbb).on('kasimi_faviconnotifications_update', function(event, notificationsCount) {
+++		setUnreadNotificationsCount(notificationsCount);
+++	});
+++});
+++});
++\ No newline at end of file
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\kasimi\\faviconnotifications/styles/FLATBOOTS/template/js/faviconnotifications.js" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\kasimi\\faviconnotifications/styles/FLATBOOTS/template/js/faviconnotifications.js"
++new file mode 100644
++index 000000000..21f4d69dc
++--- /dev/null
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\kasimi\\faviconnotifications/styles/FLATBOOTS/template/js/faviconnotifications.js"
++@@ -0,0 +1,8 @@
+++/**
+++ *
+++ * @package phpBB Extension - Favicon Notifications
+++ * @copyright (c) 2016 kasimi
+++ * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
+++ *
+++ */
+++head.ready(function(){jQuery(function(i){var n=new Favico({bgColor:"#d00",textColor:"#fff",fontFamily:"sans-serif",fontStyle:"bold",type:"circle",position:"down",animation:"popFade"}),o=function(i){n.badge(i)},t=parseInt(i("em","#notification_list_button").html());o(t);var a=phpbb.markNotifications;phpbb.markNotifications=function(i,n){return o(n),a(i,n)},i(phpbb).on("kasimi_faviconnotifications_update",function(i,n){o(n)})})});
++\ No newline at end of file
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\kasimi\\faviconnotifications/styles/all/template/event/overall_header_head_append.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\kasimi\\faviconnotifications/styles/all/template/event/overall_header_head_append.html"
++index c13078643..7c674b05d 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\kasimi\\faviconnotifications/styles/all/template/event/overall_header_head_append.html"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\kasimi\\faviconnotifications/styles/all/template/event/overall_header_head_append.html"
++@@ -1,4 +1,4 @@
++-{% if S_USER_LOGGED_IN and not S_IS_BOT %}
++-	{% INCLUDEJS 'js/favico-0.3.10.dev.js' %}
++-	{% INCLUDEJS 'js/faviconnotifications.js' %}
++-{% endif %}
+++<!-- IF S_USER_LOGGED_IN and not S_IS_BOT -->
+++	<!-- INCLUDEJS js/favico-0.3.10.min.js -->
+++	<!-- INCLUDEJS js/faviconnotifications.js -->
+++<!-- ENDIF -->
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\kasimi\\faviconnotifications/styles/all/template/js/favico-0.3.10.dev.js" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\kasimi\\faviconnotifications/styles/all/template/js/favico-0.3.10.dev.js"
++deleted file mode 100644
++index 2a501e539..000000000
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\kasimi\\faviconnotifications/styles/all/template/js/favico-0.3.10.dev.js"
+++++ /dev/null
++@@ -1,905 +0,0 @@
++-/**
++- * @license MIT or GPL-2.0
++- * @fileOverview Favico animations
++- * @author Miroslav Magda, http://blog.ejci.net
++- * @source: https://github.com/ejci/favico.js
++- * @version 0.3.10
++- */
++-
++-/**
++- * Create new favico instance
++- * @param {Object} Options
++- * @return {Object} Favico object
++- * @example
++- * var favico = new Favico({
++- *    bgColor : '#d00',
++- *    textColor : '#fff',
++- *    fontFamily : 'sans-serif',
++- *    fontStyle : 'bold',
++- *    type : 'circle',
++- *    position : 'down',
++- *    animation : 'slide',
++- *    elementId: false,
++- *    element: null,
++- *    dataUrl: function(url){},
++- *    win: window
++- * });
++- */
++-(function () {
++-
++-	var Favico = (function (opt) {
++-		'use strict';
++-		opt = (opt) ? opt : {};
++-		var _def = {
++-			bgColor: '#d00',
++-			textColor: '#fff',
++-			fontFamily: 'sans-serif', //Arial,Verdana,Times New Roman,serif,sans-serif,...
++-			fontStyle: 'bold', //normal,italic,oblique,bold,bolder,lighter,100,200,300,400,500,600,700,800,900
++-			type: 'circle',
++-			position: 'down', // down, up, left, leftup (upleft)
++-			animation: 'slide',
++-			elementId: false,
++-			element: null,
++-			dataUrl: false,
++-			win: window
++-		};
++-		var _opt, _orig, _h, _w, _canvas, _context, _img, _ready, _lastBadge, _running, _readyCb, _stop, _browser, _animTimeout, _drawTimeout, _doc;
++-
++-		_browser = {};
++-		_browser.ff = typeof InstallTrigger != 'undefined';
++-		_browser.chrome = !!window.chrome;
++-		_browser.opera = !!window.opera || navigator.userAgent.indexOf('Opera') >= 0;
++-		_browser.ie = /*@cc_on!@*/false;
++-		_browser.safari = Object.prototype.toString.call(window.HTMLElement).indexOf('Constructor') > 0;
++-		_browser.supported = (_browser.chrome || _browser.ff || _browser.opera);
++-
++-		var _queue = [];
++-		_readyCb = function () {
++-		};
++-		_ready = _stop = false;
++-		/**
++-		 * Initialize favico
++-		 */
++-		var init = function () {
++-			//merge initial options
++-			_opt = merge(_def, opt);
++-			_opt.bgColor = hexToRgb(_opt.bgColor);
++-			_opt.textColor = hexToRgb(_opt.textColor);
++-			_opt.position = _opt.position.toLowerCase();
++-			_opt.animation = (animation.types['' + _opt.animation]) ? _opt.animation : _def.animation;
++-
++-			_doc = _opt.win.document;
++-
++-			var isUp = _opt.position.indexOf('up') > -1;
++-			var isLeft = _opt.position.indexOf('left') > -1;
++-
++-			//transform the animations
++-			if (isUp || isLeft) {
++-				for (var a in animation.types) {
++-					for (var i = 0; i < animation.types[a].length; i++) {
++-						var step = animation.types[a][i];
++-
++-						if (isUp) {
++-							if (step.y < 0.6) {
++-								step.y = step.y - 0.4;
++-							} else {
++-								step.y = step.y - 2 * step.y + (1 - step.w);
++-							}
++-						}
++-
++-						if (isLeft) {
++-							if (step.x < 0.6) {
++-								step.x = step.x - 0.4;
++-							} else {
++-								step.x = step.x - 2 * step.x + (1 - step.h);
++-							}
++-						}
++-
++-						animation.types[a][i] = step;
++-					}
++-				}
++-			}
++-			_opt.type = (type['' + _opt.type]) ? _opt.type : _def.type;
++-
++-			_orig = link. getIcons();
++-			//create temp canvas
++-			_canvas = document.createElement('canvas');
++-			//create temp image
++-			_img = document.createElement('img');
++-			var lastIcon = _orig[_orig.length - 1];
++-			if (lastIcon.hasAttribute('href')) {
++-				_img.setAttribute('crossOrigin', 'anonymous');
++-				//get width/height
++-				_img.onload = function () {
++-					_h = (_img.height > 0) ? _img.height : 32;
++-					_w = (_img.width > 0) ? _img.width : 32;
++-					_canvas.height = _h;
++-					_canvas.width = _w;
++-					_context = _canvas.getContext('2d');
++-					icon.ready();
++-				};
++-				_img.setAttribute('src', lastIcon.getAttribute('href'));
++-			} else {
++-				_h = 32;
++-				_w = 32;
++-				_img.height = _h;
++-				_img.width = _w;
++-				_canvas.height = _h;
++-				_canvas.width = _w;
++-				_context = _canvas.getContext('2d');
++-				icon.ready();
++-			}
++-
++-		};
++-		/**
++-		 * Icon namespace
++-		 */
++-		var icon = {};
++-		/**
++-		 * Icon is ready (reset icon) and start animation (if ther is any)
++-		 */
++-		icon.ready = function () {
++-			_ready = true;
++-			icon.reset();
++-			_readyCb();
++-		};
++-		/**
++-		 * Reset icon to default state
++-		 */
++-		icon.reset = function () {
++-			//reset
++-			if (!_ready) {
++-				return;
++-			}
++-			_queue = [];
++-			_lastBadge = false;
++-			_running = false;
++-			_context.clearRect(0, 0, _w, _h);
++-			_context.drawImage(_img, 0, 0, _w, _h);
++-			//_stop=true;
++-			link.setIcon(_canvas);
++-			//webcam('stop');
++-			//video('stop');
++-			window.clearTimeout(_animTimeout);
++-			window.clearTimeout(_drawTimeout);
++-		};
++-		/**
++-		 * Start animation
++-		 */
++-		icon.start = function () {
++-			if (!_ready || _running) {
++-				return;
++-			}
++-			var finished = function () {
++-				_lastBadge = _queue[0];
++-				_running = false;
++-				if (_queue.length > 0) {
++-					_queue.shift();
++-					icon.start();
++-				} else {
++-
++-				}
++-			};
++-			if (_queue.length > 0) {
++-				_running = true;
++-				var run = function () {
++-					// apply options for this animation
++-					['type', 'animation', 'bgColor', 'textColor', 'fontFamily', 'fontStyle'].forEach(function (a) {
++-						if (a in _queue[0].options) {
++-							_opt[a] = _queue[0].options[a];
++-						}
++-					});
++-					animation.run(_queue[0].options, function () {
++-						finished();
++-					}, false);
++-				};
++-				if (_lastBadge) {
++-					animation.run(_lastBadge.options, function () {
++-						run();
++-					}, true);
++-				} else {
++-					run();
++-				}
++-			}
++-		};
++-
++-		/**
++-		 * Badge types
++-		 */
++-		var type = {};
++-		var options = function (opt) {
++-			opt.n = ((typeof opt.n) === 'number') ? Math.abs(opt.n | 0) : opt.n;
++-			opt.x = _w * opt.x;
++-			opt.y = _h * opt.y;
++-			opt.w = _w * opt.w;
++-			opt.h = _h * opt.h;
++-			opt.len = ("" + opt.n).length;
++-			return opt;
++-		};
++-		/**
++-		 * Generate circle
++-		 * @param {Object} opt Badge options
++-		 */
++-		type.circle = function (opt) {
++-			opt = options(opt);
++-			var more = false;
++-			if (opt.len === 2) {
++-				opt.x = opt.x - opt.w * 0.4;
++-				opt.w = opt.w * 1.4;
++-				more = true;
++-			} else if (opt.len >= 3) {
++-				opt.x = opt.x - opt.w * 0.65;
++-				opt.w = opt.w * 1.65;
++-				more = true;
++-			}
++-			_context.clearRect(0, 0, _w, _h);
++-			_context.drawImage(_img, 0, 0, _w, _h);
++-			_context.beginPath();
++-			_context.font = _opt.fontStyle + " " + Math.floor(opt.h * (opt.n > 99 ? 0.85 : 1)) + "px " + _opt.fontFamily;
++-			_context.textAlign = 'center';
++-			if (more) {
++-				_context.moveTo(opt.x + opt.w / 2, opt.y);
++-				_context.lineTo(opt.x + opt.w - opt.h / 2, opt.y);
++-				_context.quadraticCurveTo(opt.x + opt.w, opt.y, opt.x + opt.w, opt.y + opt.h / 2);
++-				_context.lineTo(opt.x + opt.w, opt.y + opt.h - opt.h / 2);
++-				_context.quadraticCurveTo(opt.x + opt.w, opt.y + opt.h, opt.x + opt.w - opt.h / 2, opt.y + opt.h);
++-				_context.lineTo(opt.x + opt.h / 2, opt.y + opt.h);
++-				_context.quadraticCurveTo(opt.x, opt.y + opt.h, opt.x, opt.y + opt.h - opt.h / 2);
++-				_context.lineTo(opt.x, opt.y + opt.h / 2);
++-				_context.quadraticCurveTo(opt.x, opt.y, opt.x + opt.h / 2, opt.y);
++-			} else {
++-				_context.arc(opt.x + opt.w / 2, opt.y + opt.h / 2, opt.h / 2, 0, 2 * Math.PI);
++-			}
++-			_context.fillStyle = 'rgba(' + _opt.bgColor.r + ',' + _opt.bgColor.g + ',' + _opt.bgColor.b + ',' + opt.o + ')';
++-			_context.fill();
++-			_context.closePath();
++-			_context.beginPath();
++-			_context.stroke();
++-			_context.fillStyle = 'rgba(' + _opt.textColor.r + ',' + _opt.textColor.g + ',' + _opt.textColor.b + ',' + opt.o + ')';
++-			//_context.fillText((more) ? '9+' : opt.n, Math.floor(opt.x + opt.w / 2), Math.floor(opt.y + opt.h - opt.h * 0.15));
++-			if ((typeof opt.n) === 'number' && opt.n > 999) {
++-				_context.fillText(((opt.n > 9999) ? 9 : Math.floor(opt.n / 1000)) + 'k+', Math.floor(opt.x + opt.w / 2), Math.floor(opt.y + opt.h - opt.h * 0.2));
++-			} else {
++-				_context.fillText(opt.n, Math.floor(opt.x + opt.w / 2), Math.floor(opt.y + opt.h - opt.h * 0.15));
++-			}
++-			_context.closePath();
++-		};
++-		/**
++-		 * Generate rectangle
++-		 * @param {Object} opt Badge options
++-		 */
++-		type.rectangle = function (opt) {
++-			opt = options(opt);
++-			var more = false;
++-			if (opt.len === 2) {
++-				opt.x = opt.x - opt.w * 0.4;
++-				opt.w = opt.w * 1.4;
++-				more = true;
++-			} else if (opt.len >= 3) {
++-				opt.x = opt.x - opt.w * 0.65;
++-				opt.w = opt.w * 1.65;
++-				more = true;
++-			}
++-			_context.clearRect(0, 0, _w, _h);
++-			_context.drawImage(_img, 0, 0, _w, _h);
++-			_context.beginPath();
++-			_context.font = _opt.fontStyle + " " + Math.floor(opt.h * (opt.n > 99 ? 0.9 : 1)) + "px " + _opt.fontFamily;
++-			_context.textAlign = 'center';
++-			_context.fillStyle = 'rgba(' + _opt.bgColor.r + ',' + _opt.bgColor.g + ',' + _opt.bgColor.b + ',' + opt.o + ')';
++-			_context.fillRect(opt.x, opt.y, opt.w, opt.h);
++-			_context.fillStyle = 'rgba(' + _opt.textColor.r + ',' + _opt.textColor.g + ',' + _opt.textColor.b + ',' + opt.o + ')';
++-			//_context.fillText((more) ? '9+' : opt.n, Math.floor(opt.x + opt.w / 2), Math.floor(opt.y + opt.h - opt.h * 0.15));
++-			if ((typeof opt.n) === 'number' && opt.n > 999) {
++-				_context.fillText(((opt.n > 9999) ? 9 : Math.floor(opt.n / 1000)) + 'k+', Math.floor(opt.x + opt.w / 2), Math.floor(opt.y + opt.h - opt.h * 0.2));
++-			} else {
++-				_context.fillText(opt.n, Math.floor(opt.x + opt.w / 2), Math.floor(opt.y + opt.h - opt.h * 0.15));
++-			}
++-			_context.closePath();
++-		};
++-
++-		/**
++-		 * Set badge
++-		 */
++-		var badge = function (number, opts) {
++-			opts = ((typeof opts) === 'string' ? {
++-				animation: opts
++-			} : opts) || {};
++-			_readyCb = function () {
++-				try {
++-					if (typeof (number) === 'number' ? (number > 0) : (number !== '')) {
++-						var q = {
++-							type: 'badge',
++-							options: {
++-								n: number
++-							}
++-						};
++-						if ('animation' in opts && animation.types['' + opts.animation]) {
++-							q.options.animation = '' + opts.animation;
++-						}
++-						if ('type' in opts && type['' + opts.type]) {
++-							q.options.type = '' + opts.type;
++-						}
++-						['bgColor', 'textColor'].forEach(function (o) {
++-							if (o in opts) {
++-								q.options[o] = hexToRgb(opts[o]);
++-							}
++-						});
++-						['fontStyle', 'fontFamily'].forEach(function (o) {
++-							if (o in opts) {
++-								q.options[o] = opts[o];
++-							}
++-						});
++-						_queue.push(q);
++-						if (_queue.length > 100) {
++-							throw new Error('Too many badges requests in queue.');
++-						}
++-						icon.start();
++-					} else {
++-						icon.reset();
++-					}
++-				} catch (e) {
++-					throw new Error('Error setting badge. Message: ' + e.message);
++-				}
++-			};
++-			if (_ready) {
++-				_readyCb();
++-			}
++-		};
++-
++-		/**
++-		 * Set image as icon
++-		 */
++-		var image = function (imageElement) {
++-			_readyCb = function () {
++-				try {
++-					var w = imageElement.width;
++-					var h = imageElement.height;
++-					var newImg = document.createElement('img');
++-					var ratio = (w / _w < h / _h) ? (w / _w) : (h / _h);
++-					newImg.setAttribute('crossOrigin', 'anonymous');
++-					newImg.onload=function(){
++-						_context.clearRect(0, 0, _w, _h);
++-						_context.drawImage(newImg, 0, 0, _w, _h);
++-						link.setIcon(_canvas);
++-					};
++-					newImg.setAttribute('src', imageElement.getAttribute('src'));
++-					newImg.height = (h / ratio);
++-					newImg.width = (w / ratio);
++-				} catch (e) {
++-					throw new Error('Error setting image. Message: ' + e.message);
++-				}
++-			};
++-			if (_ready) {
++-				_readyCb();
++-			}
++-		};
++-		/**
++-		 * Set the icon from a source url. Won't work with badges.
++-		 */
++-		var rawImageSrc = function (url) {
++-			_readyCb = function() {
++-				link.setIconSrc(url);
++-			};
++-			if (_ready) {
++-				_readyCb();
++-			}
++-		};
++-		/**
++-		 * Set video as icon
++-		 */
++-		var video = function (videoElement) {
++-			_readyCb = function () {
++-				try {
++-					if (videoElement === 'stop') {
++-						_stop = true;
++-						icon.reset();
++-						_stop = false;
++-						return;
++-					}
++-					//var w = videoElement.width;
++-					//var h = videoElement.height;
++-					//var ratio = (w / _w < h / _h) ? (w / _w) : (h / _h);
++-					videoElement.addEventListener('play', function () {
++-						drawVideo(this);
++-					}, false);
++-
++-				} catch (e) {
++-					throw new Error('Error setting video. Message: ' + e.message);
++-				}
++-			};
++-			if (_ready) {
++-				_readyCb();
++-			}
++-		};
++-		/**
++-		 * Set video as icon
++-		 */
++-		var webcam = function (action) {
++-			//UR
++-			if (!window.URL || !window.URL.createObjectURL) {
++-				window.URL = window.URL || {};
++-				window.URL.createObjectURL = function (obj) {
++-					return obj;
++-				};
++-			}
++-			if (_browser.supported) {
++-				var newVideo = false;
++-				navigator.getUserMedia = navigator.getUserMedia || navigator.oGetUserMedia || navigator.msGetUserMedia || navigator.mozGetUserMedia || navigator.webkitGetUserMedia;
++-				_readyCb = function () {
++-					try {
++-						if (action === 'stop') {
++-							_stop = true;
++-							icon.reset();
++-							_stop = false;
++-							return;
++-						}
++-						newVideo = document.createElement('video');
++-						newVideo.width = _w;
++-						newVideo.height = _h;
++-						navigator.getUserMedia({
++-							video: true,
++-							audio: false
++-						}, function (stream) {
++-							newVideo.src = URL.createObjectURL(stream);
++-							newVideo.play();
++-							drawVideo(newVideo);
++-						}, function () {
++-						});
++-					} catch (e) {
++-						throw new Error('Error setting webcam. Message: ' + e.message);
++-					}
++-				};
++-				if (_ready) {
++-					_readyCb();
++-				}
++-			}
++-
++-		};
++-
++-		var setOpt = function (key, value) {
++-			var opts = key;
++-			if (!(value == null && Object.prototype.toString.call(key) == '[object Object]')) {
++-				opts = {};
++-				opts[key] = value;
++-			}
++-
++-			var keys = Object.keys(opts);
++-			for (var i = 0; i < keys.length; i++) {
++-				if (keys[i] == 'bgColor' || keys[i] == 'textColor') {
++-					_opt[keys[i]] = hexToRgb(opts[keys[i]]);
++-				} else {
++-					_opt[keys[i]] = opts[keys[i]];
++-				}
++-			}
++-
++-			_queue.push(_lastBadge);
++-			icon.start();
++-		};
++-
++-		/**
++-		 * Draw video to context and repeat :)
++-		 */
++-		function drawVideo(video) {
++-			if (video.paused || video.ended || _stop) {
++-				return false;
++-			}
++-			//nasty hack for FF webcam (Thanks to Julian Ćwirko, kontakt@redsunmedia.pl)
++-			try {
++-				_context.clearRect(0, 0, _w, _h);
++-				_context.drawImage(video, 0, 0, _w, _h);
++-			} catch (e) {
++-
++-			}
++-			_drawTimeout = setTimeout(function () {
++-				drawVideo(video);
++-			}, animation.duration);
++-			link.setIcon(_canvas);
++-		}
++-
++-		var link = {};
++-		/**
++-		 * Get icons from HEAD tag or create a new <link> element
++-		 */
++-		link.getIcons = function () {
++-			var elms = [];
++-			//get link element
++-			var getLinks = function () {
++-				var icons = [];
++-				var links = _doc.getElementsByTagName('head')[0].getElementsByTagName('link');
++-				for (var i = 0; i < links.length; i++) {
++-					if ((/(^|\s)icon(\s|$)/i).test(links[i].getAttribute('rel'))) {
++-						icons.push(links[i]);
++-					}
++-				}
++-				return icons;
++-			};
++-			if (_opt.element) {
++-				elms = [_opt.element];
++-			} else if (_opt.elementId) {
++-				//if img element identified by elementId
++-				elms = [_doc.getElementById(_opt.elementId)];
++-				elms[0].setAttribute('href', elms[0].getAttribute('src'));
++-			} else {
++-				//if link element
++-				elms = getLinks();
++-				if (elms.length === 0) {
++-					elms = [_doc.createElement('link')];
++-					elms[0].setAttribute('rel', 'icon');
++-					_doc.getElementsByTagName('head')[0].appendChild(elms[0]);
++-				}
++-			}
++-			elms.forEach(function(item) {
++-				item.setAttribute('type', 'image/png');
++-			});
++-			return elms;
++-		};
++-		link.setIcon = function (canvas) {
++-			setTimeout(function() {
++-				var url = canvas.toDataURL('image/png');
++-				link.setIconSrc(url);
++-			}, 0);
++-		};
++-		link.setIconSrc = function (url) {
++-			if (_opt.dataUrl) {
++-				//if using custom exporter
++-				_opt.dataUrl(url);
++-			}
++-			if (_opt.element) {
++-				_opt.element.setAttribute('href', url);
++-				_opt.element.setAttribute('src', url);
++-			} else if (_opt.elementId) {
++-				//if is attached to element (image)
++-				var elm = _doc.getElementById(_opt.elementId);
++-				elm.setAttribute('href', url);
++-				elm.setAttribute('src', url);
++-			} else {
++-				//if is attached to fav icon
++-				if (_browser.ff || _browser.opera) {
++-					//for FF we need to "recreate" element, atach to dom and remove old <link>
++-					//var originalType = _orig.getAttribute('rel');
++-					var old = _orig[_orig.length - 1];
++-					var newIcon = _doc.createElement('link');
++-					_orig = [newIcon];
++-					//_orig.setAttribute('rel', originalType);
++-					if (_browser.opera) {
++-						newIcon.setAttribute('rel', 'icon');
++-					}
++-					newIcon.setAttribute('rel', 'icon');
++-					newIcon.setAttribute('type', 'image/png');
++-					_doc.getElementsByTagName('head')[0].appendChild(newIcon);
++-					newIcon.setAttribute('href', url);
++-					if (old.parentNode) {
++-						old.parentNode.removeChild(old);
++-					}
++-				} else {
++-					_orig.forEach(function(icon) {
++-						icon.setAttribute('href', url);
++-					});
++-				}
++-			}
++-		};
++-
++-		//http://stackoverflow.com/questions/5623838/rgb-to-hex-and-hex-to-rgb#answer-5624139
++-		//HEX to RGB convertor
++-		function hexToRgb(hex) {
++-			var shorthandRegex = /^#?([a-f\d])([a-f\d])([a-f\d])$/i;
++-			hex = hex.replace(shorthandRegex, function (m, r, g, b) {
++-				return r + r + g + g + b + b;
++-			});
++-			var result = /^#?([a-f\d]{2})([a-f\d]{2})([a-f\d]{2})$/i.exec(hex);
++-			return result ? {
++-				r: parseInt(result[1], 16),
++-				g: parseInt(result[2], 16),
++-				b: parseInt(result[3], 16)
++-			} : false;
++-		}
++-
++-		/**
++-		 * Merge options
++-		 */
++-		function merge(def, opt) {
++-			var mergedOpt = {};
++-			var attrname;
++-			for (attrname in def) {
++-				mergedOpt[attrname] = def[attrname];
++-			}
++-			for (attrname in opt) {
++-				mergedOpt[attrname] = opt[attrname];
++-			}
++-			return mergedOpt;
++-		}
++-
++-		/**
++-		 * Cross-browser page visibility shim
++-		 * http://stackoverflow.com/questions/12536562/detect-whether-a-window-is-visible
++-		 */
++-		function isPageHidden() {
++-			return _doc.hidden || _doc.msHidden || _doc.webkitHidden || _doc.mozHidden;
++-		}
++-
++-		/**
++-		 * @namespace animation
++-		 */
++-		var animation = {};
++-		/**
++-		 * Animation "frame" duration
++-		 */
++-		animation.duration = 40;
++-		/**
++-		 * Animation types (none,fade,pop,slide)
++-		 */
++-		animation.types = {};
++-		animation.types.fade = [{
++-			x: 0.4,
++-			y: 0.4,
++-			w: 0.6,
++-			h: 0.6,
++-			o: 0.0
++-		}, {
++-				x: 0.4,
++-				y: 0.4,
++-				w: 0.6,
++-				h: 0.6,
++-				o: 0.1
++-			}, {
++-				x: 0.4,
++-				y: 0.4,
++-				w: 0.6,
++-				h: 0.6,
++-				o: 0.2
++-			}, {
++-				x: 0.4,
++-				y: 0.4,
++-				w: 0.6,
++-				h: 0.6,
++-				o: 0.3
++-			}, {
++-				x: 0.4,
++-				y: 0.4,
++-				w: 0.6,
++-				h: 0.6,
++-				o: 0.4
++-			}, {
++-				x: 0.4,
++-				y: 0.4,
++-				w: 0.6,
++-				h: 0.6,
++-				o: 0.5
++-			}, {
++-				x: 0.4,
++-				y: 0.4,
++-				w: 0.6,
++-				h: 0.6,
++-				o: 0.6
++-			}, {
++-				x: 0.4,
++-				y: 0.4,
++-				w: 0.6,
++-				h: 0.6,
++-				o: 0.7
++-			}, {
++-				x: 0.4,
++-				y: 0.4,
++-				w: 0.6,
++-				h: 0.6,
++-				o: 0.8
++-			}, {
++-				x: 0.4,
++-				y: 0.4,
++-				w: 0.6,
++-				h: 0.6,
++-				o: 0.9
++-			}, {
++-				x: 0.4,
++-				y: 0.4,
++-				w: 0.6,
++-				h: 0.6,
++-				o: 1.0
++-			}];
++-		animation.types.none = [{
++-			x: 0.4,
++-			y: 0.4,
++-			w: 0.6,
++-			h: 0.6,
++-			o: 1
++-		}];
++-		animation.types.pop = [{
++-			x: 1,
++-			y: 1,
++-			w: 0,
++-			h: 0,
++-			o: 1
++-		}, {
++-				x: 0.9,
++-				y: 0.9,
++-				w: 0.1,
++-				h: 0.1,
++-				o: 1
++-			}, {
++-				x: 0.8,
++-				y: 0.8,
++-				w: 0.2,
++-				h: 0.2,
++-				o: 1
++-			}, {
++-				x: 0.7,
++-				y: 0.7,
++-				w: 0.3,
++-				h: 0.3,
++-				o: 1
++-			}, {
++-				x: 0.6,
++-				y: 0.6,
++-				w: 0.4,
++-				h: 0.4,
++-				o: 1
++-			}, {
++-				x: 0.5,
++-				y: 0.5,
++-				w: 0.5,
++-				h: 0.5,
++-				o: 1
++-			}, {
++-				x: 0.4,
++-				y: 0.4,
++-				w: 0.6,
++-				h: 0.6,
++-				o: 1
++-			}];
++-		animation.types.popFade = [{
++-			x: 0.75,
++-			y: 0.75,
++-			w: 0,
++-			h: 0,
++-			o: 0
++-		}, {
++-				x: 0.65,
++-				y: 0.65,
++-				w: 0.1,
++-				h: 0.1,
++-				o: 0.2
++-			}, {
++-				x: 0.6,
++-				y: 0.6,
++-				w: 0.2,
++-				h: 0.2,
++-				o: 0.4
++-			}, {
++-				x: 0.55,
++-				y: 0.55,
++-				w: 0.3,
++-				h: 0.3,
++-				o: 0.6
++-			}, {
++-				x: 0.50,
++-				y: 0.50,
++-				w: 0.4,
++-				h: 0.4,
++-				o: 0.8
++-			}, {
++-				x: 0.45,
++-				y: 0.45,
++-				w: 0.5,
++-				h: 0.5,
++-				o: 0.9
++-			}, {
++-				x: 0.4,
++-				y: 0.4,
++-				w: 0.6,
++-				h: 0.6,
++-				o: 1
++-			}];
++-		animation.types.slide = [{
++-			x: 0.4,
++-			y: 1,
++-			w: 0.6,
++-			h: 0.6,
++-			o: 1
++-		}, {
++-				x: 0.4,
++-				y: 0.9,
++-				w: 0.6,
++-				h: 0.6,
++-				o: 1
++-			}, {
++-				x: 0.4,
++-				y: 0.9,
++-				w: 0.6,
++-				h: 0.6,
++-				o: 1
++-			}, {
++-				x: 0.4,
++-				y: 0.8,
++-				w: 0.6,
++-				h: 0.6,
++-				o: 1
++-			}, {
++-				x: 0.4,
++-				y: 0.7,
++-				w: 0.6,
++-				h: 0.6,
++-				o: 1
++-			}, {
++-				x: 0.4,
++-				y: 0.6,
++-				w: 0.6,
++-				h: 0.6,
++-				o: 1
++-			}, {
++-				x: 0.4,
++-				y: 0.5,
++-				w: 0.6,
++-				h: 0.6,
++-				o: 1
++-			}, {
++-				x: 0.4,
++-				y: 0.4,
++-				w: 0.6,
++-				h: 0.6,
++-				o: 1
++-			}];
++-		/**
++-		 * Run animation
++-		 * @param {Object} opt Animation options
++-		 * @param {Object} cb Callabak after all steps are done
++-		 * @param {Object} revert Reverse order? true|false
++-		 * @param {Object} step Optional step number (frame bumber)
++-		 */
++-		animation.run = function (opt, cb, revert, step) {
++-			var animationType = animation.types[isPageHidden() ? 'none' : _opt.animation];
++-			if (revert === true) {
++-				step = (typeof step !== 'undefined') ? step : animationType.length - 1;
++-			} else {
++-				step = (typeof step !== 'undefined') ? step : 0;
++-			}
++-			cb = (cb) ? cb : function () {
++-			};
++-			if ((step < animationType.length) && (step >= 0)) {
++-				type[_opt.type](merge(opt, animationType[step]));
++-				_animTimeout = setTimeout(function () {
++-					if (revert) {
++-						step = step - 1;
++-					} else {
++-						step = step + 1;
++-					}
++-					animation.run(opt, cb, revert, step);
++-				}, animation.duration);
++-
++-				link.setIcon(_canvas);
++-			} else {
++-				cb();
++-				return;
++-			}
++-		};
++-		//auto init
++-		init();
++-		return {
++-			badge: badge,
++-			video: video,
++-			image: image,
++-			rawImageSrc: rawImageSrc,
++-			webcam: webcam,
++-			setOpt: setOpt,
++-			reset: icon.reset,
++-			browser: {
++-				supported: _browser.supported
++-			}
++-		};
++-	});
++-
++-	// AMD / RequireJS
++-	if (typeof define !== 'undefined' && define.amd) {
++-		define([], function () {
++-			return Favico;
++-		});
++-	}
++-	// CommonJS
++-	else if (typeof module !== 'undefined' && module.exports) {
++-		module.exports = Favico;
++-	}
++-	// included directly via <script> tag
++-	else {
++-		this.Favico = Favico;
++-	}
++-
++-})();
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\kasimi\\faviconnotifications/styles/all/template/js/favico-0.3.10.min.bak.js" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\kasimi\\faviconnotifications/styles/all/template/js/favico-0.3.10.min.bak.js"
++new file mode 100644
++index 000000000..cd411658b
++--- /dev/null
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\kasimi\\faviconnotifications/styles/all/template/js/favico-0.3.10.min.bak.js"
++@@ -0,0 +1,7 @@
+++/**
+++ * @license MIT
+++ * @fileOverview Favico animations
+++ * @author Miroslav Magda, http://blog.ejci.net
+++ * @version 0.3.10
+++ */
+++!function(){var e=function(e){"use strict";function t(e){if(e.paused||e.ended||g)return!1;try{f.clearRect(0,0,s,l),f.drawImage(e,0,0,s,l)}catch(o){}p=setTimeout(function(){t(e)},S.duration),O.setIcon(h)}function o(e){var t=/^#?([a-f\d])([a-f\d])([a-f\d])$/i;e=e.replace(t,function(e,t,o,n){return t+t+o+o+n+n});var o=/^#?([a-f\d]{2})([a-f\d]{2})([a-f\d]{2})$/i.exec(e);return o?{r:parseInt(o[1],16),g:parseInt(o[2],16),b:parseInt(o[3],16)}:!1}function n(e,t){var o,n={};for(o in e)n[o]=e[o];for(o in t)n[o]=t[o];return n}function r(){return b.hidden||b.msHidden||b.webkitHidden||b.mozHidden}e=e?e:{};var i,a,l,s,h,f,c,d,u,y,w,g,x,m,p,b,v={bgColor:"#d00",textColor:"#fff",fontFamily:"sans-serif",fontStyle:"bold",type:"circle",position:"down",animation:"slide",elementId:!1,dataUrl:!1,win:window};x={},x.ff="undefined"!=typeof InstallTrigger,x.chrome=!!window.chrome,x.opera=!!window.opera||navigator.userAgent.indexOf("Opera")>=0,x.ie=/*@cc_on!@*/!1,x.safari=Object.prototype.toString.call(window.HTMLElement).indexOf("Constructor")>0,x.supported=x.chrome||x.ff||x.opera;var C=[];w=function(){},d=g=!1;var E=function(){i=n(v,e),i.bgColor=o(i.bgColor),i.textColor=o(i.textColor),i.position=i.position.toLowerCase(),i.animation=S.types[""+i.animation]?i.animation:v.animation,b=i.win.document;var t=i.position.indexOf("up")>-1,r=i.position.indexOf("left")>-1;if(t||r)for(var d=0;d<S.types[""+i.animation].length;d++){var u=S.types[""+i.animation][d];t&&(u.y=u.y<.6?u.y-.4:u.y-2*u.y+(1-u.w)),r&&(u.x=u.x<.6?u.x-.4:u.x-2*u.x+(1-u.h)),S.types[""+i.animation][d]=u}i.type=A[""+i.type]?i.type:v.type,a=O.getIcon(),h=document.createElement("canvas"),c=document.createElement("img"),a.hasAttribute("href")?(c.setAttribute("crossOrigin","anonymous"),c.onload=function(){l=c.height>0?c.height:32,s=c.width>0?c.width:32,h.height=l,h.width=s,f=h.getContext("2d"),M.ready()},c.setAttribute("src",a.getAttribute("href"))):(c.onload=function(){l=32,s=32,c.height=l,c.width=s,h.height=l,h.width=s,f=h.getContext("2d"),M.ready()},c.setAttribute("src",""))},M={};M.ready=function(){d=!0,M.reset(),w()},M.reset=function(){d&&(C=[],u=!1,y=!1,f.clearRect(0,0,s,l),f.drawImage(c,0,0,s,l),O.setIcon(h),window.clearTimeout(m),window.clearTimeout(p))},M.start=function(){if(d&&!y){var e=function(){u=C[0],y=!1,C.length>0&&(C.shift(),M.start())};if(C.length>0){y=!0;var t=function(){["type","animation","bgColor","textColor","fontFamily","fontStyle"].forEach(function(e){e in C[0].options&&(i[e]=C[0].options[e])}),S.run(C[0].options,function(){e()},!1)};u?S.run(u.options,function(){t()},!0):t()}}};var A={},I=function(e){return e.n="number"==typeof e.n?Math.abs(0|e.n):e.n,e.x=s*e.x,e.y=l*e.y,e.w=s*e.w,e.h=l*e.h,e.len=(""+e.n).length,e};A.circle=function(e){e=I(e);var t=!1;2===e.len?(e.x=e.x-.4*e.w,e.w=1.4*e.w,t=!0):e.len>=3&&(e.x=e.x-.65*e.w,e.w=1.65*e.w,t=!0),f.clearRect(0,0,s,l),f.drawImage(c,0,0,s,l),f.beginPath(),f.font=i.fontStyle+" "+Math.floor(e.h*(e.n>99?.85:1))+"px "+i.fontFamily,f.textAlign="center",t?(f.moveTo(e.x+e.w/2,e.y),f.lineTo(e.x+e.w-e.h/2,e.y),f.quadraticCurveTo(e.x+e.w,e.y,e.x+e.w,e.y+e.h/2),f.lineTo(e.x+e.w,e.y+e.h-e.h/2),f.quadraticCurveTo(e.x+e.w,e.y+e.h,e.x+e.w-e.h/2,e.y+e.h),f.lineTo(e.x+e.h/2,e.y+e.h),f.quadraticCurveTo(e.x,e.y+e.h,e.x,e.y+e.h-e.h/2),f.lineTo(e.x,e.y+e.h/2),f.quadraticCurveTo(e.x,e.y,e.x+e.h/2,e.y)):f.arc(e.x+e.w/2,e.y+e.h/2,e.h/2,0,2*Math.PI),f.fillStyle="rgba("+i.bgColor.r+","+i.bgColor.g+","+i.bgColor.b+","+e.o+")",f.fill(),f.closePath(),f.beginPath(),f.stroke(),f.fillStyle="rgba("+i.textColor.r+","+i.textColor.g+","+i.textColor.b+","+e.o+")","number"==typeof e.n&&e.n>999?f.fillText((e.n>9999?9:Math.floor(e.n/1e3))+"k+",Math.floor(e.x+e.w/2),Math.floor(e.y+e.h-.2*e.h)):f.fillText(e.n,Math.floor(e.x+e.w/2),Math.floor(e.y+e.h-.15*e.h)),f.closePath()},A.rectangle=function(e){e=I(e);var t=!1;2===e.len?(e.x=e.x-.4*e.w,e.w=1.4*e.w,t=!0):e.len>=3&&(e.x=e.x-.65*e.w,e.w=1.65*e.w,t=!0),f.clearRect(0,0,s,l),f.drawImage(c,0,0,s,l),f.beginPath(),f.font=i.fontStyle+" "+Math.floor(e.h*(e.n>99?.9:1))+"px "+i.fontFamily,f.textAlign="center",f.fillStyle="rgba("+i.bgColor.r+","+i.bgColor.g+","+i.bgColor.b+","+e.o+")",f.fillRect(e.x,e.y,e.w,e.h),f.fillStyle="rgba("+i.textColor.r+","+i.textColor.g+","+i.textColor.b+","+e.o+")","number"==typeof e.n&&e.n>999?f.fillText((e.n>9999?9:Math.floor(e.n/1e3))+"k+",Math.floor(e.x+e.w/2),Math.floor(e.y+e.h-.2*e.h)):f.fillText(e.n,Math.floor(e.x+e.w/2),Math.floor(e.y+e.h-.15*e.h)),f.closePath()};var T=function(e,t){t=("string"==typeof t?{animation:t}:t)||{},w=function(){try{if("number"==typeof e?e>0:""!==e){var n={type:"badge",options:{n:e}};if("animation"in t&&S.types[""+t.animation]&&(n.options.animation=""+t.animation),"type"in t&&A[""+t.type]&&(n.options.type=""+t.type),["bgColor","textColor"].forEach(function(e){e in t&&(n.options[e]=o(t[e]))}),["fontStyle","fontFamily"].forEach(function(e){e in t&&(n.options[e]=t[e])}),C.push(n),C.length>100)throw new Error("Too many badges requests in queue.");M.start()}else M.reset()}catch(r){throw new Error("Error setting badge. Message: "+r.message)}},d&&w()},U=function(e){w=function(){try{var t=e.width,o=e.height,n=document.createElement("img"),r=o/l>t/s?t/s:o/l;n.setAttribute("crossOrigin","anonymous"),n.onload=function(){f.clearRect(0,0,s,l),f.drawImage(n,0,0,s,l),O.setIcon(h)},n.setAttribute("src",e.getAttribute("src")),n.height=o/r,n.width=t/r}catch(i){throw new Error("Error setting image. Message: "+i.message)}},d&&w()},R=function(e){w=function(){try{if("stop"===e)return g=!0,M.reset(),void(g=!1);e.addEventListener("play",function(){t(this)},!1)}catch(o){throw new Error("Error setting video. Message: "+o.message)}},d&&w()},L=function(e){if(window.URL&&window.URL.createObjectURL||(window.URL=window.URL||{},window.URL.createObjectURL=function(e){return e}),x.supported){var o=!1;navigator.getUserMedia=navigator.getUserMedia||navigator.oGetUserMedia||navigator.msGetUserMedia||navigator.mozGetUserMedia||navigator.webkitGetUserMedia,w=function(){try{if("stop"===e)return g=!0,M.reset(),void(g=!1);o=document.createElement("video"),o.width=s,o.height=l,navigator.getUserMedia({video:!0,audio:!1},function(e){o.src=URL.createObjectURL(e),o.play(),t(o)},function(){})}catch(n){throw new Error("Error setting webcam. Message: "+n.message)}},d&&w()}},O={};O.getIcon=function(){var e=!1,t=function(){for(var e=b.getElementsByTagName("head")[0].getElementsByTagName("link"),t=e.length,o=t-1;o>=0;o--)if(/(^|\s)icon(\s|$)/i.test(e[o].getAttribute("rel")))return e[o];return!1};return i.element?e=i.element:i.elementId?(e=b.getElementById(i.elementId),e.setAttribute("href",e.getAttribute("src"))):(e=t(),e===!1&&(e=b.createElement("link"),e.setAttribute("rel","icon"),b.getElementsByTagName("head")[0].appendChild(e))),e.setAttribute("type","image/png"),e},O.setIcon=function(e){var t=e.toDataURL("image/png");if(i.dataUrl&&i.dataUrl(t),i.element)i.element.setAttribute("href",t),i.element.setAttribute("src",t);else if(i.elementId){var o=b.getElementById(i.elementId);o.setAttribute("href",t),o.setAttribute("src",t)}else if(x.ff||x.opera){var n=a;a=b.createElement("link"),x.opera&&a.setAttribute("rel","icon"),a.setAttribute("rel","icon"),a.setAttribute("type","image/png"),b.getElementsByTagName("head")[0].appendChild(a),a.setAttribute("href",t),n.parentNode&&n.parentNode.removeChild(n)}else a.setAttribute("href",t)};var S={};return S.duration=40,S.types={},S.types.fade=[{x:.4,y:.4,w:.6,h:.6,o:0},{x:.4,y:.4,w:.6,h:.6,o:.1},{x:.4,y:.4,w:.6,h:.6,o:.2},{x:.4,y:.4,w:.6,h:.6,o:.3},{x:.4,y:.4,w:.6,h:.6,o:.4},{x:.4,y:.4,w:.6,h:.6,o:.5},{x:.4,y:.4,w:.6,h:.6,o:.6},{x:.4,y:.4,w:.6,h:.6,o:.7},{x:.4,y:.4,w:.6,h:.6,o:.8},{x:.4,y:.4,w:.6,h:.6,o:.9},{x:.4,y:.4,w:.6,h:.6,o:1}],S.types.none=[{x:.4,y:.4,w:.6,h:.6,o:1}],S.types.pop=[{x:1,y:1,w:0,h:0,o:1},{x:.9,y:.9,w:.1,h:.1,o:1},{x:.8,y:.8,w:.2,h:.2,o:1},{x:.7,y:.7,w:.3,h:.3,o:1},{x:.6,y:.6,w:.4,h:.4,o:1},{x:.5,y:.5,w:.5,h:.5,o:1},{x:.4,y:.4,w:.6,h:.6,o:1}],S.types.popFade=[{x:.75,y:.75,w:0,h:0,o:0},{x:.65,y:.65,w:.1,h:.1,o:.2},{x:.6,y:.6,w:.2,h:.2,o:.4},{x:.55,y:.55,w:.3,h:.3,o:.6},{x:.5,y:.5,w:.4,h:.4,o:.8},{x:.45,y:.45,w:.5,h:.5,o:.9},{x:.4,y:.4,w:.6,h:.6,o:1}],S.types.slide=[{x:.4,y:1,w:.6,h:.6,o:1},{x:.4,y:.9,w:.6,h:.6,o:1},{x:.4,y:.9,w:.6,h:.6,o:1},{x:.4,y:.8,w:.6,h:.6,o:1},{x:.4,y:.7,w:.6,h:.6,o:1},{x:.4,y:.6,w:.6,h:.6,o:1},{x:.4,y:.5,w:.6,h:.6,o:1},{x:.4,y:.4,w:.6,h:.6,o:1}],S.run=function(e,t,o,a){var l=S.types[r()?"none":i.animation];return a=o===!0?"undefined"!=typeof a?a:l.length-1:"undefined"!=typeof a?a:0,t=t?t:function(){},a<l.length&&a>=0?(A[i.type](n(e,l[a])),m=setTimeout(function(){o?a-=1:a+=1,S.run(e,t,o,a)},S.duration),O.setIcon(h),void 0):void t()},E(),{badge:T,video:R,image:U,webcam:L,reset:M.reset,browser:{supported:x.supported}}};"undefined"!=typeof define&&define.amd?define([],function(){return e}):"undefined"!=typeof module&&module.exports?module.exports=e:this.Favico=e}();
++\ No newline at end of file
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\kasimi\\faviconnotifications/styles/all/template/js/favico-0.3.10.min.js" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\kasimi\\faviconnotifications/styles/all/template/js/favico-0.3.10.min.js"
++new file mode 100644
++index 000000000..66ccf4740
++--- /dev/null
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\kasimi\\faviconnotifications/styles/all/template/js/favico-0.3.10.min.js"
++@@ -0,0 +1,7 @@
+++/**
+++ * @license MIT
+++ * @fileOverview Favico animations
+++ * @author Miroslav Magda, http://blog.ejci.net
+++ * @version 0.3.10
+++ */
+++!function(){var e=function(e){"use strict";function t(e){if(e.paused||e.ended||w)return!1;try{h.clearRect(0,0,l,a),h.drawImage(e,0,0,l,a)}catch(e){}m=setTimeout(function(){t(e)},I.duration),A.setIcon(s)}function o(e){e=e.replace(/^#?([a-f\d])([a-f\d])([a-f\d])$/i,function(e,t,o,n){return t+t+o+o+n+n});var t=/^#?([a-f\d]{2})([a-f\d]{2})([a-f\d]{2})$/i.exec(e);return!!t&&{r:parseInt(t[1],16),g:parseInt(t[2],16),b:parseInt(t[3],16)}}function n(e,t){var o,n={};for(o in e)n[o]=e[o];for(o in t)n[o]=t[o];return n}e=e||{};var r,i,a,l,s,h,f,c,d,u,y,w,g,x,m,p,b={bgColor:"#d00",textColor:"#fff",fontFamily:"sans-serif",fontStyle:"bold",type:"circle",position:"down",animation:"slide",elementId:!1,dataUrl:!1,win:window};(g={}).ff="undefined"!=typeof InstallTrigger,g.chrome=!!window.chrome,g.opera=!!window.opera||navigator.userAgent.indexOf("Opera")>=0,g.ie=!1,g.safari=Object.prototype.toString.call(window.HTMLElement).indexOf("Constructor")>0,g.supported=g.chrome||g.ff||g.opera;var v=[];y=function(){},c=w=!1;var C={ready:function(){c=!0,C.reset(),y()},reset:function(){c&&(v=[],d=!1,u=!1,h.clearRect(0,0,l,a),h.drawImage(f,0,0,l,a),A.setIcon(s),window.clearTimeout(x),window.clearTimeout(m))}};C.start=function(){if(c&&!u){if(v.length>0){u=!0;var e=function(){["type","animation","bgColor","textColor","fontFamily","fontStyle"].forEach(function(e){e in v[0].options&&(r[e]=v[0].options[e])}),I.run(v[0].options,function(){d=v[0],u=!1,v.length>0&&(v.shift(),C.start())},!1)};d?I.run(d.options,function(){e()},!0):e()}}};var E={},M=function(e){return e.n="number"==typeof e.n?Math.abs(0|e.n):e.n,e.x=l*e.x,e.y=a*e.y,e.w=l*e.w,e.h=a*e.h,e.len=(""+e.n).length,e};E.circle=function(e){var t=!1;2===(e=M(e)).len?(e.x=e.x-.4*e.w,e.w=1.4*e.w,t=!0):e.len>=3&&(e.x=e.x-.65*e.w,e.w=1.65*e.w,t=!0),h.clearRect(0,0,l,a),h.drawImage(f,0,0,l,a),h.beginPath(),h.font=r.fontStyle+" "+Math.floor(e.h*(e.n>99?.85:1))+"px "+r.fontFamily,h.textAlign="center",t?(h.moveTo(e.x+e.w/2,e.y),h.lineTo(e.x+e.w-e.h/2,e.y),h.quadraticCurveTo(e.x+e.w,e.y,e.x+e.w,e.y+e.h/2),h.lineTo(e.x+e.w,e.y+e.h-e.h/2),h.quadraticCurveTo(e.x+e.w,e.y+e.h,e.x+e.w-e.h/2,e.y+e.h),h.lineTo(e.x+e.h/2,e.y+e.h),h.quadraticCurveTo(e.x,e.y+e.h,e.x,e.y+e.h-e.h/2),h.lineTo(e.x,e.y+e.h/2),h.quadraticCurveTo(e.x,e.y,e.x+e.h/2,e.y)):h.arc(e.x+e.w/2,e.y+e.h/2,e.h/2,0,2*Math.PI),h.fillStyle="rgba("+r.bgColor.r+","+r.bgColor.g+","+r.bgColor.b+","+e.o+")",h.fill(),h.closePath(),h.beginPath(),h.stroke(),h.fillStyle="rgba("+r.textColor.r+","+r.textColor.g+","+r.textColor.b+","+e.o+")","number"==typeof e.n&&e.n>999?h.fillText((e.n>9999?9:Math.floor(e.n/1e3))+"k+",Math.floor(e.x+e.w/2),Math.floor(e.y+e.h-.2*e.h)):h.fillText(e.n,Math.floor(e.x+e.w/2),Math.floor(e.y+e.h-.15*e.h)),h.closePath()},E.rectangle=function(e){2===(e=M(e)).len?(e.x=e.x-.4*e.w,e.w=1.4*e.w):e.len>=3&&(e.x=e.x-.65*e.w,e.w=1.65*e.w),h.clearRect(0,0,l,a),h.drawImage(f,0,0,l,a),h.beginPath(),h.font=r.fontStyle+" "+Math.floor(e.h*(e.n>99?.9:1))+"px "+r.fontFamily,h.textAlign="center",h.fillStyle="rgba("+r.bgColor.r+","+r.bgColor.g+","+r.bgColor.b+","+e.o+")",h.fillRect(e.x,e.y,e.w,e.h),h.fillStyle="rgba("+r.textColor.r+","+r.textColor.g+","+r.textColor.b+","+e.o+")","number"==typeof e.n&&e.n>999?h.fillText((e.n>9999?9:Math.floor(e.n/1e3))+"k+",Math.floor(e.x+e.w/2),Math.floor(e.y+e.h-.2*e.h)):h.fillText(e.n,Math.floor(e.x+e.w/2),Math.floor(e.y+e.h-.15*e.h)),h.closePath()};var A={getIcon:function(){var e=!1;return r.element?e=r.element:r.elementId?(e=p.getElementById(r.elementId)).setAttribute("href",e.getAttribute("src")):!1===(e=function(){for(var e=p.getElementsByTagName("head")[0].getElementsByTagName("link"),t=e.length-1;t>=0;t--)if(/(^|\s)icon(\s|$)/i.test(e[t].getAttribute("rel")))return e[t];return!1}())&&((e=p.createElement("link")).setAttribute("rel","icon"),p.getElementsByTagName("head")[0].appendChild(e)),e.setAttribute("type","image/png"),e},setIcon:function(e){var t=e.toDataURL("image/png");if(r.dataUrl&&r.dataUrl(t),r.element)r.element.setAttribute("href",t),r.element.setAttribute("src",t);else if(r.elementId){var o=p.getElementById(r.elementId);o.setAttribute("href",t),o.setAttribute("src",t)}else if(g.ff||g.opera){var n=i;i=p.createElement("link"),g.opera&&i.setAttribute("rel","icon"),i.setAttribute("rel","icon"),i.setAttribute("type","image/png"),p.getElementsByTagName("head")[0].appendChild(i),i.setAttribute("href",t),n.parentNode&&n.parentNode.removeChild(n)}else i.setAttribute("href",t)}},I={duration:40,types:{}};return I.types.fade=[{x:.4,y:.4,w:.6,h:.6,o:0},{x:.4,y:.4,w:.6,h:.6,o:.1},{x:.4,y:.4,w:.6,h:.6,o:.2},{x:.4,y:.4,w:.6,h:.6,o:.3},{x:.4,y:.4,w:.6,h:.6,o:.4},{x:.4,y:.4,w:.6,h:.6,o:.5},{x:.4,y:.4,w:.6,h:.6,o:.6},{x:.4,y:.4,w:.6,h:.6,o:.7},{x:.4,y:.4,w:.6,h:.6,o:.8},{x:.4,y:.4,w:.6,h:.6,o:.9},{x:.4,y:.4,w:.6,h:.6,o:1}],I.types.none=[{x:.4,y:.4,w:.6,h:.6,o:1}],I.types.pop=[{x:1,y:1,w:0,h:0,o:1},{x:.9,y:.9,w:.1,h:.1,o:1},{x:.8,y:.8,w:.2,h:.2,o:1},{x:.7,y:.7,w:.3,h:.3,o:1},{x:.6,y:.6,w:.4,h:.4,o:1},{x:.5,y:.5,w:.5,h:.5,o:1},{x:.4,y:.4,w:.6,h:.6,o:1}],I.types.popFade=[{x:.75,y:.75,w:0,h:0,o:0},{x:.65,y:.65,w:.1,h:.1,o:.2},{x:.6,y:.6,w:.2,h:.2,o:.4},{x:.55,y:.55,w:.3,h:.3,o:.6},{x:.5,y:.5,w:.4,h:.4,o:.8},{x:.45,y:.45,w:.5,h:.5,o:.9},{x:.4,y:.4,w:.6,h:.6,o:1}],I.types.slide=[{x:.4,y:1,w:.6,h:.6,o:1},{x:.4,y:.9,w:.6,h:.6,o:1},{x:.4,y:.9,w:.6,h:.6,o:1},{x:.4,y:.8,w:.6,h:.6,o:1},{x:.4,y:.7,w:.6,h:.6,o:1},{x:.4,y:.6,w:.6,h:.6,o:1},{x:.4,y:.5,w:.6,h:.6,o:1},{x:.4,y:.4,w:.6,h:.6,o:1}],I.run=function(e,t,o,i){var a=I.types[p.hidden||p.msHidden||p.webkitHidden||p.mozHidden?"none":r.animation];return i=!0===o?void 0!==i?i:a.length-1:void 0!==i?i:0,t=t||function(){},i<a.length&&i>=0?(E[r.type](n(e,a[i])),x=setTimeout(function(){o?i-=1:i+=1,I.run(e,t,o,i)},I.duration),void A.setIcon(s)):void t()},function(){(r=n(b,e)).bgColor=o(r.bgColor),r.textColor=o(r.textColor),r.position=r.position.toLowerCase(),r.animation=I.types[""+r.animation]?r.animation:b.animation,p=r.win.document;var t=r.position.indexOf("up")>-1,c=r.position.indexOf("left")>-1;if(t||c)for(var d=0;d<I.types[""+r.animation].length;d++){var u=I.types[""+r.animation][d];t&&(u.y=u.y<.6?u.y-.4:u.y-2*u.y+(1-u.w)),c&&(u.x=u.x<.6?u.x-.4:u.x-2*u.x+(1-u.h)),I.types[""+r.animation][d]=u}r.type=E[""+r.type]?r.type:b.type,i=A.getIcon(),s=document.createElement("canvas"),f=document.createElement("img"),i.hasAttribute("href")?(f.setAttribute("crossOrigin","anonymous"),f.onload=function(){a=f.height>0?f.height:32,l=f.width>0?f.width:32,s.height=a,s.width=l,h=s.getContext("2d"),C.ready()},f.setAttribute("src",i.getAttribute("href"))):(f.onload=function(){a=32,l=32,f.height=a,f.width=l,s.height=a,s.width=l,h=s.getContext("2d"),C.ready()},f.setAttribute("src",""))}(),{badge:function(e,t){t=("string"==typeof t?{animation:t}:t)||{},y=function(){try{if("number"==typeof e?e>0:""!==e){var n={type:"badge",options:{n:e}};if("animation"in t&&I.types[""+t.animation]&&(n.options.animation=""+t.animation),"type"in t&&E[""+t.type]&&(n.options.type=""+t.type),["bgColor","textColor"].forEach(function(e){e in t&&(n.options[e]=o(t[e]))}),["fontStyle","fontFamily"].forEach(function(e){e in t&&(n.options[e]=t[e])}),v.push(n),v.length>100)throw new Error("Too many badges requests in queue.");C.start()}else C.reset()}catch(e){throw new Error("Error setting badge. Message: "+e.message)}},c&&y()},video:function(e){y=function(){try{if("stop"===e)return w=!0,C.reset(),void(w=!1);e.addEventListener("play",function(){t(this)},!1)}catch(e){throw new Error("Error setting video. Message: "+e.message)}},c&&y()},image:function(e){y=function(){try{var t=e.width,o=e.height,n=document.createElement("img"),r=o/a>t/l?t/l:o/a;n.setAttribute("crossOrigin","anonymous"),n.onload=function(){h.clearRect(0,0,l,a),h.drawImage(n,0,0,l,a),A.setIcon(s)},n.setAttribute("src",e.getAttribute("src")),n.height=o/r,n.width=t/r}catch(e){throw new Error("Error setting image. Message: "+e.message)}},c&&y()},webcam:function(e){if(window.URL&&window.URL.createObjectURL||(window.URL=window.URL||{},window.URL.createObjectURL=function(e){return e}),g.supported){var o=!1;navigator.getUserMedia=navigator.getUserMedia||navigator.oGetUserMedia||navigator.msGetUserMedia||navigator.mozGetUserMedia||navigator.webkitGetUserMedia,y=function(){try{if("stop"===e)return w=!0,C.reset(),void(w=!1);(o=document.createElement("video")).width=l,o.height=a,navigator.getUserMedia({video:!0,audio:!1},function(e){o.src=URL.createObjectURL(e),o.play(),t(o)},function(){})}catch(e){throw new Error("Error setting webcam. Message: "+e.message)}},c&&y()}},reset:C.reset,browser:{supported:g.supported}}};"undefined"!=typeof define&&define.amd?define([],function(){return e}):"undefined"!=typeof module&&module.exports?module.exports=e:this.Favico=e}();
++\ No newline at end of file
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\kasimi\\faviconnotifications/styles/all/template/js/faviconnotifications.bak.js" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\kasimi\\faviconnotifications/styles/all/template/js/faviconnotifications.bak.js"
++new file mode 100644
++index 000000000..15165fc80
++--- /dev/null
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\kasimi\\faviconnotifications/styles/all/template/js/faviconnotifications.bak.js"
++@@ -0,0 +1,41 @@
+++/**
+++ *
+++ * @package phpBB Extension - Favicon Notifications
+++ * @copyright (c) 2016 kasimi
+++ * @license http://opensource.org/licenses/gpl-2.0.php GNU
\ No newline at end of file
diff --git "[FORUM_EXT]/kasimi\\faviconnotifications/styles/BBOOTS/template/event/overall_header_head_append.html" "[FORUM_EXT]/kasimi\\faviconnotifications/styles/BBOOTS/template/event/overall_header_head_append.html"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/kasimi\\faviconnotifications/styles/BBOOTS/template/event/overall_header_head_append.html"
@@ -0,0 +1,4 @@
+<!-- IF S_USER_LOGGED_IN and not S_IS_BOT -->
+	<!-- INCLUDEJS js/favico-0.3.10.min.js -->
+	<!-- INCLUDEJS js/faviconnotifications.js -->
+<!-- ENDIF -->
diff --git "[FORUM_EXT]/kasimi\\faviconnotifications/styles/BBOOTS/template/js/favico-0.3.10.min.bak.js" "[FORUM_EXT]/kasimi\\faviconnotifications/styles/BBOOTS/template/js/favico-0.3.10.min.bak.js"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/kasimi\\faviconnotifications/styles/BBOOTS/template/js/favico-0.3.10.min.bak.js"
@@ -0,0 +1,7 @@
+/**
+ * @license MIT
+ * @fileOverview Favico animations
+ * @author Miroslav Magda, http://blog.ejci.net
+ * @version 0.3.10
+ */
+!function(){var e=function(e){"use strict";function t(e){if(e.paused||e.ended||g)return!1;try{f.clearRect(0,0,s,l),f.drawImage(e,0,0,s,l)}catch(o){}p=setTimeout(function(){t(e)},S.duration),O.setIcon(h)}function o(e){var t=/^#?([a-f\d])([a-f\d])([a-f\d])$/i;e=e.replace(t,function(e,t,o,n){return t+t+o+o+n+n});var o=/^#?([a-f\d]{2})([a-f\d]{2})([a-f\d]{2})$/i.exec(e);return o?{r:parseInt(o[1],16),g:parseInt(o[2],16),b:parseInt(o[3],16)}:!1}function n(e,t){var o,n={};for(o in e)n[o]=e[o];for(o in t)n[o]=t[o];return n}function r(){return b.hidden||b.msHidden||b.webkitHidden||b.mozHidden}e=e?e:{};var i,a,l,s,h,f,c,d,u,y,w,g,x,m,p,b,v={bgColor:"#d00",textColor:"#fff",fontFamily:"sans-serif",fontStyle:"bold",type:"circle",position:"down",animation:"slide",elementId:!1,dataUrl:!1,win:window};x={},x.ff="undefined"!=typeof InstallTrigger,x.chrome=!!window.chrome,x.opera=!!window.opera||navigator.userAgent.indexOf("Opera")>=0,x.ie=/*@cc_on!@*/!1,x.safari=Object.prototype.toString.call(window.HTMLElement).indexOf("Constructor")>0,x.supported=x.chrome||x.ff||x.opera;var C=[];w=function(){},d=g=!1;var E=function(){i=n(v,e),i.bgColor=o(i.bgColor),i.textColor=o(i.textColor),i.position=i.position.toLowerCase(),i.animation=S.types[""+i.animation]?i.animation:v.animation,b=i.win.document;var t=i.position.indexOf("up")>-1,r=i.position.indexOf("left")>-1;if(t||r)for(var d=0;d<S.types[""+i.animation].length;d++){var u=S.types[""+i.animation][d];t&&(u.y=u.y<.6?u.y-.4:u.y-2*u.y+(1-u.w)),r&&(u.x=u.x<.6?u.x-.4:u.x-2*u.x+(1-u.h)),S.types[""+i.animation][d]=u}i.type=A[""+i.type]?i.type:v.type,a=O.getIcon(),h=document.createElement("canvas"),c=document.createElement("img"),a.hasAttribute("href")?(c.setAttribute("crossOrigin","anonymous"),c.onload=function(){l=c.height>0?c.height:32,s=c.width>0?c.width:32,h.height=l,h.width=s,f=h.getContext("2d"),M.ready()},c.setAttribute("src",a.getAttribute("href"))):(c.onload=function(){l=32,s=32,c.height=l,c.width=s,h.height=l,h.width=s,f=h.getContext("2d"),M.ready()},c.setAttribute("src",""))},M={};M.ready=function(){d=!0,M.reset(),w()},M.reset=function(){d&&(C=[],u=!1,y=!1,f.clearRect(0,0,s,l),f.drawImage(c,0,0,s,l),O.setIcon(h),window.clearTimeout(m),window.clearTimeout(p))},M.start=function(){if(d&&!y){var e=function(){u=C[0],y=!1,C.length>0&&(C.shift(),M.start())};if(C.length>0){y=!0;var t=function(){["type","animation","bgColor","textColor","fontFamily","fontStyle"].forEach(function(e){e in C[0].options&&(i[e]=C[0].options[e])}),S.run(C[0].options,function(){e()},!1)};u?S.run(u.options,function(){t()},!0):t()}}};var A={},I=function(e){return e.n="number"==typeof e.n?Math.abs(0|e.n):e.n,e.x=s*e.x,e.y=l*e.y,e.w=s*e.w,e.h=l*e.h,e.len=(""+e.n).length,e};A.circle=function(e){e=I(e);var t=!1;2===e.len?(e.x=e.x-.4*e.w,e.w=1.4*e.w,t=!0):e.len>=3&&(e.x=e.x-.65*e.w,e.w=1.65*e.w,t=!0),f.clearRect(0,0,s,l),f.drawImage(c,0,0,s,l),f.beginPath(),f.font=i.fontStyle+" "+Math.floor(e.h*(e.n>99?.85:1))+"px "+i.fontFamily,f.textAlign="center",t?(f.moveTo(e.x+e.w/2,e.y),f.lineTo(e.x+e.w-e.h/2,e.y),f.quadraticCurveTo(e.x+e.w,e.y,e.x+e.w,e.y+e.h/2),f.lineTo(e.x+e.w,e.y+e.h-e.h/2),f.quadraticCurveTo(e.x+e.w,e.y+e.h,e.x+e.w-e.h/2,e.y+e.h),f.lineTo(e.x+e.h/2,e.y+e.h),f.quadraticCurveTo(e.x,e.y+e.h,e.x,e.y+e.h-e.h/2),f.lineTo(e.x,e.y+e.h/2),f.quadraticCurveTo(e.x,e.y,e.x+e.h/2,e.y)):f.arc(e.x+e.w/2,e.y+e.h/2,e.h/2,0,2*Math.PI),f.fillStyle="rgba("+i.bgColor.r+","+i.bgColor.g+","+i.bgColor.b+","+e.o+")",f.fill(),f.closePath(),f.beginPath(),f.stroke(),f.fillStyle="rgba("+i.textColor.r+","+i.textColor.g+","+i.textColor.b+","+e.o+")","number"==typeof e.n&&e.n>999?f.fillText((e.n>9999?9:Math.floor(e.n/1e3))+"k+",Math.floor(e.x+e.w/2),Math.floor(e.y+e.h-.2*e.h)):f.fillText(e.n,Math.floor(e.x+e.w/2),Math.floor(e.y+e.h-.15*e.h)),f.closePath()},A.rectangle=function(e){e=I(e);var t=!1;2===e.len?(e.x=e.x-.4*e.w,e.w=1.4*e.w,t=!0):e.len>=3&&(e.x=e.x-.65*e.w,e.w=1.65*e.w,t=!0),f.clearRect(0,0,s,l),f.drawImage(c,0,0,s,l),f.beginPath(),f.font=i.fontStyle+" "+Math.floor(e.h*(e.n>99?.9:1))+"px "+i.fontFamily,f.textAlign="center",f.fillStyle="rgba("+i.bgColor.r+","+i.bgColor.g+","+i.bgColor.b+","+e.o+")",f.fillRect(e.x,e.y,e.w,e.h),f.fillStyle="rgba("+i.textColor.r+","+i.textColor.g+","+i.textColor.b+","+e.o+")","number"==typeof e.n&&e.n>999?f.fillText((e.n>9999?9:Math.floor(e.n/1e3))+"k+",Math.floor(e.x+e.w/2),Math.floor(e.y+e.h-.2*e.h)):f.fillText(e.n,Math.floor(e.x+e.w/2),Math.floor(e.y+e.h-.15*e.h)),f.closePath()};var T=function(e,t){t=("string"==typeof t?{animation:t}:t)||{},w=function(){try{if("number"==typeof e?e>0:""!==e){var n={type:"badge",options:{n:e}};if("animation"in t&&S.types[""+t.animation]&&(n.options.animation=""+t.animation),"type"in t&&A[""+t.type]&&(n.options.type=""+t.type),["bgColor","textColor"].forEach(function(e){e in t&&(n.options[e]=o(t[e]))}),["fontStyle","fontFamily"].forEach(function(e){e in t&&(n.options[e]=t[e])}),C.push(n),C.length>100)throw new Error("Too many badges requests in queue.");M.start()}else M.reset()}catch(r){throw new Error("Error setting badge. Message: "+r.message)}},d&&w()},U=function(e){w=function(){try{var t=e.width,o=e.height,n=document.createElement("img"),r=o/l>t/s?t/s:o/l;n.setAttribute("crossOrigin","anonymous"),n.onload=function(){f.clearRect(0,0,s,l),f.drawImage(n,0,0,s,l),O.setIcon(h)},n.setAttribute("src",e.getAttribute("src")),n.height=o/r,n.width=t/r}catch(i){throw new Error("Error setting image. Message: "+i.message)}},d&&w()},R=function(e){w=function(){try{if("stop"===e)return g=!0,M.reset(),void(g=!1);e.addEventListener("play",function(){t(this)},!1)}catch(o){throw new Error("Error setting video. Message: "+o.message)}},d&&w()},L=function(e){if(window.URL&&window.URL.createObjectURL||(window.URL=window.URL||{},window.URL.createObjectURL=function(e){return e}),x.supported){var o=!1;navigator.getUserMedia=navigator.getUserMedia||navigator.oGetUserMedia||navigator.msGetUserMedia||navigator.mozGetUserMedia||navigator.webkitGetUserMedia,w=function(){try{if("stop"===e)return g=!0,M.reset(),void(g=!1);o=document.createElement("video"),o.width=s,o.height=l,navigator.getUserMedia({video:!0,audio:!1},function(e){o.src=URL.createObjectURL(e),o.play(),t(o)},function(){})}catch(n){throw new Error("Error setting webcam. Message: "+n.message)}},d&&w()}},O={};O.getIcon=function(){var e=!1,t=function(){for(var e=b.getElementsByTagName("head")[0].getElementsByTagName("link"),t=e.length,o=t-1;o>=0;o--)if(/(^|\s)icon(\s|$)/i.test(e[o].getAttribute("rel")))return e[o];return!1};return i.element?e=i.element:i.elementId?(e=b.getElementById(i.elementId),e.setAttribute("href",e.getAttribute("src"))):(e=t(),e===!1&&(e=b.createElement("link"),e.setAttribute("rel","icon"),b.getElementsByTagName("head")[0].appendChild(e))),e.setAttribute("type","image/png"),e},O.setIcon=function(e){var t=e.toDataURL("image/png");if(i.dataUrl&&i.dataUrl(t),i.element)i.element.setAttribute("href",t),i.element.setAttribute("src",t);else if(i.elementId){var o=b.getElementById(i.elementId);o.setAttribute("href",t),o.setAttribute("src",t)}else if(x.ff||x.opera){var n=a;a=b.createElement("link"),x.opera&&a.setAttribute("rel","icon"),a.setAttribute("rel","icon"),a.setAttribute("type","image/png"),b.getElementsByTagName("head")[0].appendChild(a),a.setAttribute("href",t),n.parentNode&&n.parentNode.removeChild(n)}else a.setAttribute("href",t)};var S={};return S.duration=40,S.types={},S.types.fade=[{x:.4,y:.4,w:.6,h:.6,o:0},{x:.4,y:.4,w:.6,h:.6,o:.1},{x:.4,y:.4,w:.6,h:.6,o:.2},{x:.4,y:.4,w:.6,h:.6,o:.3},{x:.4,y:.4,w:.6,h:.6,o:.4},{x:.4,y:.4,w:.6,h:.6,o:.5},{x:.4,y:.4,w:.6,h:.6,o:.6},{x:.4,y:.4,w:.6,h:.6,o:.7},{x:.4,y:.4,w:.6,h:.6,o:.8},{x:.4,y:.4,w:.6,h:.6,o:.9},{x:.4,y:.4,w:.6,h:.6,o:1}],S.types.none=[{x:.4,y:.4,w:.6,h:.6,o:1}],S.types.pop=[{x:1,y:1,w:0,h:0,o:1},{x:.9,y:.9,w:.1,h:.1,o:1},{x:.8,y:.8,w:.2,h:.2,o:1},{x:.7,y:.7,w:.3,h:.3,o:1},{x:.6,y:.6,w:.4,h:.4,o:1},{x:.5,y:.5,w:.5,h:.5,o:1},{x:.4,y:.4,w:.6,h:.6,o:1}],S.types.popFade=[{x:.75,y:.75,w:0,h:0,o:0},{x:.65,y:.65,w:.1,h:.1,o:.2},{x:.6,y:.6,w:.2,h:.2,o:.4},{x:.55,y:.55,w:.3,h:.3,o:.6},{x:.5,y:.5,w:.4,h:.4,o:.8},{x:.45,y:.45,w:.5,h:.5,o:.9},{x:.4,y:.4,w:.6,h:.6,o:1}],S.types.slide=[{x:.4,y:1,w:.6,h:.6,o:1},{x:.4,y:.9,w:.6,h:.6,o:1},{x:.4,y:.9,w:.6,h:.6,o:1},{x:.4,y:.8,w:.6,h:.6,o:1},{x:.4,y:.7,w:.6,h:.6,o:1},{x:.4,y:.6,w:.6,h:.6,o:1},{x:.4,y:.5,w:.6,h:.6,o:1},{x:.4,y:.4,w:.6,h:.6,o:1}],S.run=function(e,t,o,a){var l=S.types[r()?"none":i.animation];return a=o===!0?"undefined"!=typeof a?a:l.length-1:"undefined"!=typeof a?a:0,t=t?t:function(){},a<l.length&&a>=0?(A[i.type](n(e,l[a])),m=setTimeout(function(){o?a-=1:a+=1,S.run(e,t,o,a)},S.duration),O.setIcon(h),void 0):void t()},E(),{badge:T,video:R,image:U,webcam:L,reset:M.reset,browser:{supported:x.supported}}};"undefined"!=typeof define&&define.amd?define([],function(){return e}):"undefined"!=typeof module&&module.exports?module.exports=e:this.Favico=e}();
\ No newline at end of file
diff --git "[FORUM_EXT]/kasimi\\faviconnotifications/styles/BBOOTS/template/js/favico-0.3.10.min.js" "[FORUM_EXT]/kasimi\\faviconnotifications/styles/BBOOTS/template/js/favico-0.3.10.min.js"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/kasimi\\faviconnotifications/styles/BBOOTS/template/js/favico-0.3.10.min.js"
@@ -0,0 +1,7 @@
+/**
+ * @license MIT
+ * @fileOverview Favico animations
+ * @author Miroslav Magda, http://blog.ejci.net
+ * @version 0.3.10
+ */
+!function(){var e=function(e){"use strict";function t(e){if(e.paused||e.ended||w)return!1;try{h.clearRect(0,0,l,a),h.drawImage(e,0,0,l,a)}catch(e){}m=setTimeout(function(){t(e)},I.duration),A.setIcon(s)}function o(e){e=e.replace(/^#?([a-f\d])([a-f\d])([a-f\d])$/i,function(e,t,o,n){return t+t+o+o+n+n});var t=/^#?([a-f\d]{2})([a-f\d]{2})([a-f\d]{2})$/i.exec(e);return!!t&&{r:parseInt(t[1],16),g:parseInt(t[2],16),b:parseInt(t[3],16)}}function n(e,t){var o,n={};for(o in e)n[o]=e[o];for(o in t)n[o]=t[o];return n}e=e||{};var r,i,a,l,s,h,f,c,d,u,y,w,g,x,m,p,b={bgColor:"#d00",textColor:"#fff",fontFamily:"sans-serif",fontStyle:"bold",type:"circle",position:"down",animation:"slide",elementId:!1,dataUrl:!1,win:window};(g={}).ff="undefined"!=typeof InstallTrigger,g.chrome=!!window.chrome,g.opera=!!window.opera||navigator.userAgent.indexOf("Opera")>=0,g.ie=!1,g.safari=Object.prototype.toString.call(window.HTMLElement).indexOf("Constructor")>0,g.supported=g.chrome||g.ff||g.opera;var v=[];y=function(){},c=w=!1;var C={ready:function(){c=!0,C.reset(),y()},reset:function(){c&&(v=[],d=!1,u=!1,h.clearRect(0,0,l,a),h.drawImage(f,0,0,l,a),A.setIcon(s),window.clearTimeout(x),window.clearTimeout(m))}};C.start=function(){if(c&&!u){if(v.length>0){u=!0;var e=function(){["type","animation","bgColor","textColor","fontFamily","fontStyle"].forEach(function(e){e in v[0].options&&(r[e]=v[0].options[e])}),I.run(v[0].options,function(){d=v[0],u=!1,v.length>0&&(v.shift(),C.start())},!1)};d?I.run(d.options,function(){e()},!0):e()}}};var E={},M=function(e){return e.n="number"==typeof e.n?Math.abs(0|e.n):e.n,e.x=l*e.x,e.y=a*e.y,e.w=l*e.w,e.h=a*e.h,e.len=(""+e.n).length,e};E.circle=function(e){var t=!1;2===(e=M(e)).len?(e.x=e.x-.4*e.w,e.w=1.4*e.w,t=!0):e.len>=3&&(e.x=e.x-.65*e.w,e.w=1.65*e.w,t=!0),h.clearRect(0,0,l,a),h.drawImage(f,0,0,l,a),h.beginPath(),h.font=r.fontStyle+" "+Math.floor(e.h*(e.n>99?.85:1))+"px "+r.fontFamily,h.textAlign="center",t?(h.moveTo(e.x+e.w/2,e.y),h.lineTo(e.x+e.w-e.h/2,e.y),h.quadraticCurveTo(e.x+e.w,e.y,e.x+e.w,e.y+e.h/2),h.lineTo(e.x+e.w,e.y+e.h-e.h/2),h.quadraticCurveTo(e.x+e.w,e.y+e.h,e.x+e.w-e.h/2,e.y+e.h),h.lineTo(e.x+e.h/2,e.y+e.h),h.quadraticCurveTo(e.x,e.y+e.h,e.x,e.y+e.h-e.h/2),h.lineTo(e.x,e.y+e.h/2),h.quadraticCurveTo(e.x,e.y,e.x+e.h/2,e.y)):h.arc(e.x+e.w/2,e.y+e.h/2,e.h/2,0,2*Math.PI),h.fillStyle="rgba("+r.bgColor.r+","+r.bgColor.g+","+r.bgColor.b+","+e.o+")",h.fill(),h.closePath(),h.beginPath(),h.stroke(),h.fillStyle="rgba("+r.textColor.r+","+r.textColor.g+","+r.textColor.b+","+e.o+")","number"==typeof e.n&&e.n>999?h.fillText((e.n>9999?9:Math.floor(e.n/1e3))+"k+",Math.floor(e.x+e.w/2),Math.floor(e.y+e.h-.2*e.h)):h.fillText(e.n,Math.floor(e.x+e.w/2),Math.floor(e.y+e.h-.15*e.h)),h.closePath()},E.rectangle=function(e){2===(e=M(e)).len?(e.x=e.x-.4*e.w,e.w=1.4*e.w):e.len>=3&&(e.x=e.x-.65*e.w,e.w=1.65*e.w),h.clearRect(0,0,l,a),h.drawImage(f,0,0,l,a),h.beginPath(),h.font=r.fontStyle+" "+Math.floor(e.h*(e.n>99?.9:1))+"px "+r.fontFamily,h.textAlign="center",h.fillStyle="rgba("+r.bgColor.r+","+r.bgColor.g+","+r.bgColor.b+","+e.o+")",h.fillRect(e.x,e.y,e.w,e.h),h.fillStyle="rgba("+r.textColor.r+","+r.textColor.g+","+r.textColor.b+","+e.o+")","number"==typeof e.n&&e.n>999?h.fillText((e.n>9999?9:Math.floor(e.n/1e3))+"k+",Math.floor(e.x+e.w/2),Math.floor(e.y+e.h-.2*e.h)):h.fillText(e.n,Math.floor(e.x+e.w/2),Math.floor(e.y+e.h-.15*e.h)),h.closePath()};var A={getIcon:function(){var e=!1;return r.element?e=r.element:r.elementId?(e=p.getElementById(r.elementId)).setAttribute("href",e.getAttribute("src")):!1===(e=function(){for(var e=p.getElementsByTagName("head")[0].getElementsByTagName("link"),t=e.length-1;t>=0;t--)if(/(^|\s)icon(\s|$)/i.test(e[t].getAttribute("rel")))return e[t];return!1}())&&((e=p.createElement("link")).setAttribute("rel","icon"),p.getElementsByTagName("head")[0].appendChild(e)),e.setAttribute("type","image/png"),e},setIcon:function(e){var t=e.toDataURL("image/png");if(r.dataUrl&&r.dataUrl(t),r.element)r.element.setAttribute("href",t),r.element.setAttribute("src",t);else if(r.elementId){var o=p.getElementById(r.elementId);o.setAttribute("href",t),o.setAttribute("src",t)}else if(g.ff||g.opera){var n=i;i=p.createElement("link"),g.opera&&i.setAttribute("rel","icon"),i.setAttribute("rel","icon"),i.setAttribute("type","image/png"),p.getElementsByTagName("head")[0].appendChild(i),i.setAttribute("href",t),n.parentNode&&n.parentNode.removeChild(n)}else i.setAttribute("href",t)}},I={duration:40,types:{}};return I.types.fade=[{x:.4,y:.4,w:.6,h:.6,o:0},{x:.4,y:.4,w:.6,h:.6,o:.1},{x:.4,y:.4,w:.6,h:.6,o:.2},{x:.4,y:.4,w:.6,h:.6,o:.3},{x:.4,y:.4,w:.6,h:.6,o:.4},{x:.4,y:.4,w:.6,h:.6,o:.5},{x:.4,y:.4,w:.6,h:.6,o:.6},{x:.4,y:.4,w:.6,h:.6,o:.7},{x:.4,y:.4,w:.6,h:.6,o:.8},{x:.4,y:.4,w:.6,h:.6,o:.9},{x:.4,y:.4,w:.6,h:.6,o:1}],I.types.none=[{x:.4,y:.4,w:.6,h:.6,o:1}],I.types.pop=[{x:1,y:1,w:0,h:0,o:1},{x:.9,y:.9,w:.1,h:.1,o:1},{x:.8,y:.8,w:.2,h:.2,o:1},{x:.7,y:.7,w:.3,h:.3,o:1},{x:.6,y:.6,w:.4,h:.4,o:1},{x:.5,y:.5,w:.5,h:.5,o:1},{x:.4,y:.4,w:.6,h:.6,o:1}],I.types.popFade=[{x:.75,y:.75,w:0,h:0,o:0},{x:.65,y:.65,w:.1,h:.1,o:.2},{x:.6,y:.6,w:.2,h:.2,o:.4},{x:.55,y:.55,w:.3,h:.3,o:.6},{x:.5,y:.5,w:.4,h:.4,o:.8},{x:.45,y:.45,w:.5,h:.5,o:.9},{x:.4,y:.4,w:.6,h:.6,o:1}],I.types.slide=[{x:.4,y:1,w:.6,h:.6,o:1},{x:.4,y:.9,w:.6,h:.6,o:1},{x:.4,y:.9,w:.6,h:.6,o:1},{x:.4,y:.8,w:.6,h:.6,o:1},{x:.4,y:.7,w:.6,h:.6,o:1},{x:.4,y:.6,w:.6,h:.6,o:1},{x:.4,y:.5,w:.6,h:.6,o:1},{x:.4,y:.4,w:.6,h:.6,o:1}],I.run=function(e,t,o,i){var a=I.types[p.hidden||p.msHidden||p.webkitHidden||p.mozHidden?"none":r.animation];return i=!0===o?void 0!==i?i:a.length-1:void 0!==i?i:0,t=t||function(){},i<a.length&&i>=0?(E[r.type](n(e,a[i])),x=setTimeout(function(){o?i-=1:i+=1,I.run(e,t,o,i)},I.duration),void A.setIcon(s)):void t()},function(){(r=n(b,e)).bgColor=o(r.bgColor),r.textColor=o(r.textColor),r.position=r.position.toLowerCase(),r.animation=I.types[""+r.animation]?r.animation:b.animation,p=r.win.document;var t=r.position.indexOf("up")>-1,c=r.position.indexOf("left")>-1;if(t||c)for(var d=0;d<I.types[""+r.animation].length;d++){var u=I.types[""+r.animation][d];t&&(u.y=u.y<.6?u.y-.4:u.y-2*u.y+(1-u.w)),c&&(u.x=u.x<.6?u.x-.4:u.x-2*u.x+(1-u.h)),I.types[""+r.animation][d]=u}r.type=E[""+r.type]?r.type:b.type,i=A.getIcon(),s=document.createElement("canvas"),f=document.createElement("img"),i.hasAttribute("href")?(f.setAttribute("crossOrigin","anonymous"),f.onload=function(){a=f.height>0?f.height:32,l=f.width>0?f.width:32,s.height=a,s.width=l,h=s.getContext("2d"),C.ready()},f.setAttribute("src",i.getAttribute("href"))):(f.onload=function(){a=32,l=32,f.height=a,f.width=l,s.height=a,s.width=l,h=s.getContext("2d"),C.ready()},f.setAttribute("src",""))}(),{badge:function(e,t){t=("string"==typeof t?{animation:t}:t)||{},y=function(){try{if("number"==typeof e?e>0:""!==e){var n={type:"badge",options:{n:e}};if("animation"in t&&I.types[""+t.animation]&&(n.options.animation=""+t.animation),"type"in t&&E[""+t.type]&&(n.options.type=""+t.type),["bgColor","textColor"].forEach(function(e){e in t&&(n.options[e]=o(t[e]))}),["fontStyle","fontFamily"].forEach(function(e){e in t&&(n.options[e]=t[e])}),v.push(n),v.length>100)throw new Error("Too many badges requests in queue.");C.start()}else C.reset()}catch(e){throw new Error("Error setting badge. Message: "+e.message)}},c&&y()},video:function(e){y=function(){try{if("stop"===e)return w=!0,C.reset(),void(w=!1);e.addEventListener("play",function(){t(this)},!1)}catch(e){throw new Error("Error setting video. Message: "+e.message)}},c&&y()},image:function(e){y=function(){try{var t=e.width,o=e.height,n=document.createElement("img"),r=o/a>t/l?t/l:o/a;n.setAttribute("crossOrigin","anonymous"),n.onload=function(){h.clearRect(0,0,l,a),h.drawImage(n,0,0,l,a),A.setIcon(s)},n.setAttribute("src",e.getAttribute("src")),n.height=o/r,n.width=t/r}catch(e){throw new Error("Error setting image. Message: "+e.message)}},c&&y()},webcam:function(e){if(window.URL&&window.URL.createObjectURL||(window.URL=window.URL||{},window.URL.createObjectURL=function(e){return e}),g.supported){var o=!1;navigator.getUserMedia=navigator.getUserMedia||navigator.oGetUserMedia||navigator.msGetUserMedia||navigator.mozGetUserMedia||navigator.webkitGetUserMedia,y=function(){try{if("stop"===e)return w=!0,C.reset(),void(w=!1);(o=document.createElement("video")).width=l,o.height=a,navigator.getUserMedia({video:!0,audio:!1},function(e){o.src=URL.createObjectURL(e),o.play(),t(o)},function(){})}catch(e){throw new Error("Error setting webcam. Message: "+e.message)}},c&&y()}},reset:C.reset,browser:{supported:g.supported}}};"undefined"!=typeof define&&define.amd?define([],function(){return e}):"undefined"!=typeof module&&module.exports?module.exports=e:this.Favico=e}();
\ No newline at end of file
diff --git "[FORUM_EXT]/kasimi\\faviconnotifications/styles/BBOOTS/template/js/faviconnotifications.bak.js" "[FORUM_EXT]/kasimi\\faviconnotifications/styles/BBOOTS/template/js/faviconnotifications.bak.js"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/kasimi\\faviconnotifications/styles/BBOOTS/template/js/faviconnotifications.bak.js"
@@ -0,0 +1,41 @@
+/**
+ *
+ * @package phpBB Extension - Favicon Notifications
+ * @copyright (c) 2016 kasimi
+ * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
+ *
+ */
+head.ready(function () {
+jQuery(function($) {
+	// Initialize favicon
+	var favicon = new Favico({
+		bgColor		: '#d00',
+		textColor	: '#fff',
+		fontFamily	: 'sans-serif',
+		fontStyle	: 'bold',
+		type		: 'circle',
+		position	: 'down',
+		animation	: 'popFade'
+	});
+
+	var setUnreadNotificationsCount = function(count) {
+		favicon.badge(count);
+	};
+
+	// Set initial notifications count
+	var unreadCount = parseInt($('em', '#notification_list_button').html());
+	setUnreadNotificationsCount(unreadCount);
+
+	// Update notifications count when marking notifications read
+	var phpbbMarkNotifications = phpbb.markNotifications;
+	phpbb.markNotifications = function($popup, unreadCount) {
+		setUnreadNotificationsCount(unreadCount);
+		return phpbbMarkNotifications($popup, unreadCount);
+	};
+
+	// Listen to notifications count updates from extensions
+	$(phpbb).on('kasimi_faviconnotifications_update', function(event, notificationsCount) {
+		setUnreadNotificationsCount(notificationsCount);
+	});
+});
+});
\ No newline at end of file
diff --git "[FORUM_EXT]/kasimi\\faviconnotifications/styles/BBOOTS/template/js/faviconnotifications.js" "[FORUM_EXT]/kasimi\\faviconnotifications/styles/BBOOTS/template/js/faviconnotifications.js"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/kasimi\\faviconnotifications/styles/BBOOTS/template/js/faviconnotifications.js"
@@ -0,0 +1,8 @@
+/**
+ *
+ * @package phpBB Extension - Favicon Notifications
+ * @copyright (c) 2016 kasimi
+ * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
+ *
+ */
+head.ready(function(){jQuery(function(i){var n=new Favico({bgColor:"#d00",textColor:"#fff",fontFamily:"sans-serif",fontStyle:"bold",type:"circle",position:"down",animation:"popFade"}),o=function(i){n.badge(i)},t=parseInt(i("em","#notification_list_button").html());o(t);var a=phpbb.markNotifications;phpbb.markNotifications=function(i,n){return o(n),a(i,n)},i(phpbb).on("kasimi_faviconnotifications_update",function(i,n){o(n)})})});
\ No newline at end of file
diff --git "[FORUM_EXT]/kasimi\\faviconnotifications/styles/FLATBOOTS/template/event/overall_header_head_append.html" "[FORUM_EXT]/kasimi\\faviconnotifications/styles/FLATBOOTS/template/event/overall_header_head_append.html"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/kasimi\\faviconnotifications/styles/FLATBOOTS/template/event/overall_header_head_append.html"
@@ -0,0 +1,4 @@
+<!-- IF S_USER_LOGGED_IN and not S_IS_BOT -->
+	<!-- INCLUDEJS js/favico-0.3.10.min.js -->
+	<!-- INCLUDEJS js/faviconnotifications.js -->
+<!-- ENDIF -->
diff --git "[FORUM_EXT]/kasimi\\faviconnotifications/styles/FLATBOOTS/template/js/favico-0.3.10.min.bak.js" "[FORUM_EXT]/kasimi\\faviconnotifications/styles/FLATBOOTS/template/js/favico-0.3.10.min.bak.js"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/kasimi\\faviconnotifications/styles/FLATBOOTS/template/js/favico-0.3.10.min.bak.js"
@@ -0,0 +1,7 @@
+/**
+ * @license MIT
+ * @fileOverview Favico animations
+ * @author Miroslav Magda, http://blog.ejci.net
+ * @version 0.3.10
+ */
+!function(){var e=function(e){"use strict";function t(e){if(e.paused||e.ended||g)return!1;try{f.clearRect(0,0,s,l),f.drawImage(e,0,0,s,l)}catch(o){}p=setTimeout(function(){t(e)},S.duration),O.setIcon(h)}function o(e){var t=/^#?([a-f\d])([a-f\d])([a-f\d])$/i;e=e.replace(t,function(e,t,o,n){return t+t+o+o+n+n});var o=/^#?([a-f\d]{2})([a-f\d]{2})([a-f\d]{2})$/i.exec(e);return o?{r:parseInt(o[1],16),g:parseInt(o[2],16),b:parseInt(o[3],16)}:!1}function n(e,t){var o,n={};for(o in e)n[o]=e[o];for(o in t)n[o]=t[o];return n}function r(){return b.hidden||b.msHidden||b.webkitHidden||b.mozHidden}e=e?e:{};var i,a,l,s,h,f,c,d,u,y,w,g,x,m,p,b,v={bgColor:"#d00",textColor:"#fff",fontFamily:"sans-serif",fontStyle:"bold",type:"circle",position:"down",animation:"slide",elementId:!1,dataUrl:!1,win:window};x={},x.ff="undefined"!=typeof InstallTrigger,x.chrome=!!window.chrome,x.opera=!!window.opera||navigator.userAgent.indexOf("Opera")>=0,x.ie=/*@cc_on!@*/!1,x.safari=Object.prototype.toString.call(window.HTMLElement).indexOf("Constructor")>0,x.supported=x.chrome||x.ff||x.opera;var C=[];w=function(){},d=g=!1;var E=function(){i=n(v,e),i.bgColor=o(i.bgColor),i.textColor=o(i.textColor),i.position=i.position.toLowerCase(),i.animation=S.types[""+i.animation]?i.animation:v.animation,b=i.win.document;var t=i.position.indexOf("up")>-1,r=i.position.indexOf("left")>-1;if(t||r)for(var d=0;d<S.types[""+i.animation].length;d++){var u=S.types[""+i.animation][d];t&&(u.y=u.y<.6?u.y-.4:u.y-2*u.y+(1-u.w)),r&&(u.x=u.x<.6?u.x-.4:u.x-2*u.x+(1-u.h)),S.types[""+i.animation][d]=u}i.type=A[""+i.type]?i.type:v.type,a=O.getIcon(),h=document.createElement("canvas"),c=document.createElement("img"),a.hasAttribute("href")?(c.setAttribute("crossOrigin","anonymous"),c.onload=function(){l=c.height>0?c.height:32,s=c.width>0?c.width:32,h.height=l,h.width=s,f=h.getContext("2d"),M.ready()},c.setAttribute("src",a.getAttribute("href"))):(c.onload=function(){l=32,s=32,c.height=l,c.width=s,h.height=l,h.width=s,f=h.getContext("2d"),M.ready()},c.setAttribute("src",""))},M={};M.ready=function(){d=!0,M.reset(),w()},M.reset=function(){d&&(C=[],u=!1,y=!1,f.clearRect(0,0,s,l),f.drawImage(c,0,0,s,l),O.setIcon(h),window.clearTimeout(m),window.clearTimeout(p))},M.start=function(){if(d&&!y){var e=function(){u=C[0],y=!1,C.length>0&&(C.shift(),M.start())};if(C.length>0){y=!0;var t=function(){["type","animation","bgColor","textColor","fontFamily","fontStyle"].forEach(function(e){e in C[0].options&&(i[e]=C[0].options[e])}),S.run(C[0].options,function(){e()},!1)};u?S.run(u.options,function(){t()},!0):t()}}};var A={},I=function(e){return e.n="number"==typeof e.n?Math.abs(0|e.n):e.n,e.x=s*e.x,e.y=l*e.y,e.w=s*e.w,e.h=l*e.h,e.len=(""+e.n).length,e};A.circle=function(e){e=I(e);var t=!1;2===e.len?(e.x=e.x-.4*e.w,e.w=1.4*e.w,t=!0):e.len>=3&&(e.x=e.x-.65*e.w,e.w=1.65*e.w,t=!0),f.clearRect(0,0,s,l),f.drawImage(c,0,0,s,l),f.beginPath(),f.font=i.fontStyle+" "+Math.floor(e.h*(e.n>99?.85:1))+"px "+i.fontFamily,f.textAlign="center",t?(f.moveTo(e.x+e.w/2,e.y),f.lineTo(e.x+e.w-e.h/2,e.y),f.quadraticCurveTo(e.x+e.w,e.y,e.x+e.w,e.y+e.h/2),f.lineTo(e.x+e.w,e.y+e.h-e.h/2),f.quadraticCurveTo(e.x+e.w,e.y+e.h,e.x+e.w-e.h/2,e.y+e.h),f.lineTo(e.x+e.h/2,e.y+e.h),f.quadraticCurveTo(e.x,e.y+e.h,e.x,e.y+e.h-e.h/2),f.lineTo(e.x,e.y+e.h/2),f.quadraticCurveTo(e.x,e.y,e.x+e.h/2,e.y)):f.arc(e.x+e.w/2,e.y+e.h/2,e.h/2,0,2*Math.PI),f.fillStyle="rgba("+i.bgColor.r+","+i.bgColor.g+","+i.bgColor.b+","+e.o+")",f.fill(),f.closePath(),f.beginPath(),f.stroke(),f.fillStyle="rgba("+i.textColor.r+","+i.textColor.g+","+i.textColor.b+","+e.o+")","number"==typeof e.n&&e.n>999?f.fillText((e.n>9999?9:Math.floor(e.n/1e3))+"k+",Math.floor(e.x+e.w/2),Math.floor(e.y+e.h-.2*e.h)):f.fillText(e.n,Math.floor(e.x+e.w/2),Math.floor(e.y+e.h-.15*e.h)),f.closePath()},A.rectangle=function(e){e=I(e);var t=!1;2===e.len?(e.x=e.x-.4*e.w,e.w=1.4*e.w,t=!0):e.len>=3&&(e.x=e.x-.65*e.w,e.w=1.65*e.w,t=!0),f.clearRect(0,0,s,l),f.drawImage(c,0,0,s,l),f.beginPath(),f.font=i.fontStyle+" "+Math.floor(e.h*(e.n>99?.9:1))+"px "+i.fontFamily,f.textAlign="center",f.fillStyle="rgba("+i.bgColor.r+","+i.bgColor.g+","+i.bgColor.b+","+e.o+")",f.fillRect(e.x,e.y,e.w,e.h),f.fillStyle="rgba("+i.textColor.r+","+i.textColor.g+","+i.textColor.b+","+e.o+")","number"==typeof e.n&&e.n>999?f.fillText((e.n>9999?9:Math.floor(e.n/1e3))+"k+",Math.floor(e.x+e.w/2),Math.floor(e.y+e.h-.2*e.h)):f.fillText(e.n,Math.floor(e.x+e.w/2),Math.floor(e.y+e.h-.15*e.h)),f.closePath()};var T=function(e,t){t=("string"==typeof t?{animation:t}:t)||{},w=function(){try{if("number"==typeof e?e>0:""!==e){var n={type:"badge",options:{n:e}};if("animation"in t&&S.types[""+t.animation]&&(n.options.animation=""+t.animation),"type"in t&&A[""+t.type]&&(n.options.type=""+t.type),["bgColor","textColor"].forEach(function(e){e in t&&(n.options[e]=o(t[e]))}),["fontStyle","fontFamily"].forEach(function(e){e in t&&(n.options[e]=t[e])}),C.push(n),C.length>100)throw new Error("Too many badges requests in queue.");M.start()}else M.reset()}catch(r){throw new Error("Error setting badge. Message: "+r.message)}},d&&w()},U=function(e){w=function(){try{var t=e.width,o=e.height,n=document.createElement("img"),r=o/l>t/s?t/s:o/l;n.setAttribute("crossOrigin","anonymous"),n.onload=function(){f.clearRect(0,0,s,l),f.drawImage(n,0,0,s,l),O.setIcon(h)},n.setAttribute("src",e.getAttribute("src")),n.height=o/r,n.width=t/r}catch(i){throw new Error("Error setting image. Message: "+i.message)}},d&&w()},R=function(e){w=function(){try{if("stop"===e)return g=!0,M.reset(),void(g=!1);e.addEventListener("play",function(){t(this)},!1)}catch(o){throw new Error("Error setting video. Message: "+o.message)}},d&&w()},L=function(e){if(window.URL&&window.URL.createObjectURL||(window.URL=window.URL||{},window.URL.createObjectURL=function(e){return e}),x.supported){var o=!1;navigator.getUserMedia=navigator.getUserMedia||navigator.oGetUserMedia||navigator.msGetUserMedia||navigator.mozGetUserMedia||navigator.webkitGetUserMedia,w=function(){try{if("stop"===e)return g=!0,M.reset(),void(g=!1);o=document.createElement("video"),o.width=s,o.height=l,navigator.getUserMedia({video:!0,audio:!1},function(e){o.src=URL.createObjectURL(e),o.play(),t(o)},function(){})}catch(n){throw new Error("Error setting webcam. Message: "+n.message)}},d&&w()}},O={};O.getIcon=function(){var e=!1,t=function(){for(var e=b.getElementsByTagName("head")[0].getElementsByTagName("link"),t=e.length,o=t-1;o>=0;o--)if(/(^|\s)icon(\s|$)/i.test(e[o].getAttribute("rel")))return e[o];return!1};return i.element?e=i.element:i.elementId?(e=b.getElementById(i.elementId),e.setAttribute("href",e.getAttribute("src"))):(e=t(),e===!1&&(e=b.createElement("link"),e.setAttribute("rel","icon"),b.getElementsByTagName("head")[0].appendChild(e))),e.setAttribute("type","image/png"),e},O.setIcon=function(e){var t=e.toDataURL("image/png");if(i.dataUrl&&i.dataUrl(t),i.element)i.element.setAttribute("href",t),i.element.setAttribute("src",t);else if(i.elementId){var o=b.getElementById(i.elementId);o.setAttribute("href",t),o.setAttribute("src",t)}else if(x.ff||x.opera){var n=a;a=b.createElement("link"),x.opera&&a.setAttribute("rel","icon"),a.setAttribute("rel","icon"),a.setAttribute("type","image/png"),b.getElementsByTagName("head")[0].appendChild(a),a.setAttribute("href",t),n.parentNode&&n.parentNode.removeChild(n)}else a.setAttribute("href",t)};var S={};return S.duration=40,S.types={},S.types.fade=[{x:.4,y:.4,w:.6,h:.6,o:0},{x:.4,y:.4,w:.6,h:.6,o:.1},{x:.4,y:.4,w:.6,h:.6,o:.2},{x:.4,y:.4,w:.6,h:.6,o:.3},{x:.4,y:.4,w:.6,h:.6,o:.4},{x:.4,y:.4,w:.6,h:.6,o:.5},{x:.4,y:.4,w:.6,h:.6,o:.6},{x:.4,y:.4,w:.6,h:.6,o:.7},{x:.4,y:.4,w:.6,h:.6,o:.8},{x:.4,y:.4,w:.6,h:.6,o:.9},{x:.4,y:.4,w:.6,h:.6,o:1}],S.types.none=[{x:.4,y:.4,w:.6,h:.6,o:1}],S.types.pop=[{x:1,y:1,w:0,h:0,o:1},{x:.9,y:.9,w:.1,h:.1,o:1},{x:.8,y:.8,w:.2,h:.2,o:1},{x:.7,y:.7,w:.3,h:.3,o:1},{x:.6,y:.6,w:.4,h:.4,o:1},{x:.5,y:.5,w:.5,h:.5,o:1},{x:.4,y:.4,w:.6,h:.6,o:1}],S.types.popFade=[{x:.75,y:.75,w:0,h:0,o:0},{x:.65,y:.65,w:.1,h:.1,o:.2},{x:.6,y:.6,w:.2,h:.2,o:.4},{x:.55,y:.55,w:.3,h:.3,o:.6},{x:.5,y:.5,w:.4,h:.4,o:.8},{x:.45,y:.45,w:.5,h:.5,o:.9},{x:.4,y:.4,w:.6,h:.6,o:1}],S.types.slide=[{x:.4,y:1,w:.6,h:.6,o:1},{x:.4,y:.9,w:.6,h:.6,o:1},{x:.4,y:.9,w:.6,h:.6,o:1},{x:.4,y:.8,w:.6,h:.6,o:1},{x:.4,y:.7,w:.6,h:.6,o:1},{x:.4,y:.6,w:.6,h:.6,o:1},{x:.4,y:.5,w:.6,h:.6,o:1},{x:.4,y:.4,w:.6,h:.6,o:1}],S.run=function(e,t,o,a){var l=S.types[r()?"none":i.animation];return a=o===!0?"undefined"!=typeof a?a:l.length-1:"undefined"!=typeof a?a:0,t=t?t:function(){},a<l.length&&a>=0?(A[i.type](n(e,l[a])),m=setTimeout(function(){o?a-=1:a+=1,S.run(e,t,o,a)},S.duration),O.setIcon(h),void 0):void t()},E(),{badge:T,video:R,image:U,webcam:L,reset:M.reset,browser:{supported:x.supported}}};"undefined"!=typeof define&&define.amd?define([],function(){return e}):"undefined"!=typeof module&&module.exports?module.exports=e:this.Favico=e}();
\ No newline at end of file
diff --git "[FORUM_EXT]/kasimi\\faviconnotifications/styles/FLATBOOTS/template/js/favico-0.3.10.min.js" "[FORUM_EXT]/kasimi\\faviconnotifications/styles/FLATBOOTS/template/js/favico-0.3.10.min.js"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/kasimi\\faviconnotifications/styles/FLATBOOTS/template/js/favico-0.3.10.min.js"
@@ -0,0 +1,7 @@
+/**
+ * @license MIT
+ * @fileOverview Favico animations
+ * @author Miroslav Magda, http://blog.ejci.net
+ * @version 0.3.10
+ */
+!function(){var e=function(e){"use strict";function t(e){if(e.paused||e.ended||w)return!1;try{h.clearRect(0,0,l,a),h.drawImage(e,0,0,l,a)}catch(e){}m=setTimeout(function(){t(e)},I.duration),A.setIcon(s)}function o(e){e=e.replace(/^#?([a-f\d])([a-f\d])([a-f\d])$/i,function(e,t,o,n){return t+t+o+o+n+n});var t=/^#?([a-f\d]{2})([a-f\d]{2})([a-f\d]{2})$/i.exec(e);return!!t&&{r:parseInt(t[1],16),g:parseInt(t[2],16),b:parseInt(t[3],16)}}function n(e,t){var o,n={};for(o in e)n[o]=e[o];for(o in t)n[o]=t[o];return n}e=e||{};var r,i,a,l,s,h,f,c,d,u,y,w,g,x,m,p,b={bgColor:"#d00",textColor:"#fff",fontFamily:"sans-serif",fontStyle:"bold",type:"circle",position:"down",animation:"slide",elementId:!1,dataUrl:!1,win:window};(g={}).ff="undefined"!=typeof InstallTrigger,g.chrome=!!window.chrome,g.opera=!!window.opera||navigator.userAgent.indexOf("Opera")>=0,g.ie=!1,g.safari=Object.prototype.toString.call(window.HTMLElement).indexOf("Constructor")>0,g.supported=g.chrome||g.ff||g.opera;var v=[];y=function(){},c=w=!1;var C={ready:function(){c=!0,C.reset(),y()},reset:function(){c&&(v=[],d=!1,u=!1,h.clearRect(0,0,l,a),h.drawImage(f,0,0,l,a),A.setIcon(s),window.clearTimeout(x),window.clearTimeout(m))}};C.start=function(){if(c&&!u){if(v.length>0){u=!0;var e=function(){["type","animation","bgColor","textColor","fontFamily","fontStyle"].forEach(function(e){e in v[0].options&&(r[e]=v[0].options[e])}),I.run(v[0].options,function(){d=v[0],u=!1,v.length>0&&(v.shift(),C.start())},!1)};d?I.run(d.options,function(){e()},!0):e()}}};var E={},M=function(e){return e.n="number"==typeof e.n?Math.abs(0|e.n):e.n,e.x=l*e.x,e.y=a*e.y,e.w=l*e.w,e.h=a*e.h,e.len=(""+e.n).length,e};E.circle=function(e){var t=!1;2===(e=M(e)).len?(e.x=e.x-.4*e.w,e.w=1.4*e.w,t=!0):e.len>=3&&(e.x=e.x-.65*e.w,e.w=1.65*e.w,t=!0),h.clearRect(0,0,l,a),h.drawImage(f,0,0,l,a),h.beginPath(),h.font=r.fontStyle+" "+Math.floor(e.h*(e.n>99?.85:1))+"px "+r.fontFamily,h.textAlign="center",t?(h.moveTo(e.x+e.w/2,e.y),h.lineTo(e.x+e.w-e.h/2,e.y),h.quadraticCurveTo(e.x+e.w,e.y,e.x+e.w,e.y+e.h/2),h.lineTo(e.x+e.w,e.y+e.h-e.h/2),h.quadraticCurveTo(e.x+e.w,e.y+e.h,e.x+e.w-e.h/2,e.y+e.h),h.lineTo(e.x+e.h/2,e.y+e.h),h.quadraticCurveTo(e.x,e.y+e.h,e.x,e.y+e.h-e.h/2),h.lineTo(e.x,e.y+e.h/2),h.quadraticCurveTo(e.x,e.y,e.x+e.h/2,e.y)):h.arc(e.x+e.w/2,e.y+e.h/2,e.h/2,0,2*Math.PI),h.fillStyle="rgba("+r.bgColor.r+","+r.bgColor.g+","+r.bgColor.b+","+e.o+")",h.fill(),h.closePath(),h.beginPath(),h.stroke(),h.fillStyle="rgba("+r.textColor.r+","+r.textColor.g+","+r.textColor.b+","+e.o+")","number"==typeof e.n&&e.n>999?h.fillText((e.n>9999?9:Math.floor(e.n/1e3))+"k+",Math.floor(e.x+e.w/2),Math.floor(e.y+e.h-.2*e.h)):h.fillText(e.n,Math.floor(e.x+e.w/2),Math.floor(e.y+e.h-.15*e.h)),h.closePath()},E.rectangle=function(e){2===(e=M(e)).len?(e.x=e.x-.4*e.w,e.w=1.4*e.w):e.len>=3&&(e.x=e.x-.65*e.w,e.w=1.65*e.w),h.clearRect(0,0,l,a),h.drawImage(f,0,0,l,a),h.beginPath(),h.font=r.fontStyle+" "+Math.floor(e.h*(e.n>99?.9:1))+"px "+r.fontFamily,h.textAlign="center",h.fillStyle="rgba("+r.bgColor.r+","+r.bgColor.g+","+r.bgColor.b+","+e.o+")",h.fillRect(e.x,e.y,e.w,e.h),h.fillStyle="rgba("+r.textColor.r+","+r.textColor.g+","+r.textColor.b+","+e.o+")","number"==typeof e.n&&e.n>999?h.fillText((e.n>9999?9:Math.floor(e.n/1e3))+"k+",Math.floor(e.x+e.w/2),Math.floor(e.y+e.h-.2*e.h)):h.fillText(e.n,Math.floor(e.x+e.w/2),Math.floor(e.y+e.h-.15*e.h)),h.closePath()};var A={getIcon:function(){var e=!1;return r.element?e=r.element:r.elementId?(e=p.getElementById(r.elementId)).setAttribute("href",e.getAttribute("src")):!1===(e=function(){for(var e=p.getElementsByTagName("head")[0].getElementsByTagName("link"),t=e.length-1;t>=0;t--)if(/(^|\s)icon(\s|$)/i.test(e[t].getAttribute("rel")))return e[t];return!1}())&&((e=p.createElement("link")).setAttribute("rel","icon"),p.getElementsByTagName("head")[0].appendChild(e)),e.setAttribute("type","image/png"),e},setIcon:function(e){var t=e.toDataURL("image/png");if(r.dataUrl&&r.dataUrl(t),r.element)r.element.setAttribute("href",t),r.element.setAttribute("src",t);else if(r.elementId){var o=p.getElementById(r.elementId);o.setAttribute("href",t),o.setAttribute("src",t)}else if(g.ff||g.opera){var n=i;i=p.createElement("link"),g.opera&&i.setAttribute("rel","icon"),i.setAttribute("rel","icon"),i.setAttribute("type","image/png"),p.getElementsByTagName("head")[0].appendChild(i),i.setAttribute("href",t),n.parentNode&&n.parentNode.removeChild(n)}else i.setAttribute("href",t)}},I={duration:40,types:{}};return I.types.fade=[{x:.4,y:.4,w:.6,h:.6,o:0},{x:.4,y:.4,w:.6,h:.6,o:.1},{x:.4,y:.4,w:.6,h:.6,o:.2},{x:.4,y:.4,w:.6,h:.6,o:.3},{x:.4,y:.4,w:.6,h:.6,o:.4},{x:.4,y:.4,w:.6,h:.6,o:.5},{x:.4,y:.4,w:.6,h:.6,o:.6},{x:.4,y:.4,w:.6,h:.6,o:.7},{x:.4,y:.4,w:.6,h:.6,o:.8},{x:.4,y:.4,w:.6,h:.6,o:.9},{x:.4,y:.4,w:.6,h:.6,o:1}],I.types.none=[{x:.4,y:.4,w:.6,h:.6,o:1}],I.types.pop=[{x:1,y:1,w:0,h:0,o:1},{x:.9,y:.9,w:.1,h:.1,o:1},{x:.8,y:.8,w:.2,h:.2,o:1},{x:.7,y:.7,w:.3,h:.3,o:1},{x:.6,y:.6,w:.4,h:.4,o:1},{x:.5,y:.5,w:.5,h:.5,o:1},{x:.4,y:.4,w:.6,h:.6,o:1}],I.types.popFade=[{x:.75,y:.75,w:0,h:0,o:0},{x:.65,y:.65,w:.1,h:.1,o:.2},{x:.6,y:.6,w:.2,h:.2,o:.4},{x:.55,y:.55,w:.3,h:.3,o:.6},{x:.5,y:.5,w:.4,h:.4,o:.8},{x:.45,y:.45,w:.5,h:.5,o:.9},{x:.4,y:.4,w:.6,h:.6,o:1}],I.types.slide=[{x:.4,y:1,w:.6,h:.6,o:1},{x:.4,y:.9,w:.6,h:.6,o:1},{x:.4,y:.9,w:.6,h:.6,o:1},{x:.4,y:.8,w:.6,h:.6,o:1},{x:.4,y:.7,w:.6,h:.6,o:1},{x:.4,y:.6,w:.6,h:.6,o:1},{x:.4,y:.5,w:.6,h:.6,o:1},{x:.4,y:.4,w:.6,h:.6,o:1}],I.run=function(e,t,o,i){var a=I.types[p.hidden||p.msHidden||p.webkitHidden||p.mozHidden?"none":r.animation];return i=!0===o?void 0!==i?i:a.length-1:void 0!==i?i:0,t=t||function(){},i<a.length&&i>=0?(E[r.type](n(e,a[i])),x=setTimeout(function(){o?i-=1:i+=1,I.run(e,t,o,i)},I.duration),void A.setIcon(s)):void t()},function(){(r=n(b,e)).bgColor=o(r.bgColor),r.textColor=o(r.textColor),r.position=r.position.toLowerCase(),r.animation=I.types[""+r.animation]?r.animation:b.animation,p=r.win.document;var t=r.position.indexOf("up")>-1,c=r.position.indexOf("left")>-1;if(t||c)for(var d=0;d<I.types[""+r.animation].length;d++){var u=I.types[""+r.animation][d];t&&(u.y=u.y<.6?u.y-.4:u.y-2*u.y+(1-u.w)),c&&(u.x=u.x<.6?u.x-.4:u.x-2*u.x+(1-u.h)),I.types[""+r.animation][d]=u}r.type=E[""+r.type]?r.type:b.type,i=A.getIcon(),s=document.createElement("canvas"),f=document.createElement("img"),i.hasAttribute("href")?(f.setAttribute("crossOrigin","anonymous"),f.onload=function(){a=f.height>0?f.height:32,l=f.width>0?f.width:32,s.height=a,s.width=l,h=s.getContext("2d"),C.ready()},f.setAttribute("src",i.getAttribute("href"))):(f.onload=function(){a=32,l=32,f.height=a,f.width=l,s.height=a,s.width=l,h=s.getContext("2d"),C.ready()},f.setAttribute("src",""))}(),{badge:function(e,t){t=("string"==typeof t?{animation:t}:t)||{},y=function(){try{if("number"==typeof e?e>0:""!==e){var n={type:"badge",options:{n:e}};if("animation"in t&&I.types[""+t.animation]&&(n.options.animation=""+t.animation),"type"in t&&E[""+t.type]&&(n.options.type=""+t.type),["bgColor","textColor"].forEach(function(e){e in t&&(n.options[e]=o(t[e]))}),["fontStyle","fontFamily"].forEach(function(e){e in t&&(n.options[e]=t[e])}),v.push(n),v.length>100)throw new Error("Too many badges requests in queue.");C.start()}else C.reset()}catch(e){throw new Error("Error setting badge. Message: "+e.message)}},c&&y()},video:function(e){y=function(){try{if("stop"===e)return w=!0,C.reset(),void(w=!1);e.addEventListener("play",function(){t(this)},!1)}catch(e){throw new Error("Error setting video. Message: "+e.message)}},c&&y()},image:function(e){y=function(){try{var t=e.width,o=e.height,n=document.createElement("img"),r=o/a>t/l?t/l:o/a;n.setAttribute("crossOrigin","anonymous"),n.onload=function(){h.clearRect(0,0,l,a),h.drawImage(n,0,0,l,a),A.setIcon(s)},n.setAttribute("src",e.getAttribute("src")),n.height=o/r,n.width=t/r}catch(e){throw new Error("Error setting image. Message: "+e.message)}},c&&y()},webcam:function(e){if(window.URL&&window.URL.createObjectURL||(window.URL=window.URL||{},window.URL.createObjectURL=function(e){return e}),g.supported){var o=!1;navigator.getUserMedia=navigator.getUserMedia||navigator.oGetUserMedia||navigator.msGetUserMedia||navigator.mozGetUserMedia||navigator.webkitGetUserMedia,y=function(){try{if("stop"===e)return w=!0,C.reset(),void(w=!1);(o=document.createElement("video")).width=l,o.height=a,navigator.getUserMedia({video:!0,audio:!1},function(e){o.src=URL.createObjectURL(e),o.play(),t(o)},function(){})}catch(e){throw new Error("Error setting webcam. Message: "+e.message)}},c&&y()}},reset:C.reset,browser:{supported:g.supported}}};"undefined"!=typeof define&&define.amd?define([],function(){return e}):"undefined"!=typeof module&&module.exports?module.exports=e:this.Favico=e}();
\ No newline at end of file
diff --git "[FORUM_EXT]/kasimi\\faviconnotifications/styles/FLATBOOTS/template/js/faviconnotifications.bak.js" "[FORUM_EXT]/kasimi\\faviconnotifications/styles/FLATBOOTS/template/js/faviconnotifications.bak.js"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/kasimi\\faviconnotifications/styles/FLATBOOTS/template/js/faviconnotifications.bak.js"
@@ -0,0 +1,41 @@
+/**
+ *
+ * @package phpBB Extension - Favicon Notifications
+ * @copyright (c) 2016 kasimi
+ * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
+ *
+ */
+head.ready(function () {
+jQuery(function($) {
+	// Initialize favicon
+	var favicon = new Favico({
+		bgColor		: '#d00',
+		textColor	: '#fff',
+		fontFamily	: 'sans-serif',
+		fontStyle	: 'bold',
+		type		: 'circle',
+		position	: 'down',
+		animation	: 'popFade'
+	});
+
+	var setUnreadNotificationsCount = function(count) {
+		favicon.badge(count);
+	};
+
+	// Set initial notifications count
+	var unreadCount = parseInt($('em', '#notification_list_button').html());
+	setUnreadNotificationsCount(unreadCount);
+
+	// Update notifications count when marking notifications read
+	var phpbbMarkNotifications = phpbb.markNotifications;
+	phpbb.markNotifications = function($popup, unreadCount) {
+		setUnreadNotificationsCount(unreadCount);
+		return phpbbMarkNotifications($popup, unreadCount);
+	};
+
+	// Listen to notifications count updates from extensions
+	$(phpbb).on('kasimi_faviconnotifications_update', function(event, notificationsCount) {
+		setUnreadNotificationsCount(notificationsCount);
+	});
+});
+});
\ No newline at end of file
diff --git "[FORUM_EXT]/kasimi\\faviconnotifications/styles/FLATBOOTS/template/js/faviconnotifications.js" "[FORUM_EXT]/kasimi\\faviconnotifications/styles/FLATBOOTS/template/js/faviconnotifications.js"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/kasimi\\faviconnotifications/styles/FLATBOOTS/template/js/faviconnotifications.js"
@@ -0,0 +1,8 @@
+/**
+ *
+ * @package phpBB Extension - Favicon Notifications
+ * @copyright (c) 2016 kasimi
+ * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
+ *
+ */
+head.ready(function(){jQuery(function(i){var n=new Favico({bgColor:"#d00",textColor:"#fff",fontFamily:"sans-serif",fontStyle:"bold",type:"circle",position:"down",animation:"popFade"}),o=function(i){n.badge(i)},t=parseInt(i("em","#notification_list_button").html());o(t);var a=phpbb.markNotifications;phpbb.markNotifications=function(i,n){return o(n),a(i,n)},i(phpbb).on("kasimi_faviconnotifications_update",function(i,n){o(n)})})});
\ No newline at end of file
diff --git "[ORIGINAL]/kasimi\\faviconnotifications/styles/all/template/event/overall_header_head_append.html" "[FORUM_EXT]/kasimi\\faviconnotifications/styles/all/template/event/overall_header_head_append.html"
--- "[ORIGINAL]/kasimi\\faviconnotifications/styles/all/template/event/overall_header_head_append.html"
+++ "[FORUM_EXT]/kasimi\\faviconnotifications/styles/all/template/event/overall_header_head_append.html"
@@ -1,4 +1,4 @@
-{% if S_USER_LOGGED_IN and not S_IS_BOT %}
-	{% INCLUDEJS 'js/favico-0.3.10.dev.js' %}
-	{% INCLUDEJS 'js/faviconnotifications.js' %}
-{% endif %}
+<!-- IF S_USER_LOGGED_IN and not S_IS_BOT -->
+	<!-- INCLUDEJS js/favico-0.3.10.min.js -->
+	<!-- INCLUDEJS js/faviconnotifications.js -->
+<!-- ENDIF -->
diff --git "[ORIGINAL]/kasimi\\faviconnotifications/styles/all/template/js/favico-0.3.10.dev.js" "[ORIGINAL]/kasimi\\faviconnotifications/styles/all/template/js/favico-0.3.10.dev.js"
deleted file mode 100644
--- "[ORIGINAL]/kasimi\\faviconnotifications/styles/all/template/js/favico-0.3.10.dev.js"
+++ /dev/null
@@ -1,905 +0,0 @@
-/**
- * @license MIT or GPL-2.0
- * @fileOverview Favico animations
- * @author Miroslav Magda, http://blog.ejci.net
- * @source: https://github.com/ejci/favico.js
- * @version 0.3.10
- */
-
-/**
- * Create new favico instance
- * @param {Object} Options
- * @return {Object} Favico object
- * @example
- * var favico = new Favico({
- *    bgColor : '#d00',
- *    textColor : '#fff',
- *    fontFamily : 'sans-serif',
- *    fontStyle : 'bold',
- *    type : 'circle',
- *    position : 'down',
- *    animation : 'slide',
- *    elementId: false,
- *    element: null,
- *    dataUrl: function(url){},
- *    win: window
- * });
- */
-(function () {
-
-	var Favico = (function (opt) {
-		'use strict';
-		opt = (opt) ? opt : {};
-		var _def = {
-			bgColor: '#d00',
-			textColor: '#fff',
-			fontFamily: 'sans-serif', //Arial,Verdana,Times New Roman,serif,sans-serif,...
-			fontStyle: 'bold', //normal,italic,oblique,bold,bolder,lighter,100,200,300,400,500,600,700,800,900
-			type: 'circle',
-			position: 'down', // down, up, left, leftup (upleft)
-			animation: 'slide',
-			elementId: false,
-			element: null,
-			dataUrl: false,
-			win: window
-		};
-		var _opt, _orig, _h, _w, _canvas, _context, _img, _ready, _lastBadge, _running, _readyCb, _stop, _browser, _animTimeout, _drawTimeout, _doc;
-
-		_browser = {};
-		_browser.ff = typeof InstallTrigger != 'undefined';
-		_browser.chrome = !!window.chrome;
-		_browser.opera = !!window.opera || navigator.userAgent.indexOf('Opera') >= 0;
-		_browser.ie = /*@cc_on!@*/false;
-		_browser.safari = Object.prototype.toString.call(window.HTMLElement).indexOf('Constructor') > 0;
-		_browser.supported = (_browser.chrome || _browser.ff || _browser.opera);
-
-		var _queue = [];
-		_readyCb = function () {
-		};
-		_ready = _stop = false;
-		/**
-		 * Initialize favico
-		 */
-		var init = function () {
-			//merge initial options
-			_opt = merge(_def, opt);
-			_opt.bgColor = hexToRgb(_opt.bgColor);
-			_opt.textColor = hexToRgb(_opt.textColor);
-			_opt.position = _opt.position.toLowerCase();
-			_opt.animation = (animation.types['' + _opt.animation]) ? _opt.animation : _def.animation;
-
-			_doc = _opt.win.document;
-
-			var isUp = _opt.position.indexOf('up') > -1;
-			var isLeft = _opt.position.indexOf('left') > -1;
-
-			//transform the animations
-			if (isUp || isLeft) {
-				for (var a in animation.types) {
-					for (var i = 0; i < animation.types[a].length; i++) {
-						var step = animation.types[a][i];
-
-						if (isUp) {
-							if (step.y < 0.6) {
-								step.y = step.y - 0.4;
-							} else {
-								step.y = step.y - 2 * step.y + (1 - step.w);
-							}
-						}
-
-						if (isLeft) {
-							if (step.x < 0.6) {
-								step.x = step.x - 0.4;
-							} else {
-								step.x = step.x - 2 * step.x + (1 - step.h);
-							}
-						}
-
-						animation.types[a][i] = step;
-					}
-				}
-			}
-			_opt.type = (type['' + _opt.type]) ? _opt.type : _def.type;
-
-			_orig = link. getIcons();
-			//create temp canvas
-			_canvas = document.createElement('canvas');
-			//create temp image
-			_img = document.createElement('img');
-			var lastIcon = _orig[_orig.length - 1];
-			if (lastIcon.hasAttribute('href')) {
-				_img.setAttribute('crossOrigin', 'anonymous');
-				//get width/height
-				_img.onload = function () {
-					_h = (_img.height > 0) ? _img.height : 32;
-					_w = (_img.width > 0) ? _img.width : 32;
-					_canvas.height = _h;
-					_canvas.width = _w;
-					_context = _canvas.getContext('2d');
-					icon.ready();
-				};
-				_img.setAttribute('src', lastIcon.getAttribute('href'));
-			} else {
-				_h = 32;
-				_w = 32;
-				_img.height = _h;
-				_img.width = _w;
-				_canvas.height = _h;
-				_canvas.width = _w;
-				_context = _canvas.getContext('2d');
-				icon.ready();
-			}
-
-		};
-		/**
-		 * Icon namespace
-		 */
-		var icon = {};
-		/**
-		 * Icon is ready (reset icon) and start animation (if ther is any)
-		 */
-		icon.ready = function () {
-			_ready = true;
-			icon.reset();
-			_readyCb();
-		};
-		/**
-		 * Reset icon to default state
-		 */
-		icon.reset = function () {
-			//reset
-			if (!_ready) {
-				return;
-			}
-			_queue = [];
-			_lastBadge = false;
-			_running = false;
-			_context.clearRect(0, 0, _w, _h);
-			_context.drawImage(_img, 0, 0, _w, _h);
-			//_stop=true;
-			link.setIcon(_canvas);
-			//webcam('stop');
-			//video('stop');
-			window.clearTimeout(_animTimeout);
-			window.clearTimeout(_drawTimeout);
-		};
-		/**
-		 * Start animation
-		 */
-		icon.start = function () {
-			if (!_ready || _running) {
-				return;
-			}
-			var finished = function () {
-				_lastBadge = _queue[0];
-				_running = false;
-				if (_queue.length > 0) {
-					_queue.shift();
-					icon.start();
-				} else {
-
-				}
-			};
-			if (_queue.length > 0) {
-				_running = true;
-				var run = function () {
-					// apply options for this animation
-					['type', 'animation', 'bgColor', 'textColor', 'fontFamily', 'fontStyle'].forEach(function (a) {
-						if (a in _queue[0].options) {
-							_opt[a] = _queue[0].options[a];
-						}
-					});
-					animation.run(_queue[0].options, function () {
-						finished();
-					}, false);
-				};
-				if (_lastBadge) {
-					animation.run(_lastBadge.options, function () {
-						run();
-					}, true);
-				} else {
-					run();
-				}
-			}
-		};
-
-		/**
-		 * Badge types
-		 */
-		var type = {};
-		var options = function (opt) {
-			opt.n = ((typeof opt.n) === 'number') ? Math.abs(opt.n | 0) : opt.n;
-			opt.x = _w * opt.x;
-			opt.y = _h * opt.y;
-			opt.w = _w * opt.w;
-			opt.h = _h * opt.h;
-			opt.len = ("" + opt.n).length;
-			return opt;
-		};
-		/**
-		 * Generate circle
-		 * @param {Object} opt Badge options
-		 */
-		type.circle = function (opt) {
-			opt = options(opt);
-			var more = false;
-			if (opt.len === 2) {
-				opt.x = opt.x - opt.w * 0.4;
-				opt.w = opt.w * 1.4;
-				more = true;
-			} else if (opt.len >= 3) {
-				opt.x = opt.x - opt.w * 0.65;
-				opt.w = opt.w * 1.65;
-				more = true;
-			}
-			_context.clearRect(0, 0, _w, _h);
-			_context.drawImage(_img, 0, 0, _w, _h);
-			_context.beginPath();
-			_context.font = _opt.fontStyle + " " + Math.floor(opt.h * (opt.n > 99 ? 0.85 : 1)) + "px " + _opt.fontFamily;
-			_context.textAlign = 'center';
-			if (more) {
-				_context.moveTo(opt.x + opt.w / 2, opt.y);
-				_context.lineTo(opt.x + opt.w - opt.h / 2, opt.y);
-				_context.quadraticCurveTo(opt.x + opt.w, opt.y, opt.x + opt.w, opt.y + opt.h / 2);
-				_context.lineTo(opt.x + opt.w, opt.y + opt.h - opt.h / 2);
-				_context.quadraticCurveTo(opt.x + opt.w, opt.y + opt.h, opt.x + opt.w - opt.h / 2, opt.y + opt.h);
-				_context.lineTo(opt.x + opt.h / 2, opt.y + opt.h);
-				_context.quadraticCurveTo(opt.x, opt.y + opt.h, opt.x, opt.y + opt.h - opt.h / 2);
-				_context.lineTo(opt.x, opt.y + opt.h / 2);
-				_context.quadraticCurveTo(opt.x, opt.y, opt.x + opt.h / 2, opt.y);
-			} else {
-				_context.arc(opt.x + opt.w / 2, opt.y + opt.h / 2, opt.h / 2, 0, 2 * Math.PI);
-			}
-			_context.fillStyle = 'rgba(' + _opt.bgColor.r + ',' + _opt.bgColor.g + ',' + _opt.bgColor.b + ',' + opt.o + ')';
-			_context.fill();
-			_context.closePath();
-			_context.beginPath();
-			_context.stroke();
-			_context.fillStyle = 'rgba(' + _opt.textColor.r + ',' + _opt.textColor.g + ',' + _opt.textColor.b + ',' + opt.o + ')';
-			//_context.fillText((more) ? '9+' : opt.n, Math.floor(opt.x + opt.w / 2), Math.floor(opt.y + opt.h - opt.h * 0.15));
-			if ((typeof opt.n) === 'number' && opt.n > 999) {
-				_context.fillText(((opt.n > 9999) ? 9 : Math.floor(opt.n / 1000)) + 'k+', Math.floor(opt.x + opt.w / 2), Math.floor(opt.y + opt.h - opt.h * 0.2));
-			} else {
-				_context.fillText(opt.n, Math.floor(opt.x + opt.w / 2), Math.floor(opt.y + opt.h - opt.h * 0.15));
-			}
-			_context.closePath();
-		};
-		/**
-		 * Generate rectangle
-		 * @param {Object} opt Badge options
-		 */
-		type.rectangle = function (opt) {
-			opt = options(opt);
-			var more = false;
-			if (opt.len === 2) {
-				opt.x = opt.x - opt.w * 0.4;
-				opt.w = opt.w * 1.4;
-				more = true;
-			} else if (opt.len >= 3) {
-				opt.x = opt.x - opt.w * 0.65;
-				opt.w = opt.w * 1.65;
-				more = true;
-			}
-			_context.clearRect(0, 0, _w, _h);
-			_context.drawImage(_img, 0, 0, _w, _h);
-			_context.beginPath();
-			_context.font = _opt.fontStyle + " " + Math.floor(opt.h * (opt.n > 99 ? 0.9 : 1)) + "px " + _opt.fontFamily;
-			_context.textAlign = 'center';
-			_context.fillStyle = 'rgba(' + _opt.bgColor.r + ',' + _opt.bgColor.g + ',' + _opt.bgColor.b + ',' + opt.o + ')';
-			_context.fillRect(opt.x, opt.y, opt.w, opt.h);
-			_context.fillStyle = 'rgba(' + _opt.textColor.r + ',' + _opt.textColor.g + ',' + _opt.textColor.b + ',' + opt.o + ')';
-			//_context.fillText((more) ? '9+' : opt.n, Math.floor(opt.x + opt.w / 2), Math.floor(opt.y + opt.h - opt.h * 0.15));
-			if ((typeof opt.n) === 'number' && opt.n > 999) {
-				_context.fillText(((opt.n > 9999) ? 9 : Math.floor(opt.n / 1000)) + 'k+', Math.floor(opt.x + opt.w / 2), Math.floor(opt.y + opt.h - opt.h * 0.2));
-			} else {
-				_context.fillText(opt.n, Math.floor(opt.x + opt.w / 2), Math.floor(opt.y + opt.h - opt.h * 0.15));
-			}
-			_context.closePath();
-		};
-
-		/**
-		 * Set badge
-		 */
-		var badge = function (number, opts) {
-			opts = ((typeof opts) === 'string' ? {
-				animation: opts
-			} : opts) || {};
-			_readyCb = function () {
-				try {
-					if (typeof (number) === 'number' ? (number > 0) : (number !== '')) {
-						var q = {
-							type: 'badge',
-							options: {
-								n: number
-							}
-						};
-						if ('animation' in opts && animation.types['' + opts.animation]) {
-							q.options.animation = '' + opts.animation;
-						}
-						if ('type' in opts && type['' + opts.type]) {
-							q.options.type = '' + opts.type;
-						}
-						['bgColor', 'textColor'].forEach(function (o) {
-							if (o in opts) {
-								q.options[o] = hexToRgb(opts[o]);
-							}
-						});
-						['fontStyle', 'fontFamily'].forEach(function (o) {
-							if (o in opts) {
-								q.options[o] = opts[o];
-							}
-						});
-						_queue.push(q);
-						if (_queue.length > 100) {
-							throw new Error('Too many badges requests in queue.');
-						}
-						icon.start();
-					} else {
-						icon.reset();
-					}
-				} catch (e) {
-					throw new Error('Error setting badge. Message: ' + e.message);
-				}
-			};
-			if (_ready) {
-				_readyCb();
-			}
-		};
-
-		/**
-		 * Set image as icon
-		 */
-		var image = function (imageElement) {
-			_readyCb = function () {
-				try {
-					var w = imageElement.width;
-					var h = imageElement.height;
-					var newImg = document.createElement('img');
-					var ratio = (w / _w < h / _h) ? (w / _w) : (h / _h);
-					newImg.setAttribute('crossOrigin', 'anonymous');
-					newImg.onload=function(){
-						_context.clearRect(0, 0, _w, _h);
-						_context.drawImage(newImg, 0, 0, _w, _h);
-						link.setIcon(_canvas);
-					};
-					newImg.setAttribute('src', imageElement.getAttribute('src'));
-					newImg.height = (h / ratio);
-					newImg.width = (w / ratio);
-				} catch (e) {
-					throw new Error('Error setting image. Message: ' + e.message);
-				}
-			};
-			if (_ready) {
-				_readyCb();
-			}
-		};
-		/**
-		 * Set the icon from a source url. Won't work with badges.
-		 */
-		var rawImageSrc = function (url) {
-			_readyCb = function() {
-				link.setIconSrc(url);
-			};
-			if (_ready) {
-				_readyCb();
-			}
-		};
-		/**
-		 * Set video as icon
-		 */
-		var video = function (videoElement) {
-			_readyCb = function () {
-				try {
-					if (videoElement === 'stop') {
-						_stop = true;
-						icon.reset();
-						_stop = false;
-						return;
-					}
-					//var w = videoElement.width;
-					//var h = videoElement.height;
-					//var ratio = (w / _w < h / _h) ? (w / _w) : (h / _h);
-					videoElement.addEventListener('play', function () {
-						drawVideo(this);
-					}, false);
-
-				} catch (e) {
-					throw new Error('Error setting video. Message: ' + e.message);
-				}
-			};
-			if (_ready) {
-				_readyCb();
-			}
-		};
-		/**
-		 * Set video as icon
-		 */
-		var webcam = function (action) {
-			//UR
-			if (!window.URL || !window.URL.createObjectURL) {
-				window.URL = window.URL || {};
-				window.URL.createObjectURL = function (obj) {
-					return obj;
-				};
-			}
-			if (_browser.supported) {
-				var newVideo = false;
-				navigator.getUserMedia = navigator.getUserMedia || navigator.oGetUserMedia || navigator.msGetUserMedia || navigator.mozGetUserMedia || navigator.webkitGetUserMedia;
-				_readyCb = function () {
-					try {
-						if (action === 'stop') {
-							_stop = true;
-							icon.reset();
-							_stop = false;
-							return;
-						}
-						newVideo = document.createElement('video');
-						newVideo.width = _w;
-						newVideo.height = _h;
-						navigator.getUserMedia({
-							video: true,
-							audio: false
-						}, function (stream) {
-							newVideo.src = URL.createObjectURL(stream);
-							newVideo.play();
-							drawVideo(newVideo);
-						}, function () {
-						});
-					} catch (e) {
-						throw new Error('Error setting webcam. Message: ' + e.message);
-					}
-				};
-				if (_ready) {
-					_readyCb();
-				}
-			}
-
-		};
-
-		var setOpt = function (key, value) {
-			var opts = key;
-			if (!(value == null && Object.prototype.toString.call(key) == '[object Object]')) {
-				opts = {};
-				opts[key] = value;
-			}
-
-			var keys = Object.keys(opts);
-			for (var i = 0; i < keys.length; i++) {
-				if (keys[i] == 'bgColor' || keys[i] == 'textColor') {
-					_opt[keys[i]] = hexToRgb(opts[keys[i]]);
-				} else {
-					_opt[keys[i]] = opts[keys[i]];
-				}
-			}
-
-			_queue.push(_lastBadge);
-			icon.start();
-		};
-
-		/**
-		 * Draw video to context and repeat :)
-		 */
-		function drawVideo(video) {
-			if (video.paused || video.ended || _stop) {
-				return false;
-			}
-			//nasty hack for FF webcam (Thanks to Julian Ćwirko, kontakt@redsunmedia.pl)
-			try {
-				_context.clearRect(0, 0, _w, _h);
-				_context.drawImage(video, 0, 0, _w, _h);
-			} catch (e) {
-
-			}
-			_drawTimeout = setTimeout(function () {
-				drawVideo(video);
-			}, animation.duration);
-			link.setIcon(_canvas);
-		}
-
-		var link = {};
-		/**
-		 * Get icons from HEAD tag or create a new <link> element
-		 */
-		link.getIcons = function () {
-			var elms = [];
-			//get link element
-			var getLinks = function () {
-				var icons = [];
-				var links = _doc.getElementsByTagName('head')[0].getElementsByTagName('link');
-				for (var i = 0; i < links.length; i++) {
-					if ((/(^|\s)icon(\s|$)/i).test(links[i].getAttribute('rel'))) {
-						icons.push(links[i]);
-					}
-				}
-				return icons;
-			};
-			if (_opt.element) {
-				elms = [_opt.element];
-			} else if (_opt.elementId) {
-				//if img element identified by elementId
-				elms = [_doc.getElementById(_opt.elementId)];
-				elms[0].setAttribute('href', elms[0].getAttribute('src'));
-			} else {
-				//if link element
-				elms = getLinks();
-				if (elms.length === 0) {
-					elms = [_doc.createElement('link')];
-					elms[0].setAttribute('rel', 'icon');
-					_doc.getElementsByTagName('head')[0].appendChild(elms[0]);
-				}
-			}
-			elms.forEach(function(item) {
-				item.setAttribute('type', 'image/png');
-			});
-			return elms;
-		};
-		link.setIcon = function (canvas) {
-			setTimeout(function() {
-				var url = canvas.toDataURL('image/png');
-				link.setIconSrc(url);
-			}, 0);
-		};
-		link.setIconSrc = function (url) {
-			if (_opt.dataUrl) {
-				//if using custom exporter
-				_opt.dataUrl(url);
-			}
-			if (_opt.element) {
-				_opt.element.setAttribute('href', url);
-				_opt.element.setAttribute('src', url);
-			} else if (_opt.elementId) {
-				//if is attached to element (image)
-				var elm = _doc.getElementById(_opt.elementId);
-				elm.setAttribute('href', url);
-				elm.setAttribute('src', url);
-			} else {
-				//if is attached to fav icon
-				if (_browser.ff || _browser.opera) {
-					//for FF we need to "recreate" element, atach to dom and remove old <link>
-					//var originalType = _orig.getAttribute('rel');
-					var old = _orig[_orig.length - 1];
-					var newIcon = _doc.createElement('link');
-					_orig = [newIcon];
-					//_orig.setAttribute('rel', originalType);
-					if (_browser.opera) {
-						newIcon.setAttribute('rel', 'icon');
-					}
-					newIcon.setAttribute('rel', 'icon');
-					newIcon.setAttribute('type', 'image/png');
-					_doc.getElementsByTagName('head')[0].appendChild(newIcon);
-					newIcon.setAttribute('href', url);
-					if (old.parentNode) {
-						old.parentNode.removeChild(old);
-					}
-				} else {
-					_orig.forEach(function(icon) {
-						icon.setAttribute('href', url);
-					});
-				}
-			}
-		};
-
-		//http://stackoverflow.com/questions/5623838/rgb-to-hex-and-hex-to-rgb#answer-5624139
-		//HEX to RGB convertor
-		function hexToRgb(hex) {
-			var shorthandRegex = /^#?([a-f\d])([a-f\d])([a-f\d])$/i;
-			hex = hex.replace(shorthandRegex, function (m, r, g, b) {
-				return r + r + g + g + b + b;
-			});
-			var result = /^#?([a-f\d]{2})([a-f\d]{2})([a-f\d]{2})$/i.exec(hex);
-			return result ? {
-				r: parseInt(result[1], 16),
-				g: parseInt(result[2], 16),
-				b: parseInt(result[3], 16)
-			} : false;
-		}
-
-		/**
-		 * Merge options
-		 */
-		function merge(def, opt) {
-			var mergedOpt = {};
-			var attrname;
-			for (attrname in def) {
-				mergedOpt[attrname] = def[attrname];
-			}
-			for (attrname in opt) {
-				mergedOpt[attrname] = opt[attrname];
-			}
-			return mergedOpt;
-		}
-
-		/**
-		 * Cross-browser page visibility shim
-		 * http://stackoverflow.com/questions/12536562/detect-whether-a-window-is-visible
-		 */
-		function isPageHidden() {
-			return _doc.hidden || _doc.msHidden || _doc.webkitHidden || _doc.mozHidden;
-		}
-
-		/**
-		 * @namespace animation
-		 */
-		var animation = {};
-		/**
-		 * Animation "frame" duration
-		 */
-		animation.duration = 40;
-		/**
-		 * Animation types (none,fade,pop,slide)
-		 */
-		animation.types = {};
-		animation.types.fade = [{
-			x: 0.4,
-			y: 0.4,
-			w: 0.6,
-			h: 0.6,
-			o: 0.0
-		}, {
-				x: 0.4,
-				y: 0.4,
-				w: 0.6,
-				h: 0.6,
-				o: 0.1
-			}, {
-				x: 0.4,
-				y: 0.4,
-				w: 0.6,
-				h: 0.6,
-				o: 0.2
-			}, {
-				x: 0.4,
-				y: 0.4,
-				w: 0.6,
-				h: 0.6,
-				o: 0.3
-			}, {
-				x: 0.4,
-				y: 0.4,
-				w: 0.6,
-				h: 0.6,
-				o: 0.4
-			}, {
-				x: 0.4,
-				y: 0.4,
-				w: 0.6,
-				h: 0.6,
-				o: 0.5
-			}, {
-				x: 0.4,
-				y: 0.4,
-				w: 0.6,
-				h: 0.6,
-				o: 0.6
-			}, {
-				x: 0.4,
-				y: 0.4,
-				w: 0.6,
-				h: 0.6,
-				o: 0.7
-			}, {
-				x: 0.4,
-				y: 0.4,
-				w: 0.6,
-				h: 0.6,
-				o: 0.8
-			}, {
-				x: 0.4,
-				y: 0.4,
-				w: 0.6,
-				h: 0.6,
-				o: 0.9
-			}, {
-				x: 0.4,
-				y: 0.4,
-				w: 0.6,
-				h: 0.6,
-				o: 1.0
-			}];
-		animation.types.none = [{
-			x: 0.4,
-			y: 0.4,
-			w: 0.6,
-			h: 0.6,
-			o: 1
-		}];
-		animation.types.pop = [{
-			x: 1,
-			y: 1,
-			w: 0,
-			h: 0,
-			o: 1
-		}, {
-				x: 0.9,
-				y: 0.9,
-				w: 0.1,
-				h: 0.1,
-				o: 1
-			}, {
-				x: 0.8,
-				y: 0.8,
-				w: 0.2,
-				h: 0.2,
-				o: 1
-			}, {
-				x: 0.7,
-				y: 0.7,
-				w: 0.3,
-				h: 0.3,
-				o: 1
-			}, {
-				x: 0.6,
-				y: 0.6,
-				w: 0.4,
-				h: 0.4,
-				o: 1
-			}, {
-				x: 0.5,
-				y: 0.5,
-				w: 0.5,
-				h: 0.5,
-				o: 1
-			}, {
-				x: 0.4,
-				y: 0.4,
-				w: 0.6,
-				h: 0.6,
-				o: 1
-			}];
-		animation.types.popFade = [{
-			x: 0.75,
-			y: 0.75,
-			w: 0,
-			h: 0,
-			o: 0
-		}, {
-				x: 0.65,
-				y: 0.65,
-				w: 0.1,
-				h: 0.1,
-				o: 0.2
-			}, {
-				x: 0.6,
-				y: 0.6,
-				w: 0.2,
-				h: 0.2,
-				o: 0.4
-			}, {
-				x: 0.55,
-				y: 0.55,
-				w: 0.3,
-				h: 0.3,
-				o: 0.6
-			}, {
-				x: 0.50,
-				y: 0.50,
-				w: 0.4,
-				h: 0.4,
-				o: 0.8
-			}, {
-				x: 0.45,
-				y: 0.45,
-				w: 0.5,
-				h: 0.5,
-				o: 0.9
-			}, {
-				x: 0.4,
-				y: 0.4,
-				w: 0.6,
-				h: 0.6,
-				o: 1
-			}];
-		animation.types.slide = [{
-			x: 0.4,
-			y: 1,
-			w: 0.6,
-			h: 0.6,
-			o: 1
-		}, {
-				x: 0.4,
-				y: 0.9,
-				w: 0.6,
-				h: 0.6,
-				o: 1
-			}, {
-				x: 0.4,
-				y: 0.9,
-				w: 0.6,
-				h: 0.6,
-				o: 1
-			}, {
-				x: 0.4,
-				y: 0.8,
-				w: 0.6,
-				h: 0.6,
-				o: 1
-			}, {
-				x: 0.4,
-				y: 0.7,
-				w: 0.6,
-				h: 0.6,
-				o: 1
-			}, {
-				x: 0.4,
-				y: 0.6,
-				w: 0.6,
-				h: 0.6,
-				o: 1
-			}, {
-				x: 0.4,
-				y: 0.5,
-				w: 0.6,
-				h: 0.6,
-				o: 1
-			}, {
-				x: 0.4,
-				y: 0.4,
-				w: 0.6,
-				h: 0.6,
-				o: 1
-			}];
-		/**
-		 * Run animation
-		 * @param {Object} opt Animation options
-		 * @param {Object} cb Callabak after all steps are done
-		 * @param {Object} revert Reverse order? true|false
-		 * @param {Object} step Optional step number (frame bumber)
-		 */
-		animation.run = function (opt, cb, revert, step) {
-			var animationType = animation.types[isPageHidden() ? 'none' : _opt.animation];
-			if (revert === true) {
-				step = (typeof step !== 'undefined') ? step : animationType.length - 1;
-			} else {
-				step = (typeof step !== 'undefined') ? step : 0;
-			}
-			cb = (cb) ? cb : function () {
-			};
-			if ((step < animationType.length) && (step >= 0)) {
-				type[_opt.type](merge(opt, animationType[step]));
-				_animTimeout = setTimeout(function () {
-					if (revert) {
-						step = step - 1;
-					} else {
-						step = step + 1;
-					}
-					animation.run(opt, cb, revert, step);
-				}, animation.duration);
-
-				link.setIcon(_canvas);
-			} else {
-				cb();
-				return;
-			}
-		};
-		//auto init
-		init();
-		return {
-			badge: badge,
-			video: video,
-			image: image,
-			rawImageSrc: rawImageSrc,
-			webcam: webcam,
-			setOpt: setOpt,
-			reset: icon.reset,
-			browser: {
-				supported: _browser.supported
-			}
-		};
-	});
-
-	// AMD / RequireJS
-	if (typeof define !== 'undefined' && define.amd) {
-		define([], function () {
-			return Favico;
-		});
-	}
-	// CommonJS
-	else if (typeof module !== 'undefined' && module.exports) {
-		module.exports = Favico;
-	}
-	// included directly via <script> tag
-	else {
-		this.Favico = Favico;
-	}
-
-})();
diff --git "[FORUM_EXT]/kasimi\\faviconnotifications/styles/all/template/js/favico-0.3.10.min.bak.js" "[FORUM_EXT]/kasimi\\faviconnotifications/styles/all/template/js/favico-0.3.10.min.bak.js"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/kasimi\\faviconnotifications/styles/all/template/js/favico-0.3.10.min.bak.js"
@@ -0,0 +1,7 @@
+/**
+ * @license MIT
+ * @fileOverview Favico animations
+ * @author Miroslav Magda, http://blog.ejci.net
+ * @version 0.3.10
+ */
+!function(){var e=function(e){"use strict";function t(e){if(e.paused||e.ended||g)return!1;try{f.clearRect(0,0,s,l),f.drawImage(e,0,0,s,l)}catch(o){}p=setTimeout(function(){t(e)},S.duration),O.setIcon(h)}function o(e){var t=/^#?([a-f\d])([a-f\d])([a-f\d])$/i;e=e.replace(t,function(e,t,o,n){return t+t+o+o+n+n});var o=/^#?([a-f\d]{2})([a-f\d]{2})([a-f\d]{2})$/i.exec(e);return o?{r:parseInt(o[1],16),g:parseInt(o[2],16),b:parseInt(o[3],16)}:!1}function n(e,t){var o,n={};for(o in e)n[o]=e[o];for(o in t)n[o]=t[o];return n}function r(){return b.hidden||b.msHidden||b.webkitHidden||b.mozHidden}e=e?e:{};var i,a,l,s,h,f,c,d,u,y,w,g,x,m,p,b,v={bgColor:"#d00",textColor:"#fff",fontFamily:"sans-serif",fontStyle:"bold",type:"circle",position:"down",animation:"slide",elementId:!1,dataUrl:!1,win:window};x={},x.ff="undefined"!=typeof InstallTrigger,x.chrome=!!window.chrome,x.opera=!!window.opera||navigator.userAgent.indexOf("Opera")>=0,x.ie=/*@cc_on!@*/!1,x.safari=Object.prototype.toString.call(window.HTMLElement).indexOf("Constructor")>0,x.supported=x.chrome||x.ff||x.opera;var C=[];w=function(){},d=g=!1;var E=function(){i=n(v,e),i.bgColor=o(i.bgColor),i.textColor=o(i.textColor),i.position=i.position.toLowerCase(),i.animation=S.types[""+i.animation]?i.animation:v.animation,b=i.win.document;var t=i.position.indexOf("up")>-1,r=i.position.indexOf("left")>-1;if(t||r)for(var d=0;d<S.types[""+i.animation].length;d++){var u=S.types[""+i.animation][d];t&&(u.y=u.y<.6?u.y-.4:u.y-2*u.y+(1-u.w)),r&&(u.x=u.x<.6?u.x-.4:u.x-2*u.x+(1-u.h)),S.types[""+i.animation][d]=u}i.type=A[""+i.type]?i.type:v.type,a=O.getIcon(),h=document.createElement("canvas"),c=document.createElement("img"),a.hasAttribute("href")?(c.setAttribute("crossOrigin","anonymous"),c.onload=function(){l=c.height>0?c.height:32,s=c.width>0?c.width:32,h.height=l,h.width=s,f=h.getContext("2d"),M.ready()},c.setAttribute("src",a.getAttribute("href"))):(c.onload=function(){l=32,s=32,c.height=l,c.width=s,h.height=l,h.width=s,f=h.getContext("2d"),M.ready()},c.setAttribute("src",""))},M={};M.ready=function(){d=!0,M.reset(),w()},M.reset=function(){d&&(C=[],u=!1,y=!1,f.clearRect(0,0,s,l),f.drawImage(c,0,0,s,l),O.setIcon(h),window.clearTimeout(m),window.clearTimeout(p))},M.start=function(){if(d&&!y){var e=function(){u=C[0],y=!1,C.length>0&&(C.shift(),M.start())};if(C.length>0){y=!0;var t=function(){["type","animation","bgColor","textColor","fontFamily","fontStyle"].forEach(function(e){e in C[0].options&&(i[e]=C[0].options[e])}),S.run(C[0].options,function(){e()},!1)};u?S.run(u.options,function(){t()},!0):t()}}};var A={},I=function(e){return e.n="number"==typeof e.n?Math.abs(0|e.n):e.n,e.x=s*e.x,e.y=l*e.y,e.w=s*e.w,e.h=l*e.h,e.len=(""+e.n).length,e};A.circle=function(e){e=I(e);var t=!1;2===e.len?(e.x=e.x-.4*e.w,e.w=1.4*e.w,t=!0):e.len>=3&&(e.x=e.x-.65*e.w,e.w=1.65*e.w,t=!0),f.clearRect(0,0,s,l),f.drawImage(c,0,0,s,l),f.beginPath(),f.font=i.fontStyle+" "+Math.floor(e.h*(e.n>99?.85:1))+"px "+i.fontFamily,f.textAlign="center",t?(f.moveTo(e.x+e.w/2,e.y),f.lineTo(e.x+e.w-e.h/2,e.y),f.quadraticCurveTo(e.x+e.w,e.y,e.x+e.w,e.y+e.h/2),f.lineTo(e.x+e.w,e.y+e.h-e.h/2),f.quadraticCurveTo(e.x+e.w,e.y+e.h,e.x+e.w-e.h/2,e.y+e.h),f.lineTo(e.x+e.h/2,e.y+e.h),f.quadraticCurveTo(e.x,e.y+e.h,e.x,e.y+e.h-e.h/2),f.lineTo(e.x,e.y+e.h/2),f.quadraticCurveTo(e.x,e.y,e.x+e.h/2,e.y)):f.arc(e.x+e.w/2,e.y+e.h/2,e.h/2,0,2*Math.PI),f.fillStyle="rgba("+i.bgColor.r+","+i.bgColor.g+","+i.bgColor.b+","+e.o+")",f.fill(),f.closePath(),f.beginPath(),f.stroke(),f.fillStyle="rgba("+i.textColor.r+","+i.textColor.g+","+i.textColor.b+","+e.o+")","number"==typeof e.n&&e.n>999?f.fillText((e.n>9999?9:Math.floor(e.n/1e3))+"k+",Math.floor(e.x+e.w/2),Math.floor(e.y+e.h-.2*e.h)):f.fillText(e.n,Math.floor(e.x+e.w/2),Math.floor(e.y+e.h-.15*e.h)),f.closePath()},A.rectangle=function(e){e=I(e);var t=!1;2===e.len?(e.x=e.x-.4*e.w,e.w=1.4*e.w,t=!0):e.len>=3&&(e.x=e.x-.65*e.w,e.w=1.65*e.w,t=!0),f.clearRect(0,0,s,l),f.drawImage(c,0,0,s,l),f.beginPath(),f.font=i.fontStyle+" "+Math.floor(e.h*(e.n>99?.9:1))+"px "+i.fontFamily,f.textAlign="center",f.fillStyle="rgba("+i.bgColor.r+","+i.bgColor.g+","+i.bgColor.b+","+e.o+")",f.fillRect(e.x,e.y,e.w,e.h),f.fillStyle="rgba("+i.textColor.r+","+i.textColor.g+","+i.textColor.b+","+e.o+")","number"==typeof e.n&&e.n>999?f.fillText((e.n>9999?9:Math.floor(e.n/1e3))+"k+",Math.floor(e.x+e.w/2),Math.floor(e.y+e.h-.2*e.h)):f.fillText(e.n,Math.floor(e.x+e.w/2),Math.floor(e.y+e.h-.15*e.h)),f.closePath()};var T=function(e,t){t=("string"==typeof t?{animation:t}:t)||{},w=function(){try{if("number"==typeof e?e>0:""!==e){var n={type:"badge",options:{n:e}};if("animation"in t&&S.types[""+t.animation]&&(n.options.animation=""+t.animation),"type"in t&&A[""+t.type]&&(n.options.type=""+t.type),["bgColor","textColor"].forEach(function(e){e in t&&(n.options[e]=o(t[e]))}),["fontStyle","fontFamily"].forEach(function(e){e in t&&(n.options[e]=t[e])}),C.push(n),C.length>100)throw new Error("Too many badges requests in queue.");M.start()}else M.reset()}catch(r){throw new Error("Error setting badge. Message: "+r.message)}},d&&w()},U=function(e){w=function(){try{var t=e.width,o=e.height,n=document.createElement("img"),r=o/l>t/s?t/s:o/l;n.setAttribute("crossOrigin","anonymous"),n.onload=function(){f.clearRect(0,0,s,l),f.drawImage(n,0,0,s,l),O.setIcon(h)},n.setAttribute("src",e.getAttribute("src")),n.height=o/r,n.width=t/r}catch(i){throw new Error("Error setting image. Message: "+i.message)}},d&&w()},R=function(e){w=function(){try{if("stop"===e)return g=!0,M.reset(),void(g=!1);e.addEventListener("play",function(){t(this)},!1)}catch(o){throw new Error("Error setting video. Message: "+o.message)}},d&&w()},L=function(e){if(window.URL&&window.URL.createObjectURL||(window.URL=window.URL||{},window.URL.createObjectURL=function(e){return e}),x.supported){var o=!1;navigator.getUserMedia=navigator.getUserMedia||navigator.oGetUserMedia||navigator.msGetUserMedia||navigator.mozGetUserMedia||navigator.webkitGetUserMedia,w=function(){try{if("stop"===e)return g=!0,M.reset(),void(g=!1);o=document.createElement("video"),o.width=s,o.height=l,navigator.getUserMedia({video:!0,audio:!1},function(e){o.src=URL.createObjectURL(e),o.play(),t(o)},function(){})}catch(n){throw new Error("Error setting webcam. Message: "+n.message)}},d&&w()}},O={};O.getIcon=function(){var e=!1,t=function(){for(var e=b.getElementsByTagName("head")[0].getElementsByTagName("link"),t=e.length,o=t-1;o>=0;o--)if(/(^|\s)icon(\s|$)/i.test(e[o].getAttribute("rel")))return e[o];return!1};return i.element?e=i.element:i.elementId?(e=b.getElementById(i.elementId),e.setAttribute("href",e.getAttribute("src"))):(e=t(),e===!1&&(e=b.createElement("link"),e.setAttribute("rel","icon"),b.getElementsByTagName("head")[0].appendChild(e))),e.setAttribute("type","image/png"),e},O.setIcon=function(e){var t=e.toDataURL("image/png");if(i.dataUrl&&i.dataUrl(t),i.element)i.element.setAttribute("href",t),i.element.setAttribute("src",t);else if(i.elementId){var o=b.getElementById(i.elementId);o.setAttribute("href",t),o.setAttribute("src",t)}else if(x.ff||x.opera){var n=a;a=b.createElement("link"),x.opera&&a.setAttribute("rel","icon"),a.setAttribute("rel","icon"),a.setAttribute("type","image/png"),b.getElementsByTagName("head")[0].appendChild(a),a.setAttribute("href",t),n.parentNode&&n.parentNode.removeChild(n)}else a.setAttribute("href",t)};var S={};return S.duration=40,S.types={},S.types.fade=[{x:.4,y:.4,w:.6,h:.6,o:0},{x:.4,y:.4,w:.6,h:.6,o:.1},{x:.4,y:.4,w:.6,h:.6,o:.2},{x:.4,y:.4,w:.6,h:.6,o:.3},{x:.4,y:.4,w:.6,h:.6,o:.4},{x:.4,y:.4,w:.6,h:.6,o:.5},{x:.4,y:.4,w:.6,h:.6,o:.6},{x:.4,y:.4,w:.6,h:.6,o:.7},{x:.4,y:.4,w:.6,h:.6,o:.8},{x:.4,y:.4,w:.6,h:.6,o:.9},{x:.4,y:.4,w:.6,h:.6,o:1}],S.types.none=[{x:.4,y:.4,w:.6,h:.6,o:1}],S.types.pop=[{x:1,y:1,w:0,h:0,o:1},{x:.9,y:.9,w:.1,h:.1,o:1},{x:.8,y:.8,w:.2,h:.2,o:1},{x:.7,y:.7,w:.3,h:.3,o:1},{x:.6,y:.6,w:.4,h:.4,o:1},{x:.5,y:.5,w:.5,h:.5,o:1},{x:.4,y:.4,w:.6,h:.6,o:1}],S.types.popFade=[{x:.75,y:.75,w:0,h:0,o:0},{x:.65,y:.65,w:.1,h:.1,o:.2},{x:.6,y:.6,w:.2,h:.2,o:.4},{x:.55,y:.55,w:.3,h:.3,o:.6},{x:.5,y:.5,w:.4,h:.4,o:.8},{x:.45,y:.45,w:.5,h:.5,o:.9},{x:.4,y:.4,w:.6,h:.6,o:1}],S.types.slide=[{x:.4,y:1,w:.6,h:.6,o:1},{x:.4,y:.9,w:.6,h:.6,o:1},{x:.4,y:.9,w:.6,h:.6,o:1},{x:.4,y:.8,w:.6,h:.6,o:1},{x:.4,y:.7,w:.6,h:.6,o:1},{x:.4,y:.6,w:.6,h:.6,o:1},{x:.4,y:.5,w:.6,h:.6,o:1},{x:.4,y:.4,w:.6,h:.6,o:1}],S.run=function(e,t,o,a){var l=S.types[r()?"none":i.animation];return a=o===!0?"undefined"!=typeof a?a:l.length-1:"undefined"!=typeof a?a:0,t=t?t:function(){},a<l.length&&a>=0?(A[i.type](n(e,l[a])),m=setTimeout(function(){o?a-=1:a+=1,S.run(e,t,o,a)},S.duration),O.setIcon(h),void 0):void t()},E(),{badge:T,video:R,image:U,webcam:L,reset:M.reset,browser:{supported:x.supported}}};"undefined"!=typeof define&&define.amd?define([],function(){return e}):"undefined"!=typeof module&&module.exports?module.exports=e:this.Favico=e}();
\ No newline at end of file
diff --git "[FORUM_EXT]/kasimi\\faviconnotifications/styles/all/template/js/favico-0.3.10.min.js" "[FORUM_EXT]/kasimi\\faviconnotifications/styles/all/template/js/favico-0.3.10.min.js"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/kasimi\\faviconnotifications/styles/all/template/js/favico-0.3.10.min.js"
@@ -0,0 +1,7 @@
+/**
+ * @license MIT
+ * @fileOverview Favico animations
+ * @author Miroslav Magda, http://blog.ejci.net
+ * @version 0.3.10
+ */
+!function(){var e=function(e){"use strict";function t(e){if(e.paused||e.ended||w)return!1;try{h.clearRect(0,0,l,a),h.drawImage(e,0,0,l,a)}catch(e){}m=setTimeout(function(){t(e)},I.duration),A.setIcon(s)}function o(e){e=e.replace(/^#?([a-f\d])([a-f\d])([a-f\d])$/i,function(e,t,o,n){return t+t+o+o+n+n});var t=/^#?([a-f\d]{2})([a-f\d]{2})([a-f\d]{2})$/i.exec(e);return!!t&&{r:parseInt(t[1],16),g:parseInt(t[2],16),b:parseInt(t[3],16)}}function n(e,t){var o,n={};for(o in e)n[o]=e[o];for(o in t)n[o]=t[o];return n}e=e||{};var r,i,a,l,s,h,f,c,d,u,y,w,g,x,m,p,b={bgColor:"#d00",textColor:"#fff",fontFamily:"sans-serif",fontStyle:"bold",type:"circle",position:"down",animation:"slide",elementId:!1,dataUrl:!1,win:window};(g={}).ff="undefined"!=typeof InstallTrigger,g.chrome=!!window.chrome,g.opera=!!window.opera||navigator.userAgent.indexOf("Opera")>=0,g.ie=!1,g.safari=Object.prototype.toString.call(window.HTMLElement).indexOf("Constructor")>0,g.supported=g.chrome||g.ff||g.opera;var v=[];y=function(){},c=w=!1;var C={ready:function(){c=!0,C.reset(),y()},reset:function(){c&&(v=[],d=!1,u=!1,h.clearRect(0,0,l,a),h.drawImage(f,0,0,l,a),A.setIcon(s),window.clearTimeout(x),window.clearTimeout(m))}};C.start=function(){if(c&&!u){if(v.length>0){u=!0;var e=function(){["type","animation","bgColor","textColor","fontFamily","fontStyle"].forEach(function(e){e in v[0].options&&(r[e]=v[0].options[e])}),I.run(v[0].options,function(){d=v[0],u=!1,v.length>0&&(v.shift(),C.start())},!1)};d?I.run(d.options,function(){e()},!0):e()}}};var E={},M=function(e){return e.n="number"==typeof e.n?Math.abs(0|e.n):e.n,e.x=l*e.x,e.y=a*e.y,e.w=l*e.w,e.h=a*e.h,e.len=(""+e.n).length,e};E.circle=function(e){var t=!1;2===(e=M(e)).len?(e.x=e.x-.4*e.w,e.w=1.4*e.w,t=!0):e.len>=3&&(e.x=e.x-.65*e.w,e.w=1.65*e.w,t=!0),h.clearRect(0,0,l,a),h.drawImage(f,0,0,l,a),h.beginPath(),h.font=r.fontStyle+" "+Math.floor(e.h*(e.n>99?.85:1))+"px "+r.fontFamily,h.textAlign="center",t?(h.moveTo(e.x+e.w/2,e.y),h.lineTo(e.x+e.w-e.h/2,e.y),h.quadraticCurveTo(e.x+e.w,e.y,e.x+e.w,e.y+e.h/2),h.lineTo(e.x+e.w,e.y+e.h-e.h/2),h.quadraticCurveTo(e.x+e.w,e.y+e.h,e.x+e.w-e.h/2,e.y+e.h),h.lineTo(e.x+e.h/2,e.y+e.h),h.quadraticCurveTo(e.x,e.y+e.h,e.x,e.y+e.h-e.h/2),h.lineTo(e.x,e.y+e.h/2),h.quadraticCurveTo(e.x,e.y,e.x+e.h/2,e.y)):h.arc(e.x+e.w/2,e.y+e.h/2,e.h/2,0,2*Math.PI),h.fillStyle="rgba("+r.bgColor.r+","+r.bgColor.g+","+r.bgColor.b+","+e.o+")",h.fill(),h.closePath(),h.beginPath(),h.stroke(),h.fillStyle="rgba("+r.textColor.r+","+r.textColor.g+","+r.textColor.b+","+e.o+")","number"==typeof e.n&&e.n>999?h.fillText((e.n>9999?9:Math.floor(e.n/1e3))+"k+",Math.floor(e.x+e.w/2),Math.floor(e.y+e.h-.2*e.h)):h.fillText(e.n,Math.floor(e.x+e.w/2),Math.floor(e.y+e.h-.15*e.h)),h.closePath()},E.rectangle=function(e){2===(e=M(e)).len?(e.x=e.x-.4*e.w,e.w=1.4*e.w):e.len>=3&&(e.x=e.x-.65*e.w,e.w=1.65*e.w),h.clearRect(0,0,l,a),h.drawImage(f,0,0,l,a),h.beginPath(),h.font=r.fontStyle+" "+Math.floor(e.h*(e.n>99?.9:1))+"px "+r.fontFamily,h.textAlign="center",h.fillStyle="rgba("+r.bgColor.r+","+r.bgColor.g+","+r.bgColor.b+","+e.o+")",h.fillRect(e.x,e.y,e.w,e.h),h.fillStyle="rgba("+r.textColor.r+","+r.textColor.g+","+r.textColor.b+","+e.o+")","number"==typeof e.n&&e.n>999?h.fillText((e.n>9999?9:Math.floor(e.n/1e3))+"k+",Math.floor(e.x+e.w/2),Math.floor(e.y+e.h-.2*e.h)):h.fillText(e.n,Math.floor(e.x+e.w/2),Math.floor(e.y+e.h-.15*e.h)),h.closePath()};var A={getIcon:function(){var e=!1;return r.element?e=r.element:r.elementId?(e=p.getElementById(r.elementId)).setAttribute("href",e.getAttribute("src")):!1===(e=function(){for(var e=p.getElementsByTagName("head")[0].getElementsByTagName("link"),t=e.length-1;t>=0;t--)if(/(^|\s)icon(\s|$)/i.test(e[t].getAttribute("rel")))return e[t];return!1}())&&((e=p.createElement("link")).setAttribute("rel","icon"),p.getElementsByTagName("head")[0].appendChild(e)),e.setAttribute("type","image/png"),e},setIcon:function(e){var t=e.toDataURL("image/png");if(r.dataUrl&&r.dataUrl(t),r.element)r.element.setAttribute("href",t),r.element.setAttribute("src",t);else if(r.elementId){var o=p.getElementById(r.elementId);o.setAttribute("href",t),o.setAttribute("src",t)}else if(g.ff||g.opera){var n=i;i=p.createElement("link"),g.opera&&i.setAttribute("rel","icon"),i.setAttribute("rel","icon"),i.setAttribute("type","image/png"),p.getElementsByTagName("head")[0].appendChild(i),i.setAttribute("href",t),n.parentNode&&n.parentNode.removeChild(n)}else i.setAttribute("href",t)}},I={duration:40,types:{}};return I.types.fade=[{x:.4,y:.4,w:.6,h:.6,o:0},{x:.4,y:.4,w:.6,h:.6,o:.1},{x:.4,y:.4,w:.6,h:.6,o:.2},{x:.4,y:.4,w:.6,h:.6,o:.3},{x:.4,y:.4,w:.6,h:.6,o:.4},{x:.4,y:.4,w:.6,h:.6,o:.5},{x:.4,y:.4,w:.6,h:.6,o:.6},{x:.4,y:.4,w:.6,h:.6,o:.7},{x:.4,y:.4,w:.6,h:.6,o:.8},{x:.4,y:.4,w:.6,h:.6,o:.9},{x:.4,y:.4,w:.6,h:.6,o:1}],I.types.none=[{x:.4,y:.4,w:.6,h:.6,o:1}],I.types.pop=[{x:1,y:1,w:0,h:0,o:1},{x:.9,y:.9,w:.1,h:.1,o:1},{x:.8,y:.8,w:.2,h:.2,o:1},{x:.7,y:.7,w:.3,h:.3,o:1},{x:.6,y:.6,w:.4,h:.4,o:1},{x:.5,y:.5,w:.5,h:.5,o:1},{x:.4,y:.4,w:.6,h:.6,o:1}],I.types.popFade=[{x:.75,y:.75,w:0,h:0,o:0},{x:.65,y:.65,w:.1,h:.1,o:.2},{x:.6,y:.6,w:.2,h:.2,o:.4},{x:.55,y:.55,w:.3,h:.3,o:.6},{x:.5,y:.5,w:.4,h:.4,o:.8},{x:.45,y:.45,w:.5,h:.5,o:.9},{x:.4,y:.4,w:.6,h:.6,o:1}],I.types.slide=[{x:.4,y:1,w:.6,h:.6,o:1},{x:.4,y:.9,w:.6,h:.6,o:1},{x:.4,y:.9,w:.6,h:.6,o:1},{x:.4,y:.8,w:.6,h:.6,o:1},{x:.4,y:.7,w:.6,h:.6,o:1},{x:.4,y:.6,w:.6,h:.6,o:1},{x:.4,y:.5,w:.6,h:.6,o:1},{x:.4,y:.4,w:.6,h:.6,o:1}],I.run=function(e,t,o,i){var a=I.types[p.hidden||p.msHidden||p.webkitHidden||p.mozHidden?"none":r.animation];return i=!0===o?void 0!==i?i:a.length-1:void 0!==i?i:0,t=t||function(){},i<a.length&&i>=0?(E[r.type](n(e,a[i])),x=setTimeout(function(){o?i-=1:i+=1,I.run(e,t,o,i)},I.duration),void A.setIcon(s)):void t()},function(){(r=n(b,e)).bgColor=o(r.bgColor),r.textColor=o(r.textColor),r.position=r.position.toLowerCase(),r.animation=I.types[""+r.animation]?r.animation:b.animation,p=r.win.document;var t=r.position.indexOf("up")>-1,c=r.position.indexOf("left")>-1;if(t||c)for(var d=0;d<I.types[""+r.animation].length;d++){var u=I.types[""+r.animation][d];t&&(u.y=u.y<.6?u.y-.4:u.y-2*u.y+(1-u.w)),c&&(u.x=u.x<.6?u.x-.4:u.x-2*u.x+(1-u.h)),I.types[""+r.animation][d]=u}r.type=E[""+r.type]?r.type:b.type,i=A.getIcon(),s=document.createElement("canvas"),f=document.createElement("img"),i.hasAttribute("href")?(f.setAttribute("crossOrigin","anonymous"),f.onload=function(){a=f.height>0?f.height:32,l=f.width>0?f.width:32,s.height=a,s.width=l,h=s.getContext("2d"),C.ready()},f.setAttribute("src",i.getAttribute("href"))):(f.onload=function(){a=32,l=32,f.height=a,f.width=l,s.height=a,s.width=l,h=s.getContext("2d"),C.ready()},f.setAttribute("src",""))}(),{badge:function(e,t){t=("string"==typeof t?{animation:t}:t)||{},y=function(){try{if("number"==typeof e?e>0:""!==e){var n={type:"badge",options:{n:e}};if("animation"in t&&I.types[""+t.animation]&&(n.options.animation=""+t.animation),"type"in t&&E[""+t.type]&&(n.options.type=""+t.type),["bgColor","textColor"].forEach(function(e){e in t&&(n.options[e]=o(t[e]))}),["fontStyle","fontFamily"].forEach(function(e){e in t&&(n.options[e]=t[e])}),v.push(n),v.length>100)throw new Error("Too many badges requests in queue.");C.start()}else C.reset()}catch(e){throw new Error("Error setting badge. Message: "+e.message)}},c&&y()},video:function(e){y=function(){try{if("stop"===e)return w=!0,C.reset(),void(w=!1);e.addEventListener("play",function(){t(this)},!1)}catch(e){throw new Error("Error setting video. Message: "+e.message)}},c&&y()},image:function(e){y=function(){try{var t=e.width,o=e.height,n=document.createElement("img"),r=o/a>t/l?t/l:o/a;n.setAttribute("crossOrigin","anonymous"),n.onload=function(){h.clearRect(0,0,l,a),h.drawImage(n,0,0,l,a),A.setIcon(s)},n.setAttribute("src",e.getAttribute("src")),n.height=o/r,n.width=t/r}catch(e){throw new Error("Error setting image. Message: "+e.message)}},c&&y()},webcam:function(e){if(window.URL&&window.URL.createObjectURL||(window.URL=window.URL||{},window.URL.createObjectURL=function(e){return e}),g.supported){var o=!1;navigator.getUserMedia=navigator.getUserMedia||navigator.oGetUserMedia||navigator.msGetUserMedia||navigator.mozGetUserMedia||navigator.webkitGetUserMedia,y=function(){try{if("stop"===e)return w=!0,C.reset(),void(w=!1);(o=document.createElement("video")).width=l,o.height=a,navigator.getUserMedia({video:!0,audio:!1},function(e){o.src=URL.createObjectURL(e),o.play(),t(o)},function(){})}catch(e){throw new Error("Error setting webcam. Message: "+e.message)}},c&&y()}},reset:C.reset,browser:{supported:g.supported}}};"undefined"!=typeof define&&define.amd?define([],function(){return e}):"undefined"!=typeof module&&module.exports?module.exports=e:this.Favico=e}();
\ No newline at end of file
diff --git "[FORUM_EXT]/kasimi\\faviconnotifications/styles/all/template/js/faviconnotifications.bak.js" "[FORUM_EXT]/kasimi\\faviconnotifications/styles/all/template/js/faviconnotifications.bak.js"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/kasimi\\faviconnotifications/styles/all/template/js/faviconnotifications.bak.js"
@@ -0,0 +1,41 @@
+/**
+ *
+ * @package phpBB Extension - Favicon Notifications
+ * @copyright (c) 2016 kasimi
+ * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
+ *
+ */
+head.ready(function () {
+jQuery(function($) {
+	// Initialize favicon
+	var favicon = new Favico({
+		bgColor		: '#d00',
+		textColor	: '#fff',
+		fontFamily	: 'sans-serif',
+		fontStyle	: 'bold',
+		type		: 'circle',
+		position	: 'down',
+		animation	: 'popFade'
+	});
+
+	var setUnreadNotificationsCount = function(count) {
+		favicon.badge(count);
+	};
+
+	// Set initial notifications count
+	var unreadCount = parseInt($('em', '#notification_list_button').html());
+	setUnreadNotificationsCount(unreadCount);
+
+	// Update notifications count when marking notifications read
+	var phpbbMarkNotifications = phpbb.markNotifications;
+	phpbb.markNotifications = function($popup, unreadCount) {
+		setUnreadNotificationsCount(unreadCount);
+		return phpbbMarkNotifications($popup, unreadCount);
+	};
+
+	// Listen to notifications count updates from extensions
+	$(phpbb).on('kasimi_faviconnotifications_update', function(event, notificationsCount) {
+		setUnreadNotificationsCount(notificationsCount);
+	});
+});
+});
\ No newline at end of file
diff --git "[ORIGINAL]/kasimi\\faviconnotifications/styles/all/template/js/faviconnotifications.js" "[FORUM_EXT]/kasimi\\faviconnotifications/styles/all/template/js/faviconnotifications.js"
--- "[ORIGINAL]/kasimi\\faviconnotifications/styles/all/template/js/faviconnotifications.js"
+++ "[FORUM_EXT]/kasimi\\faviconnotifications/styles/all/template/js/faviconnotifications.js"
@@ -1,43 +1,8 @@
 /**
  *
  * @package phpBB Extension - Favicon Notifications
- * @copyright (c) 2016 kasimi - https://kasimi.net
+ * @copyright (c) 2016 kasimi
  * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
  *
  */
-
-jQuery(function($) {
-
-	'use strict';
-
-	// Initialize favicon
-	let favicon = new Favico({
-		bgColor		: '#d00',
-		textColor	: '#fff',
-		fontFamily	: 'sans-serif',
-		fontStyle	: 'bold',
-		type		: 'circle',
-		position	: 'up',
-		animation	: 'popFade',
-	});
-
-	let setUnreadNotificationsCount = function(count) {
-		favicon.badge(count);
-	};
-
-	// Set initial notifications count
-	let unreadCount = parseInt($('strong', '#notification_list_button').html());
-	setUnreadNotificationsCount(unreadCount);
-
-	// Update notifications count when marking notifications read
-	let phpbbMarkNotifications = phpbb.markNotifications;
-	phpbb.markNotifications = function($popup, unreadCount) {
-		setUnreadNotificationsCount(unreadCount);
-		return phpbbMarkNotifications($popup, unreadCount);
-	};
-
-	// Listen to notifications count updates from extensions
-	$(phpbb).on('kasimi_faviconnotifications_update', function(event, notificationsCount) {
-		setUnreadNotificationsCount(notificationsCount);
-	});
-});
+jQuery(function(i){var n=new Favico({bgColor:"#d00",textColor:"#fff",fontFamily:"sans-serif",fontStyle:"bold",type:"circle",position:"down",animation:"popFade"}),o=function(i){n.badge(i)},t=parseInt(i("em","#notification_list_button").html());o(t);var a=phpbb.markNotifications;phpbb.markNotifications=function(i,n){return o(n),a(i,n)},i(phpbb).on("kasimi_faviconnotifications_update",function(i,n){o(n)})})
\ No newline at end of file
```
