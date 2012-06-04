<?php
class dtable {
	
	var $connection;
	var $rsName;
	var $listName;
	var $tableName;
	var $columns;
	var $columnsSort;
	var $columnsSortIcon;
	var $startRow;
	var $maxRows;
	var $defaultMaxRows;
	var $pageNum;
	var $totalRows;
	var $totalPages;
	var $url;
	var $filterVisible;
	var $filter;
	var $filterCalculated;
	
	/**
	 * Constructor
	 * @param object connection object
	 * @param string recordset name
	 * @param string listObjectName 
	 * @access public
	 */
	function dtable(&$connection, $rsName, $listName, $tableName) {
		$this->connection = &$connection;
		$this->rsName = $rsName;
		$this->listName = $listName;
		$this->tableName = $tableName;
		$this->columns = array();
		$this->defaultSort = '';
		$this->columnsSort = array();
		$this->columnsSortIcon = array();
		$this->startRow = 0;
		$this->maxRows = 0;
		$this->defaultMaxRows = 0;
		$this->pageNum = 0;
		$this->totalRows = 0;
		$this->totalPages = 0;
		$this->filterVisible = false;
		$this->filter = array();
		$this->filterCalculated = '1=1';
	}
	
	/**
	 * setter. set the list pk and pktype
	 * @param string primary key field name
	 * @param string primary key field type
	 * @return nothing;
	 * @access public
	 */
	function setPK($pk, $pkType) {
		$this->pk = $pk;
		$this->pkType = $pkType;
	}

	/**
	 * setter. set the page URL (PHP_SELF)
	 * @param string page URL ( /admin/index.php?a=b);
	 * @return nothing;
	 * @access public
	 */
	function setUrl($url) {
		$this->url = $url;
	}
	
	/**
	 * setter. set the form URL 
	 * @param string page URL ( /admin/form.php?a=b);
	 * @return nothing;
	 * @access public
	 */
	function setFormUrl($url) {
		$this->formUrl = KT_getUriFolder() . $url;
	}
	
	/**
	 * setter. set the max rows number of the recordset
	 * @param int max rows;
	 * @return nothing;
	 * @access public
	 */
	function setMaxRows($maxRows) {
		$this->maxRows = $maxRows;
		$this->defaultMaxRows = $maxRows;
	}
	
	/**
	 * setter. add columns  
	 * @param string column name;
	 * @param string column type
	 * @param string column name for using when filtering
	 * @param string column name for using when sorting
	 * @param string callback function
	 * @param string compare type (= or %)
	 * @return nothing;
	 * @access public
	 */
	function addColumn($column, $type, $order_column, $compare_type) {
		$this->columns[$column] = array(
															'column' => $column,
															'type' => $type,
															'order_column' => $order_column,
															'compare_type' => $compare_type
															);
	}
	
	/**
	 * setter. set the default sorting column and direction
	 * @param string column name;
	 * @param string direction (ASC OR DESC)
	 * @return nothing;
	 * @access public
	 */
	function setDefaultSortColumn($defaultColumn, $defaultOrder='ASC') {
		$this->defaultSort = $defaultColumn . ' ' . $defaultOrder;
	}
	
	/**
	 * Main method of the class; 
	 * @return nothing;
	 * @access public
	 */
	function Execute() {
		$this->prepareNav();
		$this->prepareSort();
		$this->prepareFilter();
		if (isset($_GET['KT_data_request'])) {
			ob_start();
		}
	}

	/**
	 * prepare navigation values: maxRows and pageNum;
	 * @return nothing;
	 * @access public
	 */
	function prepareNav() {
		if ($this->isShowAll()) {
			$this->maxRows = 10000;
		}
	}
	
