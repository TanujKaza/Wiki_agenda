<?php
        require_once('include/common.php') ;
	include('function.php') ;

	if(isset($_REQUEST["action"]) && !empty($_REQUEST["action"])){
		extract($_REQUEST);
		$output="";
		switch ($action) {
			
                        case 'get_task':
                                get_tasks($task_id) ;
                                break;
             
                        case 'edit_task_status':
                                edit_task_status($subtask_id);
                                break;

                        case 'add_subtask':
                                add_subtask($task_id,$subtask_name,$subtask_comment,$due_date);
                                break;

                        case 'get_topic':
                                get_topics($topic_id);
                                break;

                        case 'edit_topic_status':
                                edit_topic_status($subtopic_id);
                                break;

                        case 'edit_folder_status':
                                edit_folder_status($folder_id);
                                break;

                        case 'add_subtopic':
                                add_subtopic($topic_id,$subtopic_name,$subtopic_comment);
                                break;

                        case 'get_expenses':
                                get_expenses($folder_id);
                                break;
                        
                        case 'get_folder':
                                get_folder();
                                break;

                        case 'add_expense':
                                add_expense($folder_id,$expense_reason,$expense_amount);
                                break;

                        case 'edit_budget':
                                edit_budget($addition,$folder_id);
                                break;

                        case 'add_folder':
                                add_folder($folder_name,$budget);
                                break;

                        case 'get_reminders':
                                get_reminders($reminder_status);
                                break;

                        case 'get_past_reminders':
                                get_reminders($reminder_status);
                                break;

                        case 'edit_reminder_status':
                                edit_reminder_status($reminder_id);
                                break;

                        case 'add_reminder':
                                add_reminder($reminder_name,$reminder_date,$reminder_hours,$reminder_minutes,$reminder_yearly);
                                break;

                        case 'edit_rem_time':
                                edit_rem_time($new_time,$reminder_id);
                                break;

                        case 'edit_rem_date':
                                edit_rem_date($new_date,$reminder_id);
                                break;

                        case 'edit_task_date':
                                edit_task_date($new_date,$task_id);
                                break;

                        case 'get_home_screen':
                                get_home_screen();
                                break;

                        case 'export_title':
                                export_title($folder_id);
                                break;

                        case 'export_excel':
                                export_excel($folder_id);
                                break;

                        case 'get_project_info':
                                project_info();
                                break;
                                
        		default:
        			# code...
        			break;
		}
	}	
?>



