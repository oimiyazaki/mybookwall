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

////////////// Add book & search page //////////////


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


    			// check if book is already in collection db

				$query = "SELECT * FROM `collectionId` WHERE `userId` = '".userId($link)."' AND `bookId` = '".bookId($isbn13, $link)."'";

				$result = mysqli_query($link, $query);

				if (mysqli_num_rows($result) == 1) { // $result = mysqli_query($link, $query)

					// book is already in collections db.
					echo '{"success" : "Book already added to collections db."}';


				} else {

								
					// Add book to collections db using the bookId and userId
					$query = "INSERT INTO `collectionId` (`userId`, `bookId`) VALUES ('".userId($link)."', '".bookId($isbn13, $link)."')";

					if (mysqli_query($link, $query) === TRUE) {  

						// success
						echo '{"success" : "Book added successfully to collection db."}';

					} else {

						// Show error if the user could not be added 
						echo '{"error" : "Could not add book collections db."}';

					}	

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

				addBookToCollectionsDb($isbn13, $link);
		
		} else { 


			// Add book to the book db
			$query = "INSERT INTO `book` (`author`, `image`, `isbn13`, `publishedDate`, `title`) VALUES ('".$author."', '".$image."', '".$isbn13."', '".$publishedDate."', '".$title."')";

			if (mysqli_query($link, $query) === TRUE) {  

				// success : Book added successfully to book db
				
				// add book to collections db
				addBookToCollectionsDb($isbn13, $link); 

			} else {

				// Show error if the user could not be added 
				echo '{"error" : "Could not add book book db."}';


			}				


		}


	}

////////////// book wall page  //////////////

// Check to see if mybookwall property is set
if (isset($_GET["mybookwall"])) {

	$bookIdsInCollection = "";

	// search for books the user has in their collection
	$query = "SELECT `bookId` FROM `collectionId` WHERE userId = '".userId($link)."'";

	$result = mysqli_query($link, $query);

	while ($row = mysqli_fetch_array($result)) {

		$bookIdsInCollection .= $row["bookId"].",";

	}

	// Check if the user has zero books in their collection
	if (!$bookIdsInCollection) {

		echo "<h3>Welcome to your book wall! <a href='http://mybookwall.com/?p=addabook'>Add your first book</a>  :)</h3>";

	// The user does have books. Continue
	} else {

		// bookIds in the format: (1,2,3). This is for the query
		$bookIdsInCollection = "(".substr($bookIdsInCollection, 0, -1).")";

		$query = "SELECT * FROM `book` WHERE bookId in ".$bookIdsInCollection."";

		$result = mysqli_query($link, $query);

		if ($result->num_rows > 0) {
		    // output data of each row
		    while($row = $result->fetch_assoc()) {

		        // echo "<img src='" . $row["image"]."&printsec=frontcover&img=1&zoom=5&edge=curl&source=gbs_api'><br>";
		        
		    	echo "<img class='book-wall-book' data-title='".$row["title"]."' data-book-id='".$row["bookId"]."' src='" . $row["image"]."&printsec=frontcover&img=1&zoom=5&edge=curl&source=gbs_api'><br>";

		    }

		} else {
		    
		    echo "0 results";
		
		}

	}

}

////////////// Get book summaries  //////////////

	if (isset($_GET["summary"])) { 

		$bookId = mysqli_real_escape_string($link, $_GET["summary"]); 

		// search book db for book summary
		$query = "SELECT `summary` FROM `book` WHERE bookId = ".$bookId."";

		$result = mysqli_query($link, $query);

		$row = mysqli_fetch_array($result);

		// if no summary, echo "no book summary"
		if ($row["summary"] == NULL) {

			echo '{"success" : "no summary found."}';

		// else, echo summary links
		} else {

			// make sting into a JSON 
			$summaryArray = json_decode($row["summary"]);

			echo $row["summary"];


			// // // TCS - escape :::::::::::::::::::::::::::::::::::::::::::::::::::
			// // $escape = $link->real_escape_string("Zero to one — my summary of Peter Thiel’s book");
			// // echo $escape;	

			// // TCE - :::::::::::::::::::::::::::::::::::::::::::::::::::		


			// // print_r test code. :::::::::::::: END
			// $summary = '[
			// 		{
			// 			"title" : "8 Writing Lessons from Everybody Writes by Ann Handley",
			// 			"url" : "https://blog.marketo.com/2017/06/8-writing-lessons-everybody-writes-ann-handley.html"
			// 		},
			// 		{
			// 			"title" : "6 Lessons from Ann Handley to Help Anyone Write Better Content",
			// 			"url" : "https://www.impactbnd.com/blog/lessons-from-ann-handley-everyone-write-better-content"
			// 		},
			// 		{
			// 			"title" : "Key Takeaways From Everybody Writes",
			// 			"url" : "https://hub.uberflip.com/blog/key-takeaways-from-ann-handleys-everybody-writes"
			// 		}
			// 	]';
			// // echo to put JSON on page
			// echo $summary;

			// // encode to create links
			// $summaryArray = json_decode($summary);

			// // print_r test code. :::::::::::::: END			


		}	

	}

////////////// Add book summary (title and url) //////////////


