<?php
class AjaxService {
	var $object = null;
	var $exportedMethods = null;

	function AjaxService() {
		$this->exportedMethods = array();
	}

	function exportMethod($object, $method) {
		array_push($this->exportedMethods, array(
			'object' => $object, 
			'method' => $method
		));
	}

	function exportFunction($method) {
		array_push($this->exportedMethods, array(
			'object' => null, 
			'method' => $method
		));
	}

	function renderJavascriptStubs() {
		$toret = '
			<script type="text/javascript">' . "\n" ;
            $toret .= '<!--' . "\n";
        if (!isset($GLOBALS['stub_loader'])) {
            $toret .= '
				var StubFilesLoaded = false;
				function loadStubFiles(callback, args) {
					var StubJSLoader = new Kore.JSLoader();
					StubJSLoader.addFile("includes/yui/yahoo/yahoo.js");
					StubJSLoader.addFile("includes/yui/event/event.js");
					StubJSLoader.addFile("includes/yui/connection/connection.js");
					StubJSLoader.addFile("includes/kore/js/error.js");
					StubJSLoader.addFile("includes/kore/js/dataprovider/transporter.js");
					StubJSLoader.addFile("includes/kore/js/dataprovider/dataprovider.js");
					StubJSLoader.addFile("includes/kore/js/dataprovider/jsonprovider.js");
					StubJSLoader.loadFiles(function() {
						StubFilesLoaded = true;
						callback.apply(null, args);
					});
				}';
            $GLOBALS['stub_loader'] = true;
        }
		foreach ($this->exportedMethods as $m) {
			$obj_prefix1 = '';
			$obj_prefix2 = '';
			if ($m['object']) {
				$obj_prefix1 = $m['object']. '_';
				$obj_prefix2 = $m['object'];
			}
			$toret .= '
				'. $obj_prefix1 . $m['method'] . ' = function() {
					if(!StubFilesLoaded) { loadStubFiles('. $obj_prefix1 . $m['method'] . ', arguments);return;};
					var params = arguments;
					var functor = params[params.length-1];
					var postOptions;
					var hash = {
						"AjaxServiceCall": "true", 
						"ServiceObject" : "' . $obj_prefix2 . '", 
						"ServiceMethod" : "' . $m['method'] . '"
					};
					for (var i = 0; i < params.length-1; i++) {
						var sPar = params[i];
						if((typeof params[i] == "string") && /^\{[^\}]+\}$/.test(params[i])){
							try {
								eval("var tmpObj = " + params[i]);
								Object.extend(hash, tmpObj);
							} catch(e) {};
						} else {
							if (params[i].toString() == "POST-DATA") {
								postOptions = {method: "POST", postData: params[i+1]};
								break;	
							}
							else {
								hash["params_"+i] = params[i];	
							}
						};
					}
					var url; 
					';
		if (isset($GLOBALS["stub_context"])) {
			// this file is included as the opened region in a widget			
			$toret .= 'url = "'. KT_addReplaceParam($GLOBALS["stub_context"], "KT_ajax_request", "true") . '";
					';
		} else {	
			if(KT_is_ajax_request()) {
				// this page is called from a widget to output content for a region
				$toret .= 'url = "'. KT_getFullUri() . '";
				';
			}
			else {
				$toret .= '
					var L = window.location;
					url = L.protocol + "//" + L.host + L.pathname + L.search;
					if(typeof window.$ctrl != "undefined") {
                        // on a master page
						var hashParams = window.location.hash.replace(/^#/, "");
						if(hashParams){ 
						    url = window.$app_path + "?" + hashParams;
                        }
                        
                        ';
                if (isset($GLOBALS['me'])) {
					$toret .= '
                            var currentPanel = "' . $GLOBALS['me']->id . '";
                            url = url.replace(/[^\?&]*__state=[^&]*/i, "");
						    if ( !(new RegExp(currentPanel + "__state=","i").test(hashParams)) ) {
                                    url += (/\?/.test(url)? "&" : "?");
						            url += currentPanel + "__state=' . $GLOBALS['me']->currentState . '";
						    }
                            url = url.replace(/\?&/i, "?");
                            ';
                }
                    $toret .= '
					}
					url += (/\?/.test(url)? "&" : "?");
					url += "KT_ajax_request=true";
					';
				}	
		} 
				
				$toret .= '
					var _querry = $H(hash).toQueryString();
					if(_querry){
						url += (/\?/.test(url)? "&" : "?");
					}
					url += _querry;
					var provider;
					if (typeof postOptions == "undefined") {
					   	provider = new Kore.JsonProvider(url);
					} else {
						provider = new Kore.JsonProvider(url, postOptions);
					}
					provider.updateEvent.subscribe(functor, provider, true);
					provider.getContent();
				}';
        }
		$toret .= '
            //-->
			</script>
		';
		return $toret;
	}