	/**
	 * preapare sorting links / icons for each column and store in columnsSort and columnsSortIcon;
	 * @return nothing;
	 * @access public
	 */
	function prepareSort() {
		$sorter_reference = "s_" . $this->listName;
		if (isset($_GET[$sorter_reference])) {
			$sorterString = $_GET[$sorter_reference];
			$this->defaultSort = $sorterString;
			$columnName = preg_replace("/\s+(DESC|ASC)/i", "", $sorterString);
		} else {
			$columnName = preg_replace("/\s+(DESC|ASC)/i", "", $this->defaultSort);
		}

		if ($columnName != '') {
			preg_match("/\S*\s+(DESC|ASC)/i", $this->defaultSort, $matches);
			foreach ($this->columns as $key => $arr) {
				$order = '';
				if($key == $columnName) {
					if (strtoupper($matches[1]) == 'ASC') {
						$paramVal = "DESC";
						$order = 'ASC';
					} else {
						$paramVal = "ASC";
						$order = 'DESC';
					}
				} else {
					$paramVal = "ASC";
				}
				$this->columnsSort[$key] = KT_addReplaceParam($this->url, $sorter_reference, $key . ' ' .$paramVal);
				$this->columnsSortIcon[$key] = $order;
			}		
		}
	}

	function getKeepSortHidden() {
		return '<input type="hidden" name="s_'.$this->listName.'" value="'.KT_escapeAttribute($this->defaultSort).'" />';
	}
    
    function getQuerryParams() {
        $strToRet = '';
        foreach ($_GET as $p => $v) {
            if (strpos($p, $this->listName) === false && $p != "pageNum_".$this->rsName && $p != "totalRows_".$this->rsName && $p != "KT_data_request") {
                $strToRet .= '<input type="hidden" name="'. $p . '" value="'.KT_escapeAttribute(KT_getRealValue("GET", $p)).'" />' . "\n";
            }
        }
        return $strToRet;
    }
	
	/**
	 * execute and calculate the filter condition and store in a local variable
	 * if no filter was submited, then the condition is 1=1;
	 * @return nothing;
	 * @access public
	 */
	function prepareFilter() {
		if (isset($_GET['show_filter_' . $this->listName])) {
			$this->filterVisible = true;
		}
		
		if (isset($_GET[$this->listName])) {
			foreach($this->columns as $colname => $colDetails) {
				$value = trim(KT_getRealValue("GET", $this->listName.'_'.$colname));
				if ($value!='') {
					$this->filter[$colname] = $value;
				}
			}
		}
		
		$condition = '';
		if (count($this->filter) > 0) {
			foreach ($this->filter as $colname => $value) {
				if ($condition != '') {
					$condition .= " AND ";
				}
				$compareType = $this->columns[$colname]['compare_type'];
				$type = $this->columns[$colname]['type'];
				switch ($type) {
					case 'NUMERIC_TYPE':
					case 'DOUBLE_TYPE':
						// if decimal separator is , => .
						$value = str_replace(',', '.', $value);
						if (preg_match('/^(<|>|=|<=|>=|=<|=>|<>|!=)\s?-?\d*\.?\d+$/', $value, $matches)) {
							$modifier = trim($matches[1]);
							if ($modifier == '!=') {
								$modifier = '<>';
							}
							$value = trim(substr($value, strlen($modifier)));
							$condition .= KT_escapeFieldName($colname) . ' ' . $modifier . ' ' . $value;
						} else {
							$condition .= KT_escapeFieldName($colname) . ' ' . $compareType . ' ' . KT_escapeForSql($value, $type);
						}
						break;
					case 'CHECKBOX_1_0_TYPE':
					case 'CHECKBOX_-1_0_TYPE':
						if (preg_match('/^[<>]{1}\s?-?\d*\.?\d+$/', $value)) {
							$condition .= KT_escapeFieldName($colname) . $value;
						} else {
							$condition .= KT_escapeFieldName($colname) . " = " . KT_escapeForSql($value, $type);
						}
						break;
					case 'DATE_TYPE':
					case 'DATE_ACCESS_TYPE':
						$localCond = $this->prepareDateCondition($colname, $this->columns[$colname], $value);
						if ($localCond != '') {
							$condition .= $localCond;
						}
						break;
					default:
						switch ($compareType) {
							case '=':
								break;
							case 'A%':
								$value = $value . '%';
								$compareType = 'LIKE';
								break;
							case '%A':
								$value = '%' . $value;
								$compareType = 'LIKE';
								break;
							default :
								$value = '%' . $value . '%';
								$compareType = 'LIKE';
								break;
						}
						$value = KT_escapeForSql($value, $type);
						$condition .= KT_escapeFieldName($colname) . ' ' . $compareType . ' ' . $value;
						break;
				}
			} // end foreach
			if ($condition != '') {
				$this->filterCalculated = $condition;
			}
            $this->filterCalculated = str_replace("%","%%", $this->filterCalculated);
		} 		
	}
	
