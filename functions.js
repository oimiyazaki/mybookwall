
////////////// Login Signup page //////////////

	// Check email is in the right format
	function isEmail(email) {

	 	var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
		
		return regex.test(email);
	}


////////////// add a book page //////////////

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
			bookResults += "<tr><td><img src=" + image + "></td><td><strong>" + title + "<br></strong><br>by " + author + "<br><br>Published: " + publishedDate + "<br><br>ISBN-13: " + isbn13 + "<br><td><button class='button' isbn13='" + isbn13 +"'>Adding...</button><p>Oh oh!<br>Could not add.<br>Try agian. </p></td></tr>";


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


		///////////// Make the Add to Library work /////////////


		function addBookToDatabase() {
		$.ajax({
			url: "http://mybookwall.com/actions.php?author=" + bookResultsArray[book].author + "&image=" + bookResultsArray[book].image + "&isbn13=" + bookResultsArray[book].isbn13 + "&publishedDate=" + bookResultsArray[book].publishedDate + "&title=" + bookResultsArray[book].title + "",
			type: "GET", /// ::::::::::::::::: Change GET to POST
			success: function(data) {


				console.log(data);


			}});

		}


		$("button").click(function () {
			
			for (book in bookResultsArray) {

				if (bookResultsArray[book].isbn13 == $(this).attr("isbn13")) {

					// console.log(bookResultsArray[book].author);
					// console.log(bookResultsArray[book].image);
					// console.log(bookResultsArray[book].isbn13);
					// console.log(bookResultsArray[book].publishedDate);
					// console.log(bookResultsArray[book].title);

					addBookToDatabase()

				}

			}

		});

		
		





	}
