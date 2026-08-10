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
	
	$Post = new Post();

	$ERROR = "";
	if(isset($URL[1])){

		 $ROW = $Post->get_one_post($URL[1]);

		 if(!$ROW){

		 	$ERROR = "No such post was found!";
		 }else{

		 	if($ROW['userid'] != $_SESSION['userid']){

		 		$ERROR = "Accesss denied! you cant delete this file!";
		 	}
		 }

	}else{

		$ERROR = "No such post was found!";
	}

	if(isset($_SERVER['HTTP_REFERER']) && !strstr($_SERVER['HTTP_REFERER'], "/edit/")){

		$_SESSION['return_to'] = $_SERVER['HTTP_REFERER'];
	}

	//if something was posted
	if($_SERVER['REQUEST_METHOD'] == "POST"){

		$Post->edit_post($_POST,$_FILES);


		header("Location: ".$_SESSION['return_to']);
		die;
	}

?>

<!DOCTYPE html>
	<html>
	<head>
		<title>Delete | BUT family</title>

		<link rel="stylesheet" href="http://localhost/main.css">
		<link rel="stylesheet" href="//localhost/home_adaptive.css">
		<link rel="stylesheet" href="//localhost/emojionearea.css"/>
		<meta name="viewport" content="width=device-width, initial-scale=1" style="overflow:hidden">

	</head>


	<style type="text/css">
		
	</style>

	<body>

		<br>
		<?php include("header.php"); ?>

		<!--cover area-->
		<div id="main_block">
		 
			<!--below cover area-->
			<div style="display: flex;">	

				<!--posts area-->
 				<div id="post_area">
 					
 					<div id="posting" style="height:auto;border-radius:15px;">

  						<form method="post" enctype="multipart/form-data">
 							
  								<?php

 									if($ERROR != ""){

								 		echo $ERROR;
								 	}else{

	  									echo "Edit Post<br><br>";
 										
 										echo '<textarea id="posting_form" style="overflow:hidden;height:70%;position:static;"name="post" placeholder="Whats on your mind?">'.$ROW['post'].'</textarea>
	 										  <input style="display:none" id="photo_button" type="file" name="file">';
										echo' <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
										<script src="https://cdnjs.cloudflare.com/ajax/libs/emojionearea/3.4.2/emojionearea.min.js"></script>
										<script type="text/javascript">
										   $("#posting_form").emojioneArea({pickerPosition:"bottom"});
										</script>';
	  									echo "<label for='photo_button' style='margin-left:10px;cursor: pointer;'><img src='//localhost/icons/photo.png' style='height:25px'></label><input style='display:none' id='photo_button' type='hidden' name='postid' value='$ROW[postid]'>";
	 									echo "<input id='post_button' type='submit' value='Save'>";

	 									if(file_exists($ROW['image']))
										{
											$image_class = new Image();
  
											$ext = pathinfo($ROW['image'],PATHINFO_EXTENSION);
											$ext = strtolower($ext);

											if($ext == "jpeg" || $ext == "jpg"){

												$post_image = $image_class->get_thumb_post($ROW['image']);

												echo "<br><br><div style='text-align:center;'><img src='$post_image' style='width:50%;' /></div>";

											}elseif($ext == "mp4"){

												echo "<video controls style='width:100%' >
													<source src='" . ROOT . "$ROW[image]' type='video/mp4' >
												</video>";
						 						
											}
										}

 									}
 								?>
  							
	 						
	 						<br>
 						</form>
 					</div>
  

 				</div>
			</div>

		</div>

	</body>
</html>