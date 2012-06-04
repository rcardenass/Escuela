<?php
/*
	Copyright (c) InterAKT Online 2000-2006
*/

$GLOBALS['Widgets.Rating.default_options'] = array(
	'you' => 'Your rating: ', 
	'titles' => array(
		'Worst', 
		'Not so good', 
		'OK', 
		'Pretty Good', 
		'Excellent'
	), 
);

class Rating {
	var $exportedMethods = array('saveRating');
	var $config = array();
    var $connection = null;
    var $table = null;
    var $relPath = null;
	
	function Rating($id) {
		$this->id = $id;
		$this->options = $GLOBALS['Widgets.Rating.default_options'];
	}

	function setConnection($connection) {
		$this->config['connection'] = $connection;
	}

	function setTable($tableName) {
		$this->config['table'] = $tableName;
	}

	function setPrimaryKey($fieldName) {
		$this->config['primaryKey'] = $fieldName;
	}

	function setRatingField($fieldName) {
		$this->config['ratingField'] = $fieldName;
	}

	function setNumberOfRatesField($fieldName) {
		$this->config['numberOfRates'] = $fieldName;
	}
	
	function setRelPath($relPath) {
		$this->relPath = $relPath;
	}

	function getRateClass($index, $id) {
		return ($index <= $this->currentRating) ? 'present_selected' : 'present_normal';
	}

	function renderForId($index, $currentRating) {
    $index = KT_DynamicData($index, null, '');
		$content = '';
		$this->currentRating = intval($currentRating);
		if ($this->currentRating == null) {
			$this->currentRating = 0;
		}
		for ($i = 0; $i < 5; $i++) {
			$content .= '<a href="#'.($i+1).'" title="'.$this->options['titles'][$i].'">' .
					'<img src="'.$this->relPath.'includes/jaxon/widgets/rating/img/'.$this->getRateClass($i+1, $index).'.gif" style="border:0px;" alt="' . $this->options['titles'][$i] . '"/>' .
					'</a>';
		}
		$content = '
		<div class="rater" id="rating_'.$this->id . '_' . $index.'">'.$content.'</div><script  type="text/javascript">var rating_'.$this->id .
		'_'. $index.' = new Widgets.Rating("'.addslashes($this->id).'", "'.addslashes($index).'", '.
		KT_json($this->options).', "'.md5($this->id.$this->config['table'].$this->config['primaryKey'].
		$this->config['ratingField'].$index).'");</script>';
		return $content; 
	}

	function saveRating($value, $index) {
		require_once(realpath(dirname(__FILE__) . '/' . '/../../../../Connections/' .$this->config['connection'].'.php'));
		$conn_name = $this->config['connection'];
		$hostname = 'MM_' . $conn_name . '_HOSTNAME';
        $connWrap = null;
		if (empty($GLOBALS[$hostname])) {
			//we are on mysql
			// Make unified connection variable
			$database = 'database_' . $conn_name;
			$connWrap = new KT_Connection($GLOBALS[$conn_name], $GLOBALS[$database]);
		} else {
			$connWrap = $GLOBALS[$conn_name];
		}
		$rs = $connWrap->Execute($this->getRatingQueryTemplate($index));
		if ($rs === false){
				return array('error' => array('code' => 'SQL error', 'message' => $connWrap->ErrorMsg()) );	
		}
		$rate = $this->deserializeRating($rs->Fields('rating'), $rs->Fields('numrates'));
		$new_rate = (($rate['average'] * $rate['number_of_rates'] + $value)) / ($rate['number_of_rates']+1);
    	$rs = $connWrap->Execute($this->saveRatingQueryTemplate($new_rate, $rate['number_of_rates']+1, $index));
		if ($rs !== false){
			$tmp = array('rating' => round($new_rate));
		}else{
			$tmp = array('error' => array( 'code' => 'SQL Error', 'message' => 'The rating save failed: '.$connWrap->ErrorMsg()));
		}
		return $tmp;
	}

	function getRatingQueryTemplate($index) {
		return sprintf("SELECT %s AS rating, %s AS numrates FROM %s WHERE %s = %s", 
			$this->config['ratingField'], 
			$this->config['numberOfRates'], 
			$this->config['table'], 
			$this->config['primaryKey'], 
			$index);
	}
	function saveRatingQueryTemplate($value, $numrates, $index) {
		return sprintf("UPDATE %s SET %s = %s, %s = %s WHERE %s = %s", 
			$this->config['table'], 
			$this->config['ratingField'], 
			$value, 
			$this->config['numberOfRates'], 
			$numrates, 
			$this->config['primaryKey'], 
			$index);
	}

	function deserializeRating($rate, $num) {
		$toret = array();
		if ($rate == '' || is_null($rate)) {
			$toret['average'] = 0;
		} else {
			$toret['average'] = floatval($rate);
		}
		if ($num == '' || is_null($num)) {
			$toret['number_of_rates'] = 0;
		} else {
			$toret['number_of_rates'] = intval($num);
		}
		return $toret;
	}
}
?>