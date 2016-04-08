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

<<!DOCTYPE html>
<html>
<head>
	<title>Upload</title>
	<meta charset="utf-8">
  	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="css/bootstrap.css">
	<script src="js/jquery.js"></script>
	<script type="text/javascript" src="js/bootstrap.js"></script>

	<?php
		$courseTitle = $courseLevel = $NoVideos = "";
		$display = 'none';
		$nextBtn = ''; 
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
		////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

		///////////////////////////////////////VALIDATE SIGNIN//////////////////////////////////////////////////////////////
		if(isset($_POST['course_btn'])){
			if($_SERVER['REQUEST_METHOD'] == "POST"){
				$course_title = test_input($_POST["course_title"]);
				$course_level = test_input($_POST["course_level"]);
				$NoVideos = test_input($_POST["no_videos"]);
			}
			$getTeacherId = "SELECT teacher_id FROM teacher WHERE username='$user'";
			$result = mysqli_query($conn,$getTeacherId);
			$teacherId = mysqli_fetch_assoc($result);

			$sql = "INSERT into course (course_title,course_level,teacher_id) VALUES ('$course_title','$course_level','$teacherId[teacher_id]')";

			if(mysqli_query($conn,$sql)){	
				$display = 'block';
				$nextBtn = 'disabled';
			}
			else{
				echo "error : " . mysqli_error($conn);
			}
		}
	?>

	<?php
		$link = $_GET['link'];
		if($link == 1){
			redirectTo("teacher_profile.php");
		}
		else if ($link == 2) {
			redirectTo("upload.php");	
		}
		else if($link == 3){
			$_SESSION["CurUser"] = "";
			redirectTo("mainPage.php");	
		}
	?>

	<style>
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
		td{
			padding: 3px;
		}
	</style>
</head>
<body>
	<div id="header"> 
		<nav class="navbar navbar-inverse navbar-fixed-top"> 
			<ul class="nav navbar-nav">
				<li><a href="?link=1" name="link"><?php echo $user; ?></a></li>
				<li><a href="?link=2" name="link">Upload new courses</a></li>
				<li><a href="?link=3" name="link">Sign out</a></li>
			</ul>
		</nav>  

		<div id="logo" class="text-center">
			<img src="images/logo2.png" >
		</div>	
	</div>

	<div class="text-center">	
	<h1>Upload Course</h1><br>
		<h3>Course detail</h3>
		<form id="Course_detail" method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
			<table align="center">
				<tr>
					<th>Course title:</th>
					<td><input class="form-control" id="course_title" name="course_title" type="text" required></input></td>
				</tr>
				<tr>
					<th>Course level:</th>
					<td><input type="text" class="form-control" id="course_level" name="course_level" required></input></td>
				</tr>
				<tr>
					<th>No of videos:</th>
					<td><input type="number" class="form-control" id="no_videos" name="no_videos" required></input></td>
				</tr>
				<tr>
					<td></td>
				   <td align="right"><input type="submit" class="btn btn-success" name="course_btn" value="next" <?php echo $nextBtn; ?> ></input>
				   </td>
				</tr>
			</table>
		</form>
	</div>

	<div class="text-center" id="lesson_form" style="display: <?php echo $display;?>;">	 
		<h3>Lesson detail</h3>
		<form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
			<table align="center">
				<tr>
					<th>Lesson title:</th>
					<td><input class="form-control" name="course_title" type="text" required></input></td>
				</tr>
				<tr>
					<th>Lesson link:</th>
					<td><input type="text" class="form-control" name="course_level" required></input></td>
				</tr>
				<tr>
					<td></td>
				   <td align="right"><input type="submit" class="btn btn-success " name="course_btn" value="next" required></input></td>
				</tr>
			</table>
		</form>
	</div>

</body>
</html>