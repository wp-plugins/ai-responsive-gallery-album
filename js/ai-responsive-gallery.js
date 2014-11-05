window.Modernizr=function(e,t,i){function n(e){y.cssText=e}function o(e,t){return typeof e===t}function a(e,t){return!!~(""+e).indexOf(t)}function r(e,t){for(var n in e){var o=e[n];if(!a(o,"-")&&y[o]!==i)return"pfx"==t?o:!0}return!1}function l(e,t,n){for(var a in e){var r=t[e[a]];if(r!==i)return n===!1?e[a]:o(r,"function")?r.bind(n||t):r}return!1}function s(e,t,i){var n=e.charAt(0).toUpperCase()+e.slice(1),a=(e+" "+C.join(n+" ")+n).split(" ");return o(t,"string")||o(t,"undefined")?r(a,t):(a=(e+" "+w.join(n+" ")+n).split(" "),l(a,t,i))}var d,c,u,p="2.6.2",h={},f=!0,m=t.documentElement,g="modernizr",v=t.createElement(g),y=v.style,b=({}.toString," -webkit- -moz- -o- -ms- ".split(" ")),_="Webkit Moz O ms",C=_.split(" "),w=_.toLowerCase().split(" "),x={},I=[],k=I.slice,E=function(e,i,n,o){var a,r,l,s,d=t.createElement("div"),c=t.body,u=c||t.createElement("body");if(parseInt(n,10))for(;n--;)l=t.createElement("div"),l.id=o?o[n]:g+(n+1),d.appendChild(l);return a=["&#173;",'<style id="s',g,'">',e,"</style>"].join(""),d.id=g,(c?d:u).innerHTML+=a,u.appendChild(d),c||(u.style.background="",u.style.overflow="hidden",s=m.style.overflow,m.style.overflow="hidden",m.appendChild(u)),r=i(d,e),c?d.parentNode.removeChild(d):(u.parentNode.removeChild(u),m.style.overflow=s),!!r},S={}.hasOwnProperty;u=o(S,"undefined")||o(S.call,"undefined")?function(e,t){return t in e&&o(e.constructor.prototype[t],"undefined")}:function(e,t){return S.call(e,t)},Function.prototype.bind||(Function.prototype.bind=function(e){var t=this;if("function"!=typeof t)throw new TypeError;var i=k.call(arguments,1),n=function(){if(this instanceof n){var o=function(){};o.prototype=t.prototype;var a=new o,r=t.apply(a,i.concat(k.call(arguments)));return Object(r)===r?r:a}return t.apply(e,i.concat(k.call(arguments)))};return n}),x.touch=function(){var i;return"ontouchstart"in e||e.DocumentTouch&&t instanceof DocumentTouch?i=!0:E(["@media (",b.join("touch-enabled),("),g,")","{#modernizr{top:9px;position:absolute}}"].join(""),function(e){i=9===e.offsetTop}),i},x.cssanimations=function(){return s("animationName")},x.csstransitions=function(){return s("transition")};for(var $ in x)u(x,$)&&(c=$.toLowerCase(),h[c]=x[$](),I.push((h[c]?"":"no-")+c));return h.addTest=function(e,t){if("object"==typeof e)for(var n in e)u(e,n)&&h.addTest(n,e[n]);else{if(e=e.toLowerCase(),h[e]!==i)return h;t="function"==typeof t?t():t,"undefined"!=typeof f&&f&&(m.className+=" "+(t?"":"no-")+e),h[e]=t}return h},n(""),v=d=null,function(e,t){function i(e,t){var i=e.createElement("p"),n=e.getElementsByTagName("head")[0]||e.documentElement;return i.innerHTML="x<style>"+t+"</style>",n.insertBefore(i.lastChild,n.firstChild)}function n(){var e=v.elements;return"string"==typeof e?e.split(" "):e}function o(e){var t=g[e[f]];return t||(t={},m++,e[f]=m,g[m]=t),t}function a(e,i,n){if(i||(i=t),c)return i.createElement(e);n||(n=o(i));var a;return a=n.cache[e]?n.cache[e].cloneNode():h.test(e)?(n.cache[e]=n.createElem(e)).cloneNode():n.createElem(e),a.canHaveChildren&&!p.test(e)?n.frag.appendChild(a):a}function r(e,i){if(e||(e=t),c)return e.createDocumentFragment();i=i||o(e);for(var a=i.frag.cloneNode(),r=0,l=n(),s=l.length;s>r;r++)a.createElement(l[r]);return a}function l(e,t){t.cache||(t.cache={},t.createElem=e.createElement,t.createFrag=e.createDocumentFragment,t.frag=t.createFrag()),e.createElement=function(i){return v.shivMethods?a(i,e,t):t.createElem(i)},e.createDocumentFragment=Function("h,f","return function(){var n=f.cloneNode(),c=n.createElement;h.shivMethods&&("+n().join().replace(/\w+/g,function(e){return t.createElem(e),t.frag.createElement(e),'c("'+e+'")'})+");return n}")(v,t.frag)}function s(e){e||(e=t);var n=o(e);return v.shivCSS&&!d&&!n.hasCSS&&(n.hasCSS=!!i(e,"article,aside,figcaption,figure,footer,header,hgroup,nav,section{display:block}mark{background:#FF0;color:#000}")),c||l(e,n),e}var d,c,u=e.html5||{},p=/^<|^(?:button|map|select|textarea|object|iframe|option|optgroup)$/i,h=/^(?:a|b|code|div|fieldset|h1|h2|h3|h4|h5|h6|i|label|li|ol|p|q|span|strong|style|table|tbody|td|th|tr|ul)$/i,f="_html5shiv",m=0,g={};!function(){try{var e=t.createElement("a");e.innerHTML="<xyz></xyz>",d="hidden"in e,c=1==e.childNodes.length||function(){t.createElement("a");var e=t.createDocumentFragment();return"undefined"==typeof e.cloneNode||"undefined"==typeof e.createDocumentFragment||"undefined"==typeof e.createElement}()}catch(i){d=!0,c=!0}}();var v={elements:u.elements||"abbr article aside audio bdi canvas data datalist details figcaption figure footer header hgroup mark meter nav output progress section summary time video",shivCSS:u.shivCSS!==!1,supportsUnknownElements:c,shivMethods:u.shivMethods!==!1,type:"default",shivDocument:s,createElement:a,createDocumentFragment:r};e.html5=v,s(t)}(this,t),h._version=p,h._prefixes=b,h._domPrefixes=w,h._cssomPrefixes=C,h.testProp=function(e){return r([e])},h.testAllProps=s,h.testStyles=E,h.prefixed=function(e,t,i){return t?s(e,t,i):s(e,"pfx")},m.className=m.className.replace(/(^|\s)no-js(\s|$)/,"$1$2")+(f?" js "+I.join(" "):""),h}(this,this.document),function(e,t,i){function n(e){return"[object Function]"==g.call(e)}function o(e){return"string"==typeof e}function a(){}function r(e){return!e||"loaded"==e||"complete"==e||"uninitialized"==e}function l(){var e=v.shift();y=1,e?e.t?f(function(){("c"==e.t?p.injectCss:p.injectJs)(e.s,0,e.a,e.x,e.e,1)},0):(e(),l()):y=0}function s(e,i,n,o,a,s,d){function c(t){if(!h&&r(u.readyState)&&(b.r=h=1,!y&&l(),u.onload=u.onreadystatechange=null,t)){"img"!=e&&f(function(){C.removeChild(u)},50);for(var n in E[i])E[i].hasOwnProperty(n)&&E[i][n].onload()}}var d=d||p.errorTimeout,u=t.createElement(e),h=0,g=0,b={t:n,s:i,e:a,a:s,x:d};1===E[i]&&(g=1,E[i]=[]),"object"==e?u.data=i:(u.src=i,u.type=e),u.width=u.height="0",u.onerror=u.onload=u.onreadystatechange=function(){c.call(this,g)},v.splice(o,0,b),"img"!=e&&(g||2===E[i]?(C.insertBefore(u,_?null:m),f(c,d)):E[i].push(u))}function d(e,t,i,n,a){return y=0,t=t||"j",o(e)?s("c"==t?x:w,e,t,this.i++,i,n,a):(v.splice(this.i++,0,e),1==v.length&&l()),this}function c(){var e=p;return e.loader={load:d,i:0},e}var u,p,h=t.documentElement,f=e.setTimeout,m=t.getElementsByTagName("script")[0],g={}.toString,v=[],y=0,b="MozAppearance"in h.style,_=b&&!!t.createRange().compareNode,C=_?h:m.parentNode,h=e.opera&&"[object Opera]"==g.call(e.opera),h=!!t.attachEvent&&!h,w=b?"object":h?"script":"img",x=h?"script":w,I=Array.isArray||function(e){return"[object Array]"==g.call(e)},k=[],E={},S={timeout:function(e,t){return t.length&&(e.timeout=t[0]),e}};p=function(e){function t(e){var t,i,n,e=e.split("!"),o=k.length,a=e.pop(),r=e.length,a={url:a,origUrl:a,prefixes:e};for(i=0;r>i;i++)n=e[i].split("="),(t=S[n.shift()])&&(a=t(a,n));for(i=0;o>i;i++)a=k[i](a);return a}function r(e,o,a,r,l){var s=t(e),d=s.autoCallback;s.url.split(".").pop().split("?").shift(),s.bypass||(o&&(o=n(o)?o:o[e]||o[r]||o[e.split("/").pop().split("?")[0]]),s.instead?s.instead(e,o,a,r,l):(E[s.url]?s.noexec=!0:E[s.url]=1,a.load(s.url,s.forceCSS||!s.forceJS&&"css"==s.url.split(".").pop().split("?").shift()?"c":i,s.noexec,s.attrs,s.timeout),(n(o)||n(d))&&a.load(function(){c(),o&&o(s.origUrl,l,r),d&&d(s.origUrl,l,r),E[s.url]=2})))}function l(e,t){function i(e,i){if(e){if(o(e))i||(u=function(){var e=[].slice.call(arguments);p.apply(this,e),h()}),r(e,u,t,0,d);else if(Object(e)===e)for(s in l=function(){var t,i=0;for(t in e)e.hasOwnProperty(t)&&i++;return i}(),e)e.hasOwnProperty(s)&&(!i&&!--l&&(n(u)?u=function(){var e=[].slice.call(arguments);p.apply(this,e),h()}:u[s]=function(e){return function(){var t=[].slice.call(arguments);e&&e.apply(this,t),h()}}(p[s])),r(e[s],u,t,s,d))}else!i&&h()}var l,s,d=!!e.test,c=e.load||e.both,u=e.callback||a,p=u,h=e.complete||a;i(d?e.yep:e.nope,!!c),c&&i(c)}var s,d,u=this.yepnope.loader;if(o(e))r(e,0,u,0);else if(I(e))for(s=0;s<e.length;s++)d=e[s],o(d)?r(d,0,u,0):I(d)?p(d):Object(d)===d&&l(d,u);else Object(e)===e&&l(e,u)},p.addPrefix=function(e,t){S[e]=t},p.addFilter=function(e){k.push(e)},p.errorTimeout=1e4,null==t.readyState&&t.addEventListener&&(t.readyState="loading",t.addEventListener("DOMContentLoaded",u=function(){t.removeEventListener("DOMContentLoaded",u,0),t.readyState="complete"},0)),e.yepnope=c(),e.yepnope.executeStack=l,e.yepnope.injectJs=function(e,i,n,o,s,d){var c,u,h=t.createElement("script"),o=o||p.errorTimeout;h.src=e;for(u in n)h.setAttribute(u,n[u]);i=d?l:i||a,h.onreadystatechange=h.onload=function(){!c&&r(h.readyState)&&(c=1,i(),h.onload=h.onreadystatechange=null)},f(function(){c||(c=1,i(1))},o),s?h.onload():m.parentNode.insertBefore(h,m)},e.yepnope.injectCss=function(e,i,n,o,r,s){var d,o=t.createElement("link"),i=s?l:i||a;o.href=e,o.rel="stylesheet",o.type="text/css";for(d in n)o.setAttribute(d,n[d]);r||(m.parentNode.insertBefore(o,m),f(i,0))}}(this,document),Modernizr.load=function(){yepnope.apply(window,[].slice.call(arguments,0))},function(e,t,i){"use strict";var n,o,a=e.event;n=a.special.debouncedresize={setup:function(){e(this).on("resize",n.handler)},teardown:function(){e(this).off("resize",n.handler)},handler:function(e,t){var i=this,r=arguments,l=function(){e.type="debouncedresize",a.dispatch.apply(i,r)};o&&clearTimeout(o),t?l():o=setTimeout(l,n.threshold)},threshold:150};var r="data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///ywAAAAAAQABAAACAUwAOw==";e.fn.imagesLoaded=function(t){function n(){var i=e(u),n=e(p);l&&(p.length?l.reject(d,i,n):l.resolve(d)),e.isFunction(t)&&t.call(a,d,i,n)}function o(t,i){t.src!==r&&-1===e.inArray(t,c)&&(c.push(t),i?p.push(t):u.push(t),e.data(t,"imagesLoaded",{isBroken:i,src:t.src}),s&&l.notifyWith(e(t),[i,d,e(u),e(p)]),d.length===c.length&&(setTimeout(n),d.unbind(".imagesLoaded")))}var a=this,l=e.isFunction(e.Deferred)?e.Deferred():0,s=e.isFunction(l.notify),d=a.find("img").add(a.filter("img")),c=[],u=[],p=[];return e.isPlainObject(t)&&e.each(t,function(e,i){"callback"===e?t=i:l&&l[e](i)}),d.length?d.bind("load.imagesLoaded error.imagesLoaded",function(e){o(e.target,"error"===e.type)}).each(function(t,n){var a=n.src,l=e.data(n,"imagesLoaded");return l&&l.src===a?(o(n,l.isBroken),void 0):n.complete&&n.naturalWidth!==i?(o(n,0===n.naturalWidth||0===n.naturalHeight),void 0):((n.readyState||n.complete)&&(n.src=r,n.src=a),void 0)}):n(),l?l.promise(a):a};var l=e(t),s=t.Modernizr;e.Stapel=function(t,i){this.el=e(i),this._init(t)},e.Stapel.defaults={gutter:40,pileAngles:2,pileAnimation:{openSpeed:400,openEasing:"ease-in-out",closeSpeed:400,closeEasing:"ease-in-out"},otherPileAnimation:{openSpeed:400,openEasing:"ease-in-out",closeSpeed:350,closeEasing:"ease-in-out"},delay:0,randomAngle:!1,onLoad:function(){return!1},onBeforeOpen:function(){return!1},onAfterOpen:function(){return!1},onBeforeClose:function(){return!1},onAfterClose:function(){return!1}},e.Stapel.prototype={_init:function(t){this.options=e.extend(!0,{},e.Stapel.defaults,t),this._config();var i=this;this.el.imagesLoaded(function(){i.options.onLoad(),i._layout(),i._initEvents()})},_config:function(){this.support=s.csstransitions;var t={WebkitTransition:"webkitTransitionEnd",MozTransition:"transitionend",OTransition:"oTransitionEnd",msTransition:"MSTransitionEnd",transition:"transitionend"},i={WebkitTransform:"-webkit-transform",MozTransform:"-moz-transform",OTransform:"-o-transform",msTransform:"-ms-transform",transform:"transform"};this.support&&(this.transEndEventName=t[s.prefixed("transition")]+".cbpFWSlider",this.transformName=i[s.prefixed("transform")]),this.spread=!1,this.items=this.el.children("li").hide(),this.close=e("#tp-close")},_getSize:function(){this.elWidth=this.el.outerWidth(!0)},_initEvents:function(){var t=this;l.on("debouncedresize.stapel",function(){t._resize()}),this.items.on("click.stapel",function(){var i=e(this);return!t.spread&&i.data("isPile")?(t.spread=!0,t.pileName=i.data("pileName"),t.options.onBeforeOpen(t.pileName),t._openPile(),!1):void 0})},_layout:function(){this._piles(),this.itemSize={width:this.items.outerWidth(!0),height:this.items.outerHeight(!0)},this.items.remove(),this._setInitialStyle(),this.el.css("min-width",this.itemSize.width+this.options.gutter),this._getSize(),this._setItemsPosition(),this.items=this.el.children("li").show(),this.itemsCount=this.items.length},_piles:function(){this.piles={};var t,i=this,n=0;this.items.each(function(){for(var o=e(this),a=o.attr("data-pile")||"nopile-"+o.index(),r=a.split(","),l=0,s=r.length;s>l;++l){var d=e.trim(r[l]);t=i.piles[d],t||(t=i.piles[d]={elements:[],position:{left:0,top:0},index:n},++n);var c=o.clone().get(0);t.elements.push({el:c,finalPosition:{left:0,top:0}}),e(c).appendTo(i.el)}})},_setInitialStyle:function(){for(var t in this.piles)for(var i=this.piles[t],n=0,o=i.elements.length;o>n;++n){var a=e(i.elements[n].el),r={transform:"rotate(0deg)"};if(this._applyInitialTransition(a),n===o-2)r={transform:"rotate("+this.options.pileAngles+"deg)"};else if(n===o-3)r={transform:"rotate(-"+this.options.pileAngles+"deg)"};else if(n!==o-1){var l={visibility:"hidden"};a.css(l).data("extraStyle",l)}else"nopile"!==t.substr(0,6)&&a.data("front",!0).append('<div class="tp-title"><span>'+t+"</span><span>"+o+"</span></div>");a.css(r).data({initialStyle:r,pileName:t,pileCount:o,shadow:a.css("box-shadow"),isPile:"nopile"===t.substr(0,6)?!1:!0})}},_applyInitialTransition:function(e){this.support&&e.css("transition","left 400ms ease-in-out, top 400ms ease-in-out")},_setItemsPosition:function(){var t,i,n=0,o=0,a=0,r=0;for(var l in this.piles){var s,d,c=this.piles[l],u=this.itemSize.width+this.options.gutter,p=0,h=0;n+u<=this.elWidth?(t=n,i=o,n+=u):(0===a&&(a=Math.ceil((this.elWidth-n+this.options.gutter)/2)),o+=this.itemSize.height+this.options.gutter,t=0,i=o,n=u),c.position.left=t,c.position.top=i;for(var f=0,m=c.elements.length;m>f;++f){var g=c.elements[f],v=g.finalPosition;p+u<=this.elWidth?(s=p,d=h,p+=u):(h+=this.itemSize.height+this.options.gutter,s=0,d=h,p=u),v.left=s,v.top=d;var y=e(g.el);l!==this.pileName?y.css({left:c.position.left,top:c.position.top}):(r=g.finalPosition.top,y.css({left:g.finalPosition.left,top:r}))}}r=this.spread?r:o,this.el.css({marginLeft:a,height:r+this.itemSize.height})},_openPile:function(){if(!this.spread)return!1;var t;for(var i in this.piles)for(var n=this.piles[i],o=0,a=0,r=n.elements.length;r>a;++a){var l=n.elements[a],s=e(l.el),d=s.find("img"),c=i===this.pileName?{zIndex:9999,visibility:"visible",transition:this.support?"left "+this.options.pileAnimation.openSpeed+"ms "+(r-a-1)*this.options.delay+"ms "+this.options.pileAnimation.openEasing+", top "+this.options.pileAnimation.openSpeed+"ms "+(r-a-1)*this.options.delay+"ms "+this.options.pileAnimation.openEasing+", "+this.transformName+" "+this.options.pileAnimation.openSpeed+"ms "+(r-a-1)*this.options.delay+"ms "+this.options.pileAnimation.openEasing:"none"}:{zIndex:1,transition:this.support?"opacity "+this.options.otherPileAnimation.closeSpeed+"ms "+this.options.otherPileAnimation.closeEasing:"none"};i===this.pileName?(s.data("front")&&s.find("div.tp-title").hide(),r-1>a&&d.css("visibility","visible"),t=l.finalPosition,t.transform=this.options.randomAngle&&a!==n.index?"rotate("+Math.floor(11*Math.random()-5)+"deg)":"none",this.support||s.css("transform","none"),r-3>a&&s.css("box-shadow","none")):r-1>a&&d.css("visibility","hidden"),s.css(c);var u=this;i===this.pileName?this._applyTransition(s,t,this.options.pileAnimation.openSpeed,function(){var t=this.target||this.nodeName;if("LI"===t){var i=e(this);i.css("box-shadow",i.data("shadow")),u.support&&i.off(u.transEndEventName),++o,o===i.data("pileCount")&&(e(document).one("mousemove.stapel",function(){u.el.addClass("tp-open")}),u.options.onAfterOpen(u.pileName,o))}}):this._applyTransition(s,{opacity:0},this.options.otherPileAnimation.closeSpeed)}this.el.css("height",t.top+this.itemSize.height)},_closePile:function(){var t=this;if(this.spread){this.spread=!1,this.options.onBeforeClose(this.pileName),this.el.removeClass("tp-open");var i;for(var n in this.piles)for(var o=this.piles[n],a=0,r=0,l=o.elements.length;l>r;++r){var s=e(o.elements[r].el),d=n===this.pileName?{transition:this.support?"left "+this.options.pileAnimation.closeSpeed+"ms "+this.options.pileAnimation.closeEasing+", top "+this.options.pileAnimation.closeSpeed+"ms "+this.options.pileAnimation.closeEasing+", "+this.transformName+" "+this.options.pileAnimation.closeSpeed+"ms "+this.options.pileAnimation.closeEasing:"none"}:{transition:this.support?"opacity "+this.options.otherPileAnimation.openSpeed+"ms "+this.options.otherPileAnimation.openEasing:"none"};s.css(d),i=o.position,n===this.pileName&&(e.extend(i,s.data("initialStyle")),l-3>r&&s.css("box-shadow","none")),n===this.pileName?this._applyTransition(s,i,this.options.pileAnimation.closeSpeed,function(){var i=this.target||this.nodeName;if("LI"===i){var n=e(this),o=n.data("extraStyle");n.css("box-shadow",n.data("shadow")),t.support?(n.off(t.transEndEventName),t._applyInitialTransition(n)):n.css(n.data("initialStyle")),o&&n.css(o),++a,n.data("front")&&n.find("div.tp-title").show(),a===n.data("pileCount")&&t.options.onAfterClose(n.data("pileName"),a)}}):this._applyTransition(s,{opacity:1},this.options.otherPileAnimation.openSpeed,function(){var i=this.target||this.nodeName;if("LI"===i){var n=e(this);n.index()<l-1&&n.find("img").css("visibility","visible"),t.support&&(n.off(t.transEndEventName),t._applyInitialTransition(n))}})}this.pileName="",this.el.css("height",i.top+this.itemSize.height)}return!1},_resize:function(){this._getSize(),this._setItemsPosition()},_applyTransition:function(t,i,n,o){e.fn.applyStyle=this.support?e.fn.css:e.fn.animate,o&&this.support&&t.on(this.transEndEventName,o),o=o||function(){return!1},t.stop().applyStyle(i,e.extend(!0,[],{duration:n+"ms",complete:o}))},closePile:function(){this._closePile()}};var d=function(e){t.console&&t.console.error(e)};e.fn.stapel=function(t){var i=e.data(this,"stapel");if("string"==typeof t){var n=Array.prototype.slice.call(arguments,1);this.each(function(){return i?e.isFunction(i[t])&&"_"!==t.charAt(0)?(i[t].apply(i,n),void 0):(d("no such method '"+t+"' for stapel instance"),void 0):(d("cannot call methods on stapel prior to initialization; attempted to call method '"+t+"'"),void 0)})}else this.each(function(){i?i._init():i=e.data(this,"stapel",new e.Stapel(t,this))});return i}}(jQuery,window);