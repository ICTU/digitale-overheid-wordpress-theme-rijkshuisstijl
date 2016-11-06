function hideMenuButton(e,t,n){header.classList.remove("menu-met-js"),header.classList.remove("active"),header.classList.add("geen-menu-button"),menu.setAttribute("aria-hidden","false");var a=e.getElementById("menu-button");a&&header.removeChild(menuButton)}function showMenuButton(e,t,n){"use strict";header.classList.add("menu-met-js"),header.classList.remove("geen-menu-button"),menuButton=e.createElement("button"),menuButton.classList.add("menu-button"),menuButton.setAttribute("id","menu-button"),menuButton.setAttribute("aria-label","Menu"),menuButton.setAttribute("aria-expanded","false"),menuButton.setAttribute("aria-controls","menu"),menuButton.innerHTML="<i>&#x2261;</i><b>&nbsp;menu</b>",menu.setAttribute("aria-hidden","true"),menu.setAttribute("aria-labelledby","menu-button"),header.insertBefore(menuButton,menu),menuButton.addEventListener("click",function(){menu.classList.contains("active")?(header.classList.remove("active"),menu.classList.remove("active"),menu.setAttribute("aria-hidden","true"),menuButton.setAttribute("aria-label","Open menu"),menuButton.innerHTML="<i>&#x2261;</i><b>&nbsp;menu</b>",menuButton.setAttribute("aria-expanded","false")):(header.classList.add("active"),menu.classList.add("active"),menu.setAttribute("aria-hidden","false"),menuButton.setAttribute("aria-label","Sluit menu"),menuButton.innerHTML="<i>X</i><b>&nbsp;Sluit menu</b>",menuButton.setAttribute("aria-expanded","true"))},!1)}function WidthChange(e){e.matches?hideMenuButton(document,window):showMenuButton(document,window)}window.matchMedia||(window.matchMedia=function(){"use strict";var e=window.styleMedia||window.media;if(!e){var t=document.createElement("style"),n=document.getElementsByTagName("script")[0],a=null;t.type="text/css",t.id="matchmediajs-test",n.parentNode.insertBefore(t,n),a="getComputedStyle"in window&&window.getComputedStyle(t,null)||t.currentStyle,e={matchMedium:function(e){var n="@media "+e+"{ #matchmediajs-test { width: 1px; } }";return t.styleSheet?t.styleSheet.cssText=n:t.textContent=n,"1px"===a.width}}}return function(t){return{matches:e.matchMedium(t||"all"),media:t||"all"}}}()),!window.addEventListener&&function(e,t,n,a,i,s,r){e[a]=t[a]=n[a]=function(e,t){var n=this;r.unshift([n,e,t,function(e){e.currentTarget=n,e.preventDefault=function(){e.returnValue=!1},e.stopPropagation=function(){e.cancelBubble=!0},e.target=e.srcElement||n,t.call(n,e)}]),this.attachEvent("on"+e,r[0][3])},e[i]=t[i]=n[i]=function(e,t){for(var n=0,a;a=r[n];++n)if(a[0]==this&&a[1]==e&&a[2]==t)return this.detachEvent("on"+e,r.splice(n,1)[0][3])},e[s]=t[s]=n[s]=function(e){return this.fireEvent("on"+e.type,e)}}(Window.prototype,HTMLDocument.prototype,Element.prototype,"addEventListener","removeEventListener","dispatchEvent",[]),!function(){function e(e){var t="focus"===e.type?"focusin":"focusout",n=new CustomEvent(t,{bubbles:!0,cancelable:!1});n.c1Generated=!0,e.target.dispatchEvent(n)}function t(n){n.c1Generated||(a.removeEventListener("focus",e,!0),a.removeEventListener("blur",e,!0),a.removeEventListener("focusin",t,!0),a.removeEventListener("focusout",t,!0)),setTimeout(function(){a.removeEventListener("focusin",t,!0),a.removeEventListener("focusout",t,!0)})}var n=window,a=n.document;void 0===n.onfocusin&&(a.addEventListener("focus",e,!0),a.addEventListener("blur",e,!0),a.addEventListener("focusin",t,!0),a.addEventListener("focusout",t,!0))}();var myCarousel=function(){"use strict";function e(e,t){e.classList?e.classList.remove(t):e.className=e.className.replace(new RegExp("(^|\\b)"+t.split(" ").join("|")+"(\\b|$)","gi")," ")}function t(e,t){return e.classList?e.classList.contains(t):new RegExp("(^| )"+t+"( |$)","gi").test(e.className)}function n(n){if(v=n,l=document.getElementById(v.id),c=l.querySelectorAll(".slide"),l.className="active carousel",v.starttext="Speel diashow af",v.stoptext="Stop diashow",v.duration||(v.duration=1e4),(v.slidenav||v.animate)&&c.length>1){m=document.createElement("li"),m.className="slidenav";var s=document.createElement("span");v.animate&&(v.startAnimated?s.innerHTML="<button data-stop=true>"+v.stoptext+"</button>":s.innerHTML="<button data-start=true>"+v.starttext+"</button>",m.appendChild(s)),m.addEventListener("click",function(e){var t=e.target;"button"===t.localName&&(t.getAttribute("data-stop")?r():t.getAttribute("data-start")&&u())},!0),l.className="active carousel with-slidenav",l.appendChild(m)}c[0].parentNode.addEventListener("transitionend",function(n){var a=n.target;e(a,"in-transition"),t(a,"current")&&(f&&(a.setAttribute("tabindex","-1"),a.focus(),f=!1),h&&(a.removeAttribute("aria-live"),h=!1))}),l.addEventListener("focusin",function(e){t(e.target,"slide")||o()}),l.addEventListener("focusout",function(e){t(e.target,"slide")||u()}),d=0,a(d),v.startAnimated&&(b=setTimeout(i,v.duration))}function a(e,t,n){f="undefined"!=typeof t&&t,n="undefined"!=typeof n?n:"none",e=parseFloat(e);var a=c.length,i=e+1,s=e-1;i===a?i=0:s<0&&(s=a-1);for(var r=c.length-1;r>=0;r--)c[r].className="slide",c[r].querySelector(".img-container").setAttribute("aria-hidden","true");a>1?(c[i].className="next slide","next"===n&&(c[i].className="next slide in-transition"),c[s].className="prev slide","prev"===n&&(c[s].className="prev slide in-transition"),c[e].className="current slide",c[e].querySelector(".img-container").removeAttribute("aria-hidden"),h&&c[e].setAttribute("aria-live","polite"),d=e):c[0].className="current slide"}function i(){var e=c.length,t=d+1;t===e&&(t=0),h=!0,a(t,!1,"prev"),v.animate&&(b=setTimeout(i,v.duration))}function s(){var e=c.length,t=d-1;t<0&&(t=e-1),h=!0,a(t,!1,"next")}function r(){clearTimeout(b),v.animate=!1,p=!1;var e=l.querySelector("[data-stop], [data-start]");e.innerHTML=v.starttext,e.removeAttribute("data-stop"),e.setAttribute("data-start","true")}function u(){v.animate=!0,p=!1,b=setTimeout(function(){i()},5e3);var e=l.querySelector("[data-stop], [data-start]");e.innerHTML=v.stoptext,e.setAttribute("data-stop","true"),e.removeAttribute("data-start")}function o(){v.animate&&(clearTimeout(b),v.animate=!1,p=!0)}var l,c,d,m,v,b,f,p,h="false";return{init:n,next:i,prev:s,goto:a,stop:r,start:u}};if(document.getElementById("carousel")){var carousel=new myCarousel;carousel.init({id:"carousel",slidenav:!0,animate:!0,startAnimated:!0,duration:1e4})}var collapsiblelist=document.querySelectorAll("tabs");if(collapsiblelist.length>0){var selectedelement=collapsiblelist[0].querySelectorAll("selected"),t,i=selectedelement[0].getElementsByTagName("a");collapsiblelist[0].className="tabs collapsed",t=i.length>0?i:selectedelement,t[0].onclick=function(e){"tabs collapsed"===collapsiblelist[0].className?collapsiblelist[0].className="tabs":collapsiblelist[0].className="tabs collapsed"}}var header=document.querySelector("#menu-container"),menu=document.querySelector(".nav-primary"),menuButton=document.querySelector(".menu-button");if(matchMedia){var mq=window.matchMedia("(min-width: 900px)");mq.addListener(WidthChange),WidthChange(mq)}