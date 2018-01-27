<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
<div class="row">
	<div class="col-1">
  	</div>
	<div class="col-11">
  		<h2>Add books to your library</h2>
  	</div>
</div>
<div class="row">
	<div class="col-1">
  	</div>
	<div class="col-11">
	    <form id="searchBooks">
	        <input id="searchBookQuery" type="text" name="search" placeholder="Search by title, author, ISBN" required>
	        <input class="button-submit" id="searchBookButton" type="submit" name="searchBookbutton" value="Search">
	    </form>

	        <!-- test -->

  			<div id="insert">x</div>
  			  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

  			<script type="text/javascript">
  				


		</script>
        <!-- test -->


  	</div>
</div>
<div class="row">
	<div class="col-1">
  	</div>
  	<div class="col-11">
		<div id="search-table-container">

			<!-- When a user searches for a book, javascript will insert a table html here -->

		</div>
  	</div>
</div>



</body>



<script type="text/javascript">
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
			bookResults += "<tr><td><img src=" + image + "></td><td><strong>" + title + "<br></strong><br>" + author + "<br><br>" + publishedDate + "<h2>hw2</h2><br><td><button class='button'>Add to Library</button><h3>button</h3></td></tr>";

		}
		
		// finish creating the search table
		bookResults = "<table>" + bookResults + "</table>";

		// Add table to DOM
		$("#search-table-container").html(bookResults);

		$("#insert").html("<table><tr><td>This is a table</td></tr></table><img style='width: 25%; height: 25%' src='http://doglers.com/wp-content/gallery/Boxer-Puppies/Boxer-Puppy-Photo.jpg'>");	

			$("button").click(function () {
				alert("this is a image");

			});

	}


	///////////////////////////////// Footer //////////////////////////////

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

			// test start
			$("#insert2").click(function () {
					alert("h2");

					$("#insert2").html("hello world");


			});


						$("h3").click(function () {
				alert("this is a h3");

			});

			// start test

			// $("#insert").html("<table><tr><td>This is a table</td></tr></table><img src='http://cdn.akc.org/Marketplace/Breeds/Boxer_SERP.jpg'>");
			
			$("#insert").html("<table><tr><td>This is a table</td></tr></table><img style='width: 25%; height: 25%' src='http://doglers.com/wp-content/gallery/Boxer-Puppies/Boxer-Puppy-Photo.jpg'>");			

			$("img").click(function () {
				alert("this is a image");

			});
			// test end 

</script>



</html>