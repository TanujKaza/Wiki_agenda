<?php
	require_once('MysqliDb.php') ;

	ini_set("error_reporting", E_ALL);
	ini_set("display_errors", 1);

	DEFINE('DB_HOST','localhost');
	DEFINE('DB_USER','root');
	DEFINE('DB_PASSWORD','tangoalpha77151');
	DEFINE('DB_NAME','wiki_look');

	DEFINE('TABLE_TOPICS','topics');
	DEFINE('TABLE_SUBTOPICS','subtopics');
	DEFINE('TABLE_TASKS','tasks');
	DEFINE('TABLE_SUBTASKS','subtasks');
	DEFINE('TABLE_EXPENSES_FOLDER','expenses_folder');
	DEFINE('TABLE_EXPENSES_ENTRY','expenses_entry');
	DEFINE('TABLE_REMINDERS','reminders'); 

	$conn = new Mysqlidb (DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

	function print_response($data){
		echo "<pre>";
		echo print_r($data);
		echo "</pre>";
	}   

?>