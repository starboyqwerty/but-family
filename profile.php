<?php

	include("classes/autoload.php");

	$login = new Login();
	$_SESSION['userid'] = isset($_SESSION['userid']) ? $_SESSION['userid'] : 0;
	
	$user_data = $login->check_login($_SESSION['userid'],false);
 
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

		include("change_image.php");
		
		if(isset($_POST['first_name'])){

			$settings_class = new Settings();
			$settings_class->save_settings($_POST,$_SESSION['userid']);

		}elseif(isset($_POST['post'])){

			$post = new Post();
			$id = $_SESSION['userid'];
			$result = $post->create_post($id, $_POST,$_FILES);
			
			if($result == "")
			{
				header("Location: " . ROOT . "profile");
				die;
			}else
			{

				echo "<div style='text-align:center;font-size:12px;color:white;background-color:grey;'>";
				echo "<br>The following errors occured:<br><br>";
				echo $result;
				echo "</div>";
			}
		}
			
	}

	//collect posts
	$post = new Post();
	$id = $user_data['userid'];
	
	$posts = $post->get_posts($id);

	//collect friends
	$user = new User();
 	
	$friends = $user->get_following($user_data['userid'],"user");

	$image_class = new Image();

	//check if this is from a notification
	if(isset($URL[2])){
		notification_seen($URL[2]);
	}

?>

