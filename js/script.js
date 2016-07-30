$(document).ready(function(){

	$("#due_date_subtask,#reminder_date").datepicker();

	function ajaxCaller(url, data, callback, responseType, timeout) {
	    if (typeof url !== 'undefined' && typeof data !== "undefined") {
	        $.ajax({
	            cache: false,
	            type: "POST",
	            timeout: (typeof timeout === "undefined") ? "60000" : timeout,
	            url: url,
	            data: data,
	            async: true,
	            dataType: (typeof responseType === "undefined") ? "text" : responseType,
	            success: function (response) {
		        	eval(callback(response));
				},
	            error: function(){
	            }
	        });
	    }
	}

	function show_data(response){
		$("#main_data").html(response) ;
	}

	function show_data_parent(response){
		$("#parent_data").html(response) ;
	}

	function refresh_topic(){
		var topic_id = $("#topic_id_store").val() ;
		var url="ajax.php";
		var dataSet="action=get_topic&topic_id="+topic_id;

		ajaxCaller(url,dataSet,show_data) ;
	}

	function refresh_task(){
		var task_id = $("#task_id_store").val() ;
		var url="ajax.php";
		var dataSet="action=get_task&task_id="+task_id;
		ajaxCaller(url,dataSet,show_data) ;

	}

	function refresh_expense_parent(){
		var url="ajax.php";
		var dataSet="action=get_folder";
		ajaxCaller(url,dataSet,show_data_parent) ;
	}

	function refresh_expense(){
		var url="ajax.php";
		var dataSet="action=get_expenses&folder_id=0";
		ajaxCaller(url,dataSet,show_data) ;
	}

	function refresh_reminders(){
		var url="ajax.php";
		var dataSet="action=get_reminders&reminder_status=Ongoing";
		ajaxCaller(url,dataSet,show_data) ;

		dataSet="action=get_past_reminders&reminder_status=Completed";
		ajaxCaller(url,dataSet,show_data_parent) ;
	}

	function edit_task_status(response){
		// $("#response_log").html(response) ;
		refresh_task();
	}

	function edit_task_date(response){
		//$("#response_log").html(response) ;
		refresh_task();
	}

	function add_subtask(response){
		// $("#response_log").html(response) ;	
		refresh_task();
	}

	function edit_topic_status(response){
		// $("#response_log").html(response) ;
		refresh_topic();
	}

	function edit_folder_status(response){
		// $("#response_log").html(response) ;
		refresh_expense();
		refresh_expense_parent();
	}

	function edit_reminder_status(response){
		//$("#response_log").html(response) ;
		refresh_reminders();
	}

	function add_subtopic(response){
		// $("#response_log").html(response) ;	
		refresh_topic();
	}

	function add_expense(response){
		// $("#response_log").html(response) ;
		refresh_expense();
		refresh_expense_parent();
	}

	function edit_budget(response){
		// $("#response_log").html(response) ;
		refresh_expense_parent();
	}

	function add_reminder(response){
		//$("#response_log").html(response) ;
		refresh_reminders();
	}

	function edit_reminder(response){
		//$("#response_log").html(response) ;
		refresh_reminders();
	}

	function apply_datepicker(){
		$("#input_r_date").datepicker();
		$("#input_t_date").datepicker();
	}

	/*function export_title(response){
		objData = JSON.parse(response);
		folder_name = objData.data[0].expenses_folder_name ;

		$("#export_folder_choice").append("<strong><center>"+folder_name+"</center></strong>");
	}*/

	$("#main_menu").on('click','#project_info',function(){
		var url="ajax.php";
		var dataSet="action=get_project_info";
		ajaxCaller(url,dataSet,show_data) ;

		$("#parent_data").html("") ;
	});

	$("#main_menu").on('click','.task_dropdown',function(){
		var id = this.id ;
		var task_id = id.slice(14) ;
		$("#task_id_store").val(task_id);
		$("#parent_data").html("") ;
		
		var url="ajax.php";
		var dataSet = "action=get_task&task_id="+task_id;
		ajaxCaller(url,dataSet,show_data) ;

	});

	$("#main_menu").on('click','.topic_dropdown',function(){
		var id = this.id ;
		var topic_id = id.slice(15) ;
		$("#topic_id_store").val(topic_id);
		$("#parent_data").html("") ;

		var url="ajax.php";
		var dataSet = "action=get_topic&topic_id="+topic_id;
		ajaxCaller(url,dataSet,show_data) ;
	});

	$("#main_menu").on('click','#expenses_tab',function(){
		var url="ajax.php";
		var dataSet="action=get_expenses&folder_id=0";
		ajaxCaller(url,dataSet,show_data) ;

		dataSet="action=get_folder";
		ajaxCaller(url,dataSet,show_data_parent) ;
	});

	$("#main_menu").on('click','#reminders_tab',function(){
		var url="ajax.php";
		var dataSet="action=get_reminders&reminder_status=Ongoing";
		ajaxCaller(url,dataSet,show_data) ;

		dataSet="action=get_past_reminders&reminder_status=Completed";
		ajaxCaller(url,dataSet,show_data_parent) ;
	});

	$("#main_menu").on('click','#home_tab',function(){
		$("#parent_data").html("") ;

		var url="ajax.php";
		var dataSet="action=get_home_screen";
		ajaxCaller(url,dataSet,show_data) ;
	});

	$("#main_data").on('click','.checkbox_status_task',function(){
		var subtask_id = this.id ;
		var id_hide_element = "#taskrow_" + subtask_id;
		$(id_hide_element).hide() ;

		var url = "ajax.php";
		var dataSet = "action=edit_task_status&subtask_id="+subtask_id;
		ajaxCaller(url,dataSet,edit_task_status) ;
	});

	$("#main_data").on('click','.checkbox_status_topic',function(){
		var subtopic_id = this.id ;
		var id_hide_element = "#topicrow_" + subtopic_id;
		$(id_hide_element).hide() ;

		var url = "ajax.php";
		var dataSet = "action=edit_topic_status&subtopic_id="+subtopic_id;
		ajaxCaller(url,dataSet,edit_topic_status) ;
	});

	$("#parent_data").on('click','.checkbox_status_folder',function(){
		var folder_id = this.id ;
		var id_hide_element = "#folderrow_" + folder_id;
		$(id_hide_element).hide() ;

		var url = "ajax.php";
		var dataSet = "action=edit_folder_status&folder_id="+folder_id;
		ajaxCaller(url,dataSet,edit_folder_status) ;
	});

	$("#main_data").on('click','.checkbox_status_reminder',function(){
		var reminder_id = this.id ;
		var id_hide_element = "#reminderrow_" + reminder_id;
		$(id_hide_element).hide() ;

		var url = "ajax.php";
		var dataSet = "action=edit_reminder_status&reminder_id="+reminder_id;
		ajaxCaller(url,dataSet,edit_reminder_status) ;
	});

	$("#parent_data").on('click','.checkbox_status_reminder',function(){
		var reminder_id = this.id ;
		var id_hide_element = "#reminderrow_" + reminder_id;
		$(id_hide_element).hide() ;

		var url = "ajax.php";
		var dataSet = "action=edit_reminder_status&reminder_id="+reminder_id;
		ajaxCaller(url,dataSet,edit_reminder_status) ;
	});

	$("#myModalsubtask").on('click','#add_subtask_submit',function(){
		var task_id = $("#task_id_store").val() ;
		var subtask_name = $("#subtaskname").val() ;
		var subtask_comment = $("#subtask_comment").val();
		var due_date = $("#due_date_subtask").val();

		var url = "ajax.php";
		var dataSet="action=add_subtask&task_id="+task_id+"&subtask_name="+subtask_name+"&subtask_comment="+subtask_comment+"&due_date="+due_date;
		if(subtask_name){
			ajaxCaller(url,dataSet,add_subtask) ;
		}
	});

	$("#myModalreminder").on('click','#add_reminder_submit',function(){
		var reminder_name = $("#remindername").val() ;
		var reminder_date = $("#reminder_date").val() ;
		var reminder_hours = $("#reminder_time_hours").val();
		var reminder_minutes = $("#reminder_time_minutes").val();
		var reminder_yearly = $("#reminder_yearly").val();
		
		var url = "ajax.php";
		var dataSet="action=add_reminder&reminder_name="+reminder_name+"&reminder_date="+reminder_date+"&reminder_hours="+reminder_hours+"&reminder_minutes="+reminder_minutes
		+"&reminder_yearly="+reminder_yearly;
		if(reminder_name){
			ajaxCaller(url,dataSet,add_reminder) ;
		}
	});

	$("#myModalsubtopic").on('click','#add_subtopic_submit',function(){
		var topic_id = $("#topic_id_store").val() ;
		var subtopic_name = $("#subtopicname").val() ;
		var subtopic_comment = $("#subtopic_comment").val();

		var url = "ajax.php";
		var dataSet="action=add_subtopic&topic_id="+topic_id+"&subtopic_name="+subtopic_name+"&subtopic_comment="+subtopic_comment;
		if(subtopic_name){
			ajaxCaller(url,dataSet,add_subtopic) ;
		}
	});

	$("#main_data").on('click','#add_subtask_sign',function(){
		$("#subtaskname").val("") ;
		$("#subtask_comment").val("");
		$("#due_date_subtask").val("");
	});

	$("#main_data").on('click','#add_subtopic_sign',function(){
		$("#subtopicname").val("") ;
		$("#subtopic_comment").val("");
	});

	$("#main_data").on('click','#add_reminder_sign',function(){
		$("#remindername").val("") ;
		$("#reminder_date").val("");
		$("#reminder_time_hours").val("");
		$("#reminder_time_minutes").val("");
		$("#reminder_yearly").val("");
	});

	$("#parent_data").on('click','#add_folder_sign',function(){
		$("#foldername").val("");
		$("#folder_budget").val("");
	});

	$("#main_data").on('click','#add_expense_sign',function(){
		$("#expensereason").val("") ;
		$("#expense_amount").val("");
		$("#folder_id").prop('selectedIndex',0);

		$("#expensereason,#expense_amount").attr("disabled","disabled");
	});

	/*$("#parent_data").on('click','.export_folder_id',function(){
		$("#export_folder_choice").empty();
		$("#folder_id_pass").hide();
		var folder_id = (this.id).slice(14);
		var dataSet = "action=export_title&folder_id="+folder_id;
		var url="ajax.php";

		ajaxCaller(url,dataSet,export_title);
		$("#folder_id_pass").val(folder_id);
	});*/

	$("#myModalexpense").on('change','#folder_id',function () { 
    	if(!$("#folder_id").val()){
    		$("#expensereason").val("") ;
			$("#expense_amount").val("");
			$("#expensereason,#expense_amount").attr("disabled","disabled");    		
		}
    	else{
    		$("#expensereason,#expense_amount").removeAttr('disabled'); 
    	}
    });

    $("#myModalexpense").on('click','#add_expense_submit',function(){
		var folder_id = $("#folder_id").val() ;
		var expense_reason = $("#expensereason").val() ;
		var expense_amount = $("#expense_amount").val();

		var url = "ajax.php";
		var dataSet="action=add_expense&folder_id="+folder_id+"&expense_reason="+expense_reason+"&expense_amount="+expense_amount;
		if(expense_reason){
			ajaxCaller(url,dataSet,add_expense) ;
		}
	});

	$("#main_data").on('click','.folder_option_id',function(){
		var folder_id = (this.id).slice(14) ;

		var url="ajax.php";
		var dataSet="action=get_expenses&folder_id="+folder_id;
		ajaxCaller(url,dataSet,show_data) ;
	});

	/*$("#myModalexport_folder").on('click','#export_folder_excel',function(){
		var folder_id = $("#folder_id_pass").val();
		var url="ajax.php";
		var dataSet="action=export_excel&folder_id="+folder_id;
		ajaxCaller(url,dataSet,export_excel) ;

		$("#folder_id_pass").val("");
	});*/

	$("#parent_data").on('click','.budget_edit',function(){
		var folder_id=(this.id).slice(12);
		$(this).removeClass("budget_edit");
		var edit_layout = "<div class='col-xs-12'><input class='form-control' id='input_budget' type='text' style='text-align:center;' placeholder='Addition'><br><br>";
		edit_layout += "<button type='button' class='btn btn-primary edit_budget_action' id="+folder_id+" style='margin-right:50px;'><i class='fa fa-check'></i></button>";
		edit_layout += "<button type='button' class='btn btn-primary' id='edit_budget_no'><i class='fa fa-times'></i></button></div>";
		$(this).html(edit_layout) ;
	});

	$("#main_data").on('click','.edit_reminder_time',function(){
		var reminder_id=(this.id).slice(12);
		$(this).removeClass("edit_reminder_time");
		var edit_layout = "<div class='col-xs-12'><input class='form-control' id='input_r_time' type='text' style='text-align:center;' placeholder='Time'><br>";
		edit_layout += "<button type='button' class='btn btn-primary edit_r_time_action' id="+reminder_id+" style='margin-right:50px;'><i class='fa fa-check'></i></button>";
		edit_layout += "<button type='button' class='btn btn-primary' id='edit_r_time_no'><i class='fa fa-times'></i></button></div>";
		$(this).html(edit_layout) ;
	});

	$("#main_data").on('click','.edit_reminder_date',function(){
		var reminder_id=(this.id).slice(12);
		$(this).removeClass("edit_reminder_date");
		var edit_layout = "<div class='col-xs-12'><input class='form-control' id='input_r_date' type='text' placeholder='Date'><br>";
		edit_layout += "<button type='button' class='btn btn-primary edit_r_date_action' id="+reminder_id+" style='margin-right:50px;'><i class='fa fa-check'></i></button>";
		edit_layout += "<button type='button' class='btn btn-primary' id='edit_r_date_no'><i class='fa fa-times'></i></button></div>";
		$(this).html(edit_layout) ;
		apply_datepicker();
	});

	$("#main_data").on('click','.input_t_date',function(){
		var task_id = (this.id).slice(12);
		$(this).removeClass("input_t_date");
		var edit_layout = "<div class='col-xs-12'><input class='form-control' id='input_t_date' type='text' placeholder='Date'><br>";
		edit_layout += "<button type='button' class='btn btn-primary edit_t_date_action' id="+task_id+" style='margin-right:50px;'><i class='fa fa-check'></i></button>";
		edit_layout += "<button type='button' class='btn btn-primary' id='edit_t_date_no'><i class='fa fa-times'></i></button></div>";
		$(this).html(edit_layout) ;
		apply_datepicker();
	});

	$("#main_data").on('click','.edit_t_date_action',function(){
		var new_date=$("#input_t_date").val();
		var task_id=this.id;
		var url="ajax.php";
		var dataSet="action=edit_task_date&new_date="+new_date+"&task_id="+task_id;
		ajaxCaller(url,dataSet,edit_task_date);
	});

	$("#main_data").on('click','.edit_r_time_action',function(){
		var new_time=$("#input_r_time").val();
		var reminder_id =this.id;
		var url="ajax.php";
		var dataSet="action=edit_rem_time&new_time="+new_time+"&reminder_id="+reminder_id;
		ajaxCaller(url,dataSet,edit_reminder);
	});

	$("#main_data").on('click','.edit_r_date_action',function(){
		var new_date=$("#input_r_date").val();
		var reminder_id =this.id;
		var url="ajax.php";
		var dataSet="action=edit_rem_date&new_date="+new_date+"&reminder_id="+reminder_id;
		ajaxCaller(url,dataSet,edit_reminder);
	});

	$("#main_data").on('click','#edit_r_time_no,#edit_r_date_no',function(){
		refresh_reminders();
	});

	$("#main_data").on('click','#edit_t_date_no',function(){
		refresh_task();
	});

	$("#parent_data").on('click','#edit_budget_no',function(){
		refresh_expense_parent();
	});

	$("#parent_data").on('click','.edit_budget_action',function(){
		var addition=$("#input_budget").val();
		var folder_id =this.id;
		var url="ajax.php";
		var dataSet="action=edit_budget&addition="+addition+"&folder_id="+folder_id;
		ajaxCaller(url,dataSet,edit_budget);
	});

	$("#myModalfolder").on('click','#add_folder_submit',function(){
		var folder_name = $("#foldername").val();
		var budget = $("#folder_budget").val();

		var url="ajax.php";
		var dataSet="action=add_folder&folder_name="+folder_name+"&budget="+budget;
		ajaxCaller(url,dataSet,add_expense);
	});
});