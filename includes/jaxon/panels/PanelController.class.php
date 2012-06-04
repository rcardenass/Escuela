<?php

class PanelController {
	/**
	 * list of panels
	 * @var array $panels
	 * @access private
	 */
	 var $panels = array();

	/**
	 * list of layout changers
	 * @var array $layout_changers
	 * @access private
	 */
	var $layout_changers = array();
	
	
	/**
	 * list trigger panels with associated lister panels
	 * @var array $triggers
	 * @access private
	 */
	var $triggers = array();

	/**
	 * the master panel id
	 * @var string $masterPanel
	 * @access private
	 */
	var $masterPanel = null;

	/**
	* binding data to render
	* @var array
	* @access private
	*/
	var $afterLoad_JsActions = array();

	/**
	 * list of panel parameters TO BE UNSET used for stuff like link(), etc
	 * @var Array $params
	 * @access private
	 */
	var $params = array();
	
	/**
	 * interpolated panel title
	 * @var string $title
	 * @access private
	 */
	var $title = '';

	/**
	 * interpolated panel description
	 * @var string $description
	 * @access private
	 */
	var $description = '';

	/**
	 * interpolated panel keywords
	 * @var string $keywords
	 * @access private
	 */
	var $keywords = '';

	/**
	 * interpolated panel title
	 * @var string $currentPage
	 * @access private
	 */
	var $currentPage;
	
	/*
	 * Remembers the last link ID so we can push it in the afterLoad_JsActions array when displayed, and then use it in the tooltip if any.
	 * @var string 
	 * @access private
	 */
	var $lastLinkId = '';

	/**
	 * Constructor
	 * @return null
	 */
	function PanelController(){
		$this->currentPage = basename(KT_getPHP_SELF());
	}

	/**
	 * calls panel states, panel params
	 * @return null
	 */

	function init(){
		$this->initPanelStates();
		ob_start();
	}
	/**
	 * initializes the states for all the panels
	 * init uses both "__state" GET params and layout changers rules
	 * @return null
	 */
	function initPanelStates() {
		// for all panel ids, check if a state is passed as URL parameter
		// find the panels in this page
		foreach ($this->panels as $panelId => $notused) {
			$panelObj = & $this->panels[$panelId];
			$panelObj->updateStateFromURL();
		}
		$has_no_panels = true;
		foreach ($this->panels as $panelId => $notused) {
			$panelObj = & $this->panels[$panelId];
			if ($panelObj->stateFromUrl) {
				$has_no_panels = false;
				break;
			}
		}
		
		
		if ($has_no_panels) {
			$this->panels[$this->masterPanel]->stateFromUrl = true;
		}
		
		$GLOBALS['panels_from_lc'] = array();
		// run layout changers for each trigger panel
		foreach ($this->triggers as $panelId => $notused) {
			$this->runLayoutChangers($panelId);
		}
	}
    
	/**
	 * runs layout changers for a trigger panel
	 * adds listener panels to $GLOBALS['panels_from_lc'] to be sent in the current request
	 * sets the corresponding states for listener panels
	 * @return null
	 */
	function runLayoutChangers($panelId) {
		// check if the cuthis is a trigger
		$triggerPanel = & $this->panels[$panelId];
		if ($triggerPanel->stateFromUrl) {
			// adds listeners to GLOBALS['panels_from_lc'] if the trigger state is set from url ( the current trigger panel has been ajax requested)
			foreach($this->triggers[$panelId] as $listenerId => $notused) {
				if (!in_array($listenerId, $GLOBALS['panels_from_lc'])){
					$GLOBALS['panels_from_lc'][] = $listenerId;
				}
			}
		}
		// update the states for listeners, using the layout changers rules
		$currentTriggerState = $triggerPanel->currentState;
		if (isset($this->layout_changers[$panelId][$currentTriggerState])) {
			foreach($this->layout_changers[$panelId][$currentTriggerState] as $listenerId => $listenerState) {
				$listenerPanel = & $this->panels[$listenerId];
				//if (!$listenerPanel->stateFromUrl) {
					$listenerPanel->setCurrentState($listenerState);
					$listenerPanel->stateFromLayoutChanger = true;
				//}
			}
		}
	}

