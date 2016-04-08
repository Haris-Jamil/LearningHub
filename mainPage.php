<?php
	///////////////////////////////////////////////////REDIRECT FUNCTION/////////////////////////////////////////// 
	function redirectTo($url){
		header("Location: " . $url);
		exit();	
	}
	//////////////////////////////////////////////////SESSION START/////////////////////////////////////////////////
	session_start();
	/////////////////////////////////////////////////////////////////////////////////////////////////////////////////
?>

<!DOCTYPE html>
<html>
	<head>
		<title>Learning Hub</title>
		<meta charset="utf-8">
  		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" type="text/css" href="css/bootstrap.css">
		<link rel="stylesheet" type="text/css" href="css/mainStyle.css">	
		<script src="js/jquery.js"></script>
		<script type="text/javascript" src="js/bootstrap.js"></script>

		<?php 

		/////////////////////////////////////////VARIABLES////////////////////////////////////////////////////////////
		$appusername = $email = $password = $status= "";
		$appusernameErr =$emailErr = "";
		$usernameSI = $passwordSI = $statusSI = "";
		$SIErr = $goto = "";
		$saveData = 0;
		////////////////////////////////////////////////////////////////////////////////////////////////////////////

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
			echo "connection built successfully" . "<br>";
		}
		////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

		///////////////////////////////////////VALIDATE SIGNIN//////////////////////////////////////////////////////////////
		if(isset($_POST['signin'])){

			if($_SERVER["REQUEST_METHOD"]=="POST"){
				$usernameSI = test_input($_POST["usernameSI"]);
				$passwordSI = test_input($_POST["passwordSI"]);
				$statusSI = test_input($_POST["status"]);
			}

			$checkUsernameSIAvail = mysqli_query($conn,"SELECT username FROM " . $statusSI . " WHERE username='$usernameSI'");
			$checkPassword = mysqli_query($conn,"SELECT password FROM " .$statusSI. " WHERE username='$usernameSI'");

			$pass = mysqli_fetch_assoc($checkPassword);

			if( (mysqli_num_rows($checkUsernameSIAvail) != 1) || ($pass['password'] != $passwordSI) ){
				$SIErr = "incorrect user name or password";
			}
			else{
				$_SESSION["CurUser"] = $usernameSI;
				if($statusSI == "students"){
					redirectTo('profile.php');	
				}
				else{
					redirectTo('teacher_profile.php');	
				}
			}

		}
		////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

		///////////////////////////////////////VALIDATE SIGNUP//////////////////////////////////////////////////////////////
		if(isset($_POST['signup'])){

			if($_SERVER["REQUEST_METHOD"]=="POST"){
				$appusername = test_input($_POST["username"]);
				$email = test_input($_POST["email"]);
				$password = test_input($_POST["password"]);
				$status = test_input($_POST["status"]);
			}

			if($status == "student"){
				$checkUsernameAvail = mysqli_query($conn,"SELECT username FROM students WHERE username='$appusername'");	
				$checkEmailAvail = mysqli_query($conn,"SELECT email FROM students WHERE email='$email'");
				$sql = "INSERT INTO students (username,email,password) VALUES ('$appusername','$email','$password')";
				$goto = "profile.php";
			}
			else{
				$checkUsernameAvail = mysqli_query($conn,"SELECT username FROM teacher WHERE username='$appusername'");
				$checkEmailAvail = mysqli_query($conn,"SELECT email FROM teacher WHERE email='$email'");	
				$sql = "INSERT INTO teacher (username,email,password) VALUES ('$appusername','$email','$password')";
				$goto = "teacher_profile.php";
			}
			

			if(mysqli_num_rows($checkUsernameAvail) != 0){
				$appusernameErr = "username not available";
				$saveData=1;
			}
			if(mysqli_num_rows($checkEmailAvail) != 0){
				$emailErr = "Email already in use";
				$saveData=1;
			}
			if($saveData == 0){
				
				if(mysqli_query($conn,$sql)){
					$_SESSION['CurUser'] = $appusername;
					redirectTo($goto);
				}
				else{
					echo "error : " . mysqli_error($conn);
				}
	
			}
		}
		//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		
		mysqli_close($conn);
	?>

	</head>
	<body data-spy="scroll" data-target=".navbar">
		<nav class="navbar navbar-inverse navbar-fixed-top"> 
			<ul class="nav navbar-nav">
				<li><a href="#home">Home</a></li>
				<li><a href="#middle">Explore</a></li>
				<li><a href="#contact">Contact</a></li>
			</ul>
		</nav>

		<section id="home" style="background: url(images/space.jpg); background-size: 100% 100%" class="cl_white text-center ">
			<img src="images/logo2.png" id="logo">
			<br>
			<div class="col-md-4 col-md-offset-4" >
				<h2>Learn Amazing Courses now!</h2>
				
				<div>
					<h3>Sign in</h3>
					 <form id="signin-form" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
						<table align="center">
							<tr>
							    <th>User Name:</th>
						 		<td><input type="text" class="form-control" name="usernameSI" required></input></td>
							</tr>
							<tr>
							 	<th>Password:</th>
							 	<td><input type="password" class="form-control" name="passwordSI" required=></input></td>
							</tr>
							<tr>
						 		<td></td>
						 		<td ><span class="error"><?php echo $SIErr; ?></span></td>
						 	</tr>
						 	<tr>
						 	<th>Account: </th>
						 		<td><input type="radio"  name="status" value="teacher" required> Teacher</input>
						 			<input type="radio"  name="status" value="students"> Stundent</input>
						 		</td>
							</tr>
							<tr>
								<td></td>
							<td align="right"><input type="submit" class="btn btn-success" name="signin" value="Sign in"></input></td>
							</tr>
						</table>
					 </form>

				</div>
				<br><br>
		
				<h3>Don't have any acount? sign up!</h3>	
				<form id="signup-form" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
					<table  align="center">
						 <tr>
						 	<th >User Name: </th>
						 	<td ><input type="text" class="form-control" name="username" required></td>
						 </tr>
						 <tr>
						 	<td></td>
						 	<td ><span class="error"><?php echo $appusernameErr; ?></span></td>
						 </tr>
						<tr>
						 	<th>Email: </th>
						 	<td><input type="email" class="form-control" name="email" required></input></td>
						 </tr>
						 <tr>
						 	<td></td>
						 	<td ><span class="error"><?php echo $emailErr; ?></span></td>
						 </tr>
						 <tr>
						 	<th>Password: </th>
						 	<td><input type="password" class="form-control" name="password" required></input></td>		 	
						</tr>
						<tr>
						 	<th>Account: </th>
						 	<td><input type="radio"  name="status" value="teacher" required> Teacher</input>
						 		<input type="radio"  name="status" value="student"> Stundent</input>
						 	</td>
						</tr>
						<tr>
							<td></td>
							<td align="right"><input type="submit" class="btn btn-success" name="signup" value="sign up" ></input></td>
						</tr>
					</table>
				 </form>
			</div>
		</section>

		

		<section class="container-fluid" align="center" id="middle">
			<div class="page-header">
				<h1 class="text-center">Courses</h1>
			</div>	
			<div>
				<img src="images/business.jpg" class="img-thumbnail explore" >
				<img src="images/creative.jpg" class="img-thumbnail explore" >
				<img src="images/technology.jpg" class="img-thumbnail explore" >	
			</div>
			<div>
				<h2 class="col-md-4 text-center" >business</h2>
				<h2 class="col-md-4 text-center" >Creative</h2>
				<h2 class="col-md-4 text-center" >Technology</h2>
			</div>
			<div align="center">
				<button class="btn btn-info btn-lg" >Explore!</button>
			</div>
		</section>

		<section class="container-fluid" id="contact">
			<h1 class="text-center" style="color: white;">Contact Us</h1>
			<hr class="container">
			<form class="col-md-4 col-md-offset-4">
				<div class="fomr-group">
					<input class="form-control" type="text" placeholder="name" style="margin-bottom: 10px;">
				</div>
				<div class="fomr-group">
					<input class="form-control " type="email" placeholder="email" style="margin-bottom: 10px;">
				</div>
				<div class="fomr-group">
					<input class="form-control" type="text" placeholder="subject" style="margin-bottom: 10px;">
				</div>
				<div class="fomr-group">
					<textarea class="form-control" rows="7" style="margin-bottom: 10px;" placeholder="comments.."></textarea> 
				</div>
				<div class="fomr-group">
					<input type="submit" class="btn btn-success btn-block"></input> 
				</div>
			</form>
			<div class="col-md-4 col-md-offset-4">
				<img src="images/logo2.png" id="logo">	
			</div>
		</section>	
	
		<div id="footer" >
			<br>
			<p style="align:center;">&copy; 2016 Learninghub.com all rights reserved</p>
		</div>	
	</body>
</html>