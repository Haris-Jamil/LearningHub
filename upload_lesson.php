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
	$_SESSION['video_number'] = 1;
	$courseLastId= $_SESSION['lastCourseId'];
?>

<!DOCTYPE html>
<html>
<head>
	<title>Add lessons</title>
	<meta charset="utf-8">
  	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="css/bootstrap.css">
	<script src="js/jquery.js"></script>
	<script type="text/javascript" src="js/bootstrap.js"></script>
	<?php
		$lesson_title = $lesson_link = "";

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

		////////////////////////////////////////////////////LESSON////////////////////////////////////////////////////////
		if(isset($_POST['lesson_btn'])){

				if($_SERVER['REQUEST_METHOD'] == "POST"){
					$lesson_title = test_input($_POST["lesson_title"]);
					$lesson_link = test_input($_POST["lesson_link"]);
				}

				$sql = "INSERT into lesson (lesson_title,lesson_link,course_id) VALUES ('$lesson_title','$lesson_link','$courseLastId')";

				if(mysqli_query($conn,$sql)){	
					$_SESSION['NoVideos']--;
					$_SESSION['video_number']++;
					if($_SESSION['NoVideos'] == 0){
						redirectTo('teacher_profile.php');
					}
				}
				else{
					echo "error : " . mysqli_error($conn);
				}
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
				margin-top: 530px;
		}
		td{
			padding: 3px;
		}
	</style>

</head>
<body>

	<div id="logo" class="text-center">
			<img src="images/logo2.png" >
	</div>	

	<div class="text-center" id="lesson_form">	 
		<h3>Lesson detail</h3>
		<h4>Video: <?php echo $_SESSION['video_number']; ?></h4>
		<form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
			<table align="center" id="lesson_table">
				<tr>
					<th>Lesson title:</th>
					<td><input class="form-control" name="lesson_title" type="text" required></input></td>
				</tr>
				<tr>
					<th>Lesson link:</th>
					<td><input type="text" class="form-control" name="lesson_link" required></input></td>
				</tr>
				<tr>
					<td></td>
				   <td align="right"><input type="submit" class="btn btn-success " name="lesson_btn" value="next" required></input></td>
				</tr>
			</table>
		</form>
	</div>
		<div id="footer">
		<br>
		<p style="align:center;">&copy; 2016 Learninghub.com all rights reserved</p>
	</div>
</body>
</html>