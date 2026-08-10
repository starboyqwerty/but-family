		<div style="display: flex;">	

				<!--friends area-->	
				<div id="left_friends_bar">		
					<div id="friends_bar">
					
					
						
						Members<br>
  						
							<?php if(group_access($_SESSION['userid'],$group_data,'member')):?>
							<?php
						 
								$image_class = new Image();
								$post_class = new Post();
								$user_class = new User();

								$members = $group->get_members($group_data['userid'],10);

								if(is_array($members)){

									foreach ($members as $member) {
										# code...
										$FRIEND_ROW = $user_class->get_user($member['userid']);
										include("user_group_member.inc.php");
									}

								}else{

									echo "This group has no members";
								}

							?>
							 
							<?php endif; ?>
					</div>

				

				</div>

				<!--posts area-->
 				<div id="post_area">
 					
 					<?php if(!($group_data['group_type'] == 'public' && !group_access($_SESSION['userid'],$group_data,'member'))): ?>
 					<div id="posting">

 					<form method="post" enctype="multipart/form-data">

	 						<textarea id="posting_form" name="post" placeholder="Whats on your mind?"></textarea>
							 <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
							 <script src="https://cdnjs.cloudflare.com/ajax/libs/emojionearea/3.4.2/emojionearea.min.js"></script>
							 <script type="text/javascript">
								$('#posting_form').emojioneArea({pickerPosition:'bottom'});

							 </script>
							
							<label for="photo_button" style="margin-left:10px;cursor: pointer;"><img src="//localhost/icons/photo.png" style="height:25px"></label>
	 						<input  style="display:none" id="photo_button" type="file" name="file">
	 						<input id="post_button" type="submit" value="Post">
	 						<br>
 						</form>
					</div>
 					<?php endif; ?>

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
	 					 <input id="post_button" type="button" value="Next Page" style="float: right;width:150px;">
	 					 </a>
	 					 <a href="<?= $pg['prev_page'] ?>">
	 					 <input id="post_button" type="button" value="Prev Page" style="float: left;width:150px;">
	 					 </a>
	 				</div>

 				</div>
			</div>