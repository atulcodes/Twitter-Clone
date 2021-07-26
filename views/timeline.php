<div class="container mainContainer">
 	
 	<div class="row">
 		<div class="col-md-8">
 			
 			<h2>Tweets for you :</h2>
 			<br>
 			<?php displayTweets('isFollowing'); ?>

 		</div>
 		<div class="col-md-4">
 			<?php displaySearch(); ?>
 			<?php displayTweetbox(); ?>
 		</div>
 	</div>

 </div>