	/**
	 * getter. get the column sort link
	 * @param string column name
	 * @return string link or null;
	 * @access public
	 */
	function getSortLink($column) {
		if (isset($this->columnsSort[$column])) {
			return $this->columnsSort[$column];
		}
		return '';
	}
	
	/**
	 * getter. get the sort order (ASC or DESC)
	 * @param string column name;
	 * @return string;
	 * @access public
	 */
	function getSortIcon($column) {
		if (isset($this->columnsSortIcon[$column])) {
			return $this->columnsSortIcon[$column];
		}	
		return '';
	}
	
	/**
	 * verified if the link show all was pressed;
	 * @return boolean true if show all is pressed;
	 * @access public
	 */
	function isShowAll() {
		if (isset($_GET["show_all_" . $this->listName])) {
			$ret = true;
		} else {
			$ret = false;
		}
		return $ret;
	}
	
	/**
	 * get the link for show all / show x 
	 * @return string url;
	 * @access public
	 */
	function getShowAllLink() {
		$reference = "show_all_" . $this->listName;
		if ($this->isShowAll()) {
			$url = KT_addReplaceParam(KT_getFullUri(), $reference);
			$url =  KT_addReplaceParam($url, 'show_filter_' . $this->listName);
			$url =  KT_addReplaceParam($url, 'reset_filter_' . $this->listName);
		} else {
			$url = KT_addReplaceParam(KT_getFullUri(), $reference, "1");
			$url =  KT_addReplaceParam($url, 'pageNum_' . $this->rsName);
			$url =  KT_addReplaceParam($url, 'show_filter_' . $this->listName);
			$url =  KT_addReplaceParam($url, 'reset_filter_' . $this->listName);
		}
		return $url;
	}
	
	/**
	 * Check if show filter link was pressed or not;
	 * @return boolean true if show filter was pressed;
	 * @access public
	 */
	function isFilterVisible() {
		return $this->filterVisible;
	}
	
	/**
	 * getter. get the URL for show filter / reset filter link  
	 * @return string link;
	 * @access public
	 */
	function getFilterLink() {
		if ($this->isFilterVisible()) {
			$url =  KT_addReplaceParam(KT_getFullUri(), 'show_filter_' . $this->listName);
			$url =  KT_addReplaceParam($url, 'reset_filter_' . $this->listName, "1");
		} else {
			$url =  KT_addReplaceParam(KT_getFullUri(), 'reset_filter_' . $this->listName);
			$url =  KT_addReplaceParam($url,'show_filter_' . $this->listName, "1");
		}
		return $url;
	}
	
	/**
	 * getter. get the condition for filter; if no conditions were applied, return 1=1
	 * @return string;
	 * @access public
	 */
	function getFilter() {
		return $this->filterCalculated;
	}
	
	/**
	 * getter. get filter value for given column
	 * @param string column name;
	 * @return string value or null;
	 * @access public
	 */
	function getFilterValue($column) {
		if (isset($this->filter[$column])) {
			return $this->filter[$column];
		}
		return null;
	}
	
	/**
	 * getter. get URL with any nav params removed from it;
	 * @return string;
	 * @access public
	 */
	function getFilterUri() {
		$url = $this->url;
		$url = preg_replace('/\?.*$/', '', $url);
		return $url;
	}
	
	/**
	 * getter. return the column name and direction for using in sorting; 
	 * @param string $fileInfo the name of the form field;
	 * @return nothing;
	 * @access public
	 */
	function getSorter() {
		$sorter_reference = "s_" . $this->listName;
		preg_match("/(.*)\s*(ASC|DESC)/i", $this->defaultSort, $matches);
		if (sizeof($matches) != 3 || !isset($this->columns[trim($matches[1])])) {
			die('Invalid sort parameter.');
		}

		return $this->columns[trim($matches[1])]['order_column'] . ' ' . $matches[2];
	}
	
