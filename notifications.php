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
	
	$Post = new Post();
	$User = new User();
 	$image_class = new Image();

?>

<!DOCTYPE html>
	<html>
	<head>
		<title>Notifications | BUT family</title>
		<link rel="stylesheet" href="//localhost/main.css">
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

 							$DB = new Database();
 							$id = esc($_SESSION['userid']);
 							$follow = array();

 							//check content i follow
 							$sql = "select * from content_i_follow where disabled = 0 && userid = '$id' limit 100";
 							$i_follow = $DB->read($sql);
 							if(is_array($i_follow)){
 								$follow = array_column($i_follow, "contentid");
 							}

 							if(count($follow) > 0){

 								$str = "'" . implode("','", $follow) . "'";
   								$query = "select * from notifications where (userid != '$id' && content_owner = '$id') || (contentid in ($str)) order by id desc limit 30";
 							}else{

  								$query = "select * from notifications where userid != '$id' && content_owner = '$id' order by id desc limit 30";
 							}
 
 							$data = $DB->read($query);
 						?>

 						<?php if(is_array($data)): ?>

 							<?php foreach ($data as $notif_row): 
 							 
 							 	include("single_notification.php");
  					 		 endforeach; ?>
  					 	<?php else: ?>
  					 			No notifications were found
  					 	<?php endif; ?>

 					</div>
  

 				</div>
			</div>

		</div>

	</body>
</html>