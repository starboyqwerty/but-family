
	<div id="message_left" style="background: rgb(45,108,253);
background: linear-gradient(0deg, rgba(45,108,253,1) 0%, rgba(109,188,212,0.927608543417367) 43%, rgba(8,255,161,0.9220063025210083) 100%);">
		<div>
		
			<?php 

				$image = "images/user_male.jpg";
				if($ROW_USER['gender'] == "Female")
				{
					$image = "images/user_female.jpg";
				}

				if(file_exists($ROW_USER['profile_image']))
				{
					$image = $image_class->get_thumb_profile($ROW_USER['profile_image']);
				}
  
			?>

			<img id="message_img" src="<?php echo ROOT . $image ?>" >
		</div>
		<div style="width: 100%;">
			<div style="font-weight: bold;color: #405d9b;width: 100%;">
				<?php 
					echo "<a href='".ROOT."profile/$MESSAGE[msgid]'>";
					echo htmlspecialchars($ROW_USER['first_name']) . " " . htmlspecialchars($ROW_USER['last_name']); 
					echo "</a>";

				 
				?>
				
		<span style="color: #999;float:right">
			
			<?php 

				$post = new Post();
  
					echo "<a href='".ROOT."delete/msg/$MESSAGE[id]' >";
		 				echo '<svg fill="#2e2e2e" width="24" height="24" viewBox="0 0 24 24"><path d="M12 0c-6.627 0-12 5.373-12 12s5.373 12 12 12 12-5.373 12-12-5.373-12-12-12zm4.151 17.943l-4.143-4.102-4.117 4.159-1.833-1.833 4.104-4.157-4.162-4.119 1.833-1.833 4.155 4.102 4.106-4.16 1.849 1.849-4.1 4.141 4.157 4.104-1.849 1.849z"/></svg>';
					echo "</a>";
  
			 ?>

		</span>
			</div>
			
			
			<?php echo check_tags($MESSAGE['message']) ?>
  
			<?php 

				if(file_exists($MESSAGE['file']))
				{

					$post_image = ROOT . $image_class->get_thumb_post($MESSAGE['file']);

					echo "<img src='$post_image' style='width:80%;' />";
				}
				
			?>

		<br/>
		 
		<span style="color:#2e2e2e;float:right;font-size:15px;">
			
			<?php 
				$time = new Time();
				echo $time->get_time($MESSAGE['date']) ?>

		</span>

		<?php 

			if(file_exists($MESSAGE['file'])){

				echo "<a href='".ROOT."image_view/msg/$MESSAGE[id]' >";
				echo ". View Full Image . ";
				echo "</a>";
			}
		?>

 
		</div>
	</div>