	/**
	 * getter. get the navigation link for the given element: first, next, previous, last
	 * @return string;
	 * @access public
	 */
	function getNavLink($element) {
		$ret = "javascript: void(0);";

		switch (strtolower($element)) {
			case "first":
				if ($this->getPageNum() > 0) {
					$ret = $this->url;
					$ret = KT_addReplaceParam($ret, "show_filter_" . $this->listName);
					$ret = KT_addReplaceParam($ret, "reset_filter_" . $this->listName);
					$ret = KT_addReplaceParam($ret, "pageNum_".$this->rsName, 0);
					$ret = KT_addReplaceParam($ret, "totalRows_".$this->rsName, $this->getTotalRows());
				}
				break;
			case "previous":
				if ($this->getPageNum() > 0) {
					$ret = $this->url;
					$ret = KT_addReplaceParam($ret, "show_filter_" . $this->listName);
					$ret = KT_addReplaceParam($ret, "reset_filter_" . $this->listName);
					$ret = KT_addReplaceParam($ret, "pageNum_".$this->rsName, max(0, $this->getPageNum() - 1)); 
					$ret = KT_addReplaceParam($ret, "totalRows_".$this->rsName, $this->getTotalRows());
				}
				break;
			case "next":
				if ($this->getPageNum() < $this->getTotalPages()) {
					$ret = $this->url;
					$ret = KT_addReplaceParam($ret, "show_filter_" . $this->listName);
					$ret = KT_addReplaceParam($ret, "reset_filter_" . $this->listName);
					$ret = KT_addReplaceParam($ret, "pageNum_".$this->rsName, min($this->getTotalPages(), $this->getPageNum() + 1)); 
					$ret = KT_addReplaceParam($ret, "totalRows_".$this->rsName, $this->getTotalRows());
				}
				break;
			case "last":
				if ($this->getPageNum() < $this->getTotalPages()) {
					$ret = $this->url;
					$ret = KT_addReplaceParam($ret, "show_filter_" . $this->listName);
					$ret = KT_addReplaceParam($ret, "reset_filter_" . $this->listName);
					$ret = KT_addReplaceParam($ret, "pageNum_".$this->rsName, $this->getTotalPages()); 
					$ret = KT_addReplaceParam($ret, "totalRows_".$this->rsName, $this->getTotalRows());
				} 
				break;
		}
		return $ret;
	}
	
	/**
	 * getter. get the stas for from / to;
	 * @return string;
	 * @access public
	 */
	function getStats($what) {
		$ret = '';
		switch (strtolower($what)) {
			case 'from':
				$ret = ($this->getTotalRows() == 0) ? 0 :($this->getPageNum()*$this->getMaxRows() + 1);
				break;
			case 'to':
				$ret = min($this->getPageNum()*$this->getMaxRows() + $this->getMaxRows(), $this->getTotalRows());
				break;	
			case 'of':
				$ret = $this->getTotalRows();
				break;	
			default :
				break;
		}
		return $ret;
	}
	
	/**
	 * setter. sets the start row
	 * @access public
	 */
	function setStartRow($startRow) {
		$this->startRow = $startRow;
	}
	
	/**
	 * getter. get start row
	 * @return int;
	 * @access public
	 */
	function getStartRow() {
		return $this->startRow;
	}
	
	/**
	 * getter. get max rows number per page;
	 * @return int;
	 * @access public
	 */
	function getMaxRows() {
		return $this->maxRows;
	}
	
	/**
	 * getter. get the max number rows per page
	 * @return int;
	 * @access public
	 */
	function getDefaultMaxRows() {
		return $this->defaultMaxRows;
	}
	
	/**
	 * setter. sets curent page number
	 * @access public
	 */
	function setPageNum($pageNum) {
		$this->pageNum = $pageNum;
	}

	/**
	 * getter. get curent page number
	 * @return int;
	 * @access public
	 */
	function getPageNum() {
		return $this->pageNum;
	}
	
