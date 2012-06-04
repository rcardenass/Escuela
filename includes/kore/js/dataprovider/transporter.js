
if(!Kore){var Kore={};}
Kore.Transporter=Class.create();Kore.Transporter.prototype={error:null,transport:null,initialize:function(_1,_2){this.setOptions(_2);var _3=_2.onComplete;var _4=this;if(_1.length>2047){this.error=new Kore.Error(Kore.Error.ERR_REQUEST_URI_TOO_LONG,"Request-URI Too Long");this.transport=null;_3(_4,null);return;}
var _s=function(_6){var _7=false;if(!_4.error){_4.transport=_6;_7=_6.getResponseHeader["Kt_location"];if(_7){_7=_4._sanitizeRedirectURL(_7);_4.options.method="GET";_4._makeRequest(_7,{success:_s,failure:_f});}}
if(!_7){_3(_4,null);}};var _f=function(_9){_4.error=new Kore.Error(_9.status,_9.statusText);_4.transport=_9;_3(_4,null);return;};this._makeRequest(_1,{success:_s,failure:_f});},_sanitizeRedirectURL:function(_a){var _b=_a.replace(/[#\s\r\n]*$/gi,"");if(_b.indexOf("KT_ajax_request=true")>=0){_b=_b.replace(/&KT_ajax_request=true/,"");_b=_b.replace(/\?KT_ajax_request=true$/,"");_b=_b.replace(/\?KT_ajax_request=true&/,"?");}
var _c=_b.match(/([^\?#]*)/i);_c=_c[1];var _d=_b.match(/\#([^\#]*)/i);if(_d){_d=_d[1].toQueryParams();}
if(_b.indexOf("__state=")>0&&_d){_b=_c+"?"+$H(_d).toQueryString();}
if(typeof dhtmlHistory!="undefined"){dhtmlHistory.toAdd=_b;}
if(_b.indexOf("KT_ajax_request=true")<0){_b=_b+(_b.indexOf("?")>=0?"&KT_ajax_request=true":"?KT_ajax_request=true");}
return _b;},_makeRequest:function(_e,_f){try{var _10=Kore.getDocumentCharset();if(_10){YAHOO.util.Connect.initHeader("Kt_charset",_10);}}
catch(err){}
YAHOO.util.Connect.asyncRequest(this.options.method,_e,_f,this.options.postData);},setOptions:function(_11){this.options={onComplete:function(){},method:"GET",asynchronous:true,parameters:"",postData:null};Object.extend(this.options,_11||{});}};