<?php 

////////////// Login Signup page //////////////



	// Check if a cookie exist. If it does, create a session
	if (array_key_exists("username", $_COOKIE)) {

		$_SESSION["username"] = $_COOKIE["username"];

	}

	// // If a session doesn't exist, redirect to sign up/ log in page
	// if (!array_key_exists("username", $_SESSION)) {

	// 	header("Location: http://mybookwall.com");

	// }

	// if session exists, welcome
	if (array_key_exists("username", $_SESSION)) {

		$menu = "<li class='menu-right'><form method='post' id='logOut'><input type='submit' name='LogOut' value='Log out'></form></li>";

	} else {

		$menu = "<li class='menu-right'><a href='http://mybookwall.com/?p=login'>Login or Sign up</a></li>";

	}



	// Connect to DB
	$servername = "localhost";
	$username = "rz1evutb36oq";
	$password = "19MYZK90mar*";
	$dbname = "prodV1";

	$link = mysqli_connect($servername, $username, $password, $dbname);

	// Error message if DB doesn't connect
	if (mysqli_connect_error()) {

		die("There was an error connecting to the database.");


	} 

	// Set variables
	$errorSignUp = "";
	$errorLogIn = "";


	// If the form sign up is submitted
	if (isset($_POST["emailSignUp"]) || isset($_POST["passwordSignUp"])) {

		$email = mysqli_real_escape_string($link, $_POST["emailSignUp"]);
		$password = mysqli_real_escape_string($link, $_POST["passwordSignUp"]);

		// Display error if 1) email is empty, 2) email is invalid, and/ or 3) password is empty
		if ($email == "") {

			$errorSignUp .= "<p>The email field cannot be empty.</p>";

		} elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {

			$errorSignUp .= "<p>The email entered is invalid.</p>";
			
			}

		if ($password == "") {

			$errorSignUp .= "<p>The password field cannot be empty.</p>";

		}

		// If no errors were found continue
		if ($errorSignUp == "") {

			// check if email is already in use
			$query = "SELECT * FROM users WHERE email = '".$email."'";

			$result = mysqli_query($link, $query);

			if (mysqli_num_rows($result) > 0) {

				$errorSignUp .= "<p>The email entered is already in use.</p>";

			} else { 

				// Add user to the database
				$hash = password_hash($password, PASSWORD_DEFAULT);

				$query = "INSERT INTO users (email, password) VALUES ('".$email."', '".$hash."')";

				if (mysqli_query($link, $query) === TRUE) {  /////////// Test Code: Replace -> TRUE with -> (mysqli_query($link, $query) === TRUE)

					// If they decided to stay logged in, create cookie
					if (isset($_POST["stayLoggedInSignUp"])) {

						setcookie("username", $email, time() + 86400 * 7);
						
					} 

					// Create session and log them in
					$_SESSION["username"] = $email; 

					header("Location: http://mybookwall.com");


				} else {

					// Show error if the user could not be added 
					$errorSignUp .= "<p>An error occured. Please try again.</p>";

				}				


			}


		}


	}

	// If the form log in is submitted
		if (isset($_POST["emailLogIn"]) || isset($_POST["passwordLogIn"])) {

			$email = mysqli_real_escape_string($link, $_POST["emailLogIn"]);

			$password = mysqli_real_escape_string($link, $_POST["passwordLogIn"]);

			// Display error if 1) email is empty, 2) email is invalid, and/ or 3) password is empty
			if ($email == "") {

				$errorLogIn .= "<p>The email field cannot be empty.</p>";

			} 

			if ($password == "") {

				$errorLogIn .= "<p>The password field cannot be empty.</p>";

			}

			// If no errors were found continue
			if ($errorLogIn == "") {

				// Query for email addres in DB
				$query = "SELECT * FROM users WHERE email = '".$email."'";

				$result = mysqli_query($link, $query);

				// Show error if the email address is not found
				if (!mysqli_num_rows($result) > 0) {

					$errorLogIn .= "<p>Invalid email or password.</p>";

				} else {

					// Query for email address
					$row = mysqli_fetch_array($result);

					// Show error if the password is not a match
					if (!password_verify($password, $row["password"])) {

						$errorLogIn .= "<p>Invalid email or password.</p>";

					} else {

						// If they decided to stay logged in, create cookie
						if (isset($_POST["stayLoggedInLogIn"])) {

							setcookie("username", $email, time() + 86400 * 7);
							
						} 

						// Create session and log them in
						$_SESSION["username"] = $email; 


						header("Location: http://mybookwall.com");
					}

				}

			}

		}


////////////// Log out //////////////

	// Log out
	if (isset($_POST["LogOut"])) {

		// Unset all of the session variables.
		// $_SESSION = array();

		// If it's desired to kill the session, also delete the session cookie.
		// Note: This will destroy the session, and not just the session data!
		if (ini_get("session.use_cookies")) {
		    $params = session_get_cookie_params();
		    setcookie(session_name(), '', time() - 42000,
		        $params["path"], $params["domain"],
		        $params["secure"], $params["httponly"]
		    );
		}

		// Finally, destroy the session.
		session_destroy();

		// Remove cookie
		setcookie("username", "", time() - 3600);


		// Redirect to sign up/ log in page
		header("Location: http://mybookwall.com");

	}

////////////// search page //////////////






 ?>