// Copyright 2001, 2003 InterAKT Online. All rights reserved.
function editMaskPre(obj, mask, evt) {
	if(obj.value.length == 0 && evt.keyCode != 8 && evt.keyCode != 0 && evt.keyCode!= 9) {
		var str = obj.value;
		obj.value = '';
		completeMask(obj, mask);
		obj.value+=str;
	}
}

function toregexp(txt) {
	txt = txt.replace(/([-\/\[\]()\*\+])/g, '\\$1');
	txt = txt.replace(/N/g, '\\d');
	txt = txt.replace(/\?/g, '.');
	txt = txt.replace(/A/g, '\\w');
	txt = txt.replace(/C/g, '[A-Za-z]');
	return txt;
}

function editMask(obj, mask, evt) {
	var tmVal = getFirstMatch(obj.value, mask);
	if (obj.value != tmVal) {
		obj.value = tmVal;
	}
	if(evt.keyCode != 8 && obj.value.length != 0) { // backspace and tab
		completeMask(obj, mask);
	}
}

function getFirstMatch(value, mask) {
	var size = value.length;
	if(size == 0) {
		return "";
	}
	var re = new RegExp('^' + toregexp(mask.substr(0, size)) + '$');
	if (!value.match(re)) { 
		return getFirstMatch(value.substr(0, size-1), mask);
	} else {
		return value;
	}
}


function completeMask(obj, mask) {
	var size = obj.value.length;
	var sw=true;
	while (sw) {
		if (mask.length<=size) {
			break;
		}
		switch (mask.charAt(size)) {
			case 'N':
			case 'A':
			case 'C':
			case '?':
				sw = false;
				return;
			default:
				obj.value += mask.charAt(size);
		}
		size++;
	}
	obj.lastMatched = obj.value;
	return;
}