<!DOCTYPE html>
	<html>
	<head>
		<title>Profile | BUT family</title>
		<link rel="stylesheet" href="/main.css">
		<link rel="stylesheet" href="/adaptive.css">
		<link rel="stylesheet" href="/emojionearea.css"/>
		<meta name="viewport" content="width=device-width, initial-scale=1" style="overflow:hidden">
		<style>
			    #menu_buttons:hover{
					color:orangered;
				 }
		@media only screen and (max-width:1400px) {
		#change_block{
			max-width:600px;
			margin:auto;
			min-height: 400px;
			flex:2.5;
			padding: 20px;
			padding-right: 0px;
		}

	}
		@media only screen and (max-width:800px){
		#change_profile_image{
			margin-top:50px;

		}
		#change_cover_image{
			margin-top:50px;

		}
		#change_block{
			max-width:60%;
			margin-left:35%;
			min-height: 400px;
			flex:2.5;
			padding: 20px;
			padding-right: 0px;
			margin-top:120px;
		}
		}
		@media only screen and (max-width:550px){
		#change_profile_image{
			margin-top:30px;

		}
		#change_cover_image{
			margin-top:30px;

		}
		#change_block{
			max-width:80%;
			margin:auto;
			min-height: 400px;
			flex:2.5;
			padding: 20px;
			padding-right: 0px;
			margin-top:35px;
			padding-bottom:30px;
		}
	
		}
		
		</style>
	</head>


	<body>

		<br>
		<?php include("header.php"); ?>
 
 		<!--change profile image area-->
 		<div class="bubu" id="change_profile_image" style="display:none;z-index:1;position:absolute;width: 100%;height: 500%;background-color: #000000aa;">
 			<div id="change_block">
				
			 <svg id="btn" style="cursor:pointer;float:right;margin-top:5px;margin-right:5px;"fill="#2e2e2e" width="24" height="24" viewBox="0 0 24 24"><path d="M12 0c-6.627 0-12 5.373-12 12s5.373 12 12 12 12-5.373 12-12-5.373-12-12-12zm4.151 17.943l-4.143-4.102-4.117 4.159-1.833-1.833 4.104-4.157-4.162-4.119 1.833-1.833 4.155 4.102 4.106-4.16 1.849 1.849-4.1 4.141 4.157 4.104-1.849 1.849z"/></svg>

 					<form method="post" action="<?=ROOT?>profile/profile" enctype="multipart/form-data">
	 					<div style="border:solid thin #aaa; padding: 10px;background-color: white;">

						 	<label for="photo_button" style="margin-left:10px;cursor: pointer;"><img src="/icons/photo.png" style="height:30px"></label>
	 						<input  style="display:none" id="photo_button" type="file" name="file"><br>
	 						<input id="post_button" type="submit" style="width:120px;" value="Change">
	 						<br>
							<div style="text-align: center;">
								<br>
							<?php
								echo "<img src='" . ROOT . "$user_data[profile_image]' style='width:80%;max-width:500px;' >";
	 						?>
							</div>
	 					</div>
  					</form>
 				</div>
 		</div>
		
		<!--change cover image area-->
 		<div class="bubu" id="change_cover_image" style="display:none;z-index:1;position:absolute;width: 100%;height: 500%;background-color: #000000aa;">
 			<div id="change_block">
			 <svg id="btn" style="cursor:pointer;float:right;margin-top:5px;margin-right:5px;"fill="#2e2e2e" width="24" height="24" viewBox="0 0 24 24"><path d="M12 0c-6.627 0-12 5.373-12 12s5.373 12 12 12 12-5.373 12-12-5.373-12-12-12zm4.151 17.943l-4.143-4.102-4.117 4.159-1.833-1.833 4.104-4.157-4.162-4.119 1.833-1.833 4.155 4.102 4.106-4.16 1.849 1.849-4.1 4.141 4.157 4.104-1.849 1.849z"/></svg>

 					
 					<form method="post" action="<?=ROOT?>profile/cover" enctype="multipart/form-data">
					
	 					<div style="border:solid thin #aaa; padding: 10px;background-color: white;">

						 	<label for="photo_button" style="margin-left:10px;cursor: pointer;"><img src="/icons/photo.png" style="height:30px"></label>
	 						<input  style="display:none" id="photo_button" type="file" name="file"><br>
	 						<input id="post_button" type="submit" style="width:120px;" value="Change">
	 						<br>
							<div style="text-align: center;">
								<br>
							<?php

 	 							echo "<img src='" . ROOT . "$user_data[cover_image]' style='max-width:500px;width:80%' >";
								 
	 						?>
							</div>
	 					</div>
  					</form>

 				</div>
 		</div>

		<!--cover area-->
		<div id="main_block">
			
			<div id="profile_block">

					<?php 

						$image = "images/cover_image.jpg";
						if(file_exists($user_data['cover_image']))
						{
							$image = $image_class->get_thumb_cover($user_data['cover_image']);
						}
					?>

				<img id="cover_class" src="<?php echo ROOT . $image ?>">


				<span style="font-size: 12px;">
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

					<img id="profile_pic" src="<?php echo ROOT . $image ?>"><br/>

					<?php if(i_own_content($user_data)):?>
					
						<a onclick="show_change_profile_image(event)" style="text-decoration: none;color:#999;" href="<?=ROOT?>change_profile_image/profile">Change Profile Image</a> | 
						<a onclick="show_change_cover_image(event)" style="text-decoration: none;color:#999;" href="<?=ROOT?>change_profile_image/cover">Change Cover</a>
					
					<?php endif; ?>

				</span>
				<br>
					<div style="font-size: 20px;color: black;">
						<a href="<?=ROOT?>profile/<?php echo $user_data['userid'] ?>">
							<?php echo $user_data['first_name'] . " " . $user_data['last_name']  ?>
							<br><span style="font-size:12px;">@<?=$user_data['tag_name']?></span>
						</a>

						<br>
						<?php if($user_data['userid'] == $_SESSION['userid']): ?>
							<a href="<?=ROOT?>messages">
								<img style="height:25px" src="//localhost/icons/message.png">
							</a>
						<?php else: ?>
							<a href="<?=ROOT?>messages/new/<?=$user_data['userid']?>">
								<img style="height:25px" src="//localhost/icons/message.png">
							</a>
						<?php endif; ?>

						<?php
							$mylikes = "";
							if($user_data['likes'] > 0){

								$mylikes = $user_data['likes'];
							}
						?>
						

						<a style="text-align:center;font-size:15px" href="<?=ROOT?>like/user/<?php echo $user_data['userid']?>">
							<img style="height:25px" src="//localhost/icons/follow.png"> <?php echo $mylikes?>
						</a>

 						

					</div>
				<br>
				


				<a href="<?=ROOT?>home"><div id="menu_buttons">Timeline</div></a>
				<a href="<?=ROOT?>profile/<?php echo $user_data['userid'] ?>/about"><div id="menu_buttons">About</div></a>
				<a href="<?=ROOT?>profile/<?php echo $user_data['userid'] ?>/followers"><div id="menu_buttons">Followers</div></a>
				<a href="<?=ROOT?>profile/<?php echo $user_data['userid'] ?>/following"><div id="menu_buttons">Following</div></a>
				<a href="<?=ROOT?>profile/<?php echo $user_data['userid'] ?>/photos"><div id="menu_buttons">Photos</div></a>
				
				<?php 
					if($user_data['userid'] == $_SESSION['userid']){
						
						echo '<a href="'.ROOT. 'profile/'.$user_data['userid'].'/groups"><div id="menu_buttons">Groups</div></a>';
						echo '<a href="'.ROOT. 'profile/'.$user_data['userid'].'/settings"><div id="menu_buttons">Settings</div></a>';
					}
				?>
			</div>
			<div id="below">

			<!--below cover area-->
	 
	 		<?php 

	 			$section = "default";

	 			if(isset($URL[2])){

	 				$section = $URL[2];
	 			}

	 			if($section == "default"){

	 				include("profile_content_default.php");
	 			 
	 			}elseif($section == "following"){
	 				
	 				include("profile_content_following.php");

	 			}elseif($section == "followers"){

	 				include("profile_content_followers.php");

	 			}elseif($section == "about"){

	 				include("profile_content_about.php");

	 			}elseif($section == "settings"){

	 				include("profile_content_settings.php");

	 			}elseif($section == "photos"){

	 				include("profile_content_photos.php");
	 			}elseif($section == "groups"){

	 				include("profile_content_groups.php");
	 			}
				


	 		?>
			</div>

		</div>

	</body>
