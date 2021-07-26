<?php

	include("functions.php");

	if(array_key_exists("action", $_GET) and $_GET["action"] == "loginSignup"){
		$error = "";

		if(!$_POST["email"]){
			$error.="<p>Email Addres is required.</p>";
		}
		if(!$_POST["password"]){
			$error.="<p>Password is required.</p>";
		}
		if($_POST["email"] and filter_var($_POST["email"],FILTER_VALIDATE_EMAIL) === false){
			$error.="<p>Please enter a valid Email Address.</p>";
		}

		if($error != ""){
			echo $error;
			exit();
		}

		if($_POST['loginActive'] == "0"){
			
			$query = "select * from users where email = '".mysqli_real_escape_string($link, $_POST['email'])."' limit 1";
			$result = mysqli_query($link, $query);
			if(mysqli_num_rows($result) > 0){
				$error.="<p>That Email Address is already taken! Try another one.</p>";
			}else{
				$query = "insert into users(email,password) values('".mysqli_real_escape_string($link, $_POST['email'])."', '".mysqli_real_escape_string($link, $_POST['password'])."')";
				if(mysqli_query($link, $query)){
					$_SESSION['id'] = mysqli_insert_id($link);
					$query = "update users set password = '".md5(md5($_SESSION['id']).$_POST['password'])."' where id = ".$_SESSION['id']." limit 1";
					if(mysqli_query($link, $query)){
						echo "1";
					}else{
						$error.="<p>Couldn't create user.. Please try again later.";
					}
				}else{
					$error.="<p>Couldn't create user.. Please try again later.";
				}
			}

		}else{

			$query = "select * from users where email = '".mysqli_real_escape_string($link, $_POST['email'])."' limit 1";
			$result = mysqli_query($link, $query);
			$row = mysqli_fetch_assoc($result);
			if($row['password'] == md5(md5($row['id']).$_POST['password'])){
				$_SESSION['id'] = $row['id'];
				echo "1";
			}else{
				$error.="<p>Couldn't find that username/password combination. Please try again.</p>";
			}
			
		}
		
		if($error != ""){
			echo $error;
			exit();
		}

	}
	if(array_key_exists("action", $_GET) and $_GET["action"] == "toggleFollow"){
		$query = "select * from isfollowing where follower = ".$_SESSION['id']." and isFollowing = ".$_POST['userId'];
		$result = mysqli_query($link, $query);
		if(mysqli_num_rows($result) > 0){
			$row = mysqli_fetch_assoc($result);
			$query = "delete from isfollowing where id = ".$row['id']." limit 1";
			mysqli_query($link, $query);
			echo "1";
		}else{
			$row = mysqli_fetch_assoc($result);
			$query = "insert into isfollowing(follower, isFollowing) values(".$_SESSION['id'].", ".$_POST['userId'].")";
			mysqli_query($link, $query);
			echo "2";
		}
	}

	if(array_key_exists('action', $_GET) and $_GET['action'] == "postTweet"){
		if(!$_POST['tweetContent']){
			echo "Your Tweet is empty!";
		}else if(strlen($_POST['tweetContent']) > 140){
			echo "Your tweet is too long!";
		}else{
			 mysqli_query($link, "insert into tweets(userid,tweets) values('".mysqli_real_escape_string($link, $_SESSION['id'])."', '".mysqli_real_escape_string($link, $_POST['tweetContent'])."')");

			 echo "1";
		}
	}
	if(array_key_exists('action', $_GET) and $_GET['action'] == "removeTweet"){
		if(mysqli_query($link, "delete from tweets where id = ".$_POST['data-id'])){
			echo "1";
		}
	}
?>