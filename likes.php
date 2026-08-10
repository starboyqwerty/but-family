<?php 

	include("classes/autoload.php");
 
	$login = new Login();
	$user_data = $login->check_login($_SESSION['userid']);
 
 	$USER = $user_data;
 	
 	if(isset($URL[2]) && is_numeric($URL[2])){

	 	$profile = new Profile();
	 	$profile_data = $profile->get_profile($URL[2]);

	 	if(is_array($profile_data)){
	 		$user_data = $profile_data[0];
	 	}

 	}
 	
	
	$Post = new Post();
	$likes = false;

	$ERROR = "";
	if(isset($URL[2]) && isset($URL[1])){
 
		$likes = $Post->get_likes($URL[2],$URL[1]);
	}else{

		$ERROR = "No information post was found!";
	}
 
?>

<!DOCTYPE html>
	<html>
	<head>
		<title>People who like you | BUT family</title>
		<link rel="stylesheet" href="//localhost/main.css">
		<link rel="stylesheet" href="//localhost/home_adaptive.css">
		<meta name="viewport" content="width=device-width, initial-scale=1" style="overflow:hidden">

	</head>


<body style="font-family: tahoma; background-color: #2e2e2e;height:100%; width:100%; margin:0px; padding:0px;">

		<br>
		<?php include("header.php"); ?>

		<!--cover area-->
		<div id="main_block">
		 
			<!--below cover area-->
			<div style="display: flex;">	

				<!--posts area-->
 				<div id="post_area">
 					
 					<div id="message_area">

  					 <?php 

  					 		$User = new User();
  					 		$image_class = new Image();

  					 		if(is_array($likes)){

  					 			foreach ($likes as $row) {
  					 				# code...
  					 				$FRIEND_ROW = $User->get_user($row['userid']);
 									include("user.php");
 					 			}
  					 		}

  					 ?>

  					 <br style="clear: both;">
 					</div>
  

 				</div>
			</div>

		</div>

	</body>
</html>