<?php 

session_start();

	include("classes/connect.php");
	include("classes/login.php");
 
	$email = "";
	$password = "";
	
	if($_SERVER['REQUEST_METHOD'] == 'POST')
	{


		$login = new Login();
		$result = $login->evaluate($_POST);
		
		if($result != "")
		{

			echo "<div style='text-align:center;font-size:12px;color:white;background-color:grey;'>";
			echo "<br>The following errors occured:<br><br>";
			echo $result;
			echo "</div>";
		}else
		{

			header("Location: " .ROOT."profile");
			die;
		}
 

		$email = $_POST['email'];
		$password = $_POST['password'];
		

	}


	

?>

<html> 

	<head>
		
		<title>BUT family | Log in</title>
	</head>
	<meta name="viewport" content="width=device-width, initial-scale=1" style="overflow:hidden">

	<style>
		@font-face {
		font-family: 'Capture';
		src: url('/fonts/Capture.ttf');
		}
		#bar{
			height:100px;
			background-color: #ffb308;
			color: white;
			padding: 4px;
		}

		#signup_button{

			background: rgb(56,56,56);
			background: linear-gradient(0deg, rgba(56,56,56,1) 0%, rgba(170,168,166,0.8995973389355743) 100%);
			width: 70px;
			text-align: center;
			padding:4px;
			border-radius: 4px;
			float:right;
			text-decoration:none;
			color:white;
			text:bold;
		}

		#bar2{
			background-color: white;
			width: 500px;
			margin-left:-200px;
			margin-right:100px;
			margin-top: 40px;
			padding:10px;
			padding-top: 50px;
			text-align: center;
			font-weight: bold;
		}
		#text{

			height: 40px;
			width: 300px;
			border-radius: 4px;
			border:solid 1px #ccc;
			padding: 4px;
			font-size: 14px;
		}

		#button{

			width: 300px;
			height: 40px;
			border-radius: 12px;
			font-weight: bold;
			border:none;
			background: rgb(247,58,41);
	    	background: linear-gradient(0deg, rgba(247,58,41,0.9780287114845938) 0%, rgba(255,198,8,0.8995973389355743) 100%);
			color: white;
			cursor:pointer;
		}
		.But_fam{
			margin-top:-10px;
			font-family: 'Capture';
			font-size:100px;
			color:black;
		}

	</style>

<body style="font-family: tahoma; background-color: #2e2e2e;height:100%; width:100%; margin:0px; padding:0px;">
		
		<div id="bar">
		<img src="/icons/logo.png" style="margin-left:20px;float:left;height:100px;">


			<div class="But_fam">&nbsp BUT family</div>
			<a href="<?=ROOT?>signup">
			<div style="margin-top:-50px;float:right" id="signup_button">Signup</div>
			</a>
		</div>
		<div style="padding:20px;margin-top:50px">
		<img src="/icons/123.png" style="float:left">

		<div id="bar2" style="float:right;margin-right:300px">
			
			<form method="post">
				Log in to BUT family<br><br>

				<input name="email" value="<?php echo $email ?>" type="text" id="text" placeholder="Email"><br><br>
				<input name="password" value="<?php echo $password ?>" type="password" id="text" placeholder="Password"><br><br>

				<input type="submit" id="button" value="Log in">
				<br><br><br>

			</form>
		</div>
	</div>
	

	</body>


</html>