<?php
class CalculateRating {
	private $id, $DB, $base;
	function calculateRating($id) {
		$this -> DB =
		require '../Connect.php';
		$this -> id = $id;
		$this -> getPoints();

		$tasks = $this -> getNumber();
		//for all task in this campaign calculate the rating of corresponding events
		for ($i = 0; $i < $tasks; $i++) {
			new Rating($this -> base, $this -> id);
		}

	}

	function getPoints() {
		//get all calculated points in this campaign
		$sql = "SELECT trackedPointX, trackedPointY, (min*60+sec+msec/1000)AS Time, type_id, team_id FROM CalculatedEvent WHERE CampaignId=" . $this -> id." ORDER BY Time";
		$stmt = $this -> DB -> prepare($sql);
		if ($stmt -> execute()) {
			$this -> base = $stmt -> fetchAll(PDO::FETCH_ASSOC);
		} else {
			include_once "Email.php";
			new Email('failed', 'to select all points of task', $this->id);
		}
	}

	function getNumber() {
		//get the number of tasks in this campaign not rated.
		$sql = "SELECT COUNT(*)AS count FROM Task WHERE CampaignId=" . $this -> id . " AND isRated=0";
		$stmt = $this -> DB -> prepare($sql);
		if ($stmt -> execute()) {
			$stmt = $stmt -> fetch();
			return $stmt['count'];
		} else {
			include_once "Email.php";
			new Email('failed', 'to select number of tasks in campaing', $this->id);
		}

	}

}

class Rating {
	private $base, $data, $DB, $rating, $id;
	function Rating($base, $id) {
		include_once 'UpdateValues.php';
		$this -> base = $base;
		$this -> DB =
		require '../Connect.php';
		$this -> id = $id;
		$this -> getData();
		//remove all data from the calculated events not belongig in the sequence of this task
		$this -> base = $this -> getDataInSequence();
		$this -> rating = array();
		if (count($this -> data) != 0) {
			if (is_null($this -> data[0]['EventId'])) {
				//calculate the number of missed events in this task
				$missed = $this -> calculateMissed();
				new UpdateValues($this -> data, $this -> rating, $missed, $this -> id);
			} else {
				$this -> createMatrix();
			}
		} else {
			$missed = $this -> calculateMissed();
			new UpdateValues($this -> data, $this -> rating, $missed, $this -> id);
		}
	}

	function getDataInSequence() {
		$array = array();
		//for all data in the entered events
		foreach ($this->data as $j => $DataRow) {
			//get the starttime of the sequence
			$start = $this -> data[$j]['sequenceStart'];
			//for each data in the calculated events
			foreach ($this->base as $i => $row) {
				//if the time of the calculated event is not in the sequence
				if (floatval($row['Time']) > floatval($start)) {
					if (floatval($row['Time']) < floatval($start) + 5) {
						//delete the calculated event from the list.
						array_push($array, $row);
						unset($this -> base[$i]);
					}
				}
			}
		}
		return $array;
	}

	function getData() {
		//get all events of this tasks
		$sql = "Select t.TaskId, t.sequenceStart, e.EventId, e.trackedPointX, e.trackedPointY, (e.min*60+ e.sec+ e.msec/10)AS Time, e.type_id, e.team_id from Task t LEFT JOIN Event e ON t.TaskId = e.TaskId WHERE t.TaskID =(SELECT t1.TaskId FROM Task t1 WHERE t1.CampaignId=".$this->id." AND isRated=0 LIMIT 1)";
		$stmt = $this -> DB -> prepare($sql);
		if ($stmt -> execute()) {
			$this -> data = $stmt -> fetchAll(PDO::FETCH_ASSOC);
		} else {
			include_once "Email.php";
			new Email('failed', 'to get points of task points', $this->id);
		}
	}

