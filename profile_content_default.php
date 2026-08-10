<style>
.myCustomCss {
        width: 100%!important;
        position: flex!important;
		z-index: 0!important;
     }
	 </style>
		<div id="content_block" >	

				<!--friends area-->			
				<div id="left_friends_bar">
					
					<div id="friends_bar">
						
						Following<br>
 
 						<?php 

 	 					 	if($friends)
 	 					 	{

 	 					 		foreach ($friends as $friend) {
 	 					 			# code...
 
 									$FRIEND_ROW = $user->get_user($friend['userid']);
 	 					 			include("user.php");
 	 					 		}
 	 					 	}
 	 			 

	 					 ?>

					</div>

				</div>

				<!--posts area-->
 				<div id="post_area">
 					
 					<div id="posting">

 						<form method="post" enctype="multipart/form-data">

	 						<textarea class="myCustomCss" id="posting_form" name="post" placeholder="Поделитесь чем-нибудь!"></textarea>
							 <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
							 <script src="https://cdnjs.cloudflare.com/ajax/libs/emojionearea/3.4.2/emojionearea.min.js"></script>
							 <script type="text/javascript">
								$('#posting_form').emojioneArea({pickerPosition:'bottom'});

							 </script>

							<label for="photo_button" style="margin-left:10px;cursor: pointer;"><img src="/icons/photo.png" style="height:25px"></label>
	 						<input  style="display:none" id="photo_button" type="file" name="file">
	 						<input id="post_button" type="submit" value="Post">
	 						<br>
							
 						</form>
						
 					</div>
 
	 				<!--posts-->
	 				<div id="post_bar">
	 					
 	 					 <?php 

 	 					 	if($posts)
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
	 					 <input id="post_button" type="button" value="Next Page" style="margin-bottom:5px;float: right;width:120px;">
	 					 </a>
	 					 <a href="<?= $pg['prev_page'] ?>">
	 					 <input id="post_button" type="button" value="Prev Page" style="margin-bottom:5px;float: left;width:120px;">
	 					 </a>
	 				</div>

 				</div>
			</div>