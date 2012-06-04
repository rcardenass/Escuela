<?php
class Panel {
	/**
	 * sitewide unique global id
	 * @var string
	 * @access public
	 */	
	var $id = null;

	/**
	 * states and files array for this panel
	 * @var array
	 * @access public
	 */	
	var $states = null;

	/**
	 * key in $this->states array, which is the current panel state.
	 * @var string
	 * @access public
	 */
	var $currentState = null;
	
	
	/**
	 * flag that indicates that the current state has been set from url
	 * @var boolean
	 * @access public
	 */
	var $stateFromUrl = false;

	/**
	 * flag that indicates that the current state has been set from layout changers
	 * @var boolean
	 * @access public
	 */
	var $stateFromLayoutChanger = false;

	/**
	 * instantiation pieces which are at the end. 
	 * $var array lateHtml 
	 * @access public
	 */
	var $lateHtml = array();

	/**
	 * update effect used for this panel
	 * $var updateEffect
	 */
	var $updateEffect = '';

	/**
	 * style (arktic, aqua etc)
	 * $var style
	 * @access public
	 */
	var $style = 'none';


	var $templates_path = '';

	/** 
	 * Constructor
	 * @param string id
	 * @param bool $visibility : the initial value of the visibility flag. 
	 * @ access public
	 */
	function Panel($id){
		$this->templates_path = realpath(dirname(__FILE__)) . '/panel_templates/';
		$this->id = $id;
	}

	function setUpdateEffect($effectName) {
		$this->updateEffect = $effectName;
	}

	function setStyle($style="") {
		if ($style == "") {
			$style = "none";
		}
		$this->style = $style;
	}

	/**
	 * Adds a state for a panel
	 * State descriptor: 
	 * 		file_name : the require()
	 * 		default : is the default state 
	 * 		restrict_by : add a condition for restricting access to a state 
	 * @param string $panelState
	 * @param string $panelFile
	 * 
	 */
	function addState($panelState, $panelFile, $panelTitle = null, $panelDescription=null, $panelKeywords=null) {
		$this->states[$panelState] = array(
			'file_name' => $panelFile,
			'title' => $panelTitle,
			'description' => $panelDescription,
			'keywords' => $panelKeywords
		);
	}

	/**
	 * Gets "real" state for a panel
	 * - initially get the default state
	 * - get the state from the uri variable
	 * - check for restrictions
	 * @return string the real state of the panel
	 */	
	function updateStateFromURL() {
		$state = "";
		$get_var_name = $this->id . "__state";
		if (isset($_GET[$get_var_name])) {
			$state = $_GET[$get_var_name];
			$this->stateFromUrl = true; /* flag the current panel with state from url */
		}
		$this->setCurrentState($state);
	}

	/**
	 * return the title for the real panel state
	 * @return string the panel title
	 */
	function getTitle() {
		return $this->states[$this->currentState]['title'];
	}

	/**
	 * return the description for the real panel state
	 * @return string the panel description
	 */
	function getDescription() {
		return $this->states[$this->currentState]['description'];
	}

	/**
	 * return the keywords for the real panel state
	 * @return string the panel keywords
	 */
	function getKeywords() {
		return $this->states[$this->currentState]['keywords'];
	}

	/**
	 * sets the state for a panel, WITHOUT CHECKING FOR RESTRICTED
	 * - for the moment, the default state is the empty one (panelState == '')
	 */
	function setCurrentState($panelState) {
		if(array_key_exists($panelState, $this->states)){
			$this->currentState = $panelState;
		} else {
			die("Invalid state: ".$panelState.", for panel: ".$this->id);
		}
	}

	
	/**
	 * begin panel rendering;
	 * - checks for states
	 * - sets the global 'me' variable
	 * - outputs the panel container for script operations, if we are not in XHR request
	 * @return null
	 */	
	function renderBegin() {
		if($this->states == null || count($this->states) == 0) die("can't render an empty panel");

		$GLOBALS['me'] = &$this;
		if (KT_is_ajax_request()) {
			$GLOBALS['ctrl']->cleanJsInstantiation();
		}
		$GLOBALS['ctrl']->addJsInstantiation('Controller.initForms("'.$this->id.'");');
		$GLOBALS['ctrl']->addJsInstantiation('Controller.initLinks("'.$this->id.'");');
		
		if ($GLOBALS['ctrl']->getMasterPanel() == $this->id) {
			$GLOBALS['ctrl']->title = $this->getTitle();
			$GLOBALS['ctrl']->description = $this->getDescription();
			$GLOBALS['ctrl']->keywords = $this->getKeywords();
		}
		ob_start();
	}

	/**
	 * end panel rendering;
	 * - outputs the panel container for script operations, if we are not in XHR request
	 * @return null
	 */
	function renderEnd() {
		$c = ob_get_contents();
		ob_end_clean();
		
		$visible = true;
		$test_content = trim($c);
		preg_match("/^<div\s+class=\\\"panel__content\\\">(.*)<\/div>$/ims", $test_content, $matches);
		if (isset($matches[1])) {
			$test_content = trim($matches[1]);
		}
		if ($test_content == "") {
			$visible = false;
		}
		// BEGIN
		if (!KT_is_ajax_request()) {
			echo '<div id="__'.$this->id.'" class="panel_class" style="'.(!$visible ? 'display: none' : '').'">';
			include($this->templates_path . $this->style. '/begin.html');
		}       
		// CONTENT        
		echo $c;
		// END
		if (!KT_is_ajax_request()) {
			include($this->templates_path . $this->style. '/end.html');
			echo "</div>";
		}
		if (count($this->lateHtml) > 0) {
			echo join("", $this->lateHtml);
		}
	}

	/**
	 * returns the file name for the current state
	 * @return string the file name to require()
	 */
	function getFileName() {
		return $this->states[$this->currentState]['file_name'];
	}
}
?>