	/**
	 * sets the master panel for this master page
	 * @param string @panelId
	 * @return null
	 */
	function setMasterPanel($panelId) {
        if (!isset($panelId) || $panelId === "") {
            if (isset($this->panels) && count($this->panels) == 1) {
                $panel_names = array_keys($this->panels);
                $this->masterPanel = $panel_names[0];
                return;
            } else {
                die ("Error setting main panel. You must set one panel as the Main Panel for this page.");
            }
            
        }
		$this->masterPanel = $panelId;
	}

	/**
	 * the master panel for this master page
	 * @return string panel id
	 */
	function getMasterPanel() {
		return $this->masterPanel;
	}

	/**
	 * Panel factory, adds the panel to this controller and returns the panel instance
	 * @param string $panelId
	 * @return Panel instance
	 */
	function & createPanel ($panelId) {
		if(empty($this->panels[$panelId])){
			$newPanel = new Panel($panelId);
			$this->panels[$panelId] = & $newPanel;
		} else {
			die('Error creating panel. You already have a panel called "'.$panelId.'".');
		}
		return $newPanel;
	}

	/**
	 * returns a panel, based on its panel id 
	 * @param string $panelId
	 * @return Panel instance
	 */
	function & getPanel($panelId){
		return $this->panels[$panelId];
	}

	/**
	 * Compiles and saves an unique link to be used
	 * @param none
	 * @return String new link id
	 */
	function link_id() {
		$this->lastLinkId = uniqid('link__');
		return $this->lastLinkId;
	}

	/**
	 * creates a dynamic link
	 * @param string $panelId
	 * @param string $state
	 * @return string panel url, with the necessary parameters
	 */
	function link($panelId, $state) {
		$ret = $this->compileLink($panelId, $state);
		if (isset($GLOBALS['me'])) {
			$this_panel = ($GLOBALS['me'] !== null ? $GLOBALS['me']->id : '');
		} else {
			$this_panel = '';
		}
		$GLOBALS['ctrl']->addJsInstantiation("new PanelLink('".$this->lastLinkId."', {'panel': '".$this_panel."'})");
		// reset the params used for the current link
		$this->params = array();
        $toret = $ret;
        $toret = str_replace("&amp;", "&", $toret);
		return str_replace("&", "&amp;", $toret);
	}

	/**
	 * used to set properties for all the link variants
	 * @param string $panelId
	 * @param string $state
	 * @return string panel url, with the necessary parameters
	 */
	function compileLink($panelId, $state) {
		$linkParams = $this->params;
		
		# optimize state for panel with only one state
		$newParams = $this->getNewLinkParams($panelId, $state, $linkParams);

		$uri = $this->currentPage;
		if (sizeof($newParams) > 0){
			$uri .= '?';
			foreach ($newParams as $name => $value) {
				$uri .= '&';
				$uri .= urlencode($name) . '=' . urlencode($value);
			}

			$uri = str_replace('?&', '?', $uri);
		}
		return $uri;
	}
	
	
	/**
	 * Compiles link parameters, adding existing non-default states to the parameters array 
	 * @param $panelId the targeted panel
	 * @param $state the targeted panels' state
	 * @param $now_params the parameters that were specified
	 * @return array of merged parameters
	 */
	function getNewLinkParams($panelId, $state, $now_params) {
		// get the state params, only for panels which are not default
		$new_params = array();
		foreach ($this->panels as $p => $notused) {
			$po = & $this->panels[$p];
			if ("" !== $po->currentState && $p != $panelId) {
				# must be added, only if the panel is not the one we are creating the link for 
				# ( we take care of this later) AND the panel has more than one state
				if (!isset($this->triggers[$panelId][$p])) {
					$new_params[$p.'__state'] = $po->currentState;
				}
			}
		}
		# add the state ONLY if the panel has more than one, otherwise the default state will be served
		if (!empty($this->panels[$panelId]) && count($this->panels[$panelId]->states) != 1) {
			$new_params[$panelId.'__state'] = $state;
		}
		# add the now params, overriding existent params

		$new_params = array_merge($now_params, $new_params);
		return $new_params;
	}

