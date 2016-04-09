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
 	<title>Browse Courses</title>
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

		if(isset($_POST['searchBtn'])){

				if($_SERVER['REQUEST_METHOD'] == "POST"){
					$searched_course = test_input($_POST["searched_course"]);
				}

				$sql = "SELECT * FROM course WHERE course_title LIKE '%$searched_course%' ";
				$result = mysqli_query($conn,$sql);
		}

		if(isset($_POST['view_course'])){

				if($_SERVER['REQUEST_METHOD'] == "POST"){

					$_SESSION['course_title'] = test_input($_POST["course_title"]);
					$_SESSION['course_id'] = test_input($_POST["course_id"]);

					redirectTo("show_lessons.php");
				}

		}


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
				margin-top: 580px;
		}
		h3{
			color: white;
		}
		td{
			padding: 3px;
		}
		#icon{
			float: left;
		}
		#tut_block{	
			height: 190px;
		}
		#course_link{
			text-decoration: none;
			color:  black;
			margin-left: 5px;
			margin-top: 10px;
		}
		#course_link:hover{
			color:black ;
			text-decoration: underline;
		}
		#level{
			color: black;
			float: right;
			margin-top: 70px;
		}
		#btn{
			padding: 5px;
		}
		#submit_btn{
			margin-top: 30px;
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

	<h1 align="center">Search courses here!</h1>
	<div>
		<form id="search_form" method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" >
			<table align="center">
				<tr>
					<td><input type="text" class="form-control" name="searched_course" required></td>
					<td><input type="submit" class="btn btn-info" name="searchBtn" value="search"></td>
				</tr>
			</table>
		</form>
	</div>
	<br><br>
	<div class="container">
	<hr>
		<?php 
			while($row = mysqli_fetch_assoc($result)){

				echo "<div id='tut_block' class='well col-md-4 col-md-offset-1'>
						<h4><a id='course_link'>{$row['course_title']}</a></h4>
						<h5 id='level'>Level: {$row['course_level']}</h5>
						<form id='submit_btn' method='post' action='browse.php'>
							<input type='hidden' name='course_title' value='{$row['course_title']}' >
							<input type='hidden' name='course_id' value='{$row['course_id']}' >
							<input type='submit' class='btn btn-success btn-lg' name='view_course' id='btn'>
						</form>
				 	</div>";
			}
		?>
	</div>

	<div id="footer">
		<br>
		<p style="align:center;">&copy; 2016 Learninghub.com all rights reserved</p>
	</div>
 </body>
 </html>
