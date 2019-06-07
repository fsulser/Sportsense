<?php
session_start();
if (!isset($_SESSION['AdminId'])) {
	$arr = array('success' => 2, 'error_msg' => 'Couldn\'t execute query.');
	echo json_encode($arr);
} else {
	$DB = require_once ('config.php');
	$sql = "SELECT c.CampaignId, (SELECT teamName From Teams WHERE v.homeTeam = teamId) as home,(SELECT teamName From Teams WHERE v.awayTeam = teamId) as away, c.number, c.finished, (SELECT COUNT(*) FROM Task WHERE CampaignId = c.CampaignId AND finished=1)AS finishedNumber FROM campaign c LEFT JOIN VideoInformations v ON c.VideoId= v.VideoId";
	$stmt = $DB->prepare($sql);
	if($stmt->execute()){
		$array = $stmt -> fetchAll(PDO::FETCH_ASSOC);
		echo json_encode($array);
	}else{
		$arr = array('success' => 0, 'error_msg' => 'Couldn\'t get Campaigns');
		echo json_encode($arr);
	}
}

?>