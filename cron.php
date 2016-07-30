<?php
	require_once('include/common.php') ;

	function delete_subtasks(){
		$current_time = time();
		$buffer_time = $current_time - 86400 * 7;
		$GLOBALS['conn']->where("subtask_status","Completed")
						->where("subtask_edited_time",$buffer_time,"<=");

		$subtasks = $GLOBALS['conn']->get(TABLE_SUBTASKS);

		foreach($subtasks as $subtask){
			$GLOBALS['conn']->where("subtask_id",$subtask['subtask_id']);
			if($GLOBALS['conn']->delete(TABLE_SUBTASKS)){
				echo "Successfully deleted<br>";
			}
			else{
				echo "Not deleted<br>";
			}
		}
	}

	function delete_subtopics(){
		$current_time = time();
		$buffer_time = $current_time - 86400 * 7;
		$GLOBALS['conn']->where("subtopic_status","Completed")
						->where("subtopic_edited_time",$buffer_time,"<=");

		$subtopics = $GLOBALS['conn']->get(TABLE_SUBTOPICS);

		foreach($subtopics as $subtopic){
			$GLOBALS['conn']->where("subtopic_id",$subtopic['subtopic_id']);
			if($GLOBALS['conn']->delete(TABLE_SUBTOPICS)){
				echo "Successfully deleted<br>";
			}
			else{
				echo "Not deleted<br>";
			}
		}
	}

	function delete_folders(){
		$current_time = time();
		$buffer_time = $current_time - 86400 * 30;
		$GLOBALS['conn']->where("expenses_status","Completed")
						->where("folder_edited_time",$buffer_time,"<=");

		$folders = $GLOBALS['conn']->get(TABLE_EXPENSES_FOLDER);

		foreach($folders as $folder){
			$GLOBALS['conn']->where("expenses_id",$folder['expenses_id']);
			if($GLOBALS['conn']->delete(TABLE_EXPENSES_FOLDER)){
				echo "Successfully deleted<br>";
			}
			else{
				echo "Not deleted<br>";
			}
		}
	}

	function delete_reminders(){
		$current_time = time();
		$buffer_time = $current_time - 86400 * 3;
		$GLOBALS['conn']->where("reminder_status","Completed")
						->where("reminder_edited_time",$buffer_time,"<=");

		$reminders = $GLOBALS['conn']->get(TABLE_REMINDERS);

		foreach($reminders as $reminder){
			$GLOBALS['conn']->where("reminder_id",$reminder['reminder_id']);
			if($GLOBALS['conn']->delete(TABLE_REMINDERS)){
				echo "Successfully deleted<br>";
			}
			else{
				echo "Not deleted<br>";
			}
		}
	}

	function reminder_status(){
		$current_time = time();
		$GLOBALS['conn']->where("reminder_status","Ongoing")
						->where("reminder_time",$current_time,"<=");

		$reminders = $GLOBALS['conn']->get(TABLE_REMINDERS);

		foreach($reminders as $reminder){
			$data_reminder = Array("reminder_status"=>"Completed");

			$GLOBALS['conn']->where('reminder_id', $reminder['reminder_id']);
			$id = $GLOBALS['conn']->update(TABLE_REMINDERS, $data_reminder) ;

			if($id){
				echo "Updated successfully<br>" ;
			}
			else{
				echo "Not updated<br>";
			}

			if($reminder['reminder_yearly'] == 'Yes' || $reminder['reminder_yearly'] == 'yes'){
				$epoch_time =  $reminder['reminder_time'];
		    	$edited_time = new DateTime("@$epoch_time");
		    	$edited_time = $edited_time->format('m/d/y');

		    	$remaining = substr($edited_time,0,6);
		    	$year = substr($edited_time,6);
		    	$year++;

		    	$new_date = $remaining;
		    	$new_date .= $year;

		    	$new_time = strtotime($new_date) + 3600 * 12;

		    	$data_reminder = Array(
							"reminder_name" => $reminder['reminder_name'],
							"reminder_insert_time" => time(),
							"reminder_edited_time" => time(),
							"reminder_time" => $new_time,
							"reminder_yearly"=> "Yes",
							"reminder_status"=>"Ongoing"
							);

				$id = $GLOBALS['conn']->insert(TABLE_REMINDERS,$data_reminder) ; 

				if($id){
					echo "Entry was created . Id=" . $id . "<br>";
				}
				else{
					echo "Entry was not created " . $GLOBALS['conn']->getLastError() ."<br>"; 
				}
			}
		}
	}

	delete_subtasks();
	delete_subtopics();
	delete_folders();
	delete_reminders();
	reminder_status();

	$current_time = time() + 19800;
	$current_time = new DateTime("@$current_time");
    $update_time = $current_time->format('H:i:s, F jS, Y');
	echo $update_time."<br>";
?>