	function handleAjaxRequest() {
		if (isset($_GET['AjaxServiceCall'])) {
			$this->checkServiceCall();

			//get object / method from variables
			$object = $_GET['ServiceObject'];
			if ($object == '') {
				$object = null;
			}
			$method = $_GET['ServiceMethod'];

			$params = array();
			foreach($_GET as $k => $v) {
			           if (preg_match("/^params_\d{1,2}$/", $k)) {
			              array_push($params, KT_getRealValue("GET", $k));
			           }
			}
			foreach($_POST as $k => $v) {
	              array_push($params, KT_getRealValue("POST", $k));
			}
			
			$params = array_values($params);

			$m = $this->findServiceCall($object, $method);
			if ($m['object']) {
				$toret = call_user_func_array(array(&$GLOBALS[$m['object']], $m['method']), $params);
			} else {
				$toret = call_user_func_array($m['method'], $params);
			}
			
			// do not cache AJAX Requests
			$seconds_expire  = -86400; //one day ago
            KT_sendExpireHeader($seconds_expire);

			$isOpera = false;
			if (isset($_SERVER) && isset($_SERVER['HTTP_USER_AGENT'])) {
				if (stristr($_SERVER['HTTP_USER_AGENT'], 'opera/9.')) {
					$isOpera = true;
				}
			}
            if (isset($_SERVER['HTTP_KT_CHARSET'])) {
                header('Content-Type: text/' . (!$isOpera ? 'jaxon' : 'plain') . '; charset='.$_SERVER['HTTP_KT_CHARSET']);
            } else {
                header('Content-Type: text/' . (!$isOpera ? 'jaxon' : 'plain') . '');
            }
			echo KT_json($toret);
			die();
		}
	}
	
	function checkServiceCall() {
		if (isset($_GET['AjaxServiceCall'])) {
			$param_errors = array();
			$object = null; $method = null;

			if (!isset($_GET['ServiceObject'])) {
				array_push($param_errors, 'Missing object definition!');
			} else {
				$object = $_GET['ServiceObject'];
				if ($object == '') {
					$object = null;
				}
			}

			if (!isset($_GET['ServiceMethod'])) {
				array_push($param_errors, 'Missing method definition!');
			} else {
				$method = $_GET['ServiceMethod'];
			}

			if (!$this->findServiceCall($object, $method)) {
				array_push($param_errors, 'The object / method pair is not defined in this page for object: '.$object.', method: '.$method.'!');
			}

			if (count($param_errors) > 0) {
				ServiceUtils::showMissingAjaxServiceParamsError($param_errors);
			}
		}
	}

	/*
	 * Make sure that only exported methods or functions are called via ajax service.
	 * */
	function findServiceCall($object, $method) {
		$service_found = false;
		foreach ($this->exportedMethods as $m) {
			if ( ($m['object'] == null || $m['object'] == $object) && $m['method'] == $method) {
				if ($m['object'] != null && !isset($GLOBALS[$m['object']])) {
					break;
				}
				$service_found = $m;
				break;
			}
		}
		return $service_found;
	}	
}
?>
