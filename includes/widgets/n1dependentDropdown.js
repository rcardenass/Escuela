// Copyright 2001, 2003 InterAKT Online. All rights reserved.
var n1ddAll = new Array();
function ddAddEvent(oldHandler,newHandler) {
	var me = function () {
		newHandler();
		if (oldHandler) {
			oldHandler();
		}
	}
	return me;
}
window.onload = ddAddEvent(window.onload,n1updateMenus);
		
function registerN1Menu(detailList, boundTo) {
	var detailListO = document.getElementById(detailList);
	detailListO.boundTo = boundTo;
	n1ddAll[detailList] = 1;
}

function n1updateMenu(detailList, defaultValue, boundTo) {
	if (!detailList || !boundTo) {
		detailList = this.detailList;
		boundTo = this.name;
	}
	
	var detailListO = document.getElementById(detailList);
	var boundToO = document.getElementById(boundTo);
//	detailListO.boundTo = boundTo;
//	boundToO.detailList = detailList;

	var ddfks = eval('ddfks_' + detailList);
	var ddnames = eval('ddnames_' + detailList);

	if (defaultValue) {
		for (i=0;i<boundToO.options.length;i++) {
			if (boundToO.options[i].value == ddfks[defaultValue]) {
				boundToO.selectedIndex = i;
				break;
			}
		}
	}

	var n1sel = ddfks[boundToO.options[boundToO.selectedIndex].value];
	detailListO.value=ddnames[n1sel];
}

function n1updateMenus() {
	for(i in n1ddAll) {
		//also set detail lists for elements as now they are initialized
		var detailO = document.getElementById(i);
		var boundTo = detailO.boundTo;
		var boundToO = document.getElementById(boundTo);
		
		boundToO.onchange = n1updateMenu;
		boundToO.detailList = i;
		
		var dddefval = eval('dddefval_' + i);
		n1updateMenu(i, dddefval, boundTo);
	}	
}
