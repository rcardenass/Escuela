
if(typeof Widgets=="undefined"){Widgets={};}
Widgets.Accordion=Class.create();Widgets.Accordion.default_accordion_options={dimensions:{width:300,height:200},title_height:27};Widgets.Accordion.prototype={activeElement:-1,shownElement:-1,loadedElements:[],htmlProvider:null,domElement:null,defaultOptions:{method:"get"},initialize:function(id,_2,_3){this.id=id;this.urls=_2||null;this.options=Object.extend(Object.copy(Widgets.Accordion.default_accordion_options),_3||{});this.nowAnimating=false;var _4=new Kore.JSLoader();_4.addFile("includes/kore/js/browser/browser.js");_4.addFile("includes/jaxon/widgets/widgets.js");_4.addFile("includes/yui/yahoo/yahoo.js");_4.addFile("includes/yui/dom/dom.js");_4.addFile("includes/yui/event/event.js");_4.addFile("includes/yui/animation/animation.js");if(this.urls!=null){_4.addFile("includes/yui/connection/connection.js");_4.addFile("includes/kore/js/error.js");_4.addFile("includes/kore/js/dataprovider/transporter.js");_4.addFile("includes/kore/js/dataprovider/dataprovider.js");_4.addFile("includes/kore/js/dataprovider/htmlprovider.js");_4.addFile("includes/kore/js/dataprovider/htmlprocessor.js");}
try{_4.loadFiles(function(){if(!Kore.isOkForAjax()){return false;}
Widgets.general_actions.addActions(this);this.render();}.bind(this));}
catch(e){alert(e.message);}},setUrl:function(_5){this.urls[this.activeElement]=_5;},loadInfo:function(_6){this.htmlProvider=new Kore.HtmlProvider(null,this,_6);this.htmlProvider.finalizeEvent.subscribe(this.onUpdate,this,true);var _7=this.urls[this.activeElement];var _8=Kore.Url.getParamsFromCurrentUrl(true);var _9=_8[1];var _a=_8[0];if(/__state/.test(_9)){if(_9!=""){_7+=((/\?/.test(_7))?"&":"?")+_9;}}else{if(_a!=""){_7+=((/\?/.test(_7))?"&":"?")+_a;}}
if(!/KT_ajax_request=true/.test(_7)){_7+=((/\?/.test(_7))?"&":"?")+"KT_ajax_request=true";}
this.htmlProvider.URL=_7;if(this.fullUrl==null){this.fullUrl=window.location.href.toString().replace(/\/[^\/]*$/,"/")+this.urls[this.activeElement];}
this.htmlProvider.getContent();},render:function(){if(!YAHOO.util.Dom.get(this.id).offsetHeight){window.setTimeout(function(){this.render();}.bind(this),10);return;}
this.options.dimensions.width=parseInt(YAHOO.util.Dom.get(this.id).style.width);this.options.dimensions.height=parseInt(YAHOO.util.Dom.get(this.id).style.height);YAHOO.util.Dom.removeClass(this.id,"phprendering");var _b=YAHOO.util.Dom.getElementsByClassName("region","div",this.id);this.options.title_height=_b[0].getElementsByTagName("h3")[0].offsetHeight;this.loadedElements=[];if(this.urls!=null){this.htmlProvider=new Kore.HtmlProvider(null,this);this.htmlProvider.finalizeEvent.subscribe(this.onUpdate,this,true);}
this.regions_length=_b.length;for(var i=0;i<_b.length;i++){YAHOO.util.Dom.removeClass(_b[i],"phprendering");_b[i].style.width=this.options.dimensions.width+"px";_b[i].style.overflow="hidden";if(!this.urls||this.urls==null){this.loadedElements.push(i);}
_b[i].setAttribute("region_number",i);_b[i].id=this.id+"region"+i;if(YAHOO.util.Dom.hasClass(_b[i],"selected")){this.loadedElements.push(i);this.activeElement=this.shownElement=i;}
var _d=_b[i].getElementsByTagName("h3")[0];_d=_d.getElementsByTagName("a")[0];_d.hideFocus=true;YAHOO.util.Event.addListener(_d,"click",this.showElementEvt,this,true);}
var _e=YAHOO.util.Dom.getElementsByClassName("accordionBody","div",this.id);this.bodiesHeight=(this.options.dimensions.height-((_b.length*this.options.title_height)-1));for(var i=0;i<_e.length;i++){_e[i].style.width=(this.options.dimensions.width)+"px";_e[i].style.overflow="hidden";_e[i].style.height="0px";}
var _f=this.shownElement;if(_f==this.regions_length-1){this.shownElement=0;}else{this.shownElement=_f+1;}
this.showElement(_f,0.1);},onUpdate:function(){this.loadedElements.push(this.activeElement);this.initLinks();this.initForms();},animateShow:function(_10){var _11=YAHOO.util.Dom.get(this.id+"region"+this.shownElement+"-body");_11.style.overflow="hidden";var _12=YAHOO.util.Dom.get(this.id+"region"+this.activeElement+"-body");_12.style.overflow="hidden";if(!_10){this.finishAnimate();return;}
var _13={"style":{"value":this.bodiesHeight}};var _14=new YAHOO.util.Anim(_13,{value:{from:this.bodiesHeight,to:0}},_10,YAHOO.util.Easing.easeOut);_14.onTween.subscribe(function(){var _15=Math.floor(_13.style.value);var _16=this.bodiesHeight-_15;_11.style.height=_15+"px";_12.style.height=_16+"px";}.bind(this));_14.onComplete.subscribe(function(){this.finishAnimate();}.bind(this));this.nowAnimating=true;_14.animate();},finishAnimate:function(){this.nowAnimating=false;var _17=YAHOO.util.Dom.get(this.id+"region"+this.shownElement+"-body");_17.style.height="0px";var _18=YAHOO.util.Dom.get(this.id+"region"+this.activeElement+"-body");_18.style.overflow="auto";var w=this.bodiesHeight;if(Kore.is.safari&&this.urls==null){w+=1;}
_18.style.height=(w)+"px";this.shownElement=this.activeElement;},showElement:function(_1a,_1b){_1b=(typeof _1b=="number")?(_1b||0.4):null;this.activeElement=_1a;if(this.shownElement==this.activeElement){return;}
YAHOO.util.Dom.addClass(this.id+"region"+this.activeElement,"selected");YAHOO.util.Dom.removeClass(this.id+"region"+this.shownElement,"selected");if(this.activeElement>=0){if(!this.loadedElements.include(this.activeElement)){var _1c=YAHOO.util.Dom.get(this.id+"region"+this.activeElement+"-body");this.domElement=YAHOO.util.Dom.getElementsByClassName("accordionContent","div",_1c)[0];this.loadInfo();}
this.animateShow(_1b);}},showElementEvt:function(e){YAHOO.util.Event.stopEvent(e);var _1e=this.nowAnimating||((this.activeElement>=0)&&!this.loadedElements.include(this.activeElement));if(_1e){return;}
var el=YAHOO.util.Event.getTarget(e);var _20=el.parentNode.parentNode.getAttribute("region_number");this.showElement(parseInt(_20),0.7);}};function accordion_showRegion(e,_22,_23){window[_22].showElement(_23);YAHOO.util.Event.stopEvent(e);}