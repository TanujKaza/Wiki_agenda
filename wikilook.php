<?php
	include('partials/header.php');
	include('function.php') ;
  	require_once('include/common.php') ;
?>

<div id="main_data">
<?php
	get_home_screen() ;
?>
</div>

<div id="parent_data">
<?php
?>
</div>

<input type="hidden" id="task_id_store" value="">
<input type="hidden" id="topic_id_store" value="">

<div id="response_log">
</div>

<!-- model box for add subtask start -->  
<div class="modal fade" id="myModalsubtask" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  
    <div class="modal-dialog" role="document">
        <div class="modal-content">   
          
            <div class="modal-header">
                <h4 class="modal-title" id="add_subtask"><strong>Add Subtask</strong></h4>
                <button type="button" class="btn btn-default pull-right" data-dismiss="modal" id="close_add_subtask">Close</button>
            </div>

            <div class="modal-body clearfix" id="disablecheck">
                <form method='post' class="subtask" name="subtask" action="" enctype="multipart/form-data">

	          	<div class="col-sm-12 ">
	            	<div id="divNameFormName" class="form-group has-feedback marbot20">
		            	Name:
		            	<input name="subtaskname" id="subtaskname" type="text" class="form-control marbot20" value="" placeholder="Name">
	              	</div>
	            </div>

	            <div class="col-sm-12 ">
	              	<div id="divNameFormName" class="form-group has-feedback marbot20">
		            	Comments:
		            	<input name="subtask_comment" id="subtask_comment" type="text" class="form-control marbot20" value="" placeholder="Comment">
		            </div>
	            </div>

	            <div class="col-sm-12" id="divName">
	            	<div id="divNameFormDateDelivery" class="form-group has-feedback marbot20">
	            		Due Date:
		                <input class="form-control marbot20" name="duedate" id="due_date_subtask" type="text" placeholder="Due Date">
		            </div>
	            </div> 

	            <div class="col-sm-12 " align="center">
	            	<button type="button" class="btn btn-success" id="add_subtask_submit" data-dismiss="modal">Add</button>
	            </div>

	          	</form>
            </div> 
        </div>
      
    </div>

</div>
<!-- model box close -->

<!-- model box for add subtopic start -->  
<div class="modal fade" id="myModalsubtopic" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  
    <div class="modal-dialog" role="document">
        <div class="modal-content">   
          
            <div class="modal-header">
                <h4 class="modal-title" id="add_subtopic"><strong>Add Subtopic</strong></h4>
                <button type="button" class="btn btn-default pull-right" data-dismiss="modal" id="close_add_subtopic">Close</button>
            </div>

            <div class="modal-body clearfix" id="disablecheck">
                <form method='post' class="subtopic" name="subtopic" action="" enctype="multipart/form-data">

	          	<div class="col-sm-12 ">
	            	<div id="divNameFormName" class="form-group has-feedback marbot20">
		            	Name:
		            	<input name="subtopicname" id="subtopicname" type="text" class="form-control marbot20" value="" placeholder="Name">
	              	</div>
	            </div>

	            <div class="col-sm-12 ">
	              	<div id="divNameFormName" class="form-group has-feedback marbot20">
		            	Comments:
		            	<input name="subtopic_comment" id="subtopic_comment" type="text" class="form-control marbot20" value="" placeholder="Comment">
		            </div>
	            </div>

	            <div class="col-sm-12 " align="center">
	            	<button type="button" class="btn btn-success" id="add_subtopic_submit" data-dismiss="modal">Add</button>
	            </div>

	          	</form>
            </div> 
        </div>
      
    </div>

</div>
<!-- model box close -->

<!-- model box for add expense start -->  
<div class="modal fade" id="myModalexpense" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  
    <div class="modal-dialog" role="document">
        <div class="modal-content">   
          
            <div class="modal-header">
                <h4 class="modal-title" id="add_expense"><strong>Add Entry</strong></h4>
                <button type="button" class="btn btn-default pull-right" data-dismiss="modal" id="close_add_expense">Close</button>
            </div>

            <div class="modal-body clearfix" id="disablecheck">
                <form method='post' class="expense" name="expense" action="" enctype="multipart/form-data">

                <?php
                	$columns = Array('expenses_folder_name','expenses_id');
	            	$conn->where('expenses_status',"Ongoing");
	              	$folders = $conn->get(TABLE_EXPENSES_FOLDER,null,$columns);
	            ?>

	            <center>
	              
	            	<select class="folder input-sm" name = 'folder_id' id="folder_id">
	            	<option value="">Select a Folder:</option> 

	            	<?php
	            		foreach($folders as $folder){
	            	?>

	              	<option value="<?php echo $folder['expenses_id']?> "> <?php echo $folder['expenses_folder_name']?></option>

	              	<?php
	              		}
	                ?>
	           		</select>
	           	</center>	

	          	<div class="col-sm-12 ">
	            	<div id="divNameFormReason" class="form-group has-feedback marbot20">
		            	Reason:
		            	<input name="expensereason" id="expensereason" type="text" class="form-control marbot20" value="" placeholder="Reason">
	              	</div>
	            </div>

	            <div class="col-sm-12 ">
	              	<div id="divNameFormAmount" class="form-group has-feedback marbot20">
		            	Amount:
		            	<input name="expense_amount" id="expense_amount" type="text" class="form-control marbot20" value="" placeholder="Amount">
		            </div>
	            </div>

	            <div class="col-sm-12 " align="center">
	            	<button type="button" class="btn btn-success" id="add_expense_submit" data-dismiss="modal">Add</button>
	            </div>

	          	</form>
            </div> 
        </div>
      
    </div>

