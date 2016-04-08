<?php 
//************  Brent Crude Prices  ****************
require_once "Quandl.php";


class Graph{
public $api_key = "FEnyznn3PiGxaFbs-Yuz";
public $quandl;
public $br_obj;
public $br_values;
public $br_labels;
public $br_label_arr;
public $br_value_arr;
public function __construct() {
		$this->quandl = new Quandl($this->api_key, 'json');
}

public function graphFiveDays($symbol){
	$this->graphHelper($symbol, 5, 1);
}
public function graphOneMonth($symbol){
	$this->graphHelper($symbol, 30, 1);
}
public function graphThreeMonths($symbol){
	$this->graphHelper($symbol, 90, 7);
}
public function graphSixMonths($symbol){
	$this->graphHelper($symbol, 180, 7);
}
public function graphAllTime($symbol){
	$this->graphHelper($symbol, -1, 365);
}
public function graphAllTimeHelper($symbol){
	$br_json = $this->quandl->getSymbol($symbol);
	$this->br_obj = json_decode($br_json, true);
	//Build arrays
	$this->br_label_arr = array();
	$this->br_value_arr = array();
	$i = 0;
	$divider = 10;
	$length = count($br_obj['data']);
	$divider = $length / $divider;
		foreach ($this->br_obj['data'] as $br_data){ //loop through data
			if($i % $divider == 0){
				$br_label_arr[] = $br_data[0];
				//date('M j',strtotime($br_data[0])); //pull dates
				$br_value_arr[] = $br_data[4]; //pull prices
			}
			++$i;
		}
}
public function graphHelper($symbol, $days, $divider){
	$br_json = $this->quandl->getSymbol($symbol);
	$this->br_obj = json_decode($br_json, true);
	//Build arrays
	$this->br_label_arr = array();
	$this->br_value_arr = array();
	$i = 0;
		foreach ($this->br_obj['data'] as $br_data){ //loop through data
			if($i % $divider == 0){
				$this->br_label_arr[] = $br_data[0];
				//date('M j',strtotime($br_data[0])); //pull dates
				$this->br_value_arr[] = $br_data[4]; //pull prices
			}
			if (++$i == $days) break;
		}
}
}

?>

