<?php

	session_start();
	date_default_timezone_set('Asia/Kolkata');

	$link = mysqli_connect("localhost", "root", "", "twitter");
	if(mysqli_connect_error()){
		die("connection error!.. Try again later.");
	}

	if(array_key_exists("function", $_GET) and $_GET['function'] == "logout"){
		session_unset();
	}

	function time_since($since) {
	    $chunks = array(
	        array(60 * 60 * 24 * 365 , 'year'),
	        array(60 * 60 * 24 * 30 , 'month'),
	        array(60 * 60 * 24 * 7, 'week'),
	        array(60 * 60 * 24 , 'day'),
	        array(60 * 60 , 'hour'),
	        array(60 , 'min'),
	        array(1 , 'sec')
	    );

	    for ($i = 0, $j = count($chunks); $i < $j; $i++) {
	        $seconds = $chunks[$i][0];
	        $name = $chunks[$i][1];
	        if (($count = floor($since / $seconds)) != 0) {
	            break;
	        }
	    }

	    $print = ($count == 1) ? '1 '.$name : "$count {$name}s";
	    return $print;
	}

	function displayTweets($type){
		global $link;
		$whereClause = "";
		$flag = 0;
		if($type == 'isFollowing'){
			$query = "select * from isfollowing where follower = ".$_SESSION['id'];
			$result = mysqli_query($link, $query);
			if(mysqli_num_rows($result) == 0){
				echo "<br><strong>There are no tweets for you!</strong>";
				$flag = 1;
			}else{
				while($row = mysqli_fetch_assoc($result)){
					if($whereClause == ""){
						$whereClause = "where ";
					}else{
						$whereClause.="or ";
					}
					$whereClause.="userid = ".$row['isFollowing']." ";
				}
			}
		}else if($type == 'yourtweets'){

			$whereClause = " where userid = ".$_SESSION['id']." ";

		}else if($type == 'search'){

			if($_GET['q'] == ""){
				echo "<br><strong>Your search string was empty... Please try again.</strong>";
				$flag=1;
			}else{
				echo "<p>Showing results for '".mysqli_real_escape_string($link, $_GET['q'])."' :</p>";
				$whereClause = "where tweets like '%".mysqli_real_escape_string($link, $_GET['q'])."%' ";
			}

		}else if(is_numeric($type)){

			echo "<h2>".$_GET['email']."'s Tweets :</h2><br>";
			$whereClause = " where userid = ".$type." ";
		}
		if($flag == 0){
			$query = "select * from tweets ".$whereClause." order by datetime desc limit 10";
			$result = mysqli_query($link, $query);

			if(mysqli_num_rows($result) == 0){
				echo "<strong>There are no tweets to display!</strong>";
			}else{

				while($row = mysqli_fetch_assoc($result)){
					$userQuery = "select * from users where id = ".mysqli_real_escape_string($link, $row['userid'])." limit 1";
					$userQueryResult = mysqli_query($link, $userQuery);
					$user = mysqli_fetch_assoc($userQueryResult);
					echo "<div class='tweet'><p><a href='?page=publicprofiles&userid=".$user['id']."&email=".$user['email']."'>".$user['email']."</a> <span class='time'>".time_since(time() - strtotime($row['datetime']))." ago :</span>";
					if(array_key_exists('id', $_SESSION) and $_SESSION['id'] == $row['userid']){
						echo "<img src='images/closeSymbol.png' class='remove' data-id=".$row['id']." style='float: right;'></p>";
					}else{
						echo "</p>";
					}
					echo "<p>".$row['tweets']."</p>";
					if(array_key_exists('id',$_SESSION)){
						$query = "select * from isfollowing where follower = ".$_SESSION['id']." and isFollowing = ".$row['userid'];
						$result1 = mysqli_query($link, $query);
						$string = "";
						if(mysqli_num_rows($result1) == 0){
							$string = "Follow";
						}else{
							$string = "Unfollow";
						}
						echo "<p><a href='#' class='toggleFollow' data-userId=".$row['userid'].">".$string."</a></p></div>";
					}else{
						echo "<p><a href='#' class='toggleFollow' data-userId=".$row['userid'].">Follow</a></p></div>";
					}
				}

			}
		}
	}

	function displaySearch(){
		echo "<form class='form-inline'>
			  <div class='form-group mb-2'>
			  	<input type='hidden' name='page' value='search'>
			    <input type='text' name='q' class='form-control' id='search' placeholder='Search'>
			  </div>
			  	<button type='submit' id='searchButton' style='position: relative; top: 0.05mm; left: 15px;' class='btn btn-primary mb-2'>Search Tweets</button>
			</form>";
	}

	function displayTweetbox(){
		if(array_key_exists("id", $_SESSION)){
			echo "<div id='tweetSuccess' style='display: none; margin: auto 0;' class='alert alert-success'>Your Tweet was posted successfully</div><div id='tweetFailure' style='display: none; margin: auto 0;' class='alert alert-danger'></div><div class='form'>
					  <div class='form-group mb-2'>
					    <textarea type='text' style='position: relative; top: 8px;' class='form-control' id='tweetContent'></textarea>
					  </div>
					  <button id='postTweetButton' type='submit' style='position: relative; top: 15px;' class='btn btn-primary mb-2'>Post Tweet</button>
					</div>";
		}
	}

	function displayUsers(){

		global $link;
		$result = mysqli_query($link, "select * from users order by email limit 15");
		while($row=mysqli_fetch_assoc($result)){
			echo "<p><a href='?page=publicprofiles&userid=".$row['id']."&email=".$row['email']."'>".$row['email']."</a></p>";
		}

	}

?>