	function tooltip($panelId, $state, $width = '', $height = '') {
		$ret = $this->getSerializedJSParams();
		$GLOBALS['ctrl']->addJsInstantiation("new PanelTooltip('".$this->lastLinkId."', '".$panelId."', '".$state."', ". $ret. ", {'width':'". $width ."', 'height':'" . $height ."'})");
		array_push($GLOBALS['me']->lateHtml, '<div id="'.$this->lastLinkId.'_tooltip" class="panel_tooltip"><div class="top" id="'.$this->lastLinkId.'_inner">Loading...</div><b class="bottom"></b></div>');
	}
	
	/**
	 * create the list of GET parameters
	 */
	function getSerializedJSParams(){
		$toret_arr = array();
		foreach ($this->params as $name => $value) {	
			if (false === strpos($name, '__state') || !preg_match("/^(.*)__state$/", $name, $m)) {
				array_push($toret_arr, '{"name": "'.KT_escapeJS($name).'", "value": "'.KT_escapeJS($value).'"}');
			}
		}
		return '[' . implode(", ", $toret_arr) . ']';
	}
	
	/**
	 * set a param value
	 * @param string $
	 * @param string $value
	 * @return null
	 */
	function setParamValue($key, $value=null) {
		$this->params[$key] = $value;
	}

	
	/**
	 * sets the title, meta description and keywords
	 * @param string $title
	 * @param string $description
	 * @param string $keywords
	 * @return null
	 */
	function setMetaInfo($title, $description, $keywords) {
		$this->title = KT_DynamicData($title, null, null, false, array(), false);
		$this->description = KT_DynamicData($description, null, null, false, array(), false);
		$this->keywords = KT_DynamicData($keywords, null, null, false, array(), false);
	}
	/**
	 * returns the current application title, from the master panel
	 * 
	 */
	function getTitle() {
		return $this->title;
	}

	/**
	 * returns the current application description, from the master panel
	 * 
	 */
	function getDescription(){
		return $this->description;
	}

	/**
	 * returns the current application keywords, from the master panel
	 * 
	 */
	function getKeywords(){
		return $this->keywords;
	}

	/**
	 * used only for main page, and needed for redirects
	 * @return null
	 */
	function end() {
		$content = ob_get_contents();
		ob_end_clean();
		// Update the page title, meta description & keywords
		$content = str_replace('{{TITLE}}', $this->getTitle(), $content);
		$content = str_replace('{{META_DESCRIPTION}}', $this->getDescription(), $content);
		$content = str_replace('{{META_KEYWORDS}}', $this->getKeywords(), $content);
        
        
		// move all <link> and <style> above body tag due to validation issues.
		preg_match("/<body[^>]*>.*?<\/body>/ims", $content, $m);
		if (!empty($m)) {
            $body = $m[0];
           
            preg_match_all("/<link[^>]*?>/i", $body, $styles);
            if (sizeof($styles) == 1) {
                $styles = $styles[0];
                $styles = implode("\n", $styles);
            }
            
            preg_match_all("/<style[^>]*>.*?<\/style>/ims", $body, $inline_styles);
            if (sizeof($inline_styles) == 1) {
                $inline_styles = $inline_styles[0];
                $inline_styles = implode("\n", $inline_styles);
            }
           
            $body = preg_replace("/<link[^>]*?>/i", "", $body);
            $body = preg_replace("/<style[^>]*>.*?<\/style>/ims", "", $body);
            
            $before_body = preg_replace("/<body.*$/ims", "", $content);
            $before_body = preg_replace("/<\/head>/i", $styles . "\n" . $inline_styles . "\n</head>", $before_body);
            $content = $before_body . $body. preg_replace('/.*<\/body>/ims', '', $content);
        }
        
		echo $content;
	}

