<div id="content">

	<br>
	<a href="<?=ROOT?>create_group">
		<input id="post_button" type="button" value="Create Group" style=" float: none;
        background-color: #ffb308;
        border:none;
        color: black;
        padding: 4px;
        font-size: 14px;
        border-radius: 2px;
        width: 50px;
        min-width: 50px;
        cursor: pointer;">
	</a>

	<div style="padding: 20px;">
	<?php
 
		$image_class = new Image();
		$group_class = new Group();
		$user_class = new User();

		$groups = $group_class->get_my_groups($user_data['userid']);

		if(is_array($groups)){

			foreach ($groups as $group) {
				# code...
				$FRIEND_ROW = $user_class->get_user($group['userid']);
				include("group.inc.php");
			}

		}else{

			echo "No groups were found!";
		}


	?>

	</div>
</div>