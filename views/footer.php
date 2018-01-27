		<footer>
			


		</footer>
		<script src="jquery-3.2.1.min.js"></script>
		<script type="text/javascript">
		//////////////////////////////////////////////////
		/////////////// Functions Start  /////////////////
		//////////////////////////////////////////////////

		////////////// Login Signup page //////////////

			// Check email is in the right format
			function isEmail(email) {

			 	var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
				
				return regex.test(email);
			}


		////////////// add a book page //////////////

			function callback(jsonp) {



				var bookResults = "";

				// construct  search result table rows from google API jsonp
				for (book in jsonp.items) {
					
					var image = title = author = publishedDate = "";

					// get image if it exists
					if (jsonp.items[book].volumeInfo.hasOwnProperty("imageLinks")) {

						image = jsonp.items[book].volumeInfo.imageLinks.smallThumbnail;

					} else {

						image = "views/img/book_not_found.png";

					}

					// get title if it exists
					if (jsonp.items[book].volumeInfo.hasOwnProperty("title")) {

						title = jsonp.items[book].volumeInfo.title;

					}

					// get subtitle if it exists
					if (jsonp.items[book].volumeInfo.hasOwnProperty("subtitle")) {

						title = title + ": " + jsonp.items[book].volumeInfo.subtitle;

					} 

					// get authors if it exists
					if (jsonp.items[book].volumeInfo.hasOwnProperty("authors")) {

						author = "by " + jsonp.items[book].volumeInfo.authors[0];

					} 

					// get published date if it exists
					if (jsonp.items[book].volumeInfo.hasOwnProperty("publishedDate")) {

						publishedDate = jsonp.items[book].volumeInfo.publishedDate;

					} 

					// construct html
					bookResults += "<tr><td><img src=" + image + "></td><td><strong>" + title + "<br></strong><br>" + author + "<br><br>" + publishedDate + "<h3>hw</h3><br><td><button class='button'>Add to Library</button><h3>button</h3></td></tr>";

				}
				
				// finish creating the search table
				bookResults = "<table>" + bookResults + "</table>";

				// Add table to DOM
				$("#search-table-container").html(bookResults);

						

			}



		//////////////////////////////////////////////////
		//////////////// Functions End  //////////////////
		//////////////////////////////////////////////////










			////////////// Login / Signup page //////////////
				
			// When form submits continue
			$("#formSignUp").submit(function() {

				var error = "";

				// Display error if 1) email is empty, 2) email is invalid, and/ or 3) password is empty
				if ($("#emailSignUp").val() == "") {

					error += "<p>The email field cannot be empty.</p>";

				} else if (!isEmail($("#emailSignUp").val())) {

					error += "<p>The email entered is invalid.</p>"

				}

				if ($("#passwordSignUp").val() == "") {

					error += "<p>The password field cannot be empty.</p>";

				}

				// If an error is found, show error and prevent the form from submitting
				if (error != "") {

					$("#errorMessageSignUp").html(error);

					return false;

				}

			});


			// When form submits continue
			$("#formLogIn").submit(function() {

				var error = "";

				// Display error if 1) email is empty and/ or 2) password is empty
				if ($("#emailLogIn").val() == "") {

					error += "<p>The email field cannot be empty.</p>";

				} 

				if ($("#passwordLogIn").val() == "") {

					error += "<p>The password field cannot be empty.</p>";

				}

				// If an error is found, show error and prevent the form from submitting
				if (error != "") {

					$("#errorMessageLogIn").html(error);

					return false;

				}

			});


			////////////// add a book page //////////////

			// Google books API ajax on search
			$("#searchBooks").submit(function(){
				
				// get value from search field DOM
				var searchBookQuery = $("#searchBookQuery").val();

				var searchBookQueryURL = encodeURI(searchBookQuery);

				// ajax call
                $.ajax({
                    url: "https://www.googleapis.com/books/v1/volumes?q=" + searchBookQueryURL + "&key=AIzaSyCwh6PW3o8e_17gjee5xmwKAq2XwcLQ3Pw&callback=callback",
                    type: "GET",
                    dataType: 'jsonp',
                    success: function(data) {
                    
                    // function callback(jsonp) is being called here

                    }

                });



				return false;

			});


			// Add a book to library 

			// $(".button-submit").click(function () {
			// 	alert("Add book");
			// })

			// $(".button").click(function () {
			// 	alert("h2");
			// })

			// test start
			$("#insert2").click(function () {
					alert("h2");

					$("#insert2").html("hello world");


			});


						$("h3").click(function () {
				alert("this is a h3");

			});







			// start test

			$("#insert").html("<table><tr><td>This is a table</td></tr></table><img src='http://cdn.akc.org/Marketplace/Breeds/Boxer_SERP.jpg'>");
			
			$("#insert").html("<table><tr><td>This is a table</td></tr></table><img style='width: 25%; height: 25%' src='http://doglers.com/wp-content/gallery/Boxer-Puppies/Boxer-Puppy-Photo.jpg'>");			

			$("img").click(function () {
				alert("this is a image");

			});
			// test end 

		////////////// add a book page //////////////

		</script>
	</body>
</html>