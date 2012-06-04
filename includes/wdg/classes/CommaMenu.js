// Copyright 2001-2005 Interakt Online. All rights reserved.

$DCM_SELECT_SIZE_OPTION_NAME = "size";
$DCM_GLOBALOBJECT = 'CommaMenus';
window[$DCM_GLOBALOBJECT] = {};

function MXW_CommaMenu (input) {
	this.painted = false;
	this.name = input;
	this.input = document.getElementById(input);

	this.recordset = new JSRecordset(WDG_getAttributeNS(this.input, 'recordset'));
	this.valuefield = WDG_getAttributeNS(this.input, 'valuefield');
	this.displayfield = WDG_getAttributeNS(this.input, 'displayfield');
	var ss = parseInt(WDG_getAttributeNS(this.input, $DCM_SELECT_SIZE_OPTION_NAME));
	this.select_size = isNaN(ss)?8:ss;

	window[$DCM_GLOBALOBJECT][input] = this;

	this.inspect();
}


function MXW_CommaMenu_paint(forceRepaint) {
	if (typeof forceRepaint=="undefined") {
		forceRepaint = false;
	}
	if(this.painted && !forceRepaint ) {
		return;
	}
	
	if (forceRepaint && this.menu) {
		this.menu.parentNode.removeChild(this.menu);
	}

	var tmp = utility.dom.createElement("SELECT", {
		"multiple"		: "true",
		"size"		: this.select_size,
		"id"		: this.name +"_select"
	});
	
	this.menu = utility.dom.insertAfter(tmp, this.input);
	WDG_setAttributeNS(this.menu, 'cbFor', this.name);
	if (!is.opera) {
		this.menu.onchange = MXW_CommaMenu_menu_click;
	} else {
		this.menu.onmousedown = MXW_CommaMenu_menu_click;
	}

	this.recordset.MoveFirst();
	while(this.recordset.MoveNext()) {
		var o = new Option(this.recordset.Fields(this.displayfield),this.recordset.Fields(this.valuefield));
		this.menu.options[this.menu.options.length] = o;
	}
	this.input.style.display = "none";

	this.painted = true;
}

function MXW_CommaMenu_inspect() {
	this.paint();
	var strValues = this.input.value;
	var arrValues = strValues.split(/,/g);
	for (var i=0; i<arrValues.length; i++) {
		arrValues[i] = String_trim(arrValues[i]);
	}
	this.menu.selectedIndex = -1;
	var obj = document.getElementById(this.name +"_select");
	
	for (var i=0; i < obj.options.length; i++) {
		if (Array_indexOf(arrValues, obj.options[i].value) != -1) {
			setTimeout('MXW_CommaMenu_lateSelect("'+this.name+'_select", '+i+')', 1);
		}
	}
}

function MXW_CommaMenu_lateSelect(zid, i) {
	document.getElementById(zid).options[i].selected = true;
}

function MXW_CommaMenu_apply() {
	var newValue = "";
	for(var i=0; i<this.menu.options.length; i++) {
		if(this.menu.options[i].selected) {
			newValue += (newValue==""?"":",") + this.menu.options[i].value;
		}
	}
	this.input.value = newValue;
}
function MXW_CommaMenu_menu_click() {
	window[$DCM_GLOBALOBJECT][WDG_getAttributeNS(this, 'cbFor')].apply();
}
MXW_CommaMenu.prototype.paint = MXW_CommaMenu_paint;
MXW_CommaMenu.prototype.apply = MXW_CommaMenu_apply;
MXW_CommaMenu.prototype.inspect = MXW_CommaMenu_inspect;

