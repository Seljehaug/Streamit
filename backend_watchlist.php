<?php
session_start();
header ("Content-Type: application/json");
require_once("connect.php");

// Get user id
$user_id = $_SESSION["user_id"];

if(isset($_POST["title_id"])){
	$title_id = $_POST["title_id"];
	$task = "";

	// Check if title is already in the users' watchlist
	$sql = "SELECT COUNT(*) count FROM watchlists WHERE user_id=? and title_id = ?";
	$stmnt = $db->prepare($sql);
	if (!$stmnt->execute(array($user_id, $title_id))){
		echo json_encode(array("status"=>"error", "message"=>$stmnt->errorInfo()[2]));
		die();
	}
	$result = $stmnt->fetch(PDO::FETCH_OBJ);

	// If yes, remove it from watchlists table
	if($result->count == 1){
		$sql = "DELETE FROM watchlists WHERE user_id=? and title_id=?";
		$stmnt = $db->prepare($sql);
		if (!$stmnt->execute(array($user_id, $title_id))){
			echo json_encode(array("status"=>"error", "message"=>$stmnt->errorInfo()[2]));
			die();
		}

		$task = "delete";
	}
	// If no, add title to the watchlists table
	else {
		$sql = "INSERT INTO watchlists (user_id, title_id) VALUES(?, ?)";
		$stmnt = $db->prepare($sql);
		if (!$stmnt->execute(array($user_id, $title_id))){
			echo json_encode(array("status"=>"error", "message"=>$stmnt->errorInfo()[2]));
			die();
		}

		// Prepare values to be sent back
		$query = "SELECT titles.*, GROUP_CONCAT(genres.name) AS genre_names
		FROM titles
		INNER JOIN genres_in_titles ON genres_in_titles.title_id = titles.title_id
		INNER JOIN genres ON genres_in_titles.genre_id = genres.genre_id
		WHERE titles.title_id = ?";
		$stmnt = $db->prepare($query);
		$stmnt->execute(array($title_id));
		$title = $stmnt->fetch(PDO::FETCH_OBJ);

		$task = "add";
	}


	if($task == "delete"){
		echo json_encode(array("task" => "delete"));
	}
	if($task == "add"){
		// add task to stdClass object title
		$title->{"task"} = $task;
		echo json_encode($title);
	}


}else{
	echo json_encode("NOT SET");
}
