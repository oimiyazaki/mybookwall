
////////////// Login Signup page //////////////

	// Check email is in the right format
	function isEmail(email) {

	 	var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
		
		return regex.test(email);
	}


////////////// add a book page //////////////

	function callback(jsonp) {

		rawObject = jsonp;

		var bookResults = "";

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

				author = "by " + jsonp.items[book].volumeInfo.authors[0];

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
			bookResults += "<tr><td><img src=" + image + "></td><td><strong>" + title + "<br></strong><br>" + author + "<br><br>Published: " + publishedDate + "<br><br>ISBN-13: " + isbn13 + "<br><td><button class='button' isbn13='" + isbn13 +"'>Add to Library</button></td></tr>";

		}
		
		// finish creating the search table
		bookResults = "<table>" + bookResults + "</table>";

		// Add table to DOM
		$("#search-table-container").html(bookResults);


		///////////// Make the Add to Library work /////////////

		// add to library buttons
		$("button").click(function () {
			
			alert($(this).attr("isbn13"));


		});


		// object test start

		var bookResultsObj = {};


		var bookObj = {
		  author : "omar",
		  date : "05/17/1990",
		  image: "http:home.com"
		};

		bookResultsObj.isbn13a = bookObj;


		console.log(bookResultsObj.isbn13a.author);
		console.log(bookResultsObj.isbn13a.image);

		var bookObj = {
		  author : "brownie",
		  date : "05/26/1985",
		  image: "http:homer.com"
		};

		bookResultsObj.isbn13b = bookObj;


		console.log(bookResultsObj.isbn13b.author);
		console.log(bookResultsObj.isbn13b.image);

		// object test end



	}
