// Copyright 2001-2005 Interakt Online. All rights reserved.

$CAL_MAIN_CLASSNAME = 'Calendar';
$CAL_GLOBALOBJECT = "Calendars";
window[$CAL_GLOBALOBJECT] = [];

function MXW_Calendar (boundTo) {
	if (is.safari && is.version < 1.4) {
		return;
	}
	this.input = document.getElementById(boundTo);

	var oldmask = WDG_getAttributeNS(this.input, 'mask');
	var mask = oldmask.replace(/ t$/, ' tt');
	WDG_setAttributeNS(this.input, 'mask', mask);

	this.readonly = (WDG_getAttributeNS(this.input, 'readonly')+'') == 'true';
	if (this.readonly) {
		this.input.readOnly = true;
	}
	//Calendar does not work on IE 5 on MAc, so we  have only SmartDate, and add spinner
	if (is.ie && is.mac) {
		WDG_setAttributeNS(this.input, 'spinner', 'yes');
		this.sd = new MXW_SmartDate(boundTo);
		return this;
	}
	this.sd = new MXW_SmartDate(boundTo);

	var paramObj = {};
	paramObj.inputField = boundTo;
	paramObj.button = boundTo + "_btn";
	paramObj.ifFormat = mask2calendar(this.sd.mask);
	paramObj.daFormat = mask2calendar(this.sd.mask);
	paramObj.label = WDG_Messages["calendar_button"];
	paramObj.firstDay = (WDG_getAttributeNS(this.input, 'mondayfirst') == 'true') ? 1 : 0 ;
	paramObj.singleClick = WDG_getAttributeNS(this.input, 'singleclick') == 'true';
	if (/(h|H|i|I|s|t)/.test(mask)) {
		paramObj.showsTime = true;
		paramObj.timeFormat = (/(t)/.test(mask) ? "12" : "24");
	}

	//WDG_setAttributeNS(this.input, 'mask', mask2calendar(paramObj.ifFormat));

	var btnAttributes = {
		"type":"button",
		"name":boundTo+"_btn",
		"id":boundTo+"_btn",
		"value":paramObj.label
	};

	var btnSrcAttributes = WDG_getAttributeNS(this.input, 'suppattrs')+'';
	if (btnSrcAttributes = btnSrcAttributes.match(/[^\s]+='[^']*'/gi)) {
		for (var i=0; i<btnSrcAttributes.length; i++) {
			var oAttr = btnSrcAttributes[i].match(/([^\s]+)='([^']*)'/i);
			if(oAttr) {
				btnAttributes[oAttr[1]] = oAttr[2];
			}
		}
	}
	this.button = utility.dom.createElement("input", btnAttributes);
	utility.dom.insertAfter(this.button, this.input);

	Calendar.setup(paramObj);
	window[$CAL_GLOBALOBJECT][boundTo] = this;
}

