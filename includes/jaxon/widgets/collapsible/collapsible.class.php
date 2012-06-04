<?php

$GLOBALS['Widgets.Collapsible.default_options'] = array(
	'dimensions' => array(), 
	'has_width' => false, 
	'has_height' => false, 
	'load_on_demand' => false
);

class Collapsible {
	var $id = '';
	var $file_name = '';
	var $title = '';
	var $open = false;
	var $options = array();

	function Collapsible($id, $title, $file, $options = array()) {
   		$title = KT_DynamicData($title, null, '');
		$file = KT_DynamicData($file, null, '');

		$this->id = $id;
		$this->title = $title;
		$this->file_name = $file;
		$this->options = $GLOBALS['Widgets.Collapsible.default_options'];
		$this->options = array_merge($this->options, $options);
	}

	function setLoadContentOnDemand($l) {
		$this->options['load_on_demand'] = $l;
	}

	function setDimensions($width, $height) {
		if ($width && $width != 0) {
			$this->options['dimensions']['width'] = $width;
			$this->options['has_width'] = true;
		}
		if ($height && $height != 0) {
			$this->options['dimensions']['height'] = $height;
			$this->options['has_height'] = true;
		}
	}

	function setDefaultOpen ($open) {
		$this->open = $open;
	}

	function getDefaultOpenClass() {
		return $this->open ? 'collapsible_phprendering collapsible_open' : '' ;
	}

	function setAjaxStubContext() {
		$GLOBALS["stub_context"] = KT_Rel2AbsUrl(KT_getUri(), "",  $this->file_name, true);
		if (isset($_SERVER['QUERY_STRING']) && $_SERVER['QUERY_STRING'] != "") {
			$GLOBALS["stub_context"] .= "?" . $_SERVER['QUERY_STRING'];
		} 
	}
	
	function resetAjaxStubContext() {
		unset($GLOBALS["stub_context"]);
	}

	function getFileName() {
		if (!$this->options['load_on_demand']) {
			return basename($this->file_name);
		} else {
			return dirname(realpath(__FILE__)) . "/empty.php";
		}
	}
	
	function renderBegin() {
		if (isset($_GET[$this->id . '__open'])) {
			$this->open =  $_GET[$this->id . '__open'] == 'true';
		}

		if ($this->open) {
		$this->options['load_on_demand'] = false;
			
		}
		if (!$this->options['load_on_demand']) {
		    $this->setAjaxStubContext();
		}


		$w = $h = '';
		if ($this->options['has_width']) {
			$w = 'width: ' . $this->options['dimensions']['width'].'px';
		}
		if ($this->options['has_height']) {
			$h = 'height: ' . $this->options['dimensions']['height'].'px';
		}
		$style = ($this->options['has_width'] || $this->options['has_height']) ? ('style="'.implode(';', array($w, $h)).';"') : '';

		$toret = '<div id="'.$this->id.'" class="collapsible '.$this->getDefaultOpenClass().'" '.$style.'>';
		$toret .= '<h3 class="title"><a id="link__'.$this->id.'" href="'. str_replace('&', '&amp;', KT_addReplaceParam(KT_getFullUri(), $this->id . '__open', ($this->open ? 'false': 'true'))) .'">'.$this->title.'</a></h3>';
		$toret .= '<div id="'.$this->id.'-body" class="collapsibleBody">
			<div class="collapsibleContent">';
			
		if (!$this->options['load_on_demand']) {
			$this->prevDir = getcwd();
			chdir(dirname(realpath($this->file_name)));
		}	
		return $toret;
	}
	
	function renderEnd() {
		if (!$this->options['load_on_demand']) {
			chdir($this->prevDir);
		}
		$toret = '</div>
		</div>';
		unset($this->options['has_width']);
		unset($this->options['has_height']);
		unset($this->options['dimensions']);

		$toret .= '
			</div>
			<script  type="text/javascript">
            <!--
			var '.$this->id.' = new Widgets.Collapsible("'.$this->id.'", "'.$this->file_name.'", '.KT_json($this->options).');
            //-->
			</script>
		';
		if (!$this->options['load_on_demand']) {
			$this->resetAjaxStubContext();
		}
		return $toret;
	}							
}
?>