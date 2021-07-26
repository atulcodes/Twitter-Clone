<?php

	include("functions.php");
	include("views/header.php");
	if(array_key_exists('page', $_GET)){
		if($_GET['page'] == 'timeline'){
			if(array_key_exists('id',$_SESSION)){
				include("views/timeline.php");
			}else{
				echo "<div align='center'><br><strong>Please Login/Signup to proceed!</strong></div>"; 
			}
		}else if($_GET['page'] == 'yourtweets'){
			if(array_key_exists('id',$_SESSION)){
				include("views/yourtweets.php");
			}else{
				echo "<div align='center'><br><strong>Please Login/Signup to proceed!</strong></div>"; 
			}
		}else if($_GET['page'] == 'search'){
			if(array_key_exists('id',$_SESSION)){
				include("views/search.php");
			}else{
				echo "<div align='center'><br><strong>Please Login/Signup to proceed!</strong></div>"; 
			}
		}else if($_GET['page'] == 'publicprofiles'){
			if(array_key_exists('id',$_SESSION)){
				include("views/publicprofiles.php");
			}else{
				echo "<div align='center'><br><strong>Please Login/Signup to proceed!</strong></div>"; 
			}
		}
	}else{
		include("views/home.php");
	}
	include("views/footer.php");

?>