</html>

<script type="text/javascript">
	
	function show_change_profile_image(event){

		event.preventDefault();
		var profile_image = document.getElementById("change_profile_image");
		profile_image.style.display = "block";
	}


	function hide_change_profile_image(){

		var profile_image = document.getElementById("change_profile_image");
		profile_image.style.display = "none";
	}

	
	function show_change_cover_image(event){

		event.preventDefault();
		var cover_image = document.getElementById("change_cover_image");
		cover_image.style.display = "block";
	}


	function hide_change_cover_image(){

		var cover_image = document.getElementById("change_cover_image");
		cover_image.style.display = "none";
	}


	window.onkeydown = function(key){

		if(key.keyCode == 27){

			//esc key was pressed
			hide_change_profile_image();
			hide_change_cover_image();
		}
	}

	let btn = document.querySelectorAll('#btn');
let bubu = document.querySelectorAll('.bubu');

for( let i = 0; i < btn.length; i++ ){
  btn[i].addEventListener('click', function(){
    display( bubu[i], "none" );    
    
    console.log( 'Индекс i = ' + i );
  });
}

function display(elems, value){
  value = value || "block"; 
  // Если функцию вызвать только с одним аргументом, второй будет "block"
  
  if( elems instanceof HTMLElement ){  
    // Если elems - один HTML-элемент
    elems.style.display = value;    
    // изменится свойство элемента и выполнение функции прервется из-за return.
    return;
  }
  
  // А можно передать список элементов и одним вызовом скрыть все.
  for( let i = 0; i < elems.length; i++ ){
    elems[i].style.display = value;
  }
}
	
</script>