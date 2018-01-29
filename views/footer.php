		<footer>
			


		</footer>
		<script src="jquery-3.2.1.min.js"></script>
		<script type="text/javascript">


			////////////// Login / Signup page Start //////////////
				
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


			////////////// Login / Signup page End //////////////
			////////////// add a book page Start //////////////

			// variables
			var searchResul

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


			////////////// add a book page End //////////////

		</script>
	</body>
</html>