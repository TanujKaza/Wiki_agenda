<?php
	require_once('include/common.php') ;

	function data_entry_tasks(){
		$data_task = Array (
					"task_name" => "Miscellaneous",
					"task_edited_time" => time(),
					"task_insert_time"=> time(),
					"task_status" => "Ongoing"
							);					

		$id = $GLOBALS['conn']->insert(TABLE_TASKS,$data_task) ; 

		if($id){
			echo "Task was created . Id=" . $id . "<br>";
		}
		else{
			echo "Task was not created " . $GLOBALS['conn']->getLastError() ."<br>"; 
		}
	}

	function data_entry_topics(){
		$data_topic = Array (
					"topic_name" => "Computer Science",
					"topic_edited_time" => time(),
					"topic_insert_time"=> time(),
					"topic_status" => "Ongoing"
							);					

		$id = $GLOBALS['conn']->insert(TABLE_TOPICS,$data_topic) ; 

		if($id){
			echo "Topic was created . Id=" . $id . "<br>";
		}
		else{
			echo "Topic was not created " . $GLOBALS['conn']->getLastError() ."<br>"; 
		}

	}

	function data_entry_subtasks(){
		$data_subtask = Array (
					"subtask_name" => "Complete the whiplist",
					"subtask_edited_time" => time(),
					"subtask_insert_time"=> time(),
					"subtask_status" => "Completed",
					"subtask_status_desc" => "Will happen in the next few days",
					"subtask_due_date" => 1467331200 , 
					"fk_task_id" => "1"
							);					

		$id = $GLOBALS['conn']->insert(TABLE_SUBTASKS,$data_subtask) ; 

		if($id){
			echo "Subtask was created . Id=" . $id . "<br>";
		}
		else{
			echo "Subtask was not created " . $GLOBALS['conn']->getLastError() ."<br>"; 
		}
	}

	function data_entry_subtopics(){
		$data_subtopic = Array (
					"subtopic_name" => "Umang Shah's Slides",
					"subtopic_edited_time" => time(),
					"subtopic_insert_time"=> time(),
					"subtopic_status" => "Ongoing",
					"subtopic_status_desc" => "Will happen in the next few days", 
					"fk_topic_id" => "7"
							);					

		$id = $GLOBALS['conn']->insert(TABLE_SUBTOPICS,$data_subtopic) ; 

		if($id){
			echo "Subtopic was created . Id=" . $id . "<br>";
		}
		else{
			echo "Subtopic was not created " . $GLOBALS['conn']->getLastError() ."<br>"; 
		}
	}

	function data_entry_expensesfolder(){
		$data_folder = Array(
							"expenses_folder_name" => "Miscellaneous",
							"folder_insert_time" => time(),
							"folder_edited_time" => time(),
							"expenses_status" => "Ongoing",
							"expenses_budget" => 0,
							"expenses_total_amount" => 0
							);

		$id = $GLOBALS['conn']->insert(TABLE_EXPENSES_FOLDER,$data_folder) ; 

		if($id){
			echo "Folder was created . Id=" . $id . "<br>";
		}
		else{
			echo "Folder was not created " . $GLOBALS['conn']->getLastError() ."<br>"; 
		}
	}

	function data_entry_expenses(){
		$data_expenses = Array(
							"expenses_reason" => "Travel expenses",
							"expenses_insert_time" => time(),
							"expenses_amount" => 200,
							"fk_folder_id"=>3
							);
		$id = $GLOBALS['conn']->insert(TABLE_EXPENSES_ENTRY,$data_expenses) ; 

		if($id){
			echo "Entry was created . Id=" . $id . "<br>";
		}
		else{
			echo "Entry was not created " . $GLOBALS['conn']->getLastError() ."<br>"; 
		}
	}

	function data_entry_reminders(){
		$data_reminder = Array(
							"reminder_name" => "Happy Birthday!",
							"reminder_insert_time" => time(),
							"reminder_edited_time" => time(),
							"reminder_time" => time() + 90000,
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

	function get_home_screen(){
		$current_time = time();
		$current_time_buffer = time() - 86400;
		$buffer_time = time() + 86400 * 10;
		$GLOBALS['conn']->where("reminder_time",$buffer_time,"<=") ;
		$GLOBALS['conn']->where("reminder_time",$current_time_buffer,">=") ;
		$GLOBALS['conn']->orderBy("reminder_time","Asc");
      	$reminders = $GLOBALS['conn']->get(TABLE_REMINDERS) ;

      	$display ="";

      	$display .= "<table class='table table-bordered table-hover table-striped display' id='reminder_table_home'>
              		<thead>
		                <tr>
			                <th class='col-md-8' style='text-align:center;'>Reminder</th>
			                <th class='col-md-2' style='text-align:center;'>Time</th>
			                <th class='col-md-2' style='text-align:center;'>Date</th>
		                </tr>
		            </thead>
		            <tbody>";

		$GMT_conversion = 19800 ;
		foreach($reminders as $reminder){
			$epoch_time =  $reminder['reminder_time'] + $GMT_conversion ;
    		$current_time = new DateTime("@$epoch_time");
    		$reminder_time = $current_time->format('H:i');
    		$reminder_date = $current_time->format('jS F, Y');

		    $display .= "<tr class='gradeA' id='reminderrow_home'>
				            <td><strong>" . $reminder['reminder_name'] . "</strong></td>				            
				            <td class='r_time_home' id='r_time_home' style='text-align:center;'>" . $reminder_time ."</td> 
				            <td class='r_date_home' id='r_date_home' style='text-align:center;'>" . $reminder_date ."</td>  
		              </tr>" ;
		}

		$display .= "</tbody>
		            <tfoot>
		            	<tr>
		            		<th style='text-align:center;'>Reminder</th>
			                <th style='text-align:center;'>Time</th>
			                <th style='text-align:center;'>Date</th>
		               	</tr> 
		            </tfoot>
		            </table>
		            " ;

		$display .= "<br><br>";

		$GLOBALS['conn']->where("subtask_status","Ongoing") ;
		$GLOBALS['conn']->orderBy("subtask_due_date","Asc");
      	$subtasks = $GLOBALS['conn']->get(TABLE_SUBTASKS) ;

		$display .= "<table class='table table-bordered table-hover table-striped display' id='subtask_table_home'>
              		<thead>
		                <tr>
			                <th class='col-md-6' style='text-align:center;'>Task</th>
			                <th class='col-md-4' style='text-align:center;'>Comments</th>
			                <th class='col-md-2' style='text-align:center;'>Due on</th>
		                </tr>
		            </thead>
		            <tbody>";

		foreach($subtasks as $subtask){
			if($subtask['subtask_due_date']){
		    	$epoch_time =  $subtask['subtask_due_date'] + $GMT_conversion ;
		    	$due_date = new DateTime("@$epoch_time");
		    	$due_date = $due_date->format('jS F, Y');
		    }
		    else{
		    	$due_date = "-" ;
		    }

			$display .= "<tr class='gradeA' id='taskrow_home'>
					            <td><strong>" . $subtask['subtask_name'] . "</strong></td>
					            <td>" . $subtask['subtask_status_desc'] . "</td> 
					            <td class='subtask_time_home' id='subtask_time_home 'style='text-align:center;'>" . $due_date ."</td> 
			              </tr>" ;
		}

		$display .= "</tbody>
		            <tfoot>
		            	<tr>
		            		<th style='text-align:center;'>Task</th>
			                <th style='text-align:center;'>Comments</th>
			                <th style='text-align:center;'>Due on</th>
		               	</tr> 
		            </tfoot>
		            </table>
		            " ;

		$display .= "<br><br>";

		$GLOBALS['conn']->where("subtopic_status","Completed") ;
		$GLOBALS['conn']->orderBy("subtopic_edited_time","Asc");
      	$subtopics = $GLOBALS['conn']->get(TABLE_SUBTOPICS) ;

      	$display .= "<table class='table table-bordered table-hover table-striped display' id='subtopic_table_home'>
              		<thead>
		                <tr>
			                <th class='col-md-6' style='text-align:center;'>Topic</th>
			                <th class='col-md-4' style='text-align:center;'>Comments</th>
			                <th class='col-md-2' style='text-align:center;'>Last Edited</th>
		                </tr>
		            </thead>
		            <tbody>";

		foreach($subtopics as $subtopic){
			$epoch_time =  $subtopic['subtopic_edited_time'] + $GMT_conversion ;
	    	$edited_time = new DateTime("@$epoch_time");
	    	$edited_time = $edited_time->format('jS F, Y');
		    
			$display .="<tr class='gradeA' id='subtopicrow_home'>
					            <td><strong>" . $subtopic['subtopic_name'] . "</strong></td>
					            <td>" . $subtopic['subtopic_status_desc'] . "</td> 
					            <td style='text-align:center;'>" . $edited_time ."</td> 
			              </tr>" ;
		}

		$display .= "</tbody>
		            <tfoot>
		            	<tr>
		            		<th style='text-align:center;'>Topic</th>
			                <th style='text-align:center;'>Comments</th>
			                <th style='text-align:center;'>Last Edited</th>
		               	</tr> 
		            </tfoot>
		            </table>";

		$display .= "<br><br>" ;
		echo $display;
	}

	function get_tasks($task_id,$task_status="Ongoing"){
		$GLOBALS['conn']->where("fk_task_id",$task_id) ;
		$GLOBALS['conn']->orderBy("subtask_due_date","Asc");
      	$subtasks = $GLOBALS['conn']->get(TABLE_SUBTASKS) ;

      	$display="
			      <a href='#' class='btn btn-success pull-right' style='margin-right:20px;margin-bottom:20px;' data-toggle='modal' data-target='#myModalsubtask' id='add_subtask_sign'>
			          <span class='glyphicon glyphicon-plus' id='add_subtask_symbol'></span> 
			        </a>
      			  <table class='table table-bordered table-hover table-striped display' id='task_table'>
              		<thead>
		                <tr>
		                	<th><i class='fa fa-check-square-o finish-task fa-square-o'></i></th>
			                <th style='text-align:center;'>Task Name</th>
			                <th style='text-align:center;'>Comments</th>
			                <th style='width:200px;text-align:center;'>Due On</th>
			                <th style='text-align:center;'>Status</th>
		                </tr>
		            </thead>
		            <tbody>";

    	$display_comp="";
    	$count_ongoing = 0;
    	$count_completed = 0;
    	$GMT_conversion = 19800 ;

		foreach($subtasks as $subtask){
			if($subtask['subtask_due_date']){
		    	$epoch_time =  $subtask['subtask_due_date'] + $GMT_conversion ;
		    	$due_date = new DateTime("@$epoch_time");
		    	$due_date = $due_date->format('jS F, Y');
		    }
		    else{
		    	$due_date = "-" ;
		    }

			if($subtask['subtask_status'] == "Ongoing"){
				$display .="<tr class='gradeA' id='taskrow_".$subtask['subtask_id']."'>
								<td><input type='checkbox' class='checkbox_status_task' id=".$subtask['subtask_id']."></td>
					            <td><strong>" . $subtask['subtask_name'] . "</strong></td>
					            <td>" . $subtask['subtask_status_desc'] . "</td> 
					            <td class='reminder_edit_time input_t_date' id='t_date_edit_".$subtask['subtask_id']."'style='text-align:center;'>" . $due_date ."</td> 
					            <td class='text-danger' style='text-align:center;'>" . $subtask['subtask_status'] ."</td> 
			              </tr>" ;
			    $count_ongoing++ ;
			}
			else if($subtask['subtask_status'] == "Completed"){
				$display_comp .="<tr class='gradeA' id='taskrow_".$subtask['subtask_id']."'>
								<td><input type='checkbox' class='checkbox_status_task' id=".$subtask['subtask_id']."></td>
					            <td><strong>" . $subtask['subtask_name'] . "</strong></td>
					            <td>" . $subtask['subtask_status_desc'] . "</td> 
					            <td style='text-align:center;'>" . $due_date ."</td> 
					            <td class='text-success' style='text-align:center;'>" . $subtask['subtask_status'] ."</td> 
			              </tr>" ;
			    $count_completed++ ;
			}
		}

		if($count_ongoing && $count_completed) $display .= "<tr><td  colspan='5'></td></tr>";

		$display .= $display_comp ;

		$table_footer ="</tbody>
		            <tfoot>
		            	<tr>
		            		<th><i class='fa fa-check-square-o finish-task fa-square-o'></i></th>
			                <th style='text-align:center;'>Task Name</th>
			                <th style='text-align:center;'>Comments</th>
			                <th style='width:200px;text-align:center;'>Due On</th>
			                <th style='text-align:center;'>Status</th>
		               	</tr> 
		            </tfoot>
		            </table>
		            " ;

		$display .= $table_footer ;

		echo $display ."<br><br>";
	}

	function edit_task_status($subtask_id){
		$GLOBALS['conn']->where('subtask_id', $subtask_id);
		$data_initial = $GLOBALS['conn']->get(TABLE_SUBTASKS);

		$task_status = $data_initial[0]['subtask_status'] ;
		$updated_status = "" ;
		if($task_status == "Ongoing"){
			$updated_status = "Completed";
		}
		else if($task_status == "Completed"){
			$updated_status = "Ongoing";
		}

		$data_subtask = Array (
								"subtask_status"=> $updated_status ,
								"subtask_edited_time" => time() 
							);

		$GLOBALS['conn']->where('subtask_id', $subtask_id);
		$id = $GLOBALS['conn']->update(TABLE_SUBTASKS, $data_subtask) ;

		if($id){
			echo "Updated successfully<br>" ;
		}
		else{
			echo "Not updated<br>";
		}
	}

	function add_subtask($task_id,$subtask_name,$subtask_comment,$due_date){
		$data_subtask = Array (
							"fk_task_id" => $task_id ,
							"subtask_name" => $subtask_name ,
							"subtask_status" => "Ongoing" ,
							"subtask_status_desc" => $subtask_comment ,
							"subtask_due_date" => strtotime($due_date) ,
							"subtask_edited_time" => time() , 
							"subtask_insert_time" => time() 
							 );

		$id = $GLOBALS['conn']->insert(TABLE_SUBTASKS,$data_subtask) ; 

		if($id){
			echo "Subtask added succesfully<br>";
		}
		else{
			echo "Failed to add".$GLOBALS['conn']->getLastError()."<br>" ;
		}
	}

	function get_topics($topic_id,$topic_status="Ongoing"){
		$GLOBALS['conn']->where("fk_topic_id",$topic_id) ;
		$GLOBALS['conn']->orderBy("subtopic_edited_time","Desc");
      	$subtopics = $GLOBALS['conn']->get(TABLE_SUBTOPICS) ;

      	$display="
			      <a href='#' class='btn btn-success pull-right' style='margin-right:20px;margin-bottom:20px;' data-toggle='modal' data-target='#myModalsubtopic' id='add_subtopic_sign'>
			          <span class='glyphicon glyphicon-plus' id='add_subtopic_symbol'></span> 
			        </a>
      			  <table class='table table-bordered table-hover table-striped display' id='topic_table'>
              		<thead>
		                <tr>
		                	<th><i class='fa fa-check-square-o finish-task fa-square-o'></i></th>
			                <th style='text-align:center;'>Topic Name</th>
			                <th style='text-align:center;'>Comments</th>
			                <th style='width:200px;text-align:center;'>Last Edited</th>
			                <th style='text-align:center;'>Status</th>
		                </tr>
		            </thead>
		            <tbody>";

    	$display_comp="";
    	$count_ongoing = 0;
    	$count_completed = 0;
    	$GMT_conversion = 19800;

		foreach($subtopics as $subtopic){
	    	$epoch_time =  $subtopic['subtopic_edited_time'] + $GMT_conversion ;
	    	$edited_time = new DateTime("@$epoch_time");
	    	$edited_time = $edited_time->format('jS F, Y');
		    
			if($subtopic['subtopic_status'] == "Ongoing"){
				$display .="<tr class='gradeA' id='topicrow_".$subtopic['subtopic_id']."'>
								<td><input type='checkbox' class='checkbox_status_topic' id=".$subtopic['subtopic_id']."></td>
					            <td><strong>" . $subtopic['subtopic_name'] . "</strong></td>
					            <td>" . $subtopic['subtopic_status_desc'] . "</td> 
					            <td style='text-align:center;'>" . $edited_time ."</td> 
					            <td class='text-danger' style='text-align:center;'>" . $subtopic['subtopic_status'] ."</td> 
			              </tr>" ;
			    $count_ongoing++ ;
			}
			else if($subtopic['subtopic_status'] == "Completed"){
				$display_comp .="<tr class='gradeA' id='topicrow_".$subtopic['subtopic_id']."'>
								<td><input type='checkbox' class='checkbox_status_topic' id=".$subtopic['subtopic_id']."></td>
					            <td><strong>" . $subtopic['subtopic_name'] . "</strong></td>
					            <td>" . $subtopic['subtopic_status_desc'] . "</td> 
					            <td style='text-align:center;'>" . $edited_time ."</td> 
					            <td class='text-success' style='text-align:center;'>" . $subtopic['subtopic_status'] ."</td> 
			              </tr>" ;
			    $count_completed++ ;
			}
		}

		if($count_ongoing && $count_completed) $display .= "<tr><td  colspan='5'></td></tr>";

		$display .= $display_comp ;

		$table_footer ="</tbody>
		            <tfoot>
		            	<tr>
		            		<th><i class='fa fa-check-square-o finish-task fa-square-o'></i></th>
			                <th style='text-align:center;'>Task Name</th>
			                <th style='text-align:center;'>Comments</th>
			                <th style='width:200px;text-align:center;'>Last Edited</th>
			                <th style='text-align:center;'>Status</th>
		               	</tr> 
		            </tfoot>
		            </table>
		            " ;

		$display .= $table_footer ;

		echo $display ."<br><br>";
	}

	function edit_topic_status($subtopic_id){
		$GLOBALS['conn']->where('subtopic_id', $subtopic_id);
		$data_initial = $GLOBALS['conn']->get(TABLE_SUBTOPICS);

		$topic_status = $data_initial[0]['subtopic_status'] ;
		$updated_status = "" ;
		if($topic_status == "Ongoing"){
			$updated_status = "Completed";
		}
		else if($topic_status == "Completed"){
			$updated_status = "Ongoing";
		}

		$data_subtopic = Array (
								"subtopic_status"=> $updated_status ,
								"subtopic_edited_time" => time() 
							);

		$GLOBALS['conn']->where('subtopic_id', $subtopic_id);
		$id = $GLOBALS['conn']->update(TABLE_SUBTOPICS, $data_subtopic) ;

		if($id){
			echo "Updated successfully<br>" ;
		}
		else{
			echo "Not updated<br>";
		}
	}

	function add_subtopic($topic_id,$subtopic_name,$subtopic_comment){
		$data_subtopic = Array (
							"fk_topic_id" => $topic_id ,
							"subtopic_name" => $subtopic_name ,
							"subtopic_status" => "Ongoing" ,
							"subtopic_status_desc" => $subtopic_comment ,
							"subtopic_edited_time" => time() , 
							"subtopic_insert_time" => time() 
							 );

		$id = $GLOBALS['conn']->insert(TABLE_SUBTOPICS,$data_subtopic) ; 

		if($id){
			echo "Subtopic added succesfully<br>";
		}
		else{
			echo "Failed to add".$GLOBALS['conn']->getLastError()."<br>" ;
		}
	}

	function get_expenses($folder_id=""){
		$GLOBALS['conn']->join(TABLE_EXPENSES_FOLDER." ef" , "ef.expenses_id = ee.fk_folder_id" , "LEFT") ;
        if(!$folder_id){
        	$GLOBALS['conn']->where("ef.expenses_status","Ongoing");
        }
        else{
        	$GLOBALS['conn']->where("ef.expenses_id",$folder_id);
        }
        $rows = $GLOBALS['conn']->get(TABLE_EXPENSES_ENTRY." ee");

        $columns = Array('expenses_id','expenses_folder_name');
      	$folders = $GLOBALS['conn']->get(TABLE_EXPENSES_FOLDER,null, $columns);

        $display="<div class='dropdown' id='filter_folder_option'>
				    <button class='btn btn-primary dropdown-toggle' type='button' data-toggle='dropdown' id='filter_folder'>Filter By Folder
				    <span class='caret'></span></button>
				    <ul class='dropdown-menu'>";

		foreach($folders as $folder){
			$display.="<li><a href='#' class='folder_option_id' id='filter_option_".$folder['expenses_id']."'>".$folder['expenses_folder_name']."</a></li>";
		}

		$display.="</ul>
				  </div>
			      <a href='#' class='btn btn-success pull-right' style='margin-right:20px;margin-bottom:20px;' data-toggle='modal' data-target='#myModalexpense' id='add_expense_sign'>
			          <span class='glyphicon glyphicon-plus' id='add_expense_symbol'></span> 
			        </a>
      			  <table class='table table-bordered table-hover table-striped display' id='expense_entry_table'>
              		<thead>
		                <tr>
			                <th style='text-align:center;'>Folder</th>
			                <th style='text-align:center;'>Reason</th>
			                <th style='width:200px;text-align:center;'>Time</th>
			                <th style='text-align:center;'>Amount</th>
		                </tr>
		            </thead>
		            <tbody>";
		$GMT_conversion = 19800;
		foreach($rows as $row){
			$epoch_time =  $row['expenses_insert_time'] + $GMT_conversion ;
	    	$insert_time = new DateTime("@$epoch_time");
	    	$insert_time = $insert_time->format('H:i, jS F, Y');

			$display .= "<tr class='gradeA' id='expensesrow_".$row['expenses_entry_id']."'>
								<td>" . $row['expenses_folder_name'] . "</td>
					            <td><strong>" . $row['expenses_reason'] . "</strong></td>
					            <td style='text-align:center;'>" . $insert_time ."</td> 
					            <td class='text-danger' style='text-align:center;'>₹ " . $row['expenses_amount'] ."</td> 
			              </tr>" ;
		}	
		
		$table_footer ="</tbody>
		            <tfoot>
		            	<tr>
			                <th style='text-align:center;'>Folder</th>
			                <th style='text-align:center;'>Reason</th>
			                <th style='width:200px;text-align:center;'>Time</th>
			                <th style='text-align:center;'>Amount</th>
		               	</tr> 
		            </tfoot>
		            </table>
		            " ;

		$display .= $table_footer ;

		echo $display ."<br><br>";
	}

	function add_expense($folder_id,$expense_reason,$expense_amount){
		$data_expense = Array(
							"expenses_reason"=>$expense_reason,
							"expenses_insert_time"=>time(),
							"expenses_amount"=>$expense_amount,
							"fk_folder_id"=>$folder_id
							);
		$id = $GLOBALS['conn']->insert(TABLE_EXPENSES_ENTRY,$data_expense) ; 

		if($id){
			echo "Expense added succesfully<br>";
		}
		else{
			echo "Failed to add".$GLOBALS['conn']->getLastError()."<br>" ;
		}

		$GLOBALS['conn']->where('expenses_id',$folder_id);
	    $folder =$GLOBALS['conn']->get(TABLE_EXPENSES_FOLDER,null,'expenses_total_amount');

	    $total_amount = $folder[0]['expenses_total_amount'] + $expense_amount;

		$data_folder = Array(
							"expenses_total_amount"=> $total_amount
						);

		$GLOBALS['conn']->where('expenses_id',$folder_id);
		$id = $GLOBALS['conn']->update(TABLE_EXPENSES_FOLDER, $data_folder);

		if($id){
			echo "Updated successfully<br>" ;
		}
		else{
			echo "Not updated<br>";
		}
	}

	function get_folder(){
		$folders = $GLOBALS['conn']->get(TABLE_EXPENSES_FOLDER);
		$display ="";

		/*$display .= "<div class='dropdown' id='export_folder_option'>
				    <button class='btn btn-primary dropdown-toggle ' type='button' data-toggle='dropdown' id='export_folder'>Export Folder
				    <span class='caret'></span></button>
				    <ul class='dropdown-menu'>";

		foreach($folders as $folder){
			$display.="<li><a href='#' class='export_folder_id' id='export_folder_".$folder['expenses_id']."' data-toggle='modal' data-target='#myModalexport_folder'>".$folder['expenses_folder_name']."</a></li>";
		}

		$display.="</ul>
				  </div>";*/

		$display .= "<div class='dropdown' id='export_folder_option'>
				    <button class='btn btn-primary dropdown-toggle ' type='button' data-toggle='dropdown' id='export_folder'>Export Folder
				    <span class='caret'></span></button>
				    <ul class='dropdown-menu'>
				    <li><a href='exportexcel.php' class='export_folder_excel' id='export_folder_excel' target='_self'>Excel</a></li>
				    <li><a href='exportpdf.php' class='export_folder_pdf' id='export_folder_pdf' target='_blank'>PDF</a></li></ul></div>";

		$display .="
			      <a href='#' class='btn btn-success pull-right' style='margin-right:20px;margin-bottom:20px;' data-toggle='modal' data-target='#myModalfolder' id='add_folder_sign'>
			          <span class='glyphicon glyphicon-plus' id='add_folder_symbol'></span> 
			        </a>
      			  <table class='table table-bordered table-hover table-striped display' id='expense_folder_table'>
              		<thead>
		                <tr>
		                	<th><i class='fa fa-check-square-o finish-task fa-square-o' style='width:10px;'></i></th>
			                <th style='text-align:center;'>Folder</th>
			                <th style='text-align:center;'>Budget</th>
			                <th style='text-align:center;'>Expenditure</th>
			                <th style='text-align:center;'>Remainder</th>
			                <th style='text-align:center;'>Status</th>
		                </tr>
		            </thead>
		            <tbody>";

		$display_comp="";
		$count_ongoing=0;
		$count_completed=0;

		foreach($folders as $folder){
			$remainder = $folder['expenses_budget'] - $folder['expenses_total_amount'];
			if($folder['expenses_status'] == "Ongoing"){
				$display .="<tr class='gradeA' id='folderrow_".$folder['expenses_id']."'>
								<td><input type='checkbox' class='checkbox_status_folder' id=".$folder['expenses_id']."></td>
					            <td style='text-align:center;'><strong>" . $folder['expenses_folder_name'] . "</strong></td>
					            <td class='budget_edit take_input' style='text-align:center;' id='budget_edit_".$folder['expenses_id']."'>₹ " . $folder['expenses_budget'] . "</td> 
					            <td style='text-align:center;'>₹ " . $folder['expenses_total_amount'] ."</td> 
					            <td style='text-align:center;'>₹ " . $remainder ."</td>
					            <td class='text-success' style='text-align:center;'>" . $folder['expenses_status'] ."</td> 
			              </tr>" ;
			    $count_ongoing++ ;
			}
			else if($folder['expenses_status'] == "Completed"){
				$display_comp .="<tr class='gradeA' id='folderrow_".$folder['expenses_id']."'>
								<td><input type='checkbox' class='checkbox_status_folder' id=".$folder['expenses_id']."></td>
					            <td style='text-align:center;'><strong>" . $folder['expenses_folder_name'] . "</strong></td>
					            <td class='budget_edit' style='text-align:center;' id='budget_edit_".$folder['expenses_id']."'>₹ " . $folder['expenses_budget'] . "</td> 
					            <td style='text-align:center;'>₹ " . $folder['expenses_total_amount'] ."</td> 
					            <td style='text-align:center;'>₹ " . $remainder ."</td>
					            <td class='text-danger' style='text-align:center;'>" . $folder['expenses_status'] ."</td> 
			              </tr>" ;
			    $count_completed++ ;
			}
		}	
		
		if($count_ongoing && $count_completed) $display .= "<tr><td  colspan='5'></td></tr>";

		$display .= $display_comp ;

		$table_footer ="</tbody>
		            <tfoot>
		            	<tr>
			                <th><i class='fa fa-check-square-o finish-task fa-square-o'></i></th>
			                <th style='text-align:center;'>Folder</th>
			                <th style='text-align:center;'>Budget</th>
			                <th style='text-align:center;'>Expenditure</th>
			                <th style='text-align:center;'>Remainder</th>
			                <th style='text-align:center;'>Status</th>
		               	</tr> 
		            </tfoot>
		            </table>
		            " ;

		$display .= $table_footer ;

		echo $display ."<br><br>";
	}

	function edit_folder_status($folder_id){
		$GLOBALS['conn']->where('expenses_id', $folder_id);
		$data_initial = $GLOBALS['conn']->get(TABLE_EXPENSES_FOLDER);

		$folder_status = $data_initial[0]['expenses_status'] ;
		$updated_status = "" ;
		if($folder_status == "Ongoing"){
			$updated_status = "Completed";
		}
		else if($folder_status == "Completed"){
			$updated_status = "Ongoing";
		}

		$data_folder = Array (
								"expenses_status"=> $updated_status ,
								"folder_edited_time" => time() 
							);

		$GLOBALS['conn']->where('expenses_id', $folder_id);
		$id = $GLOBALS['conn']->update(TABLE_EXPENSES_FOLDER, $data_folder) ;

		if($id){
			echo "Updated successfully<br>" ;
		}
		else{
			echo "Not updated<br>";
		}
	}

	function edit_budget($addition,$folder_id){
		$GLOBALS['conn']->where('expenses_id', $folder_id);
		$data_initial = $GLOBALS['conn']->get(TABLE_EXPENSES_FOLDER,null,'expenses_budget');

		$budget = $addition + $data_initial[0]['expenses_budget'];

		$data_folder=Array(
							"expenses_budget" => $budget,
							"folder_edited_time" => time()
						);
		$GLOBALS['conn']->where('expenses_id', $folder_id);
		$id = $GLOBALS['conn']->update(TABLE_EXPENSES_FOLDER, $data_folder) ;

		if($id){
			echo "Updated successfully<br>" ;
		}
		else{
			echo "Not updated<br>";
		}

	}

	function add_folder($folder_name,$budget){
		$data_folder = Array(
							"expenses_folder_name"=> $folder_name,
							"folder_insert_time"=>time(),
							"folder_edited_time"=>time(),
							"expenses_total_amount"=>0,
							"expenses_budget"=>$budget,
							"expenses_status"=>"Ongoing"
							);
		$id = $GLOBALS['conn']->insert(TABLE_EXPENSES_FOLDER,$data_folder) ; 

		if($id){
			echo "Folder added succesfully<br>";
		}
		else{
			echo "Failed to add".$GLOBALS['conn']->getLastError()."<br>" ;
		}

	}

	function get_reminders($reminder_status){
		$GLOBALS['conn']->where('reminder_status',$reminder_status);
		$GLOBALS['conn']->orderBy("reminder_time","Asc");
		$reminders = $GLOBALS['conn']->get(TABLE_REMINDERS);

		$reminder_heading ="";
		if($reminder_status == "Ongoing"){
			$display ="
			      <a href='#' class='btn btn-success pull-right' style='margin-right:20px;margin-bottom:20px;' data-toggle='modal' data-target='#myModalreminder' id='add_reminder_sign'>
			          <span class='glyphicon glyphicon-plus' id='add_reminder_symbol'></span> 
			        </a>";
			$reminder_column=" <th class='col-md-8' style='text-align:center;'>Reminders</th>";
		}
		else{
			$display ="";
			$reminder_column=" <th class='col-md-8' style='text-align:center;'>Past Reminders</th>";
		}
      	
      	$display.= "<table class='table table-bordered table-hover table-striped display' id='reminder_table'>
              		<thead>
		                <tr>
		                	<th><i class='fa fa-check-square-o finish-task fa-square-o' style='width:10px;'></i></th>".$reminder_column."
			                <th class='col-md-2' style='text-align:center;'>Time</th>
			                <th class='col-md-2' style='text-align:center;'>Date</th>
		                </tr>
		            </thead>
		            <tbody>"; 
		$GMT_conversion = 19800;
		foreach($reminders as $reminder){
				$epoch_time =  $reminder['reminder_time'] + $GMT_conversion ;
	    		$current_time = new DateTime("@$epoch_time");
	    		$reminder_time = $current_time->format('H:i');
	    		$reminder_date = $current_time->format('jS F, Y');

			    $display .= "<tr class='gradeA' id='reminderrow_".$reminder['reminder_id']."'>
								<td><input type='checkbox' class='checkbox_status_reminder' id=".$reminder['reminder_id']."></td>
					            <td><strong>" . $reminder['reminder_name'] . "</strong></td>				            
					            <td class='edit_reminder_time input_time' id='r_time_edit_".$reminder['reminder_id']."' style='text-align:center;'>" . $reminder_time ."</td> 
					            <td class='edit_reminder_date input_date' id='r_date_edit_".$reminder['reminder_id']."' style='text-align:center;'>" . $reminder_date ."</td>  
			              </tr>" ;
		}
		$table_footer ="</tbody>
		            <tfoot>
		            	<tr>
			                <th><i class='fa fa-check-square-o finish-task fa-square-o' style='width:10px;'></i></th>".$reminder_column."
			                <th style='text-align:center;'>Time</th>
			                <th style='text-align:center;'>Date</th>
		               	</tr> 
		            </tfoot>
		            </table>
		            " ;

		$display .= $table_footer ;

		echo $display ."<br><br>";

	}

	function edit_reminder_status($reminder_id){
		$GLOBALS['conn']->where('reminder_id', $reminder_id);
		$data_initial = $GLOBALS['conn']->get(TABLE_REMINDERS);

		$reminder_status = $data_initial[0]['reminder_status'] ;
		$updated_status = "" ;
		if($reminder_status == "Ongoing"){
			$updated_status = "Completed";
		}
		else if($reminder_status == "Completed"){
			$updated_status = "Ongoing";
		}

		$data_reminder = Array (
								"reminder_status"=> $updated_status ,
								"reminder_edited_time" => time() 
							);

		$GLOBALS['conn']->where('reminder_id', $reminder_id);
		$id = $GLOBALS['conn']->update(TABLE_REMINDERS, $data_reminder) ;

		if($id){
			echo "Updated successfully<br>" ;
		}
		else{
			echo "Not updated<br>";
		}
	}

	function add_reminder($reminder_name,$reminder_date,$reminder_hours,$reminder_minutes,$reminder_yearly){
		$epoch_time = strtotime($reminder_date) + $reminder_hours * 3600 + $reminder_minutes * 60;
		$data_reminder = Array (
								"reminder_name"=>$reminder_name,
								"reminder_time"=>$epoch_time,
								"reminder_status"=> "Ongoing" ,
								"reminder_yearly"=>$reminder_yearly,
								"reminder_insert_time"=>time(),
								"reminder_edited_time" => time() 
							);
		$id = $GLOBALS['conn']->insert(TABLE_REMINDERS,$data_reminder) ; 

		if($id){
			echo "Reminder added succesfully<br>";
		}
		else{
			echo "Failed to add".$GLOBALS['conn']->getLastError()."<br>" ;
		}
	}

	function edit_rem_time($new_time,$reminder_id){
		$GLOBALS['conn']->where('reminder_id', $reminder_id);
		$data_initial = $GLOBALS['conn']->get(TABLE_REMINDERS);

		$GMT_conversion = 19800;
		/*$epoch_time =  $data_initial[0]['reminder_time'] + $GMT_conversion ;
	    $current_time = new DateTime("@$epoch_time");
	    $reminder_time = $current_time->format('H:i');*/

	    $time_midnight = $data_initial[0]['reminder_time'] - $data_initial[0]['reminder_time'] % 86400;

	    $time_hours = substr($new_time,0,2);
	    $time_minutes = substr($new_time,2);

	    $updated_time = $time_midnight+$time_hours*3600+$time_minutes*60-$GMT_conversion;

	    $data_reminder=Array(
	    					"reminder_time"=>$updated_time,
	    					"reminder_edited_time"=>time()
	    					);
	    $GLOBALS['conn']->where('reminder_id', $reminder_id);
		$id = $GLOBALS['conn']->update(TABLE_REMINDERS, $data_reminder) ;

		if($id){
			echo "Updated successfully<br>" ;
		}
		else{
			echo "Not updated<br>";
		}
	}

	function edit_rem_date($new_date,$reminder_id){
		$GLOBALS['conn']->where('reminder_id', $reminder_id);
		$data_initial = $GLOBALS['conn']->get(TABLE_REMINDERS);

		$GMT_conversion = 19800;
		
		$time_in_seconds = $data_initial[0]['reminder_time'] % 86400;
		$new_date = strtotime($new_date)+$GMT_conversion;

		$updated_time = $new_date+$time_in_seconds;

		$data_reminder=Array(
	    					"reminder_time"=>$updated_time,
	    					"reminder_edited_time"=>time()
	    					);

	    $GLOBALS['conn']->where('reminder_id', $reminder_id);
		$id = $GLOBALS['conn']->update(TABLE_REMINDERS, $data_reminder) ;

		if($id){
			echo "Updated successfully<br>" ;
		}
		else{
			echo "Not updated<br>";
		}
	}

	function edit_task_date($new_date,$task_id){
		$data_subtask=Array(
	    					"subtask_due_date"=>strtotime($new_date),
	    					"subtask_edited_time"=>time()
	    					);

	    $GLOBALS['conn']->where('subtask_id', $task_id);
		$id = $GLOBALS['conn']->update(TABLE_SUBTASKS, $data_subtask) ;

		if($id){
			echo "Updated successfully<br>" ;
		}
		else{
			echo "Not updated<br>";
		}

	}

	function export_title($folder_id){
		$GLOBALS['conn']->where("expenses_id",$folder_id);
		$folder = $GLOBALS['conn']->get(TABLE_EXPENSES_FOLDER);

		$output="";
		$output['data'] = $folder ;
		echo json_encode($output);
	}

	function export_excel($folder_id){
		require_once('../PHPExcel/Classes/PHPExcel.php');
		require_once('include/common.php');

		$filename = "TATA Steel Daily Activity Sheet_";

		header("Content-Type: application/vnd.ms-excel; charset=utf-8");
		header('Content-Disposition: attachment; filename="'.$filename.'.xls"');
		header("Cache-Control: max-age=0");

		$excel = new PHPExcel();

		$objWorkSheet = $excel->createSheet(0)->setTitle("TS-Corp");


		$objWriter = PHPExcel_IOFactory::createWriter($excel, "Excel5");
		$objWriter->save("php://output");
		exit;
	}

	function project_info(){
		$information = "<h1><center>WikiLook</center></h1><h4><center>WikiLook is a to-do list cum reminder web-application developed using HTML,Jquery,PHP and CSS.<br><br>This project has been developed by Tanuj Kaza in the Summer of 2016.<br><br>Any matter can be copied or redistributed without prior permission of the author.<br><br>Feel free to ping me.</center></h4>";

		echo $information;
	}
?>