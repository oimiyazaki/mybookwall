<script type="text/javascript">

////////////// Login Signup page //////////////

	// Check email is in the right format
	function isEmail(email) {

	 	var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
		
		return regex.test(email);
	}


////////////// add a book page //////////////

	function callback(jsonp) {

		alert("hello world");

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
			bookResults += "<tr><td><img src=" + image + "></td><td><strong>" + title + "<br></strong><br>" + author + "<br><br>" + publishedDate + "<h2>hw23</h2><br><td><button class='button'>Add to Library</button><h3>button</h3></td></tr>";

		}
		
		// finish creating the search table
		bookResults = "<table>" + bookResults + "</table>";

		// Add table to DOM
		$("#search-table-container").html(bookResults);

				$("#insert").html("<table><tr><td>This is a table</td></tr></table><img src='https://a.wattpad.com/useravatar/BOXERPUPPIES.128.642834.jpg'>");

	}
</script>
