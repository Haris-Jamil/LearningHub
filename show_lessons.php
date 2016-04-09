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
	$course =  $_SESSION['course_title'];
	$id = $_SESSION['course_id'];
?>

<!DOCTYPE html>
<html>
<head>
	<title><?php echo '$course'; ?></title>
	<meta charset="utf-8">
  	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="css/bootstrap.css">
	<script src="js/jquery.js"></script>
	<script type="text/javascript" src="js/bootstrap.js"></script>

	<?php
		$searched_course = $result = "";

		function test_input($data){	
			$data = trim($data);
			$data = stripslashes($data);
			$data = htmlspecialchars($data);
			return $data;
		}

		/////////////////////////////////////////DataBase Connection/////////////////////////////////////////////////////
		$servername = "localhost";
		$username = "root";
		$password = "helloworld";
		$db = "project";

		$conn = mysqli_connect($servername,$username,$password,$db);

		if(!$conn){
			die("connection Failed:" . mysqli_connect_error());
		}
		else{
			//echo "connection built successfully" . "<br>";
		}

		$sql = "SELECT * FROM lesson WHERE course_id = '$id'";
		$result = mysqli_query($conn,$sql);
	?>

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

	<style type="text/css">
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

	<?php
		while ($row = mysqli_fetch_assoc($result)){
			
			$url = $row['lesson_link'];

			echo "<div align='center'>
					<h2>{$row['lesson_title']}</h2>
					<video width='500' height='300' controls >
						<source src='{$row['lesson_link']}' type='video/mp4'>
						not working!
					</video>
				  </div><br><br>";
		}
	?>
</body>
</html> 

