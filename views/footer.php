	<footer class="footer">
		<div class="container">
			<p>&copy; My Website 2018</p>
		</div>
	</footer>

	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
    <script type="text/javascript" src="jquery.min.js"></script>

    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	  <div class="modal-dialog" role="document">
	    <div class="modal-content">	
	      <div class="modal-header">
	        <h5 class="modal-title" id="loginModalTitle">Login</h5>
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	          <span aria-hidden="true">&times;</span>
	        </button>
	      </div>
	      <div class="alert alert-danger" id="loginAlert" style="display: none;"></div>
	      <div class="modal-body">
	        <form>
	          <input type="hidden" id="loginActive" name="loginActive" value="1">
			  <div class="form-group row">
			    <label for="email" class="col-sm-2 col-form-label">Email</label>
			    <div class="col-sm-10">
			      <input type="email" class="form-control" id="email">
			    </div>
			  </div>
			  <div class="form-group row">
			    <label for="password" class="col-sm-2 col-form-label">Password</label>
			    <div class="col-sm-10">
			      <input type="password" class="form-control" id="password">
			    </div>
			  </div>
			</form>
	      </div>
	      <div class="modal-footer">
	      	<a href="#" id="toggleLogin">Sign Up</a>
	        <button type="button" class="btn btn-primary" id="loginSignupButton">Login</button>
	      </div>
	    </div>
	  </div>
	</div>

	<script type="text/javascript">

		$("#toggleLogin").click(function() {
			if($("#loginActive").val() == "1") {
				$(this).html("Login");
				$("#loginActive").val("0");
				$("#loginModalTitle").html("Sign Up");
				$("#loginSignupButton").html("Sign Up");
			}else{
				$(this).html("Sign Up");
				$("#loginActive").val("1");
				$("#loginModalTitle").html("Login");
				$("#loginSignupButton").html("Login");
			}
		})

		$("#loginSignupButton").click(function() {
			$.ajax({
				type: "POST",
				url: "actions.php?action=loginSignup",
				data: "email=" + $("#email").val() + "&password=" + $("#password").val() + "&loginActive=" + $("#loginActive").val(),
				success: function(result) {
					if(result == "1"){
						window.location = "http://localhost/MySQL_Files/TwitterClone3/";
					}else{
						$("#loginAlert").html(result);
						$("#loginAlert").css("display","block");
					}
				} 
			})
		})

		$(".toggleFollow").click(function(){
			<?php if(array_key_exists('id', $_SESSION)){ ?>
				id = $(this).attr("data-userId");
				$.ajax({
					type: "POST",
					url: "actions.php?action=toggleFollow",
					data: "userId=" + id,
					success: function(result) {
						if(result == "1"){
							$("a[data-userId='"+ id +"']").html("Follow");
						}else if(result == "2"){
							$("a[data-userId='"+ id +"']").html("Unfollow");
						}
					} 
				})
				location.reload();
		    <?php }else{ ?>
		    	alert("Please Login/Signup to proceed.");
		    <?php } ?>
		})

		$("#postTweetButton").click(function(){

			$.ajax({
				type: "POST",
				url: "actions.php?action=postTweet",
				data: "tweetContent=" + $("#tweetContent").val(),
				success: function(result) {
					if(result == "1"){
						$("#tweetSuccess").fadeIn(1000);
						$("#tweetSuccess").fadeOut(1000, function(){
							window.location.replace("http://localhost/MySQL_Files/TwitterClone3/");
						});
						$("#tweetFailure").fadeOut();
					}else{
						$("#tweetFailure").html(result).fadeIn(1000);
						$("#tweetFailure").fadeOut(1000);
						$("#tweetSuccess").fadeOut();
					}
				} 
			})

		})

		$(".remove").hover(function(){
			$(this).css("cursor","pointer");
		})

		$(".remove").click(function(){

			$.ajax({
				type: "POST",
				url: "actions.php?action=removeTweet",
				data: "data-id=" + $(this).attr("data-id"),
				success: function(result) {
					if(result == "1"){
						location.reload();
					}
				} 
			});

		});

		$("#twitterLogo").hover(function(){
			$(this).attr("src", "http://localhost/MySQL_Files/TwitterClone3/images/twitterLogo2.png");
		}, function(){
			$(this).attr("src", "http://localhost/MySQL_Files/TwitterClone3/images/twitterLogo1.png");
		})

	</script>
  </body>
</html>