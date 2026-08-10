<?php 

	include("classes/autoload.php");
	$image_class = new Image();

	$ERROR = "";

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
	 
	$msg_class = new Messages();

  	//new message//check if thread already exists
  	if(isset($URL[1]) && $URL[1] == "new"){

  		$old_thread = $msg_class->read($URL[2]);
  		if(is_array($old_thread)){

  			//redirect the user
  			header("Location: ".ROOT."messages/read/". $URL[2]);
			die;
  		}
  	}

	//if a message was posted
	if($ERROR == "" && $_SERVER['REQUEST_METHOD'] == "POST"){
 
		$user_class = new User();
		if(is_array($user_class->get_user($URL[2]))){

			$ERROR = $msg_class->send($_POST,$_FILES,$URL[2]);

			header("Location: ".ROOT."messages/read/". $URL[2]);
			die;
		}else{
			$ERROR = "The requested user could not be found!";
		}

		
	}

?>

<!DOCTYPE html>
	<html>
	<head>
		<title>Messages | BUT family</title>
		<link rel="stylesheet" href="//localhost/main.css">
		<link rel="stylesheet" href="//localhost/home_adaptive.css">
		<link rel="stylesheet" href="//localhost/emojionearea.css"/>
		<meta name="viewport" content="width=device-width, initial-scale=1" style="overflow:hidden">
	</head>
	<style>
	.myCustomCss {
        width: 100%!important;
        position: flex!important;
		background-color: #2e2e2e!important;
		color:white!important;
     }
	
	 #message_area{
	 }
	 #messanger_back{
		min-height:400px;
		max-height:800px;
		overflow:scroll;
	 }
	 @media only screen and (max-width:1200px){
		#messanger_back{
		min-height:400px;
		max-height:700px;
		overflow:scroll;
	 }
	 }
	 @media only screen and (max-width:800px){
		#messanger_back{
		min-height:500px;
		max-height:600px;
		overflow:scroll;
	 }}
	 @media only screen and (max-width:550px){
		#messanger_back{
		min-height:400px;
		overflow:scroll;
	 	}
	}




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
 					
 					<div id="message_area">

  						<form id="message_form" method="post" enctype="multipart/form-data">
							
 							
  								<?php

 									if($ERROR != ""){

								 		echo $ERROR;
								 	}else{

								 		if(isset($URL[1]) && $URL[1] == "read"){

 								 			echo "";
	  										if(isset($URL[2]) && is_numeric($URL[2])){
								 			
 								 				$data = $msg_class->read($URL[2]);
	  											
	  											$user = new User();
		 										$FRIEND_ROW = $user->get_user($URL[2]);

		 										include "user.php";

												echo "<div style='width:100px;float:right;'>";
		 										echo "<a href='".ROOT."messages'>";
		 										echo '<input id="post_button" type="button" style="border-radius:15px;width:auto;cursor:pointer;margin:4px;background: rgb(45,108,253);
												 background: linear-gradient(0deg, rgba(45,108,253,1) 0%, rgba(109,188,212,0.927608543417367) 43%, rgba(8,255,161,0.9220063025210083) 100%);" value="All Messages">';
		 										echo "</a>";

		 										if(is_array($data)){
			 										echo "<a href='".ROOT."delete/thread/". $data[0]['msgid'] ."'>";
			 										echo '<input id="post_button" type="button" style="border-radius:10px;width:auto;cursor:pointer;background: rgb(247,58,41);
													 background: linear-gradient(0deg, rgba(247,58,41,0.9780287114845938) 0%, rgba(255,198,8,0.8995973389355743) 100%);margin:4px;" value="Delete Thread">';
			 										echo "</a>";
			 									}
												echo "</div>";


		 										echo '
 		 										<div id="messanger_back">';
 		 											$user = new User();

 		 											if(is_array($data)){
	 		 											foreach ($data as $MESSAGE) {
	 		 												# code...
	  		 												//show($MESSAGE);
			 												$ROW_USER = $user->get_user($MESSAGE['sender']);

			 												if(i_own_content($MESSAGE)){
	 		 													include "message_right.php";
	 		 												}else{

	  		 													include "message_left.php";
			 												}
	 		 											}
 		 											}

		 										echo '
		 										</div>';

		 										echo '
		 										<div style="background-color:#2e2e2e;border:solid thin #aaa; padding: 10px;padding-bottom:20px;">

 								 						<textarea class="myCustomCss" id="posting_form" style="color:white;background-color: #2e2e2e;"name="message" placeholder="Сообщение"></textarea>
														  <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
														  <script src="https://cdnjs.cloudflare.com/ajax/libs/emojionearea/3.4.2/emojionearea.min.js"></script>
														  <script type="text/javascript">
															 $("#posting_form").emojioneArea({pickerPosition:"bottom"});
							 
														  </script>
														<label for="photo_button" style="margin-left:10px;cursor: pointer;"><img src="//localhost/icons/photo.png" style="height:25px"></label>
								 						<input id="photo_button" type="file" style="display:none"name="file" >
								 						<input id="post_button" type="submit" value="Send">
								 						<br>
 							 						
							 					</div>

							 					';

	  										}else{

	  											echo "That user could not be found<br><br>";
	  										}

								 		}else
								 		if(isset($URL[1]) && $URL[1] == "new"){

	  										echo "<div id='message_area1'>&nbsp &nbsp Start New Message with:<br><br>";
											
	  										if(isset($URL[2]) && is_numeric($URL[2])){
	  											
	  											$user = new User();
		 										$FRIEND_ROW = $user->get_user($URL[2]);
												
		 										include "user.php";
												 echo '
												 <div id="messanger_back" style="min-height:400px;">';
													 $user = new User();

													 if(is_array($data)){
														 foreach ($data as $MESSAGE) {
															 # code...
															  //show($MESSAGE);
															$ROW_USER = $user->get_user($MESSAGE['sender']);

															if(i_own_content($MESSAGE)){
																 include "message_right.php";
															 }else{

																  include "message_left.php";
															}
														 }
													 }

												echo '
												</div>';
												
		 										echo '
		 										<div style="background-color:#2e2e2e;border:solid thin #aaa; padding: 10px;padding-bottom:20px;">

												 <textarea class="myCustomCss" id="posting_form" style="color:white;background-color: #2e2e2e;"name="message" placeholder="Сообщение"></textarea>
												 <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
												 <script src="https://cdnjs.cloudflare.com/ajax/libs/emojionearea/3.4.2/emojionearea.min.js"></script>
												 <script type="text/javascript">
													$("#posting_form").emojioneArea({pickerPosition:"bottom"});
					
												 </script>
														<label for="photo_button" style="margin-left:10px;cursor: pointer;"><img src="//localhost/icons/photo.png" style="height:25px"></label>
														<input id="photo_button"type="file" style="display:none"name="file" >
 								 						<input id="post_button" type="submit" value="Send">
								 						<br>
 							 						
							 					</div>

							 					';

	  										}else{

	  											echo "That user could not be found<br><br>";
	  										}
	  										

								 		}else{

	  										echo "&nbsp &nbsp Messages<br><br>";
		  									$data = $msg_class->read_threads();
		  									$user = new User();
		  									$me = esc($_SESSION['userid']);

		  									if(is_array($data)){
			  									foreach ($data as $MESSAGE) {
			  										# code...
			  										$myid = ($MESSAGE['sender'] == $me) ? $MESSAGE['receiver'] : $MESSAGE['sender'];

			 										$ROW_USER = $user->get_user($myid);

			  										include("thread.php");
			  									}
		  									}else{
		  										echo "You have no messages!";
		  									}

		  									echo "<br style='clear:both;'>";
								 		}

										
 									}
 								?>
  							
	 						
	 						<br>
 						</form>
 					</div></div>
  

 				</div>
			</div>

		</div>

	</body>
</html>