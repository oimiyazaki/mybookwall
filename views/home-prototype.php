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

        
        <img id="zero-to-one" class="book-wall-book" data-title="Zero to One" data-link-array='{ "linkArray" : [ {"title" : "Summary 1", "url" : "https://www.google.com/"} , {"title" : "Summary 2", "url" : "https://www.google.com/"} ] }' src="https://images-na.ssl-images-amazon.com/images/I/41puRJbtwkL.jpg">

        <!-- '{ "linkArray" : [ {"title" : "Summary 1", "url" : "https://www.google.com/"} ] }' -->


        <img id="the-lean-startup" src="https://images-na.ssl-images-amazon.com/images/I/517wplLjOXL.jpg">
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
    <a href="https://goo.gl/uVjmr9">Video: The Lean Startup by Eric Ries - BOOK SUMMARY</a>
    <a href="https://goo.gl/QHLUnM">Article: BOOK SUMMARY: THE LEAN STARTUP BY ERIC RIES</a>
  </div>
</div>
<script type="text/javascript">

     $('.book-wall-book').click(function() {

        // open modal
        document.getElementById('id01').style.display='block';
        
        // Populate modal with title information
        title = $(this).data('title');

        $("#modal-title").html(title);

        // Populate modal with links information
        linkObj = $(this).data('link-array');
        

        // TEST OBJECTS
        // linkObj = '{ "linkArray" : [ {"title" : "Summary 1", "url" : "https://www.google.com/"} ] }';
        // linkObj = '{ "linkArray" : [ {"title" : "Summary 1", "url" : "https://www.google.com/"} , {"title" : "Summary 2", "url" : "https://www.google.com/"} ] }';

        // console.log(linkObj["linkArray"][0].title);
        // console.log(linkObj["linkArray"][0].url);
        // console.log(linkObj["linkArray"][1].title);
        // console.log(linkObj["linkArray"][1].url);


        var linkContent = "";

        for (link in linkObj.linkArray) {

        console.log(linkObj["linkArray"][link].title);
        console.log(linkObj["linkArray"][link].url);

        linkContent += "<p><a href='" + linkObj["linkArray"][link].title + "'>" + linkObj["linkArray"][link].url + "</a></p>";

        }

        $("#modal-summaries").html(linkContent);

    }); 

</script>
