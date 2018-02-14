
////////////// Login Signup page //////////////

	// Check email is in the right format
	function isEmail(email) {

	 	var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
		
		return regex.test(email);
	}


////////////// add a book page //////////////


	function displayToast(message) {

		$("#snackbar").html(message);

	    // Get the snackbar DIV
	    var x = document.getElementById("snackbar")

	    // Add the "show" class to DIV
	    x.className = "show";


	    // After 3 seconds, remove the show class from DIV
	    setTimeout(function(){ x.className = x.className.replace("show", ""); }, 3000);
	}


	function callback(jsonp) {


		var bookResults = "";

		var bookResultsArray = [];

		///////////// Generate table with search results /////////////

		// construct  search result table rows from google API jsonp
		for (book in jsonp.items) {
			
			var image = title = author = publishedDate = isbn13 = "";

			// get image if it exists
			if (jsonp.items[book].volumeInfo.hasOwnProperty("imageLinks")) {

				image = jsonp.items[book].volumeInfo.imageLinks.smallThumbnail;

				// console.log(image);

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

				author = jsonp.items[book].volumeInfo.authors[0];

			} 

			// get published date if it exists
			if (jsonp.items[book].volumeInfo.hasOwnProperty("publishedDate")) {

				publishedDate = jsonp.items[book].volumeInfo.publishedDate;

			} 

			// to get isbn13, check if industryIdentifiers exists
			if (jsonp.items[book].volumeInfo.hasOwnProperty("industryIdentifiers")) {

				// check if isbn13
				for (i in jsonp.items[book].volumeInfo.industryIdentifiers) {

					// if isbn13 is found...
					if (jsonp.items[book].volumeInfo.industryIdentifiers[i].type == "ISBN_13")  {

						isbn13 = jsonp.items[book].volumeInfo.industryIdentifiers[i].identifier;

					}

				}

			} 

			// construct html
			bookResults += "<tr><td><img src=" + image + "></td><td><strong>" + title + "<br></strong><br>by " + author + "<br><br>Published: " + publishedDate + "<br><br>ISBN-13: " + isbn13 + "<br><td><button class='button-add-book' isbn13='" + isbn13 +"'>Add</button><p class='search-error'></p></td></tr>";

			// build array of book objects
			var bookObj = {
			  isbn13 : isbn13,
			  title : title,
			  author : author,
			  publishedDate: publishedDate,
			  image : image
			};

			// push object to array
			bookResultsArray.push(bookObj);

		}
		
		// finish creating the search table
		bookResults = "<table>" + bookResults + "</table>";

		// Add table to DOM
		$("#search-table-container").html(bookResults);





		///////////// Make the Add to Library button work /////////////

		var addBookError = "";

		function addBookToDatabase() {

		var url = encodeURI("http://mybookwall.com/actions.php?author=" + bookResultsArray[book].author + "&image=" + bookResultsArray[book].image + "&isbn13=" + bookResultsArray[book].isbn13 + "&publishedDate=" + bookResultsArray[book].publishedDate + "&title=" + bookResultsArray[book].title + "");

		$.ajax({
			url: url,
			type: "POST", /// ::::::::::::::::: Change GET to POST
			success: function(data) {

				var response = data;
				response = JSON.parse(response);

				if (response.success == "Book already added to collections db.") {

						displayToast("Book already added.");

				} else if (response.success == "Book added successfully to collection db.") {

					displayToast("Successfully added book.");

				} else {

					displayToast("Could not add book. Please try again.");

				}

			}});


		}


		$(".button-add-book").click(function () {
			
			for (book in bookResultsArray) {

				if (bookResultsArray[book].isbn13 == $(this).attr("isbn13")) {

					addBookToDatabase();

				}

			}

		});

	}

////////////// Book wall page //////////////

// make request to get book summaries and populate modal
function getBookSummary() {

    $.ajax({
        url: "http://mybookwall.com/actions.php?summary=" + bookId + "",
        type: "GET",
        success: function(data) {
            
            //  parse json
            var summaryJson = JSON.parse(data);

				if (summaryJson.success == "no summary found.") {

		            // insert content into html
		            $("#modal-summaries").html("<p>No summaries yet.  :(</p>");


				// iterate through summaries and construct html
				} else {



		            // empty variable for summary content
		            var summaryContent = "";

		            // construct content from json
		            for (summary in summaryJson) {

		                var title = summaryJson[summary].title;
		                var url = summaryJson[summary].url;

		                summaryContent += `<a href="${url}">${title}</a><br>`;

		            }

		            // insert content into html
		            $("#modal-summaries").html(`<p>${summaryContent}</p>`);




				}






    }});

}



function displayBookWall() {

	$.ajax({
		url: "http://mybookwall.com/actions.php?mybookwall=me",
		type: "GET",
		success: function(data) {

		// display book wall
		$("#book-wall-container").html(data);

		///// Open and populate modal with book summaries		
	     $('.book-wall-book').click(function() {
	     	console.log("hi modal");

	        // open modal
	        document.getElementById('id01').style.display='block';
	        
	        // Populate modal with title information
	        title = $(this).data('title');

	        $("#modal-title").html(title);

	        // get bookID from html datatype
	        bookId = $(this).data('book-id');


	        // execute get book summaries
	        getBookSummary();


	    }); 



	}});

}