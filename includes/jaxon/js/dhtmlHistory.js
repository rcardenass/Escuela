
window.dhtmlHistory={initialize:function(){if(this.isInternetExplorer()==false){return;}
if(historyStorage.hasKey("DhtmlHistory_pageLoaded")==false){this.fireOnNewListener=false;this.firstLoad=true;historyStorage.put("DhtmlHistory_pageLoaded",true);}else{this.fireOnNewListener=true;this.firstLoad=false;}},addListener:function(_1){this.listener=_1;if(this.fireOnNewListener==true){this.fireHistoryEvent(this.currentLocation);this.fireOnNewListener=false;}},add:function(_2,_3){var _4=this;var _5=function(){if(_4.currentWaitTime>0){_4.currentWaitTime=_4.currentWaitTime-_4.WAIT_TIME;}
_2=_4.removeHash(_2);var _6=document.getElementById(_2);if(_6!=undefined||_6!=null){var _7="Exception: History locations can not have "+"the same value as _any_ id's "+"that might be in the document, "+"due to a bug in Internet "+"Explorer; please ask the "+"developer to choose a history "+"location that does not match "+"any HTML id's in this "+"document. The following ID "+"is already taken and can not "+"be a location: "+_2;throw _7;}
historyStorage.put(_2,_3);_4.ignoreLocationChange=true;this.ieAtomicLocationChange=true;_4.currentLocation=_2;window.location.hash=_2;if(_4.isInternetExplorer()){_4.iframe.src="includes/jaxon/js/"+"blank.html?"+_2;}
this.ieAtomicLocationChange=false;};window.setTimeout(_5,this.currentWaitTime);this.currentWaitTime=this.currentWaitTime+this.WAIT_TIME;},isFirstLoad:function(){if(this.firstLoad==true){return true;}else{return false;}},isInternational:function(){return false;},getVersion:function(){return"0.05";},getCurrentLocation:function(){var _8=this.removeHash(window.location.hash);return _8;},currentLocation:null,listener:null,iframe:null,ignoreLocationChange:null,WAIT_TIME:200,currentWaitTime:0,fireOnNewListener:null,firstLoad:null,ieAtomicLocationChange:null,create:function(){var _9=this.getCurrentLocation();this.currentLocation=_9;if(this.isInternetExplorer()){document.write("<iframe style='border: 0px; width: 1px; "+"height: 1px; position: absolute; bottom: 0px; "+"right: 0px; visibility: visible;' "+"name='DhtmlHistoryFrame' id='DhtmlHistoryFrame' "+"src='"+"includes/jaxon/js/"+"blank.html?"+_9+"'>"+"</iframe>");this.WAIT_TIME=400;}
var _a=this;window.onunload=function(){_a.firstLoad=null;};if(this.isInternetExplorer()==false){if(historyStorage.hasKey("DhtmlHistory_pageLoaded")==false){this.ignoreLocationChange=true;this.firstLoad=true;historyStorage.put("DhtmlHistory_pageLoaded",true);}else{this.ignoreLocationChange=false;this.fireOnNewListener=true;}}else{this.ignoreLocationChange=true;}
if(this.isInternetExplorer()){this.iframe=document.getElementById("DhtmlHistoryFrame");}
var _a=this;var _b=function(){_a.checkLocation();};setInterval(_b,100);},fireHistoryEvent:function(_c){var _d=historyStorage.get(_c);this.listener.call(null,_c,_d);},checkLocation:function(){if(this.isInternetExplorer()==false&&this.ignoreLocationChange==true){this.ignoreLocationChange=false;return;}
if(this.isInternetExplorer()==false&&this.ieAtomicLocationChange==true){return;}
var _e=this.getCurrentLocation();if(_e==this.currentLocation){return;}
this.ieAtomicLocationChange=true;if(this.isInternetExplorer()&&this.getIFrameHash()!=_e){this.iframe.src="includes/jaxon/js/"+"blank.html?"+_e;}else{if(this.isInternetExplorer()){return;}}
this.currentLocation=_e;this.ieAtomicLocationChange=false;this.fireHistoryEvent(_e);},getIFrameHash:function(){var _f=document.getElementById("DhtmlHistoryFrame");var doc=_f.contentWindow.document;var _11=new String(doc.location.search);if(_11.length==1&&_11.charAt(0)=="?"){_11="";}else{if(_11.length>=2&&_11.charAt(0)=="?"){_11=_11.substring(1);}}
return _11;},removeHash:function(_12){if(_12==null||_12==undefined){return null;}else{if(_12==""){return"";}else{if(_12.length==1&&_12.charAt(0)=="#"){return"";}else{if(_12.length>1&&_12.charAt(0)=="#"){return _12.substring(1);}else{return _12;}}}}},iframeLoaded:function(_13){if(this.ignoreLocationChange==true){this.ignoreLocationChange=false;return;}
var _14=new String(_13.search);if(_14.length==1&&_14.charAt(0)=="?"){_14="";}else{if(_14.length>=2&&_14.charAt(0)=="?"){_14=_14.substring(1);}}
if(this.pageLoadEvent!=true){window.location.hash=_14;}
this.fireHistoryEvent(_14);},isInternetExplorer:function(){var _15=navigator.userAgent.toLowerCase();if(document.all&&_15.indexOf("msie")!=-1){return true;}else{return false;}}};window.historyStorage={debugging:false,storageHash:new Object(),hashLoaded:false,put:function(key,_17){this.assertValidKey(key);if(this.hasKey(key)){this.remove(key);}
this.storageHash[key]=_17;this.saveHashTable();},get:function(key){this.assertValidKey(key);this.loadHashTable();var _19=this.storageHash[key];if(_19==undefined){return null;}else{return _19;}},remove:function(key){this.assertValidKey(key);this.loadHashTable();delete this.storageHash[key];this.saveHashTable();},reset:function(){if(this.storageField){this.storageField.value="";}
this.storageHash=new Object();},hasKey:function(key){this.assertValidKey(key);this.loadHashTable();if(typeof this.storageHash[key]=="undefined"){return false;}else{return true;}},isValidKey:function(key){return(typeof key=="string");},storageField:null,init:function(){var _1d=this;if(!document.body){window.setTimeout(function(){_1d.init();});return;}
var _1e=document.createElement("form");_1e.id="historyStorageForm";_1e.setAttribute("method","GET");if(!this.debugging){_1e.style.position="absolute";_1e.style.top="-1000px";_1e.style.left="-1000px";}
var _1f=document.createElement("textarea");_1f.setAttribute("id","historyStorageField");_1f.setAttribute("name","historyStorageField");_1e.appendChild(_1f);document.body.insertBefore(_1e,document.body.firstChild);this.storageField=document.getElementById("historyStorageField");},assertValidKey:function(key){if(this.isValidKey(key)==false){throw"Please provide a valid key for "+"window.historyStorage, key= "+key;}},loadHashTable:function(){if(this.hashLoaded==false){var _21=this.storageField?this.storageField.value:"";if(_21!=""&&_21!=null){this.storageHash=eval("("+_21+")");}
this.hashLoaded=true;}},saveHashTable:function(){this.loadHashTable();var _22=JSON.stringify(this.storageHash);if(this.storageField){this.storageField.value=_22;}}};Array.prototype.______array="______array";var JSON={org:"http://www.JSON.org",copyright:"(c)2005 JSON.org",license:"http://www.crockford.com/JSON/license.html",stringify:function(arg){var c,i,l,s="",v;switch(typeof arg){case"object":if(arg){if(arg.______array=="______array"){for(i=0;i<arg.length;++i){v=this.stringify(arg[i]);if(s){s+=",";}
s+=v;}
return"["+s+"]";}else{if(typeof arg.toString!="undefined"){for(i in arg){v=arg[i];if(typeof v!="undefined"&&typeof v!="function"){v=this.stringify(v);if(s){s+=",";}
s+=this.stringify(i)+":"+v;}}
return"{"+s+"}";}}}
return"null";case"number":return isFinite(arg)?String(arg):"null";case"string":l=arg.length;s="\"";for(i=0;i<l;i+=1){c=arg.charAt(i);if(c>=" "){if(c=="\\"||c=="\""){s+="\\";}
s+=c;}else{switch(c){case"\b":s+="\\b";break;case"\f":s+="\\f";break;case"\n":s+="\\n";break;case"\r":s+="\\r";break;case"\t":s+="\\t";break;default:c=c.charCodeAt();s+="\\u00"+Math.floor(c/16).toString(16)+(c%16).toString(16);}}}
return s+"\"";case"boolean":return String(arg);default:return"null";}},parse:function(_25){var at=0;var ch=" ";function error(m){throw{name:"JSONError",message:m,at:at-1,text:_25};}
function next(){ch=_25.charAt(at);at+=1;return ch;}
function white(){while(ch!=""&&ch<=" "){next();}}
function str(){var i,s="",t,u;if(ch=="\""){outer:while(next()){if(ch=="\""){next();return s;}else{if(ch=="\\"){switch(next()){case"b":s+="\b";break;case"f":s+="\f";break;case"n":s+="\n";break;case"r":s+="\r";break;case"t":s+="\t";break;case"u":u=0;for(i=0;i<4;i+=1){t=parseInt(next(),16);if(!isFinite(t)){break outer;}
u=u*16+t;}
s+=String.fromCharCode(u);break;default:s+=ch;}}else{s+=ch;}}}}
error("Bad string");}
function arr(){var a=[];if(ch=="["){next();white();if(ch=="]"){next();return a;}
while(ch){a.push(val());white();if(ch=="]"){next();return a;}else{if(ch!=","){break;}}
next();white();}}
error("Bad array");}
function obj(){var k,o={};if(ch=="{"){next();white();if(ch=="}"){next();return o;}
while(ch){k=str();white();if(ch!=":"){break;}
next();o[k]=val();white();if(ch=="}"){next();return o;}else{if(ch!=","){break;}}
next();white();}}
error("Bad object");}
function num(){var n="",v;if(ch=="-"){n="-";next();}
while(ch>="0"&&ch<="9"){n+=ch;next();}
if(ch=="."){n+=".";while(next()&&ch>="0"&&ch<="9"){n+=ch;}}
if(ch=="e"||ch=="E"){n+="e";next();if(ch=="-"||ch=="+"){n+=ch;next();}
while(ch>="0"&&ch<="9"){n+=ch;next();}}
v=+n;if(!isFinite(v)){error("Bad number");}else{return v;}}
function word(){switch(ch){case"t":if(next()=="r"&&next()=="u"&&next()=="e"){next();return true;}
break;case"f":if(next()=="a"&&next()=="l"&&next()=="s"&&next()=="e"){next();return false;}
break;case"n":if(next()=="u"&&next()=="l"&&next()=="l"){next();return null;}
break;}
error("Syntax error");}
function val(){white();switch(ch){case"{":return obj();case"[":return arr();case"\"":return str();case"-":return num();default:return ch>="0"&&ch<="9"?num():word();}}
return val();}};window.historyStorage.init();window.dhtmlHistory.create();