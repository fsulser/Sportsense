<?php
session_start();
//check if session variables are set
if (isset($_SESSION['token']) && isset($_SESSION['Task'])) {
	if ($_SESSION['Task'] == 'basic') {
		new Values();
	}else{
		$arr = array('success' => 0, 'error_msg' => 'Couldn\'t enter Events');
		echo json_encode($arr);
	}
} else {
	$arr = array('success' => 0, 'error_msg' => 'Couldn\'t enter Events');
	echo json_encode($arr);
}


class Values{
	private static $DB, $data;
	function Values(){
		self::$DB = require '../Connect.php';
		//get entered events from users
		self::$data = json_decode($_POST['data'], true);
		$this->getTaskInformations();
	}
	
	function getTaskInformations(){
		//get all informations of the task, to check if entered values are possible or not
		$sql = "SELECT c.start AS sequenceStart, c.sequenceLength FROM campaign c WHERE c.CampaignId=1";
		$stmt = self::$DB->prepare($sql);
		if($stmt->execute()){
			$stmt = $stmt->fetch();
			$this->checkHandler($stmt);
		}else{
			$arr = array('success' => 0, 'error_msg' => 'Couldn\'t enter Events');
			echo json_encode($arr);
		}
	}
	
	function checkHandler($stmt){
		$boolean = true;
		//for all entered events check position and time data
		for ($i=0; $i < count(self::$data); $i++) { 
			if(!$this->checkTime($stmt, $i)){
				$boolean = false;
				break;
			}
			if(!$this->checkPosition($stmt, $i)){
				$boolean = false;
				break;
			}
		}
		if(!$this->checkValuesAlreadyEntered()){
			$boolean = false;
		}
		
		if($boolean == true){
			//calculate rating for all entered events
			new Rating();
		}
		
	}
	
	function checkTime($stmt, $i){
		//checking if time of entered data is between start and endtime of sequence
		if(floatval(self::$data[$i]['Time']) < floatval($stmt['sequenceStart']) || floatval(self::$data[$i]['Time']) > floatval($stmt['sequenceStart']) + floatval($stmt['sequenceLength']) ){
			$arr = array('success' => 3, 'error_msg' => 'Wrong values');
			echo json_encode($arr);
			return false;
		}else{
			return true;
		}
	}
	
	function checkPosition($stmt, $i){
		//check if position is on field.
		$positions = explode(' ', self::$data[$i]['Position']);
		$dataPositionX = $positions[0];
		$dataPositionY = $positions[1];

		if(floatval($dataPositionX) < 0 || floatval($dataPositionX) > 664){
			$arr = array('success' => 3, 'error_msg' => 'Wrong values');
			echo json_encode($arr);
			return false;
		}else{
			if(floatval($dataPositionY) < 0 || floatval($dataPositionY) > 445){
				$arr = array('success' => 3, 'error_msg' => 'Wrong values');
				echo json_encode($arr);
				return false;
			}else{
				return true;				
			}
		}
	}
	
	function checkValuesAlreadyEntered(){
		//checks if the values have already been entered by the user in the case that a user sends his data twice or more.
		$sql = "SELECT COUNT(*)AS number FROM Task WHERE token='".$_SESSION['token']."' LIMIT 1";
		$stmt = self::$DB->prepare($sql);
		if($stmt->execute()){
			$stmt = $stmt->fetch();
			if($stmt['number']==0){
				return true;
			}else{
				$arr = array('success' => 1, 'error_msg' => 'Already entered');
				echo json_encode($arr);
				return false;
			}
		}else{
			$arr = array('success' => 1, 'error_msg' => 'Already entered');
			echo json_encode($arr);
			return false;
		}
	}
	
	
}


class Rating {
	private static $DB, $groundTruth, $data, $rating;
	
	function Rating() {
		self::$data = json_decode($_POST['data'], true);
		self::$rating = array();
		self::$DB = require ('../Connect.php');
		$this -> getValues();
		include 'InsertBasic.php';
		// check if user has entered events
		if(count(self::$data)!=0){
			//if user entered any data create the datamatrix to compare the values with the ground truth
			$this -> createMatrix();
		}else{
			//if user has not entered any events calculate the number of missed events and enter and update the database
			$missed = $this -> calculateMissed();
			new InsertValues(self::$data, self::$rating, $missed);
		}
	}
	

	function getValues() {
		//get all events from ground truth
		$sql = "Select b.trackedPointX, b.trackedPointY, b.min, b.sec, b.msec, b.type_id, (Select t.TeamName from Teams t where t.TeamId = b.team_id) as team_id, b.player_id, b.period_id from GroundTruth b";
		$stmt = self::$DB -> prepare($sql);
		if ($stmt -> execute()) {
			self::$groundTruth = $stmt -> fetchAll();
		} else {
			$arr = array('success' => 0, 'error_msg' => 'Couldn\'t enter Events');
			echo json_encode($arr);
		}
	}

