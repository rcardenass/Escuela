function show_as_buttons_func() {
	var toret = false;
	if (!(typeof $NXT_LIST_SETTINGS == 'undefined' || typeof $NXT_LIST_SETTINGS['show_as_buttons'] == 'undefined' || $NXT_LIST_SETTINGS['show_as_buttons'] == false)) {
		toret = true;
	}
 	if (!(typeof $NAV_SETTINGS == 'undefined' || typeof $NAV_SETTINGS['show_as_buttons'] == 'undefined' || $NAV_SETTINGS['show_as_buttons'] == false)) {
		toret = true;
	}
	return toret;
}
show_as_buttons = "show_as_buttons_func()";
not_show_as_buttons = "!" + show_as_buttons;
/*
 * transforms a link to a button, keeping the link inner text, and adding the onclick event
 */
function KT_style_replace_with_button(el, add_event) {
	if (typeof add_event == 'undefined') {
		add_event = false;
	}
	var elnou = utility.dom.createElement('input', {
		'type' : 'button', 
		'value': el.innerHTML
	});

	el.style.display = 'none';
	elnou = utility.dom.insertAfter(elnou, el);

	if (add_event) {
		var onclick = el.onclick;
		elnou.onclick = onclick;
	}

	elnou.style.visibility = el.style.visibility;
	if (el.innerHTML == '') {
		elnou.style.display = 'none';
	}

	return elnou;
}

function KT_style_modify_custom_links(el) {
    var classes = utility.dom.getClassNames(el);
    if (1
    &&  Array_indexOf(classes, 'KT_link') < 0
    ) {
        return;
    }

    var elnou = KT_style_replace_with_button(el);
    /*utility.dom.attachEvent(*/elnou.onclick = function(e) {
        var a = this.previousSibling;
        if (!a.onclick) {
            var act = utility.dom.getLink(a);
            var parts = act.toString().split('?');
            if (parts.length == 1) {
                parts[1] = '';
            }
            var qs = new QueryString(parts[1]); var action_url = parts[0], variables = [];
            Array_each(qs.keys, function(key, i) {
                Array_push(variables, [key, qs.values[i]]);
            });

            var frm = utility.dom.createElement(
                "FORM", 
                {'action': act, 'method': 'GET', 'style': "display: none"}
            );
            Array_each(variables, function(input, i){
                frm.appendChild(utility.dom.createElement('INPUT', {'type': 'hidden', 'id': input[0], 'name': input[0], 'value': input[1]}));
            });

            frm = document.body.appendChild(frm);
            frm.submit();
        } else {
            var to_exec = a.onclick;
            a.onclick();
        }
    };/*);*/
    //elnou.className = 'button_big';
}
/*
 * this array holds the transformations for the list / form elements
 * each array item is an object with tthe following properties:
 * 	* selector : the string passwd to utility.dom.getElementsBySelector
 * 	* transform : transformation function whichch has a single parameter : the element to handle
 * 	* eval : condition which tells if the transformation is executed
 */