	function createMatrix() {
		$trueRowNumb = count($this -> base);
		$dataRowNumb = count($this -> data);

		$weightArray = array();

		// create an n*m matrix, where m is the number of ground truth events and n is the number of entered data 
		for ($i = 0; $i < $trueRowNumb; $i++) {
			for ($j = 0; $j < $dataRowNumb; $j++) {
				//calculate the weights between each row and column
				$weightArray[$j][$i] = $this -> calculateWeigth($i, $j);
			}
		}

		//select the maximum value in the datamatrix.
		for ($i = 0; $i < $trueRowNumb; $i++) {
			$max = $this -> recursive_array_max($weightArray);
			//if the biggest value in the matrix is greater than -1. allocathe the point to the correlated ground thruth point
			if ($max > -1) {
				$index = $this -> searchIndex($max, $weightArray);
				$this -> rating[$index['column']] = $weightArray[$index['column']][$index['row']];
				$weightArray = $this -> deleteRow($weightArray, $index['row']);
				$weightArray = $this -> deleteCol($weightArray, $index['column']);
			}
		}
		//calculate the missed events of the ground truth
		$missed = $this -> calculateMissed();
		new UpdateValues($this -> data, $this -> rating, $missed, $this -> id);
	}

	function calculateMissed() {
		// missed events = ground truth - not number of rated events
		return count($this -> base) - count($this -> rating);
	}

	function deleteRow($weightArray, $index) {
		//set the row used to small values
		for ($i = 0; $i < count($weightArray); $i++) {
			$weightArray[$i][$index] = -100;
		}
		return $weightArray;
	}

	function deleteCol($array, $offset) {
		//set the coloms used to small values
		for ($i = 0; $i < count($array[0]); $i++) {
			$array[$offset][$i] = -100;
		}
		return $array;
	}

	function searchIndex($max, $weightArray) {
		for ($i = 0; $i <= count($weightArray); $i++) {
			if (in_array($max, $weightArray[$i])) {
				$index = array_search($max, $weightArray[$i]);
				return array('column' => $i, 'row' => $index);
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
		if (isset($this -> base[$trueIndex])) {
			$time = $this -> calculateTime($trueIndex, $dataIndex);
			$team = $this -> calculateTeam($trueIndex, $dataIndex);
			$event = $this -> calculateEvent($trueIndex, $dataIndex);
			$position = $this -> calculatePosition($trueIndex, $dataIndex);
			return ($time + $team + $event + $position) / 4;
		}
	}

	function calculateTime($trueIndex, $dataIndex) {
		// calculating the time distance
		$dataTime = $this -> data[$dataIndex]['Time'];
		$trueTime = $this -> base[$trueIndex]['Time'];

		//+-1 sec is accepted (=-1)
		return 1 - 2 * abs($dataTime - $trueTime);
	}

	function calculateTeam($trueIndex, $dataIndex) {
		// calculating the team distance with -1,1 if equal or not
		$dataTeam = $this -> data[$dataIndex]['team_id'];
		$trueTeam = $this -> base[$trueIndex]['team_id'];
		if ($dataTeam == $trueTeam) {
			return 1;
		} else {
			return -1;
		}
	}

	function calculateEvent($trueIndex, $dataIndex) {
		//calculate the event distance with -1,1 if equal or not.
		$dataEvent = $this -> data[$dataIndex]['type_id'];
		$trueEvent = $this -> base[$trueIndex]['type_id'];
		if ($dataEvent == $trueEvent) {
			return 1;
		} else {
			return -1;
		}
	}

	function calculatePosition($trueIndex, $dataIndex) {
		//calculate the positional distance between the data and ground truth
		$dataPositionX = $this -> base[$trueIndex]['trackedPointX'];
		$dataPositionY = $this -> base[$trueIndex]['trackedPointY'];

		$truePositionX = $this -> base[$trueIndex]['trackedPointX'];
		$truePositionY = $this -> base[$trueIndex]['trackedPointY'];

		$distance = sqrt(pow(abs($dataPositionX) - abs($truePositionX), 2) + pow(abs($dataPositionY) - abs($truePositionY), 2));
		$maxDistance = 20;
		if ($distance < $maxDistance) {
			$rating = 1 - pow($distance / $maxDistance, 2);
		} else {
			$rating = 1 - ($distance / $maxDistance);
		}

		return $rating;
	}

	function timeToSeconds($min, $sec, $msec) {
		return (floatval($min) * 60) + floatval($sec) + floatval('0.' . $msec);
	}

}
?>