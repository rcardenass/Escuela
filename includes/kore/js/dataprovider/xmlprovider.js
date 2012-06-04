
if(!Kore){var Kore={};}
Kore.XmlProvider=Class.create();Kore.XmlProvider.prototype=Object.extend(new Kore.DataProvider(),{onComplete:function(){try{if(this.error){this.content=null;return;}
var ct=this.transport.getResponseHeader["Content-Type"];if(typeof ct=="undefined"){ct=this.transport.getResponseHeader["Content-type"];}
ct=ct.trim();if(ct.indexOf("application/xml")==-1&&ct.indexOf("text/xml")==-1){this._setError();return;}
this.content=this.transport.responseXML;}
catch(e){this._setError();}},_setError:function(){this.error=new Kore.Error(Kore.Error.ERR_NOT_XML,"The response is not a valid XML:"+"\r\n================================\r\n"+this.transport.responseXML+"\r\n================================\r\n");this.content=null;}});