$TRANSFORMATIONS = [
	{
		'selector': 'div.KT_tnglist div.KT_bottombuttons a.KT_edit_op_link', 
		'transform': function(el) { 
			var elnou = KT_style_replace_with_button(el, true);
		}, 
		'eval': show_as_buttons
	}, 
	{
		'selector': 'div.KT_tnglist div.KT_bottombuttons a.KT_delete_op_link', 
		'transform': function(el) {
			KT_style_replace_with_button(el, true);
		}, 
		'eval': show_as_buttons
	}, 
	{
		'selector': 'div.KT_tnglist div.KT_bottombuttons a.KT_additem_op_link', 
		'transform': function(el) {
			KT_style_replace_with_button(el, true);
		}, 
		'eval': show_as_buttons
	}, 
	{
		'selector': 'div.KT_tnglist div.KT_topbuttons a.KT_edit_op_link', 
		'transform': function(el) { 
			KT_style_replace_with_button(el, true);
		}, 
		'eval': show_as_buttons
	}, 
	{
		'selector': 'div.KT_tnglist div.KT_topbuttons a.KT_delete_op_link', 
		'transform': function(el) {
			KT_style_replace_with_button(el, true);
		}, 
		'eval': show_as_buttons
	}, 
	{
		'selector': 'div.KT_tnglist div.KT_topbuttons a.KT_additem_op_link', 
		'transform': function(el) {
			KT_style_replace_with_button(el, true);
		}, 
		'eval': show_as_buttons
	}, 
	{
		'selector': 'div.KT_tnglist th.KT_sorter a.KT_move_op_link', 
		'transform': function(el) {
			var elnou = KT_style_replace_with_button(el, true);
			elnou.style.display = 'none';
		}, 
		'eval': show_as_buttons
	}, 
	{
		'selector' : 'div.KT_tnglist table.KT_tngtable tr td a', 
		'transform': function(el) {
			var classes = utility.dom.getClassNames(el);
			if (Array_indexOf(classes, 'KT_edit_link') < 0
			&&  Array_indexOf(classes, 'KT_moveup_link') < 0
			&&  Array_indexOf(classes, 'KT_movedown_link') < 0
			&&  Array_indexOf(classes, 'KT_delete_link') < 0
			&&  Array_indexOf(classes, 'KT_link') < 0
			) {
				return;
			}

			var elnou = KT_style_replace_with_button(el);
			elnou.onclick = function(e) {
				var a = this.previousSibling;
				if (Array_indexOf(['KT_movedown_link', 'KT_moveup_link', 'KT_delete_link'], a.className) >= 0) {
					var to_exec = a.onclick;
					try {
						a.onclick(e);
					} catch(e) { }
				} else if (Array_indexOf(['KT_link'], a.className) >= 0) {
					if (!a.onclick) {
						var act = utility.dom.getLink(a);
						var parts = act.toString().split('?');
						if (parts.length == 1) {
							parts[1] = '';
						}
						var qs = new QueryString(parts[1]); var action_url = parts[0], variables = [];
						Array_each(qs.keys, function(key, i) {
							Array_push(variables, [key, qs.values[i]]);
						});

						var frm = utility.dom.createElement(
							"FORM", 
							{'action': act, 'method': 'GET', 'style': "display: none"}
						);
						Array_each(variables, function(input, i){
							frm.appendChild(utility.dom.createElement('INPUT', {'type': 'hidden', 'id': input[0], 'name': input[0], 'value': input[1]}));
						});

						frm = document.body.appendChild(frm);
						frm.submit();
					} else {
						var to_exec = a.onclick;
						a.onclick();
					}
				} else if (Array_indexOf(['KT_edit_link'], a.className) >= 0) {
					try {
						var o = utility.dom.setEventVars(e);
						var table = utility.dom.getParentByTagName(this, 'table');
						var row = utility.dom.getParentByTagName(this, 'tr');

						var tmp = utility.dom.getElementsByClassName(row, 'id_checkbox')[0];
						var myinput = null;
						if (tmp.type && tmp.type.toLowerCase() == 'checkbox' && tmp.name.toString().match(/^kt_pk/)) {
							myinput = tmp;
						}

						var inputs = utility.dom.getElementsByClassName(table, 'id_checkbox');
						Array_each(inputs, function(input) {
							if (input.type && input.type.toLowerCase() == 'checkbox' && 
								input.name.toString().match(/^kt_pk/)) {
								input.checked = (input == myinput);
							}
						});
						nxt_list_edit_link_form(this);
					} catch(e) {
						window.location.href = a.href;
					}					
				} else {
					window.location.href = a.href;
				}
			};/*);*/
			var move_up = Array_indexOf(classes, 'KT_moveup_link') >= 0;
			var move_down = Array_indexOf(classes, 'KT_movedown_link') >= 0;
			if (move_up || move_down) {
				if (move_up && typeof $nxt_move_up_background_image != 'undefined' || move_down && typeof $nxt_move_down_background_image != 'undefined') {
					elnou.value = "";
				}
				elnou.className = 'button_smallest KT_button_move_' + (move_up?'up':'down');
			} else {
				elnou.className = 'button_big';
			}

		}, 
		'eval': show_as_buttons
	},
	{
		'selector' : 'div.KT_tng div.KT_bottombuttons a', 
		'transform': KT_style_modify_custom_links, 
		'eval': show_as_buttons
	}, 
	{
		'selector' : 'div.KT_tng div.KT_topbuttons a', 
		'transform': KT_style_modify_custom_links, 
		'eval': show_as_buttons
	}, 
	{
		'selector' : 'div.KT_textnav ul li a', 
		'transform' : function(el) {
			var li = utility.dom.getParentByTagName(el, 'li');
			if (! (Array_indexOf(['first', 'prev', 'next', 'last'], li.className) >= 0)) {
				return;
			}
			var elnou = KT_style_replace_with_button(el);
			if (!el.href.match(/void\(0\)/)) {
				elnou.onclick = function(e) {
					window.location.href = el.href;
				};
			} else {
				//utility.dom.classNameAdd(el.parentNode, 'disabled');
				var inp = el.parentNode.getElementsByTagName('input');
				if (inp.length > 0) {
					inp[0].disabled = true;
				}
			}
			var values = {'first': '<<', 'prev': '<', 'next': '>', 'last': '>>'};
			elnou.value = values[li.className.toString().replace(/ disabled/, '')];
			elnou.className = 'button_smallest' + (el.href.match(/void\(0\)/) ? ' disabled' : '');
		}, 
		'eval': show_as_buttons
	}, 
	{
		'selector' : 'div.KT_textnav ul li a', 
		'transform' : function(el) {
			if (!el.href.match(/void\(0\)/)) {
			} else {
				utility.dom.classNameAdd(el, 'disabled');
			}
		}, 
		'eval': not_show_as_buttons
	}, 
	{
		'selector': 'div#KT_tngdeverror a', 
		'transform': function(el) { 
			var elnou = KT_style_replace_with_button(el, true);
		}, 
		'eval': show_as_buttons
	}, 
	{
		'selector': 'div#KT_tngtrace a', 
		'transform': function(el) { 
			var elnou = KT_style_replace_with_button(el, true);
		}, 
		'eval': show_as_buttons
	}, 
	{
		'selector' : 'div.KT_tnglist table.KT_tngtable tr.KT_row_filter input[type="submit"]', 
		'transform': function(el) {
			el.className = 'KT_row_filter_submit_button';
		}, 
		'eval': "1"
	}, 
	{
		'selector' : 'div.KT_tng input[type="text"]', 
		'transform': function(el) {
			utility.dom.classNameAdd(el, 'input_text');
		}, 
		'eval': "1"
	}, 
	{
		'selector' : 'div.KT_tng input[type="widget"]', 
		'transform': function(el) {
			utility.dom.classNameAdd(el, 'input_text');
		}, 
		'eval': "1"
	}, 
	{
		'selector' : 'div.KT_tng input[type="password"]', 
		'transform': function(el) {
			utility.dom.classNameAdd(el, 'input_text');
		}, 
		'eval': "1"
	}, 
	{
		'selector' : 'div.KT_textnav ul li a.disabled input', 
		'transform': function(el) {
			el.disabled = true;
		}, 
		'eval': "1"
	}, 
	{
		'selector' : 'div.KT_tngform', 
		'transform' : function(el) {

			if (typeof window['ktmls'] != 'undefined' && is.mozilla && typeof(ktml_isElementVisible) == 'undefined') {
				return;
			}
			var tbl = document.createElement('table', {
				'className' : 'KT_tngtable'
			});
			tbl.className = 'KT_tngtable';
			
			multiple_edits = false;
			var tables = utility.dom.getElementsBySelector('div.KT_tngform table.KT_tngtable');
			if (tables.length && tables.length > 1) {
				multiple_edits = true;
			}
			if (tables.length == 1 || (typeof $NXT_FORM_SETTINGS['show_as_grid'] == 'undefined' || $NXT_FORM_SETTINGS['show_as_grid'] == false )) {
				return true;
			}
			multiple_edits = true;
			var num_of_columns = tables[0].rows.length;

			//el.appendChild(tbl);
			//	STEP n-3 : create the header table
			var row_head = tbl.insertRow(-1);
			var cell_head = row_head.insertCell(-1);
			cell_head.innerHTML = NXT_Messages['Record_FH'];
			cell_head.className = 'KT_th';
			Array_each(tables[0].rows, function(row) {
				var label = row.getElementsByTagName('label')[0];

				var cell_head = row_head.insertCell(-1);
				cell_head.className = 'KT_th';
				if (label) {
					cell_head.appendChild(label);
				} else {
					cell_head.innerHTML = row.getElementsByTagName('td')[0].innerHTML;
				}
			})


			//	STEP n-2 : create the new table and hide it
			var hidden_ids = utility.dom.getElementsByClassName(el, 'id_field');
			var hidden_ids_index = 0;
			Array_each(tables, function(table_to_copy, index) {
				var row_content = tbl.insertRow(-1);
				
				var cell_record_no = row_content.insertCell(-1);
				cell_record_no.innerHTML = (index+1)+'';
				cell_record_no.noWrap = true;
				cell_record_no.style.verticalAlign = "top";

				Array_each(table_to_copy.rows, function(row) {
					//var cell_content = row_content.insertCell(-1);
					//cell_content.innerHTML = row.getElementsByTagName('td')[1].innerHTML;
					var td = row_content.appendChild(row.getElementsByTagName('td')[1]);//.cloneNode(true)
					td.style.verticalAlign = "top";
					var hint = utility.dom.getElementsByClassName(td, 'KT_field_hint', 'span');
					if (hint.length) {
						for (var i = 0; i < hint.length; i++) {
							hint[i].parentNode.removeChild(hint[i]);
						}
					}
				})

				var hidden = hidden_ids[hidden_ids_index++];
				/*
				while (hidden && (hidden.nodeType == 3 || hidden.tagName.toLowerCase() != 'input')) {
					hidden = hidden.nextSibling;
				}
				*/
				if (hidden) {
					cell_record_no.appendChild(hidden);
				} else {
					alert('could not find hidden !');
				}

			})

			// STEP n-1 : delete the old tables 
			Array_each(tables, function(table_to_copy, index) {
				//remove previous h2
				var heading = table_to_copy.previousSibling;
				try {
					while (heading.previousSibling && (heading.nodeType == 3 ||  heading.tagName.toLowerCase() != 'h2')) {
						heading = heading.previousSibling;
					}
				} catch(e) { heading = null; } 
				if (heading) {
					heading.parentNode.removeChild(heading);
				}

				//remove next input
				var hidden = table_to_copy.nextSibling;
				try {
					while (hidden && hidden.nodeType != 3 && hidden.tagName.toLowerCase() != 'input') {
						hidden = hidden.nextSibling;
					}
				} catch(e) { hidden = null; }
				if (hidden) {
					hidden.parentNode.removeChild(hidden);
				}
				table_to_copy.parentNode.removeChild(table_to_copy);
			})

			//	STEP 4 : find the bottombuttons div, and add the element
			var bottom_buttons = utility.dom.getElementsBySelector('div.KT_bottombuttons')[0];
			bottom_buttons.parentNode.insertBefore(tbl, bottom_buttons);
		}, 
		'eval': '(true)'
	}
];

utility.dom.attachEvent2(window, 'onload', function(e) {
	if (is.ie && is.mac) {
		return;
	}
	if (typeof KT_style_executed == 'undefined' || KT_style_executed == false) {
		Array_each($TRANSFORMATIONS, function(t) {
			if (eval(t['eval'])) {
				var arr = utility.dom.getElementsBySelector(t['selector']);
				Array_each(arr, t['transform']);
			}
		});
		KT_style_executed = true;
	}
	$style_executed = true;
});
