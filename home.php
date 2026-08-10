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

  
	//posting starts here
	if($_SERVER['REQUEST_METHOD'] == "POST")
	{

		$post = new Post();
		$id = $_SESSION['userid'];
		$result = $post->create_post($id, $_POST,$_FILES);
		
		if($result == "")
		{
			header("Location:" . ROOT . "home");
			die;
		}else
		{

			echo "<div style='text-align:center;font-size:12px;color:white;background-color:grey;'>";
			echo "<br>The following errors occured:<br><br>";
			echo $result;
			echo "</div>";
		}
	}

?>

<!DOCTYPE html>
	<html>
	<head>
		<title>Timeline | BUT family</title>
		<link rel="stylesheet" href="/main.css">
		<link rel="stylesheet" href="/home_adaptive.css">
		<link rel="stylesheet" href="/emojionearea.css">
		<meta name="viewport" content="width=device-width, initial-scale=1">



	</head> 

<body style="font-family: tahoma; background-color: #2e2e2e;height:100%; width:100%; margin:0px; padding:0px;">

		<br>
		<?php include("header.php"); ?>

		<!--cover area-->
		<div id="main_block">
			
			 
			<!--below cover area-->
			<div style="display: flex;">	

				<!--friends area-->			
				<div id="left_friends_bar">
					
					<div id="left_bar">
						
						 <?php 

							$image = "images/user_male.jpg";
							if($user_data['gender'] == "Female")
							{
								$image = "images/user_female.jpg";
							}
							if(file_exists($user_data['profile_image']))
							{
								$image = $image_class->get_thumb_profile($user_data['profile_image']);
							}
						?>

					<img style=" margin-top: 0px;"id="profile_pic" src="<?php echo ROOT . $image ?>"><br/>

						<a href="<?=ROOT?>profile" style="text-decoration: none; color:white"> 
						 <?php echo $user_data['first_name'] . "<br> " . $user_data['last_name'] ?>
						</a>

					</div>

				</div>

				<!--posts area-->
 				<div id="post_area">
 					
 					<div id="posting" style="height:auto;">

 						<form method="post" enctype="multipart/form-data">

	 						<textarea id="posting_form" name="post" placeholder="Поделитесь чем-нибудь!"></textarea>
							 <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
							 <script src="https://cdnjs.cloudflare.com/ajax/libs/emojionearea/3.4.2/emojionearea.min.js"></script>
							 <script type="text/javascript">
								$('#posting_form').emojioneArea({pickerPosition:'bottom'});
							 </script>
							<label for="photo_button" style="margin-left:10px;cursor: pointer;"><img src="//localhost/icons/photo.png" style="height:25px"></label>
	 						<input style="display:none" id="photo_button" type="file" name="file">
	 						<input id="post_button" type="submit" value="Post">
	 						<br>
 						</form>
 					</div>
 
	 				<!--posts-->
	 				<div id="post_bar">
 					
 						<?php 

 							$page_number = isset($_GET['page']) ? (int)$_GET['page'] : 1;
  							$page_number = ($page_number < 1) ? 1 : $page_number;

 							
 							$limit = 10;
 							$offset = ($page_number - 1) * $limit;

  							$DB = new Database();
 							$user_class = new User();
 							$image_class = new Image();

 							$followers = $user_class->get_following($_SESSION['userid'],"user");

 							$follower_ids = false;
 							if(is_array($followers)){

 								$follower_ids = array_column($followers, "userid");
 								$follower_ids = implode("','", $follower_ids);

 							}

 							if($follower_ids){
 								$myuserid = $_SESSION['userid'];
 								$sql = "select * from posts where parent = 0 and owner = 0 and (userid = '$myuserid' || userid in('" .$follower_ids. "')) order by id desc limit $limit offset $offset";
 								$posts = $DB->read($sql);
 							}

 	 					 	if(isset($posts) && $posts)
 	 					 	{

 	 					 		foreach ($posts as $ROW) {
 	 					 			# code...

 	 					 			$user = new User();
 	 					 			$ROW_USER = $user->get_user($ROW['userid']);

 	 					 			include("post.php");
 	 					 		}
 	 					 	}
 	 			 
 	 					 	//get current url
 							$pg = pagination_link();
 
	 					 ?>
	 					 <a href="<?= $pg['next_page'] ?>">
	 					 <input id="post_button" type="button" value="Next Page" style="margin-right:20px;float:right;width:130px;">
	 					 </a>
	 					 <a href="<?= $pg['prev_page'] ?>">
	 					 <input id="post_button" type="button" value="Prev Page" style="margin-left:20px;float:left;width:130px;">
	 					 </a>
	 				</div>

 				</div>
			</div>

		</div>

	</body>
</html>