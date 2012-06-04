
if(!Kore){var Kore={};}
Kore.JsonProvider=Class.create();Kore.JsonProvider.prototype=Object.extend(new Kore.DataProvider(),{onComplete:function(){try{if(this.error){this.content=null;return;}
this.content=eval("("+this.content+")");}
catch(e){this.error=new Kore.Error(Kore.Error.ERR_NOT_JSON,"The response is not a valid JSON string:"+"\r\n================================\r\n"+this.content+"\r\n================================\r\n");this.content=null;}}});