<div class="row">

<!-- MODAL TEST CODE START -->
      <div id="id01" class="w3-modal">
        <div class="w3-modal-content w3-animate-top w3-card-4">
          <header class="w3-container modal-header"> 
            <span onclick="document.getElementById('id01').style.display='none'" 
            class="w3-button w3-display-topright">&times;</span>
            <h2 id="modal-title">X</h2>
          </header>
          <div class="w3-container" id="modal-summaries">
            
          </div>
        </div>
      </div>
    </div>
<!-- MODAL TEST CODE END -->




  <div class="col-12">
    <div id="book-wall-container" class="flex-container">
        <img id="elon-musk" src="https://images-na.ssl-images-amazon.com/images/I/5174GQsw2oL.jpg">
        <img id="the-hard-thing-about-hard-things" src="https://images-na.ssl-images-amazon.com/images/I/51slqM2g3jL.jpg"> 
        <img id="business-model-canvas" src="https://images-na.ssl-images-amazon.com/images/I/61wumph8%2B4L.jpg"> 

        <img id="zero-to-one" class="book-wall-book" data-title="Zero to One" data-book-id="11" src="https://images-na.ssl-images-amazon.com/images/I/41puRJbtwkL.jpg">
        <img id="the-lean-startup" class="book-wall-book" data-title="Good to Great" data-book-id="30" src="https://images-na.ssl-images-amazon.com/images/I/517wplLjOXL.jpg">


        <img id="the-everything-store" src="https://images-na.ssl-images-amazon.com/images/I/51hJ%2BguIj7L.jpg"> 
        <img id="pour-your-heart-into-it" src="https://images-na.ssl-images-amazon.com/images/I/41Qb90x5eWL.jpg"> 
        <img id="how-to-win-friends-and-influence-people" src="https://images-na.ssl-images-amazon.com/images/I/718%2Bbq5ApRL.jpg"> 
        <img id="think-grow-rich" src="https://images-na.ssl-images-amazon.com/images/I/51vcvIztyxL.jpg"> 
        <img id="the-7-habits-of-highly-effective-people" src="https://images-na.ssl-images-amazon.com/images/I/51S1IFlzLcL.jpg">
        <img id="the-power-of-habit" src="https://images-na.ssl-images-amazon.com/images/I/51NzjhIhK0L.jpg">
        <img id="the-snowball" src="https://images-na.ssl-images-amazon.com/images/I/81HYgCv2ABL.jpg">
        <img id="steve-jobs" src="https://images-na.ssl-images-amazon.com/images/I/81VStYnDGrL.jpg">
        <img id="the-innovators" src="https://images-na.ssl-images-amazon.com/images/I/519KsxAU05L.jpg">
        <img id="outliers" src="https://images-na.ssl-images-amazon.com/images/I/41683QNEDwL.jpg">
</div>
<script type="text/javascript">

     $('.book-wall-book').click(function() {

        // open modal
        document.getElementById('id01').style.display='block';
        
        // Populate modal with title information
        title = $(this).data('title');

        $("#modal-title").html(title);

        // get bookID from html datatype
        bookId = $(this).data('book-id');

        // make request to get book summaries
        function getBookSummary() {

            $.ajax({
                url: "http://mybookwall.com/actions.php?summary=" + bookId + "",
                type: "GET",
                success: function(data) {
                    
                    //  parse json
                    var summaryJson = JSON.parse(data);

                    // empty variable for summary content
                    var summaryContent = "";

                    // construct content from json
                    for (summary in summaryJson) {

                        var title = summaryJson[summary].title;
                        var url = summaryJson[summary].url;

                        summaryContent += `<a href="${url}">${title}</a><br>`;

                    }

                    // insert content into html
                    $("#modal-summaries").html(summaryContent);

            }});

        }

        // executre get book summaries
        getBookSummary();



    }); 

</script>
