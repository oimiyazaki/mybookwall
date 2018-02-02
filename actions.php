<?php 


////////////// Sessions //////////////

    // Start session
    session_start();


	// Check if a cookie exist. If it does, create a session
	if (array_key_exists("username", $_COOKIE)) {

		$_SESSION["username"] = $_COOKIE["username"];

	}



////////////// connect to DB //////////////


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

////////////// Display header //////////////

	// if session exists, welcome
	if (array_key_exists("username", $_SESSION)) {

		$menu = "<li class='menu-left'><a href='http://mybookwall.com/?p=addabook'>Add a Book</a></li><li class='menu-right'><form method='post' id='logOut'><input type='submit' name='LogOut' value='Log out'></form></li>";

	} else {

		$menu = "";

	}

////////////// Login Signup page //////////////


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

				if (mysqli_query($link, $query) === TRUE) {  

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

				// Query for email address in DB
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


	function bookId($isbn13, $link)
	{
		$isbn13 = $isbn13;
		$link = $link;

		$query = "SELECT `bookId` FROM `book` WHERE `isbn13` = '".$isbn13."'";

		$result = mysqli_query($link, $query);

		$row = mysqli_fetch_array($result);

		return $row["bookId"];

	}


	function userId($link)
	{

		$link = $link;

		$query = "SELECT `userId` FROM `users` WHERE email = '".$_SESSION["username"]."'";

		$result = mysqli_query($link, $query);

		$row = mysqli_fetch_array($result);

		return $row["userId"];

	}


	function addBookToCollectionsDb($isbn13, $link) {
    			
    			$isbn13 = $isbn13;
    			$link = $link;

				// Add book to collections db using the bookId and userId
				$query = "INSERT INTO `collectionId` (`userId`, `bookId`) VALUES ('".userId($link)."', '".bookId($isbn13, $link)."')";

				if (mysqli_query($link, $query) === TRUE) {  

					// success
					echo "{success : 'Book added successfully to collections db.'}";
					
					// get bookId to then add it to the collections table


				} else {

					// Show error if the user could not be added 
					echo "{error : 'Could not add book collections db.'}";

				}				

	};


	if (isset($_GET["author"]) && isset($_GET["image"]) && isset($_GET["isbn13"]) && isset($_GET["publishedDate"]) && isset($_GET["title"])) { // ::::::::::::::::::: Change GET to POST

		$author = mysqli_real_escape_string($link, $_GET["author"]); // ::::::::::::::: Change GET to POST
		$image = mysqli_real_escape_string($link, $_GET["image"]); // ::::::::::::::: Change GET to POST
		$isbn13 = mysqli_real_escape_string($link, $_GET["isbn13"]); // ::::::::::::::: Change GET to POST
		$publishedDate = mysqli_real_escape_string($link, $_GET["publishedDate"]); // ::::::::::::::: Change GET to POST
		$title = mysqli_real_escape_string($link, $_GET["title"]); // ::::::::::::::: Change GET to POST


		// qeury to check if isbn13 already exists in DB
		$query = "SELECT * FROM `book` WHERE `isbn13` = '".$isbn13."'";

		$result = mysqli_query($link, $query);

		// Check if the book is already in the book db. 
		if (mysqli_num_rows($result) > 0) {


				echo "book is already in book db";

				// book is already in book db. check if the book is already in the collections db for this user
				$query = "SELECT * FROM `collectionId` WHERE `userId` = '".userId($link)."' AND `bookId` = '".bookId($isbn13, $link)."'";

				// $result = mysqli_query($link, $query);

				if ($result = mysqli_query($link, $query)) {
					

					// add book to collections db
					addBookToCollectionsDb($isbn13, $link);

				} else {


					// book is already in collections db.
					echo "book is already in collections db";
				}

		} else { 

			// Add book to the book db
			$query = "INSERT INTO `book` (`author`, `image`, `isbn13`, `publishedDate`, `title`) VALUES ('".$author."', '".$image."', '".$isbn13."', '".$publishedDate."', '".$title."')";

			if (mysqli_query($link, $query) === TRUE) {  

				// success
				echo "{success : 'Book added successfully to book db.'}";
				
				// add book to collections db
				addBookToCollectionsDb($isbn13, $link); 

			} else {

				// Show error if the user could not be added 
				echo "{error : 'Could not add book to book db.'}";


			}				


		}


	}

////////////// book wall page  //////////////

if (isset($_GET["mybookwall"])) {

	$bookIdsInCollection = "";

	// search for books the user has in their collection
	$query = "SELECT `bookId` FROM `collectionId` WHERE userId = '".userId($link)."'";

	$result = mysqli_query($link, $query);

	while ($row = mysqli_fetch_array($result)) {

		$bookIdsInCollection .= $row["bookId"].",";

	}

	// bookIds in the format: (1,2,3). This is for the query
	$bookIdsInCollection = "(".substr($bookIdsInCollection, 0, -1).")";

	$query = "SELECT * FROM `book` WHERE bookId in ".$bookIdsInCollection."";

	$result = mysqli_query($link, $query);

	// while ($row = $result->fetch_assoc()) {

	// 	echo $row["title"];

	// }


	if ($result->num_rows > 0) {
	    // output data of each row
	    while($row = $result->fetch_assoc()) {
	        echo " " . $row["title"]."<br>";
	    }
	} else {
	    echo "0 results";
	}


}



 ?>