<!--top bar-->
<?php 

	$corner_image = "images/user_male.jpg";
	if(isset($USER)){
		
		if(file_exists($USER['profile_image']))
		{
			$image_class = new Image();
			$corner_image = $image_class->get_thumb_profile($USER['profile_image']);
		}else{

			if($USER['gender'] == "Female"){

				$corner_image = "images/user_female.jpg";
			}
		}
	}
?>

<div id="blue_bar">
	<a id="logo"href="<?=ROOT?>home"><img src="/icons/logo.png" style="margin-left:20px;float:left;height:70px"></a>

	<form method="get" action="<?=ROOT?>search">

		<div class="header">
			<a id="BUT_fam" href="<?=ROOT?>home">BUT family</a> 
			&nbsp &nbsp <input type="text" id="search_box" name="find" placeholder="Поиск" />

			<?php if(isset($USER)): ?>
				<a href="<?=ROOT?>profile">
				<img id="corner" src="<?php echo ROOT . $corner_image ?>">
				</a>
				<a href="<?=ROOT?>logout">
				<img src="//localhost/icons/logout.png" style="float: right;margin-top:15px;margin-right:8px;height:25px;width:25px;"></span>
				</a>
				
				<a href="<?=ROOT?>notifications">
				<span style="display: inline-block;position: relative;">
					<img src="<?=ROOT?>notification.svg" style="width:25px;height:25px;float:right;margin-top: 20px;margin-left:0px;">
					<?php 
						$notif = check_notifications();
					?>
					<?php if($notif > 0): ?>
						<div style="background-color: #2e2e2e;color: white;position: absolute;right:-15px;margin-top:10px;
						width:15px;height: 15px;border-radius: 50%;padding: 4px;text-align:center;font-size: 14px;"><?= $notif ?></div>
					<?php endif; ?>
				</span>
				</a>

				<a href="<?=ROOT?>messages">
				<span style="display: inline-block;position: relative;margin-left: 10px;">
 					<svg fill="black" style="float:right;margin-top: 10px" width="25" height="25" viewBox="0 0 24 24"><path d="M12 12.713l-11.985-9.713h23.971l-11.986 9.713zm-5.425-1.822l-6.575-5.329v12.501l6.575-7.172zm10.85 0l6.575 7.172v-12.501l-6.575 5.329zm-1.557 1.261l-3.868 3.135-3.868-3.135-8.11 8.848h23.956l-8.11-8.848z"/></svg>
					<?php 
						$notif = check_messages();
					?>
					<?php if($notif > 0): ?>
						<div style="background-color: red;color: white;position: absolute;right:-15px; margin-top:0px;
						width:15px;height: 15px;border-radius: 50%;padding: 4px;text-align:center;font-size: 14px;"><?= $notif ?></div>
					<?php endif; ?>
				</span>
				</a>

				

			<?php else: ?>
				<a href="<?=ROOT?>login">
				<span style="font-size:13px;float: right;margin:10px;color:white;">Login</span>
				</a>
			<?php endif; ?>


		</div>
	</form>
</div>