	function createMatrix() {
		$trueRowNumb = count(self::$groundTruth);
		$dataRowNumb = count(self::$data);

		$weightArray = array();

		// create an n*m matrix, where m is the number of ground truth events and n is the number of entered data 
		for ($i = 0; $i < $trueRowNumb; $i++) {
			for ($j = 0; $j < $dataRowNumb; $j++) {
				//calculate the weights between each row and column
				$weightArray[$j][$i] = $this -> calculateWeigth($i, $j);
			}
		}

		//select the maximum value in the datamatrix.
		for($i=0; $i< $trueRowNumb; $i++){
			$max = $this -> recursive_array_max($weightArray);
			//if the biggest value in the matrix is greater than -1. allocathe the point to the correlated ground thruth point
			if($max>-1){
				$index = $this -> searchIndex($max, $weightArray);
				self::$rating[$index['column']] = $weightArray[$index['column']][$index['row']];
				$weightArray = $this->deleteRow($weightArray, $index['row']);
				$weightArray = $this->deleteCol($weightArray, $index['column']);
			}
		}
		//calculate the missed events of the ground truth
		$missed = $this -> calculateMissed();
		self::$DB = null;
		new InsertValues(self::$data, self::$rating, $missed);
	}
	
	function calculateMissed(){
		// missed events = ground truth - not number of rated events
		return count(self::$groundTruth) - count(self::$rating);
	}

	function deleteRow($weightArray, $index){
		//set the row used to small values
		for($i=0; $i<count($weightArray); $i++){
			$weightArray[$i][$index] = -100;
		}
		return $weightArray;
	}
	
	function deleteCol($array, $offset) {
		//set the coloms used to small values
		for($i=0; $i<count($array[0]); $i++){
			$array[$offset][$i] = -100;
		}
		return $array;
	}

	function searchIndex($max, $weightArray) {
		for ($i = 0; $i <= count($weightArray); $i++) {
			if(in_array($max, $weightArray[$i])){
				$index = array_search($max, $weightArray[$i]);
				return array('column'=>$i, 'row' => $index);
			}
		}

	}

	function recursive_array_max($weightArray) {
		foreach ($weightArray as $value) {
			if (is_array($value)) {
				$value = $this -> recursive_array_max($value);
			}
			if (!(isset($max))) {
				$max = $value;
			} else {
				if ($max < $value) {
					$max = $value;
				}
			}
		}
		return $max;
	}

	function calculateWeigth($trueIndex, $dataIndex) {
		// calculate the distance for the time, team, event, position and build the arithmetic mean
		$time = $this -> calculateTime($trueIndex, $dataIndex);
		$team = $this -> calculateTeam($trueIndex, $dataIndex);
		$event = $this -> calculateEvent($trueIndex, $dataIndex);
		$position = $this -> calculatePosition($trueIndex, $dataIndex);
		return ($time + $team + $event + $position) / 4;
	}

	function calculateTime($trueIndex, $dataIndex) {
		// calculating the time distance
		$dataTime = self::$data[$dataIndex]['Time'];
		$trueTime = $this -> timeToSeconds(self::$groundTruth[$trueIndex]['min'], self::$groundTruth[$trueIndex]['sec'], self::$groundTruth[$trueIndex]['msec']);

		//+-1 sec is accepted (=-1)
		return 1 - 2 * abs($dataTime - $trueTime);
	}

	function calculateTeam($trueIndex, $dataIndex) {
		// calculating the team distance with -1,1 if equal or not
		$dataTeam = self::$data[$dataIndex]['Team'];
		$trueTeam = self::$groundTruth[$trueIndex]['team_id'];
		if ($dataTeam == $trueTeam) {
			return 1;
		} else {
			return -1;
		}
	}

	function calculateEvent($trueIndex, $dataIndex) {
		//calculate the event distance with -1,1 if equal or not.
		$dataEvent = self::$data[$dataIndex]['EventId'];
		$trueEvent = self::$groundTruth[$trueIndex]['type_id'];
		//TODO create Event Loss matrix
		if ($dataEvent == $trueEvent) {
			return 1;
		} else {
			return -1;
		}
	}

	function calculatePosition($trueIndex, $dataIndex) {
		//calculate the positional distance between the data and ground truth
		$positions = explode(' ', self::$data[$dataIndex]['Position']);
		$dataPositionX = $positions[0];
		$dataPositionY = $positions[1];

		$truePositionX = self::$groundTruth[$trueIndex]['trackedPointX'];
		$truePositionY = self::$groundTruth[$trueIndex]['trackedPointY'];
		
		$distance = sqrt( pow( abs($dataPositionX) - abs($truePositionX), 2 ) + pow( abs($dataPositionY) - abs($truePositionY), 2) );
		$maxDistance = 20;
		if($distance < $maxDistance){
			$rating = 1 - pow( $distance/$maxDistance , 2);
		}else{
			$rating = 1 - ($distance / $maxDistance);
		}

		return $rating;
	}

	function timeToSeconds($min, $sec, $msec) {
		return (floatval($min) * 60) + floatval($sec) + floatval('0.' . $msec);
	}
}

?>