<?php
	///////////////////////////////////////////////////REDIRECT FUNCTION/////////////////////////////////////////// 
	function redirectTo($url){
		header("Location: " . $url);
		exit();	
	}
	//////////////////////////////////////////////////SESSION START/////////////////////////////////////////////////
	
	/////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	session_start();
	$user = $_SESSION["CurUser"];
?>

<!DOCTYPE html>
<html>
<head>
	<title><?php echo $user; ?></title>
	<meta charset="utf-8">
  	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="css/bootstrap.css">
	<script src="js/jquery.js"></script>
	<script type="text/javascript" src="js/bootstrap.js"></script>

	<?php 
		$link = $_GET['link'];
		if($link == 1){
			redirectTo("profile.php");
		}
		else if ($link == 2) {
			redirectTo("browse.php");	
		}
		else if($link == 3){
			$_SESSION["CurUser"] = "";
			redirectTo("mainPage.php");	
		}

	?>

	<style>
	.cl_white{
		color: white;
	}
	#logo{
		background-color: #4d4d4d;
		width: 100%;
	}
	#footer{
			color: white;
			height: 50px;
			font-size: 15px;
			width: 100%;
			background-color: #0d0d0d;
			text-align: center;
			margin-top: 430px;
		}
	</style>

</head>
<body>
	<div id="header"> 
		<nav class="navbar navbar-inverse navbar-fixed-top"> 
			<ul class="nav navbar-nav">
				<li><a href="?link=1" name="link"><?php echo $user; ?></a></li>
				<li><a href="?link=2" name="link">Browse Courses</a></li>
				<li><a href="?link=3" name="link">Sign out</a></li>
			</ul>
		</nav>  

		<div id="logo" class="text-center">
			<img src="images/logo2.png" >
		</div>	
	</div>
     
	<div id="body"> 
		<Section class="container">	
		<div class="page-header"> 
			<h1 class="text-center">Progress</h1>	
		</div>
		
		<ul class="nav nav-tabs">
			<li class="active"><a href="#CoursePro" data-toggle="tab">Courses in progress</a></li>
			<li><a href="#CourseCom" data-toggle="tab">Courses Completed</a></li>
			<li><a href="#QuizPro" data-toggle="tab">Quizes</a></li>
		</ul>
		<br>
		<div class="tab-content">
			<div id="CoursePro" class="tab-pane fade in active">
				<div class="panel panel-primary">
					<div class="panel-heading">
						Courses in progress
					</div>
					<div class="panel-body">
						<p>Sample text</p>
						<p>Sample text</p>
						<p>Sample text</p>
						<p>Sample text</p>
						<p>Sample text</p>
						<p>Sample text</p>
						<p>Sample text</p>
						<p>Sample text</p>
						<p>Sample text</p>
						<p>Sample text</p>
						<p>Sample text</p>
						<p>Sample text</p>
						<p>Sample text</p>
						<p>Sample text</p>
						<p>Sample text</p>
					</div>
	 			</div>
			</div>
			
			<div id="CourseCom" class="tab-pane fade">
				<div class="panel panel-primary">
					<div class="panel-heading">
						Courses completed
					</div>
					<div class="panel-body">
						<p>Sample text</p>
						<p>Sample text</p>
						<p>Sample text</p>
						<p>Sample text</p>
						<p>Sample text</p>
					</div>
	 			</div>
			</div>

			<div id="QuizPro" class="tab-pane fade">
				<div class="panel panel-primary">
					<div class="panel-heading">
						Quize Scores
					</div>
					<div class="panel-body">
	
					</div>
	 			</div>	
		</section>	
	</div>	
	
	<div id="footer">
		<br>
		<p style="align:center;">&copy; 2016 Learninghub.com all rights reserved</p>
	</div>

</body>
</html>