<?php 

	include("classes/autoload.php");

	$login = new Login();
	$user_data = $login->check_login($_SESSION['userid']);

	$USER = $user_data;
 	
 	if(isset($_GET['id']) && is_numeric($_GET['id'])){

	 	$profile = new Profile();
	 	$profile_data = $profile->get_profile($_GET['id']);

	 	if(is_array($profile_data)){
	 		$user_data = $profile_data[0];
	 	}

 	}

	
	if(isset($_GET['find'])){

		$find = addslashes($_GET['find']);

		$sql = "select * from users where first_name like '%$find%' || last_name like '%$find%' limit 30";
		$DB = new Database();
		$results = $DB->read($sql);


	}
 
?>

<!DOCTYPE html>
	<html>
	<head>
		<title>Search | BUT family</title>
		<link rel="stylesheet" href="http://localhost/main.css">
		<link rel="stylesheet" href="//localhost/home_adaptive.css">
		<meta name="viewport" content="width=device-width, initial-scale=1" style="overflow:hidden">


	</head>

	

<body>

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

  					 		if(is_array($results)){

  					 			foreach ($results as $row) {
  					 				# code...
  					 				$FRIEND_ROW = $User->get_user($row['userid']);
 									
 									if($row['type'] == "profile"){
 										include("user.php");
 									}elseif($row['type'] == "group"){
 										include("group.inc.php");
 									}
 					 			}
  					 		}else{

  					 			echo "no results were found";
  					 		}

  					 ?>

  					 <br style="clear: both;">
 					</div>
  

 				</div>
			</div>

		</div>

	</body>
</html>