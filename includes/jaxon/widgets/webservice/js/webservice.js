
function wsAttachLI(){var _1=document.body&&document.body.offsetWidth;if(!_1||!StubFilesLoaded){window.setTimeout(function(){wsAttachLI();},10);return;}
var LI=document.getElementById("kore_li");if(LI){wsLoadLIFiles(wsInstantiateLI);}}
var wsLIFilesLoaded=false;function wsLoadLIFiles(_3,_4){if(!wsLIFilesLoaded){var _5=false;var _6=false;var _7=new Kore.CSSLoader();_7.addFile("includes/jaxon/css/loading.css");_7.loadFiles(function(){_5=true;if(_6){_3(_4);}});var _8=new Kore.JSLoader();_8.addFile("includes/kore/js/loadingindicator/loadingindicator.js");_8.addFile("includes/yui/dom/dom.js");_8.loadFiles(function(){_6=true;if(_5){_3(_4);}});}else{_3(_4);}}
function wsInstantiateLI(){wsLIFilesLoaded=true;wsLI=Kore.LoadingIndicator.create();wsLI.start();}