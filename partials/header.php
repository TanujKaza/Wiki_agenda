<?php
	require_once('include/common.php') ;
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta name="author" content="Tanuj Kaza">
	<meta name="keywords" content="WikiLook">
	<meta name="description" content="This is only to be run locally">
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<title>Wikilook</title>

	<script src="js/jquery-1.10.2.min.js"></script> 
	<script src="js/jquery-1.11.3.min.js"></script>
	<script src="js/bootstrap.min.js"></script> 
	<script src="js/script.js"></script>
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<link rel="stylesheet" href="css/mystyle.css">
	<link href="http://code.jquery.com/ui/1.10.4/themes/ui-lightness/jquery-ui.css" rel="stylesheet">
	<script src="http://code.jquery.com/jquery-1.10.2.js"></script>
    <script src="http://code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
	<link rel="stylesheet" href="http://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.min.css">
</head>

<body>
	<nav class="navbar navbar-default">
		<div class="container-fluid" id="main_menu">
    		<div class="navbar-header">
      			<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
        		<span class="icon-bar"></span>
		        <span class="icon-bar"></span>
		        <span class="icon-bar"></span>
		      	</button>
      			<a class="navbar-brand" href="#" id="project_info">WikiLook</a>
   			</div>
	    	<div class="collapse navbar-collapse" id="myNavbar" >
	      		<ul class="nav navbar-nav">
	        		<li><a href="#" class="home_tab" id="home_tab">HOME</a></li>
	        		<li class="dropdown">
		          		<a class="dropdown-toggle" data-toggle="dropdown" href="#">READ ABOUT <span class="caret"></span></a>
			        	<ul class="dropdown-menu">
			        		<?php
						        $columns = array('topic_id','topic_name') ;
						        $conn->where('topic_status',"Ongoing") ;
						        $topics = $conn->get(TABLE_TOPICS,null,$columns) ;
						        foreach($topics as $topic){
						    ?>
				            <li><a href="#" class="topic_dropdown" id="topic_dropdown_<?php echo $topic['topic_id'] ?> "><?php echo $topic['topic_name']?></a></li>
				           	<?php
				           		}
				           	?>
				        </ul>
	        		</li>
	        		<li class="dropdown">
		          		<a class="dropdown-toggle" data-toggle="dropdown" href="#">TASKS <span class="caret"></span></a>
			        	<ul class="dropdown-menu">
			        		<?php
						        $columns = array('task_id','task_name') ;
						        $conn->where('task_status',"Ongoing") ;
						        $tasks = $conn->get(TABLE_TASKS,null,$columns) ;
						        foreach($tasks as $task){
						    ?>
				            <li><a href="#" class="task_dropdown" id="task_dropdown_<?php echo $task['task_id'] ?>"><?php echo $task['task_name']?></a></li>
				           	<?php
				           		}
				           	?>
				        </ul>
	        		</li>
	        		<li><a href="#" id="reminders_tab">REMINDERS</a></li>
	        		<li><a href="#" id="expenses_tab">EXPENSES</a></li>
	      		</ul>
		      	<ul class="nav navbar-nav navbar-right">
		      		<li class="dropdown">
		      			<a class="dropdown-toggle" data-toggle="dropdown" href="#">DATE <span class="caret"></span></a>
			        	<ul class="dropdown-menu">
			        		<?php
					      		$GMT_conversion = 19800 ;
						    	$epoch_time = time() + $GMT_conversion ;
						    	$current_time = new DateTime("@$epoch_time");
						    	$current_time = $current_time->format('F jS, Y');
						    ?> 	
				            <li><a href="#" class="date_dropdown" id="date_dropdown"><?php echo $current_time?></a></li>
				        </ul>
				    </li>
		      	</ul>
	    	</div>
  		</div>
	</nav>