function createSummaryJson($title, $url) {

		$summary = '{ "title" : "'.$title.'", "url" : "'.$url.'" }';

		return $summary;

}

function createFirstSummaryJson($title, $url) {

		$summary = "[ ".createSummaryJson($title, $url)." ]";

		return $summary;

}

function addNewSummaryStringToExistingSummaryString($newSummary, $existingSummary) {
	// :::::::::::::::::::::::::::::::::::: s
	// echo "1. existingSummary:<br>";
	// print_r($existingSummary);
	// echo "<br><br>";

	// echo "2. newSummary:<br>";
	// print_r($newSummary);
	// echo "<br><br>";
	// :::::::::::::::::::::::::::::::::::: e

	// create existingSummary (which is an array with objects inside) that is string into a JSON 
	$existingSummaryJsonArray = json_decode($existingSummary);

	// // :::::::::::::::::::::::::::::::::::: s
	// echo "3. existingSummaryJsonArray:";
	// print_r($existingSummaryJsonArray);
	// echo "<br><br>";
	// // :::::::::::::::::::::::::::::::::::: e


	// create Json object for the very first summary (which is an object)
	$newSummaryJsonObject = json_decode($newSummary);

	// :::::::::::::::::::::::::::::::::::: s
	// echo "4. newSummaryJsonObject:<br>";
	// // $newSummaryJsonObject = "hi";
	// print_r($newSummaryJsonObject);
	// echo "<br><br>";
	// // :::::::::::::::::::::::::::::::::::: e


	// append the new summary to the exisitng summaries
	array_push($existingSummaryJsonArray, $newSummaryJsonObject);

	// // :::::::::::::::::::::::::::::::::::: s
	// echo "5. existingSummaryJsonArray:<br>";
	// print_r($existingSummaryJsonArray);
	// echo "<br><br>";
	// // :::::::::::::::::::::::::::::::::::: e


	// make the new and old summaries into a string
	$newSummary = json_encode($existingSummaryJsonArray);

	// // :::::::::::::::::::::::::::::::::::: s
	// echo "6. newSummary:<br>";
	// print_r($newSummary);
	// echo "<br><br>";
	// // :::::::::::::::::::::::::::::::::::: e


	return $newSummary;

}

function updateBookDbWithNewSummaryJsonString($newSummary, $bookId, $link) {

	$query = "UPDATE `prodV1`.`book` SET `summary` = '".$newSummary."' WHERE `book`.`bookId` = '".$bookId."'";

	if (mysqli_query($link, $query) === TRUE) {  

		// success
		echo '{"success" : "Summary added successfully to book db."}';

	} else {

		// Show error if the summary could not be added 
		echo '{"error" : "Could not add summary book db."}';

	}	

}


if (isset($_GET["bookId"]) && isset($_GET["title"]) && isset($_GET["url"])) {

	$bookId = mysqli_real_escape_string($link, $_GET["bookId"]); // ::::::::::::::: Change GET to POST
	$title = mysqli_real_escape_string($link, $_GET["title"]); // ::::::::::::::: Change GET to POST
	$url = mysqli_real_escape_string($link, $_GET["url"]); // ::::::::::::::: Change GET to POST


	// ::::::::::::::::::::::::: Start

	// $title = htmlentities($title);

	// echo $titleClean;

	// echo html_entity_decode($titleClean);


	// ::::::::::::::::::::::::: End



	// Validate title is not empty and URL is valid
	if ($title == "" || !filter_var($url, FILTER_VALIDATE_URL)) {

		echo '{"error" : "Enter a valid title and URL."}';

	} else {

		// search book db for book summary
		$query = "SELECT `summary` FROM `book` WHERE bookId = ".$bookId."";

		$result = mysqli_query($link, $query);

		$row = mysqli_fetch_array($result);

		$existingSummary = $row["summary"];

		// if no summary, add new summary link to book db
		if ($existingSummary == NULL) {

			// create Json format string for the very first summary
			$newSummary = createFirstSummaryJson($title, $url);

			// add new summary to book db
			updateBookDbWithNewSummaryJsonString($newSummary, $bookId, $link);

		// else, add summary link to existing links in the book db
		} else {

			// create Json format string for the new summary
			$newSummary = createSummaryJson($title, $url);

			// append the new summary to the exisitng summaries. The output is a string in JSON format.
			$newSummary = addNewSummaryStringToExistingSummaryString($newSummary, $existingSummary);

			// add new summary to book db
			updateBookDbWithNewSummaryJsonString($newSummary, $bookId, $link);

		}

	}

}

// // ::::::::::::::::::::::::::::::::::::::::::::::::: Start

// echo "<br><br><br><br><br>::::::::::::::::::::::::::::::::::::::::::::::::::<br><br>";

// $string = '{ "title" : "Life\'2", "url" : "https://www.google.com" }';

// echo($string);
// echo "<br><br>";
// print_r(json_decode($string));
// echo "<br><br>";
// echo(json_encode($string));
// echo "<br><br>";
// print_r(json_decode($string));
// echo "<br><br>";
// echo(json_encode($string));
// // ::::::::::::::::::::::::::::::::::::::::::::::::: End


 ?>