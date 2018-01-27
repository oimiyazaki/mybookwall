<div class="row">
	<div class="col-1">
  	</div>
	<div class="col-11">
  		<h2>Showcase your library</h2>
  	</div>
</div>
<div class="row">
	<div class="col-1">
  	</div>
	<div class="col-4">
		<!-- Sign up form -->
		<h3>Sign up</h3>
		<form method="post" id="formSignUp">
			
			<input type="text" name="emailSignUp" id="emailSignUp" placeholder="Email">
			<br>
			<input type="password" name="passwordSignUp" id="passwordSignUp" placeholder="Password">
			<br>
			<input type="checkbox" name="stayLoggedInSignUp" id="stayLoggedInSignUp">
			<br>
			<!-- <button type="submit">Sign up!</button> -->
			<input class="button-submit" type="submit" value="Sign up!">
		
		</form>
		
		<p id="errorMessageSignUp"></p>

		<?php echo $errorSignUp ?>

		<!-- Log in form -->
		<h3>Log in</h3>
		<form method="post" id="formLogIn">
			
			<input type="text" name="emailLogIn" id="emailLogIn" placeholder="Email">
			
			<input type="password" name="passwordLogIn" id="passwordLogIn" placeholder="Password">
			
			<input type="checkbox" name="stayLoggedInLogIn" id="stayLoggedInLogIn">
			
			<!-- <button type="submit">Log in!</button> -->
			<input class="button-submit" type="submit" value="Log in!">

		
		</form>

		<p id="errorMessageLogIn"></p>
		<?php echo $errorLogIn ?>

  	</div>
	<div class="col-7">
  	</div>
</div>