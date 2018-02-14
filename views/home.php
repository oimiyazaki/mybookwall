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
<div class="row">
  <div class="col-12">
    <div id="book-wall-container" class="flex-container">
        
        <!-- Auto generate books here -->

    </div>
    	<!-- MODAL TEST CODE START -->
<!--         <img id="zero-to-one" class="book-wall-book" data-title="Zero to One" data-book-id="11" src="https://images-na.ssl-images-amazon.com/images/I/41puRJbtwkL.jpg">
        <p class="book-wall-book">open modal</p> -->
	<!-- MODAL TEST CODE END -->
  </div>
</div>
    <script type="text/javascript">
        
        // Triggers function to make Ajax call to populate bookWall
        displayBookWall();


    </script>
