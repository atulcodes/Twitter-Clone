<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

    <title>Twitter</title>
    <link rel="stylesheet" type="text/css" href="http://localhost/MySQL_Files/TwitterClone3/styles.css">

  </head>
  <body>
  	<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item">
        <a class="nav-link" href="?page=timeline" style="margin-left: 40px;">Your Timeline</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="?page=yourtweets">Your Tweets</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="?page=publicprofiles">Public Profiles</a>
      </li>
    </ul>
    <div class="form-inline my-2 my-lg-0">
      <?php if(array_key_exists('id', $_SESSION)){
        $email = mysqli_query($link, "select email from users where id = ".$_SESSION['id']);
        $email = mysqli_fetch_assoc($email); 
        echo "Hi<a style='margin: 0 20px 0 10px;' href='?page=publicprofiles&userid=".$_SESSION['id']."&email=".$email['email']."'>".$email['email']."</a>";
      ?>
        <a class="btn btn-outline-success my-2 my-sm-0" href="?function=logout">Logout</a>
      <?php }else{ ?> 
        <button class="btn btn-outline-success my-2 my-sm-0" data-toggle="modal" data-target="#exampleModal">Login / Sign up</button>
      <?php } ?>  
    </div>
  </div>
</nav>
<div style="height: 5px; width: 5px; position: relative; top: -50px;"><a class="navbar-brand" href="http://localhost/MySQL_Files/TwitterClone3/"><img src="http://localhost/MySQL_Files/TwitterClone3/images/twitterLogo1.png" id="twitterLogo" style="position: relative; left: 4px; top: -6px;"></a></div>
