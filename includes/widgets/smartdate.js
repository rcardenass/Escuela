// Copyright 2001, 2003 InterAKT Online. All rights reserved.
function editDatePre(obj, mask, event) {
	var keyCode = event.keyCode;
	if (keyCode == 0) {
		keyCode=event.charCode;
	}
	
	if(keyCode == 9) {
		return;
	}

	// if the user pressed "." we autocomplete with the current date
	if ((keyCode == 190 || keyCode == 110) && (obj.value.length == 0)) {
		date = new Date();
		y = date.getFullYear();
		m = date.getMonth()+1;
		d = date.getDate();
		if (m<10) m = "0"+m;
		if (d<10) d = "0"+d;

		tmp = mask;
		tmp = tmp.replace(/D+/i, d);
		tmp = tmp.replace(/M+/i, m);
		tmp = tmp.replace(/Y+/i, y);
		obj.value = tmp;
		hndlr_utilStopEvent(event);
		return false;
	}

	var diff = 0;

	if (keyCode == 187 || keyCode == 107 || keyCode == 61) {
		diff = 1;
	} else if (keyCode == 189 || keyCode==109) {
		diff = -1;
	}

	if (diff != 0) {
		var date = getInputDate(obj.value, mask);

		y = date.getFullYear();
		m = date.getMonth()+1;
		d = date.getDate();
		d += diff;

		//compute date at 12:00PM to avoid time saving problems
		date = new Date(y, m-1, d, 12 , 1 ,1);
		y = date.getFullYear();
		m = date.getMonth()+1;
		d = date.getDate();

		//format the all the entries with yyyy mm and dd (4-2-2 digits)
		if (m<10) m = "0"+m;
		if (d<10) d = "0"+d;

		while (y.length < 4) {
			y = "0" + y;
		}

		tmp = mask;
		tmp = tmp.replace(/D+/i, d);
		tmp = tmp.replace(/M+/i, m);
		tmp = tmp.replace(/Y+/i, y);
		if (obj.value != tmp) {
			obj.value = tmp;
		}
		hndlr_utilStopEvent(event);
		return false;
	}
	
	//obj.exValue = obj.value;
	return true;
}

function hndlr_utilStopEvent(ev) {
	if(ev.preventDefault) {
		ev.preventDefault();
		ev.stopPropagation();
	} else {
		ev.cancelBubble = true;
	}
}


function toregexp2(txt) {
	txt = txt.replace(/([-\/\[\]()\*\+])/g, '\\$1');
	txt = txt.replace(/[MDY]/ig, '\\d');
	txt = txt.replace(/\?/g, '.');
	txt = txt.replace(/\./g, '\\\.');
	return txt;
}

function editDateBlur(obj, mask) {
	var flag = true;
	if (obj.value.length != 10 && obj.value.length > 0) {
		date = getInputDate(obj.value.substr(0,10), mask);
		y = date.getFullYear();
		m = date.getMonth()+1;
		d = date.getDate();
		if (m<10) m = "0"+m;
		if (d<10) d = "0"+d;

		tmp = mask;
		tmp = tmp.replace(/D+/i, d);
		tmp = tmp.replace(/M+/i, m);
		tmp = tmp.replace(/Y+/i, y);
		obj.value = tmp;
	}
}

function editDate(obj, mask, event) {
	var keyCode = event.keyCode;
	if (keyCode == 0) {
		keyCode=event.charCode;
	}

	// correct the input size
	var size = obj.value.length;
	if (size > mask.length) {
		obj.value = obj.value.substr(0, mask.length);
		size = obj.value.length;
	}

	// validsate the input value with the masks' regexp
	var re = new RegExp('^' + toregexp2(mask.substr(0, size)) + '$');
	if (!obj.value.match(re)) { 
		if (obj.lastMatched) {
			obj.value = obj.lastMatched;
		} else {
			obj.value = ''; // obj.exValue;
		}
	} else {
		obj.lastMatched = obj.value;
	}

	// re-get the text size
	size = obj.value.length;

	//if we have entered 10 chars that means we have entered a potential date
	//check this date and convert it eventually to a valid date
	if (size == 10) {

		var date = getInputDate(obj.value, mask);

		y = date.getFullYear();
		m = date.getMonth()+1;
		d = date.getDate();

		if (m<10) m = "0"+m;
		if (d<10) d = "0"+d;

		while (y.length < 4) {
			y = "0" + y;
		}

		tmp = mask;
		tmp = tmp.replace(/D+/i, d);
		tmp = tmp.replace(/M+/i, m);
		tmp = tmp.replace(/Y+/i, y);
		if (obj.value != tmp) {
			obj.value = tmp;
		}
	} else {
		if (event.keyCode!=8) {
			completeSmartDate(obj,mask);
		}
	}
}

function getInputDate(value, mask) {
	if(value.length == 0) {
		return new Date();
	}

	var d=0;
	var m=0;
	var y=0;
	if (mask.match(/D+.M+.Y+/i)) {
		d = value.substr(0,2);
		m = value.substr(3,2);
		y = value.substr(6,10);
	} else if (mask.match(/M+.D+.Y+/i)){
		m = value.substr(0,2);
		d = value.substr(3,2);
		y = value.substr(6,10);
	} else if (mask.match(/Y+.M+.D+/i)){
		y = value.substr(0,4);
		m = value.substr(5,2);
		d = value.substr(8,10);
	}

	if (y.length == 2) {
		if (y<50) {
			y = "20" + y;
		} else {
			y = "19" + y;
		}
	}

	m--;

	//compute date at 12:00 PM  to avoid time saving problems
	date = new Date(y, m, d, 12 , 1 ,1);

	return date;
}


/**
	complete the current typing text with the next char from the mask
	@param
		obj - SmartDate DOM Object
		mask - the Mask
	
**/
function completeSmartDate(obj, mask) {
	var size = obj.value.length;
	var sw=true;
	while (sw) {
		if (mask.length<=size) {
			break;
		}
		switch (mask.charAt(size)) {
			case 'M':
			case 'D':
			case 'Y':
				sw = false;
				return;
			default:
				obj.value += mask.charAt(size);
		}
		size++;
	}
	obj.lastMatched = obj.value;
}