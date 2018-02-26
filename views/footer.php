		<footer>
			
		<!-- The actual snackbar -->
		<div id="snackbar"></div>

		</footer>

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


			////////////// Summary Modal Logic //////////////
                
            // Display summary form to add title and URL
            $("#addSummaryToggle").click(function() {

              // toggled add summary form display
              $("#addSummaryForm").toggle();

              // Change text between "Add summary" and "Collapse"
              if ($('#addSummaryForm').is(":visible")) {

                $("#addSummaryToggle").html("Collapse");

              } else {

                $("#addSummaryToggle").html("Add summary");

              }

            })

            // When the modal closes, reset text input fields and collapse "add summary" section
            $("#modalCloseButton").click(function() {

                $("#addSummaryForm").hide();
                $("#addSummaryToggle").html("Add summary");
                $("#addSummaryTitle").val("");
                $("#addSummaryUrl").val("");
                $("#addSummarySubmit").val("Add");
                $("#modal-summaries-added-locally").html("");

             })


            // //// Add book the the book db
            $("#addSummaryForm").submit(function(){

              // Clear error
              $("#modalError").html("");
              
              // get value from search field and build API URL
              var addSummaryTitle = $("#addSummaryTitle").val();
              var addSummaryUrl = $("#addSummaryUrl").val();
              var bookId = $(modalBookId).data('data-book-id');

              // front-end validation to ensure fields are not empty
              if (addSummaryTitle == "" || addSummaryUrl == "" || bookId == "") {

                  $("#modalError").html("Please enter a valid title and url.");

                  return false;

              } else {

                // POST sumamry to the db

                addSummaryTitleEncoded = encodeURIComponent(addSummaryTitle);
                addSummaryUrlEncoded = encodeURIComponent(addSummaryUrl);

                var url = "http://mybookwall.com/actions.php?bookId=" + bookId + "&title=" + addSummaryTitleEncoded + "&url=" + addSummaryUrlEncoded + ""; 

                $.ajax({
                    url: url,
                    type: "GET", /// ::::::::::::::::: Change GET to POST
                    success: function(data) {
              
                      response = JSON.parse(data);

                      // display success message and reset submission form
                      if (response.success == "Summary added successfully to book db.") {

                          $("#addSummarySubmit").val("Summary added. Add another.");
                          
                          $("#addSummaryTitle").val("");
                          
                          $("#addSummaryUrl").val("");

                          $("#modal-summaries-added-locally").append(`<a href='${addSummaryUrl}'>${addSummaryTitle}</a><br>`);

                          // If we have the no summaries text in the modal, clear it
                          if ($("#modal-no-summary").data('no-summary')) {
                            
                            $("#modal-summaries").html("");

                          }

                      // display error
                      } else if (response.error == "Enter a valid title and URL.") {

                          $("#modalError").html("Please enter a valid title and url.");

                      // display error
                      } else {

                          $("#modalError").html("Couldn't add the summary. Please Try again.");

                      }

                    }

                });

              }

              return false;

            });



		</script>
	</body>
</html>