
if(typeof Widgets=="undefined"){Widgets={};}
Widgets.Rating=Class.create();Widgets.Rating.prototype={initialize:function(id,_2,_3,_4){this.id=id;this.index=_2;this.options=_3;this.key=_4;this.rated=false;var _5=new Kore.JSLoader();_5.addFile("includes/yui/yahoo/yahoo.js");_5.addFile("includes/yui/dom/dom.js");_5.addFile("includes/yui/event/event.js");_5.addFile("includes/yui/animation/animation.js");_5.addFile("includes/yui/connection/connection.js");_5.addFile("includes/kore/js/error.js");_5.addFile("includes/kore/js/browser/browser.js");_5.addFile("includes/kore/js/dataprovider/transporter.js");_5.addFile("includes/kore/js/dataprovider/dataprovider.js");_5.addFile("includes/kore/js/dataprovider/jsonprovider.js");try{_5.loadFiles(function(){if(!Kore.isOkForAjax()){return false;}
Kore.addUnloadListener(this.unload,this);this.initializeRatingMarkup();}.bind(this));delete _5;}
catch(e){}},unload:function(){},initializeRatingMarkup:function(){var _6=this.alreadyRated();if(_6){this.rated=true;this.lockOldRating(_6);}
var _7=YAHOO.util.Dom.get("rating_"+this.id+"_"+this.index).getElementsByTagName("a");for(var i=0;i<_7.length;i++){if(!this.rated){_7[i].setAttribute("initialSrc",_7[i].firstChild.src);YAHOO.util.Event.addListener(_7[i],"mouseover",this.rateOverEvt,this,true);YAHOO.util.Event.addListener(_7[i],"mouseout",this.rateOutEvt,this,true);}
YAHOO.util.Event.addListener(_7[i],"click",this.rateClickEvt,this,true);}},rateOverEvt:function(e){var el=YAHOO.util.Event.getTarget(e);var _b=this.getParentByTagName(el,"DIV");var as=_b.getElementsByTagName("a");var _d="future";for(var i=0;i<as.length;i++){as[i].firstChild.src=as[i].firstChild.src.replace(/([^\/]*)\.gif/i,_d+".gif");if(as[i]==el.parentNode){_d="present_normal";}}},rateOutEvt:function(e){var el=YAHOO.util.Event.getTarget(e);var div=this.getParentByTagName(el,"DIV");var as=div.getElementsByTagName("a");for(var i=0;i<as.length;i++){as[i].firstChild.src=as[i].getAttribute("initialSrc");}},rateClickEvt:function(e){var el=YAHOO.util.Event.getTarget(e);YAHOO.util.Event.stopEvent(e);if(!this.rated){el=this.getParentByTagName(el,"A");this.userRating=(el.hash+"").replace(/.*?(\d+)$/i,"$1");this.saveRating(this.userRating);}
return false;},saveRating:function(_16){var _17=this;window[this.id+"_saveRating"](_16,this.index,function(_18,_19){var _1a=_19[0];if(_1a.error){alert("Error no: "+_1a.error.code+" has occured: \""+_1a.error.message+"\" while executing query to URL: \""+_1a.URL+"\".");}else{if(_1a.content.error){alert("Error: "+_1a.content.error.message);}else{var _1b=_1a.content;if(_1b["rating"]){var _1c=parseInt(_1b.rating);_17.recreateRatings(_1c);}}}});},getRateClass:function(_1d,_1e){return(_1d<=_1e)?"present_selected":"present_normal";},fadeIn:function(el){YAHOO.util.Dom.setStyle(el,"opacity","0");var _20=new YAHOO.util.Anim(el,{opacity:{to:1}},1);_20.animate();},fadeOut:function(el){if(this.rated){YAHOO.util.Dom.setStyle(el,"opacity","0.3");}else{YAHOO.util.Dom.setStyle(el,"opacity","0");var _22=new YAHOO.util.Anim(el,{opacity:{from:1,to:0.3}},1);_22.animate();}},recreateRatings:function(_23){var _24="rating_"+this.id+"_"+this.index;var El=YAHOO.util.Dom.get(_24);var _26=El.getElementsByTagName("a");El.style.visibility="hidden";for(var i=0;i<_26.length;i++){_26[i].firstChild.src=_26[i].firstChild.src.replace(/([^\/]*)\.gif/i,this.getRateClass(i+1,_23)+".gif");_26[i].setAttribute("initialSrc",_26[i].firstChild.src);}
this.fadeIn(El);El.style.visibility="visible";this.saveRatingCookie();this.lockOldRating(this.userRating);this.rated=true;},saveRatingCookie:function(){if(window.navigator.cookieEnabled){var _28=this.userRating;var _29=this.key;var _2a=_28;var now=new Date();var _2c=now.getTime()+(24*60*60*1000);now.setTime(_2c);var _2d=now.toGMTString();var _2e=_29+"="+_2a+";"+"expires="+_2d;document.cookie=_2e;}},alreadyRated:function(){var _2f=null;var _30=document.cookie.split(";");var _31=this;_30.each(function(_32){var _33=_32.match(/(\w+)=/);var _34=_32.match(/=(.+)/);var _35=_33?_33[1]:null;var _36=_34?_34[1]:null;if(_35&&_36){if(_31.key==_35){_2f=_36;}}});return _2f;},lockOldRating:function(_37){var _38="rating_"+this.id+"_"+this.index;var El=YAHOO.util.Dom.get(_38);var _3a=El.getElementsByTagName("a");for(var i=0;i<_3a.length;i++){_3a[i].title=this.options.you+this.options.titles[_37-1];_3a[i].style.cursor="default";var _3c=_3a[i].getElementsByTagName("img");if(_3c&&_3c[0]){_3c[0].alt=this.options.you+this.options.titles[_37-1];}
YAHOO.util.Event.removeListener(_3a[i],"mouseover",this.rateOverEvt);YAHOO.util.Event.removeListener(_3a[i],"mouseout",this.rateOutEvt);}
this.fadeOut(El);},getParentByTagName:function(el,_3e){_3e=_3e.toLowerCase();while(el&&el.nodeName.toLowerCase()!=_3e){el=el.parentNode;}
return el;}};