</div>
<!-- model box close -->

<!-- model box for add folder start -->  
<div class="modal fade" id="myModalfolder" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  
    <div class="modal-dialog" role="document">
        <div class="modal-content">   
          
            <div class="modal-header">
                <h4 class="modal-title" id="add_folder"><strong>Add folder</strong></h4>
                <button type="button" class="btn btn-default pull-right" data-dismiss="modal" id="close_add_folder">Close</button>
            </div>

            <div class="modal-body clearfix" id="disablecheck">
                <form method='post' class="folder" name="folder" action="" enctype="multipart/form-data">

	          	<div class="col-sm-12 ">
	            	<div id="divNameFormName" class="form-group has-feedback marbot20">
		            	Name:
		            	<input name="foldername" id="foldername" type="text" class="form-control marbot20" value="" placeholder="Name">
	              	</div>
	            </div>

	            <div class="col-sm-12 ">
	              	<div id="divNameFormBudget" class="form-group has-feedback marbot20">
		            	Budget:
		            	<input name="folder_budget" id="folder_budget" type="text" class="form-control marbot20" value="" placeholder="Budget">
		            </div>
	            </div>

	            <div class="col-sm-12 " align="center">
	            	<button type="button" class="btn btn-success" id="add_folder_submit" data-dismiss="modal">Add</button>
	            </div>

	          	</form>
            </div> 
        </div>
      
    </div>

</div>
<!-- model box close -->

<!-- model box for add reminder start -->  
<div class="modal fade" id="myModalreminder" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  
    <div class="modal-dialog" role="document">
        <div class="modal-content">   
          
            <div class="modal-header">
                <h4 class="modal-title" id="add_reminder"><strong>Add reminder</strong></h4>
                <button type="button" class="btn btn-default pull-right" data-dismiss="modal" id="close_add_reminder">Close</button>
            </div>

            <div class="modal-body clearfix" id="disablecheck">
                <form method='post' class="reminder" name="reminder" action="" enctype="multipart/form-data">

	          	<div class="col-sm-12 ">
	            	<div id="divNameFormReminder" class="form-group has-feedback marbot20">
		            	Reminder:
		            	<input name="remindername" id="remindername" type="text" class="form-control marbot20" value="" placeholder="Reminder">
	              	</div>
	            </div>

	            <div class="col-sm-12 ">
	              	<div id="divNameFormdate" class="form-group has-feedback marbot20">
		            	Reminder Date:
		            	<input name="reminder_date" id="reminder_date" type="text" class="form-control marbot20" value="" placeholder="Date">
		            </div>
	            </div>

	            <div class="col-sm-6 ">
	              	<div id="divNameFormhours" class="form-group has-feedback marbot20">
		            	Time in Hours:
		            	<input name="reminder_time_hours" id="reminder_time_hours" type="text" class="form-control marbot20" value="" placeholder="Hours">
		            </div>
	            </div>

	            <div class="col-sm-6 ">
	              	<div id="divNameFormminutes" class="form-group has-feedback marbot20">
		            	Time in Minutes:
		            	<input name="reminder_time_minutes" id="reminder_time_minutes" type="text" class="form-control marbot20" value="" placeholder="Minutes">
		            </div>
	            </div>

	            <div class="col-sm-12 ">
	              	<div id="divNameFormyearly" class="form-group has-feedback marbot20">
		            	Yearly:
		            	<input name="reminder_yearly" id="reminder_yearly" type="text" class="form-control marbot20" value="" placeholder="Yearly Reminder">
		            </div>
	            </div>

	            <div class="col-sm-12 " align="center">
	            	<button type="button" class="btn btn-success" id="add_reminder_submit" data-dismiss="modal">Add</button>
	            </div>

	          	</form>
            </div> 
        </div>
      
    </div>

</div>
<!-- model box close -->

<!-- model box for export folder start -->  
<div class="modal fade" id="myModalexport_folder" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  
    <div class="modal-dialog" role="document">
        <div class="modal-content">   
          
            <div class="modal-body clearfix" id="disablecheck">
                <form method='post' class="folder_export" name="folder_export" action="" enctype="multipart/form-data">

                <div class="modal-header">
	                <h4 class="modal-title" id="export_folder_choice"></h4>
	            </div>
	            <br>
	          	<div class="col-sm-12 " align="center">
	                <button type="button" class="btn btn-success" id="export_folder_excel" data-dismiss="modal">Excel</button>
	                <button type="button" class="btn btn-danger" id="export_folder_pdf" data-dismiss="modal" style="margin-left:50px;">PDF
	                </button>
	            </div>

	            <div>
	            	<input type="text" name="folder_id_pass" id="folder_id_pass" class="form-control marbot20" value="">
	            </div>
	            
	          	</form>
            </div> 
        </div>
      
    </div>

</div>
<!-- model box close -->

</body>
</html>