	/**
	 * returns a string script with the entire panel parameters
	 * @return null
	 */
	function serializeConfigToJs() {
		$toret = '<!--' . "\n";
		$toret .= '		$app_path = "'.KT_getUri().'";' . "\n";		
		
		$toret .= '		$ctrl = new Controller(function() {' . "\n";
		foreach ($this->panels as $panelId => $notused) {
			$panelObj = & $this->panels[$panelId];
			$toret .= '		$panel_'.$panelId.' = $ctrl.createPanel(\''.KT_escapeJS($panelId).'\');' . "\n";
			$toret .= '		$panel_'.$panelId.'.setUpdateEffect(\''.KT_escapeJS($panelObj->updateEffect).'\');' . "\n";
			foreach ($panelObj->states as $panelState => $o) {
				$toret .= '			$panel_'.$panelId.'.addState(\''.KT_escapeJS($panelState).'\', \''.KT_escapeJS($o['file_name']).'\', \''.KT_escapeJS($o['title']).'\');' . "\n";
			}
			$toret .= '			$panel_'.$panelId.'.setCurrentState(\''.KT_escapeJS($panelObj->currentState).'\');' . "\n";
		}
		if ($this->getMasterPanel() !== null) {
			$toret .= '		$ctrl.setMasterPanel(\''.KT_escapeJS($this->getMasterPanel()).'\');' . "\n";
		}
		$toret .= '		Controller.initializeHistory();' . "\n";
		$toret .= '		});' . "\n";
        $toret .= '//-->' . "\n";
		return $toret;
	}

	function addJsInstantiation($str) {
		array_push($this->afterLoad_JsActions, $str);
	}
	function cleanJsInstantiation(){
		$this->afterLoad_JsActions = array();
	}
	/**
	 * renders a script portion for object instantiation (that is, the initial "plain" call which instantiates the bindings)
	 * @param bool $showOnLoad if the script must be surrounded by an "add to on load" behavior
	 * @return string script with bindings instantiation
	 * @access private
	 */
	function renderJsBindings($showOnLoad) {
		$toret = '<script type="text/javascript">' . "\n";
        $toret .=  '<!--' . "\n";
		$toret .= ($showOnLoad ? '$ctrl.addReadyEvent(function() {' : '') . "\n";
		$toret .= 'try {' . "\n";
		$toret .= join("\n", $this->afterLoad_JsActions);
		$toret .= "\n";

		$toret .= '} catch(e) {}' . "\n";
		$toret .= ($showOnLoad ? '});' : '') . "\n";
        $toret .= '//-->' . "\n";
		$toret .= '</script>' . "\n";
		return $toret;
	}
	
	/**
	 * renders a script portion for object instantiation (that is, the initial "plain" call which instantiates the bindings)
	 * @param string $trigger trigger panel
	 * @param string $triggerState trigger state
	 * @param string $listener listener panel
	 * @param string $listenerState changed listener state
	 * @access public
	 */
	function addLayoutChanger($trigger, $triggerState, $listener, $listenerState){
		/* save relation between triggers and listeners at panel level */
		if ($listener == $trigger) {
			die("You cannot add actions between states within the same panel!");
		}
		
		if (!isset($this->triggers[$trigger]) || !is_array($this->triggers[$trigger])) {
			$this->triggers[$trigger] = array();
		}
		$this->triggers[$trigger][$listener] = 1;
		
		if (!isset($this->layout_changers[$trigger]) || !is_array($this->layout_changers[$trigger])) {
			$this->layout_changers[$trigger] = array();
		}
		if (!isset($this->layout_changers[$trigger][$triggerState]) || !is_array($this->layout_changers[$trigger][$triggerState])) {
			$this->layout_changers[$trigger][$triggerState] = array();
		}
		$this->layout_changers[$trigger][$triggerState][$listener] = $listenerState;
	}



}
?>
