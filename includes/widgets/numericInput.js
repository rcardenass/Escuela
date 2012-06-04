// Copyright 2001, 2003 InterAKT Online. All rights reserved.
function numericInput(obj, evt, negative, afloat) {
	var rx = "^";
	if(negative == "true") {
		rx += "-?";
	}
	rx += "[0-9]*";
	if(afloat == "true") {
		rx += "\\.?[0-9]*";
	}
	rx += "$";
	KT_num_rx = new RegExp(rx);
	
	// full regexp - /^-?[0-9]*\.?[0-9]*$/
	if (!obj.value.match(KT_num_rx)) {
		if (obj.lastMatched) {
			obj.value = obj.lastMatched;
		} else {
			obj.value = "";
	}
	} else {
		obj.lastMatched = obj.value;
	}

}