	/**
	 * setter. sets the total rows
	 * @access public
	 */
	function setTotalRows($totalRows) {
		$this->totalRows = $totalRows;
	}

	/**
	 * getter. get the total rows
	 * @return string;
	 * @access public
	 */
	function getTotalRows() {
		return $this->totalRows;
	}
	
	/**
	 * setter. sets the total pages
	 * @return int;
	 * @access public
	 */
	function setTotalPages($totalPages) {
		$this->totalPages = $totalPages;
	}

	/**
	 * getter. get the total pages
	 * @return int;
	 * @access public
	 */
	function getTotalPages() {
		return $this->totalPages;
	}
	
	/**
	 * transform the date value in a valid SQL condition; used for calculating the filter
	 * @param string column name;
	 * @param array column array information
	 * @param column value;
	 * @return string;
	 * @access public
	 */
	function prepareDateCondition($columnName, &$arr, $value) {
		$year = '';
		$month = '';
		$day = '';
		$hour = '';
		$min = '';
		$sec = '';
		
		$dateType = '';
		$modifier = '';
		
		$date1 = '';
		$date2 = '';
		$compareType1 = '';
		$compareType2 = '';
		$condJoin = '';
		
		$cond = '';
		$myDate = '';
		$dateArr = array();
		
		if (!isset($GLOBALS['KT_db_time_format_internal'])) {
			KT_getInternalTimeFormat();
		}
		
		// extract modifier and date from value
		if ( preg_match('/^(<|>|=|<=|>=|=<|=>|<>|!=)\s*\d+.*$/', $value, $matches) ) {
			$modifier = trim($matches[1]);
			$value = trim(substr($value, strlen($modifier)));
		} elseif ( preg_match('/^[^\d]+/', $value) ) {
			$ret = '';
			return $ret;
		}
		
		// prepare modifier for databases that do not support !=
		if ($modifier == '!=') {
			$modifier = '<>';
		}
		
		/* date pieces isolation */
		
		// year only
		if ( preg_match('/^\d+$/', $value) ) {
			$dateType = 'y';
			$year = $value;
		}
		
		// year month
		if ( preg_match('/^\d+[-\/\[\]\(\)\*\|\+\.=,]{1}\d+$/', $value) ) {
			$dateType = 'm';
			$dateArr = preg_split('/([-\/\[\]\(\)\*\|\+\.=,])/', $value, -1, PREG_SPLIT_NO_EMPTY);
			$month = $dateArr[0];
			$year = $dateArr[1];
			if (strlen($month) > 2) {
				$month = $dateArr[1];
				$year = $dateArr[0];
			}
		}
		
		// full date (year, month, day)
		if ( preg_match('/^\d+[-\/\[\]\(\)\*\|\+\.=,]{1}\d+[-\/\[\]\(\)\*\|\+\.=,]{1}\d+$/', $value) ) {
			$dateType = 'd';
			list($year, $month, $day) = $this->getDateParts($value);
		}
		
		// full date & hour
		if ( preg_match('/^\d+[-\/\[\]\(\)\*\|\+\.=,]{1}\d+[-\/\[\]\(\)\*\|\+\.=,]{1}\d+\s+\d+[^\d]*$/', $value) ) {
			$dateType = 'h';
			$myParts = strpos($value, ' ');
			$datePart = substr($value, 0, $myParts);
			$timePart = substr($value, $myParts + 1);
			list($year, $month, $day) = $this->getDateParts($datePart);
			list($hour, $min, $sec) = $this->getTimeParts($timePart, 'HH');
		}
		
		// full date + hour, minutes
		if ( preg_match('/^\d+[-\/\[\]\(\)\*\|\+\.=,]{1}\d+[-\/\[\]\(\)\*\|\+\.=,]{1}\d+\s+\d+:\d+[^\d]*$/', $value) ) {
			$dateType = 'i';
			$myParts = strpos($value, ' ');
			$datePart = substr($value, 0, $myParts);
			$timePart = substr($value, $myParts + 1);
			list($year, $month, $day) = $this->getDateParts($datePart);
			list($hour, $min, $sec) = $this->getTimeParts($timePart, 'HH:ii');
		}
		
		// full date time
		if ( preg_match('/^\d+[-\/\[\]\(\)\*\|\+\.=,]{1}\d+[-\/\[\]\(\)\*\|\+\.=,]{1}\d+\s+\d+:\d+:\d+[^\d]*$/', $value) ) {
			$dateType = 's';
			$myParts = strpos($value, ' ');
			$datePart = substr($value, 0, $myParts);
			$timePart = substr($value, $myParts + 1);
			list($year, $month, $day) = $this->getDateParts($datePart);
			list($hour, $min, $sec) = $this->getTimeParts($timePart, 'HH:ii:ss');
		}
		
		if ($dateType == '') {
			$dateType = 't';
			$value = KT_formatDate2DB($value);
		}
		
		/* prepare date parts */
		
		// 1 or 2 digits year
		if ( preg_match('/^\d{1,2}$/', $year) ) {
			if ($year < 70) {
				$year = 2000 + $year;
			} else {
				$year = 1900 + $year;
			}
		}
		
		if ( $month < 1 || $month > 12 ) {
			$month = '01';
		}
		if ( $hour > 23 ) {
			$hour = '00';
		}
		if ( $min > 59 ) {
			$min = '00';
		}
		if ( $sec > 59 ) {
			$sec = '00';
		}

		/* prepare condition operators based on modifiers */
		switch ($modifier) {
			case '>=':
				$compareType1 = '>=';
				$compareType2 = '';
				$condJoin = '';
				break;
			case '<=':
				$compareType1 = '';
				$compareType2 = '<=';
				$condJoin = '';
				break;
			case '<':
				$compareType1 = '<';
				$compareType2 = '';
				$condJoin = '';
				break;
			case '>':
				$compareType1 = '';
				$compareType2 = '>';
				$condJoin = '';
				break;
			case '<>':
				$compareType1 = '<';
				$compareType2 = '>';
				$condJoin = 'OR';
				break;
			default:
				$compareType1 = '>=';
				$compareType2 = '<=';
				$condJoin = 'AND';
				break;
		}
		
		/* prepare dates for filtering */
		switch ($dateType) {
			case 'y':
				$date1 = KT_convertDate($year . '-01-01', 'yyyy-mm-dd', $GLOBALS['KT_db_date_format']);
				$date2 = KT_convertDate($year . '-12-31', 'yyyy-mm-dd', $GLOBALS['KT_db_date_format']);
				break;
			case 'm':
				$date1 = KT_convertDate($year . '-' . $month . '-01', 'yyyy-mm-dd', $GLOBALS['KT_db_date_format']);
				$maxday = KT_getDaysOfMonth($month, $year);
				$date2 = KT_convertDate($year . '-' . $month . '-' . $maxday, 'yyyy-mm-dd', $GLOBALS['KT_db_date_format']);
				break;
			case 'd':
				$date1 = KT_convertDate($year . '-' . $month . '-' . $day . ' 00:00:00', 'yyyy-mm-dd HH:ii:ss', $GLOBALS['KT_db_date_format'] . ' ' . $GLOBALS['KT_db_time_format_internal']);
				$date2 = KT_convertDate($year . '-' . $month . '-' . $day . ' 23:59:59', 'yyyy-mm-dd HH:ii:ss', $GLOBALS['KT_db_date_format'] . ' ' . $GLOBALS['KT_db_time_format_internal']);
				break;
			case 'h':
				$date1 = KT_convertDate($year . '-' . $month . '-' . $day . ' ' . $hour . ':00:00', 'yyyy-mm-dd HH:ii:ss', $GLOBALS['KT_db_date_format'] . ' ' . $GLOBALS['KT_db_time_format_internal']);
				$date2 = KT_convertDate($year . '-' . $month . '-' . $day . ' ' . $hour . ':59:59', 'yyyy-mm-dd HH:ii:ss', $GLOBALS['KT_db_date_format'] . ' ' . $GLOBALS['KT_db_time_format_internal']);
				break;
			case 'i':
				$date1 = KT_convertDate($year . '-' . $month . '-' . $day . ' ' . $hour . ':' . $min . ':00', 'yyyy-mm-dd HH:ii:ss', $GLOBALS['KT_db_date_format'] . ' ' . $GLOBALS['KT_db_time_format_internal']);
				$date2 = KT_convertDate($year . '-' . $month . '-' . $day . ' ' . $hour . ':' . $min . ':59', 'yyyy-mm-dd HH:ii:ss', $GLOBALS['KT_db_date_format'] . ' ' . $GLOBALS['KT_db_time_format_internal']);
				break;
			case 's':
				$date1 = KT_convertDate($year . '-' . $month . '-' . $day . ' ' . $hour . ':' . $min . ':' . $sec, 'yyyy-mm-dd HH:ii:ss', $GLOBALS['KT_db_date_format'] . ' ' . $GLOBALS['KT_db_time_format_internal']);
				$date2 = KT_convertDate($year . '-' . $month . '-' . $day . ' ' . $hour . ':' . $min . ':' . $sec, 'yyyy-mm-dd HH:ii:ss', $GLOBALS['KT_db_date_format'] . ' ' . $GLOBALS['KT_db_time_format_internal']);
				$compareType1 = '=';
				$compareType2 = '';
				$condJoin = '';
				break;
			case 't':
				$date1 = $value;
				$date2 = '';
				$compareType1 = '=';
				$compareType2 = '';
				$condJoin = '';
				break;
			default:
				$dateType = '';
				$compareType1 = '';
				$compareType2 = '';
				$condJoin = '';
				break;
		}
		
		if ($dateType != '') {
			$cond = '(';
			if ($compareType1 != '') {
				$cond .= KT_escapeFieldName($columnName) . ' ' . $compareType1 . ' ' . KT_escapeForSql($date1, $arr['type']);
			}
			if ($compareType2 != '') {
				if ($compareType1 != '') {
					$cond .= ' ' . $condJoin . ' ';
				}
				$cond .= KT_escapeFieldName($columnName) . ' ' . $compareType2 . ' ' . KT_escapeForSql($date2, $arr['type']);
			}
			$cond .= ')';
		}
		
		return $cond;
	}
	
