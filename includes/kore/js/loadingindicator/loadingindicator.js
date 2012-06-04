
if(!Kore){var Kore={};}
Kore.LoadingIndicator=Class.create();Kore.LoadingIndicator.prototype={element:null,initialize:function(){this.element=YAHOO.util.Dom.get("kore_li");},start:function(){if(this.element==null){return;}
YAHOO.util.Dom.addClass(document.body,"kore_li_start");try{var _1=window.pageYOffset||document.documentElement.scrollTop||document.body.scrollTop||0;YAHOO.util.Dom.setStyle(this.element,"top",_1+"px");}
catch(e){}
YAHOO.util.Dom.setStyle(this.element,"display","");},stop:function(){if(this.element==null){return;}
YAHOO.util.Dom.removeClass(document.body,"kore_li_start");try{YAHOO.util.Dom.setStyle(this.element,"display","none");}
catch(e){}}};Kore.LoadingIndicator.instance=null;Kore.LoadingIndicator.create=function(){if(Kore.LoadingIndicator.instance==null){Kore.LoadingIndicator.instance=new Kore.LoadingIndicator();}
return Kore.LoadingIndicator.instance;};