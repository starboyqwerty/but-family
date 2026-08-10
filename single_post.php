<?php 

	include("classes/autoload.php");
 
	$login = new Login();
	$user_data = $login->check_login($_SESSION['userid']);
 
 	$USER = $user_data;
 	
 	if(isset($URL[1]) && is_numeric($URL[1])){

	 	$profile = new Profile();
	 	$profile_data = $profile->get_profile($URL[1]);

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
				header("Location: ". ROOT."single_post/$URL[1]");
				die;
			}else
			{

				echo "<div style='text-align:center;font-size:12px;color:white;background-color:grey;'>";
				echo "<br>The following errors occured:<br><br>";
				echo $result;
				echo "</div>";
			}
 			
	}

	$Post = new Post();
	$ROW = false;

	$is_group_post = false;

	$ERROR = "";
	if(isset($URL[1])){

		$ROW = $Post->get_one_post($URL[1]);
		if($ROW['owner'] > 0){

			$user_class = new User();
			$group_data = $user_class->get_user($ROW['owner']);
			if($group_data['type'] == "group"){
				$is_group_post = true;
			}
		}
	}else{

		$ERROR = "No post was found!";
	}

 
?>

<!DOCTYPE html>
	<html>
	<head>
		<title>Single Post | BUT family</title>
		<link rel="stylesheet" href="//localhost/main.css">
		<link rel="stylesheet" href="//localhost/home_adaptive.css">
		<link rel="stylesheet" href="/emojionearea.css"/>
		<meta name="viewport" content="width=device-width, initial-scale=1" style="overflow:hidden">

	</head>
<body>

		<br>
		<?php include("header.php"); ?>

		<!--post area-->
	<?php if(!($is_group_post && $group_data['group_type'] == 'private' && !group_access($_SESSION['userid'],$group_data,'member'))): ?>
		
		<div id="main_block">
		 
			<!--below cover area-->
			<div style="display: flex;">	

				<!--posts area-->
 				<div id="post_area">
 					
 					<div id="message_area" style="padding:5px">

  					 <?php 
  					 		//check if this is from a notification
  					 		if(isset($URL[2])){
  					 			notification_seen($URL[2]);
  					 		}

  					 		$user = new User();
  					 		$image_class = new Image();

  					 		if(is_array($ROW)){

 	 					 		$ROW_USER = $user->get_user($ROW['userid']);
  					 			
  					 			if($ROW['parent'] == 0){
  					 				include("post.php");
  					 			}else{
  					 				$COMMENT = $ROW;
  					 				include("comment.php");
  					 			}
  					 		}

  					 ?>
					 <hr>
  					 <?php if($ROW['parent'] == 0): ?>

	  				

						<?php if(!($is_group_post && $group_data['group_type'] == 'public' && !group_access($_SESSION['userid'],$group_data,'member'))): ?>

	  					<div style="background-color: white;">

	 						<form method="post" enctype="multipart/form-data">

		 						<textarea id="posting_form" name="post" placeholder="Post a comment"></textarea>
								 <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
								<script src="https://cdnjs.cloudflare.com/ajax/libs/emojionearea/3.4.2/emojionearea.min.js"></script>
								<script type="text/javascript">
									$('#posting_form').emojioneArea({pickerPosition:'bottom'});

								</script>

								<label for="photo_button" style="margin-left:10px;cursor: pointer;"><img src="//localhost/icons/photo.png" style="height:25px"></label>
		 						<input type="hidden" name="parent" value="<?php echo $ROW['postid'] ?>">
		 						<input id="photo_button" style="display:none" type="file" name="file">
		 						<input id="post_button" type="submit" value="Post">
		 						<br>
	 						</form>
	 					</div>
 					 	<?php endif; ?>

 					 <?php else: ?>
 					 	<a href="<?=ROOT?>single_post/<?php echo $ROW['parent'] ?>" >
 					 		<input id="post_button" style="width:auto;float: left;cursor: pointer;" type="button" value="Back to main post" />
 					 	</a>
 					 <?php endif; ?>
					 <hr>

 						<?php 
 
 							$comments = $Post->get_comments($ROW['postid']);

 							if(is_array($comments)){

 								foreach ($comments as $COMMENT) {
 									# code...
 									$ROW_USER = $user->get_user($COMMENT['userid']);
 									include("comment.php");
 								}
 							}

 							//get current url
 							$pg = pagination_link();
 						?>

 						<?php if($ROW['parent'] == 0): ?>

							<a href="<?= $pg['next_page'] ?>">
	 					 <input id="post_button" type="button" value="Next Page" style="margin-right:17px;border-radius: 10px;margin-bottom:5px;float: right;width:120px;">
	 					 </a>
	 					 <a href="<?= $pg['prev_page'] ?>">
	 					 <input id="post_button" type="button" value="Prev Page" style="margin-left:17px;border-radius: 10px;margin-bottom:5px;float: left;width:120px;">
	 					 </a>

		 				<?php endif; ?>
 					</div>
  

 				</div>
			</div>

		</div>
		<!-- end post -->
	<?php else: ?>
		<div style="padding: 1em;text-align: center;background-color: white;">Sorry, you do not have access to this content!</div>
	<?php endif; ?>
	</body>
</html>