	/**
	 * getter. validate the date parts
	 * @param string date
	 * @return array with date parts: year, month, day);
	 * @access public
	 */
	function getDateParts($datePart) {
		$myDate = '';
		$dateArr = array();
		$year = '';
		$month = '';
		$day = '';
		
		$myDate = KT_convertDate($datePart, $GLOBALS['KT_screen_date_format'], 'yyyy-mm-dd');
		$dateArr = explode('-', $myDate);
		$year = $dateArr[0];
		$month = $dateArr[1];
		$day = $dateArr[2];
		if ( $month < 1 || $month > 12 ) {
			$month = '01';
		}
		$maxday = KT_getDaysOfMonth($month, $year);
		if ( $day < 1 || $day > $maxday ) {
			$day = '01';
		}
		return array($year, $month, $day);
	}
	
	/**
	 * getter. validate the time parts
	 * @param string time
	 * @param string input time format
	 * @return array with date parts: hour, mins, sec);
	 * @access public
	 */
	function getTimeParts($timePart, $format) {
		$myDate = '';
		$dateArr = array();
		$hour = '';
		$min = '';
		$sec = '';
		
		$myDate = KT_convertDate($timePart, $GLOBALS['KT_screen_time_format_internal'], $format);
		$dateArr = explode(':', $myDate);
		$hour = $dateArr[0];
		if (isset($dateArr[1])) {
			$min = $dateArr[1];
		}
		if (isset($dateArr[2])) {
			$sec = $dateArr[2];
		}
		if ( $format != 'HH:ii:ss' && preg_match('/p/i', $timePart) && $hour < 12) {
			$hour += 12;
		}
		return array($hour, $min, $sec);
	}
	
	function beginList() {
		if (isset($_GET['KT_data_request']) && $_GET['KT_data_request'] == $this->listName) {
			ob_clean();
		}
		
		return $this->getQuerryParams() . "\n" . $this->getKeepSortHidden();
	}
	
	function endList() {
		if (isset($_GET['KT_data_request']) && $_GET['KT_data_request'] == $this->listName) {
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

			ob_end_flush();
			die();
		}
	}
}
?>
