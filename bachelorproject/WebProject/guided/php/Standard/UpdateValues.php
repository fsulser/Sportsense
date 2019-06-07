<?php
class UpdateValues {
	private $DB, $data, $rating, $missed, $id;
	function UpdateValues($data, $rating, $missed, $id) {
		$this -> DB =
		require '../Connect.php';
		$this -> id = $id;
		$this -> data = $data;
		$this -> rating = $rating;
		$this -> missed = $missed;
		$this -> UpdateEvents();
	}

	function UpdateEvents() {
		//for all events in the task
		foreach ($this->data as $i => $row) {
			if (!is_null($row['EventId'])) {
				//check wheter event is assigned to calculated event. If it is take the calculated rating, otherwise set the rating to -0.5
				if (array_key_exists($i, $this -> rating)) {
					$rating = $this -> rating[$i];
				} else {
					$rating = -0.5;
				}
				//update all events
				$sql = "UPDATE Event SET rating=" . $rating . " WHERE EventId=" . $row['EventId'];
				$stmt = $this -> DB -> prepare($sql);
				if ($stmt -> execute()) {
				} else {
					include_once "Email.php";
					new Email('failed', 'to update event rating with EventId=' . $row['EventId'], $this -> id);
				}
			}
		}
		$this -> updateTask();

	}

	function updateTask() {
		//update the rating of the task.
		$rating = $this -> getTaskRating();
		if (!is_null($this -> data)) {
			if (!empty($this -> data)) {
				//if user has not missed any events and not added any events rate his task with 1
				if ($this -> missed == 0) {
					if (empty($this -> rating)) {
						$rating = 1;
					}
				}
				$sql = "UPDATE Task SET rating =" . $rating . ", isRated=1, missed=" . $this -> missed . " WHERE TaskId=" . $this -> data[0]['TaskId'];
				$stmt = $this -> DB -> prepare($sql);
				if ($stmt -> execute()) {
					$this -> updateUser();
				} else {
					include_once "Email.php";
					new Email('failed', 'update task with id=' . $this -> data[0]['TaskId'] . ' error' . $stmt -> errorInfo(), $this -> id);
				}
			} else {
				include_once "Email.php";
				new Email('failed', 'update task, data is empty error', $this -> id);
			}
		} else {
			include_once "Email.php";
			new Email('failed', 'update task, data is empty', $this -> id);
		}
	}

	function getTaskRating() {
		//calculate the task rating with all rating of events + the number of missed events *-0.5
		$rating = -$this -> missed * 0.5;
		foreach ($this->data as $i => $row) {
			//if a event does belong to a ground truth event take the calculated value. Otherwise set its rating to -0.5
			if (!is_null($row['EventId'])) {
				if (array_key_exists($i, $this -> rating)) {
					$rating = $rating + $this -> rating[$i];
				} else {
					$rating = $rating - 0.5;
				}
			}
		}
		return $rating;
	}

	function updateUser() {
		// update the users rating by the new task rating + the rating of the user as far
		$rating = $this -> getTaskRating();
		$sql = "Update Users set finishedBasic=1, userRating=userRating+" . $rating . " where UID= (Select t.UID from Task t WHERE t.TaskId=" . $this -> data[0]['TaskId'] . ")";
		$stmt = $this -> DB -> prepare($sql);
		if ($stmt -> execute()) {
			$this -> checkforLast();
		} else {
			include_once "Email.php";
			new Email('failed', 'to update user with TaskId=' . $this -> data[0]['TaskId'], $this -> id);
		}
	}

	function checkforLast() {
		//check if the updated event was the last one in this campaign
		$sql = "SELECT Count(*)AS count FROM Task WHERE isRated=0 AND CampaignId=" . $this -> id;
		$stmt = $this -> DB -> prepare($sql);
		if ($stmt -> execute()) {
			$stmt = $stmt -> fetch();
			if ($stmt['count'] == 0) {
				//if it is the last campaign gets updated
				$this -> updateCampaign();
			}
		} else {
			include_once "Email.php";
			new Email('failed', 'to get number of notRated Tasks.', $this -> id);
		}

	}

	function updateCampaign() {
		//update the campaign. set it finished.
		$sql = "Update campaign set finished=1 where CampaignId=" . $this -> id;
		$stmt = $this -> DB -> prepare($sql);
		if ($stmt -> execute()) {
			//send email to user with information that campaign has been finished
			include_once "Email.php";
			new Email('success', '', $this -> id);
		} else {
			include_once "Email.php";
			new Email('failed', 'to update campaign.', $this -> id);
		}
	}

}
?>