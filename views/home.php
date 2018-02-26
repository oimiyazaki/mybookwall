<!-- MODAL TEST CODE START -->
      <div id="id01" class="w3-modal">
        <div class="w3-modal-content w3-animate-top w3-card-4">
          <header class="w3-container modal-header"> 
            <span onclick="document.getElementById('id01').style.display='none'" 
            class="w3-button w3-display-topright" id="modalCloseButton">&times;</span>
            <h2 id="modal-title">
                <!-- API request populates title here -->
            </h2>
            <div id="modalBookId">
                <!-- When the modal opens, the "data-book-id" gets set to be used in API calls -->              
            </div>
          </header>
          <div class="w3-container">
            <p>
              <div id="modal-summaries">
                    <!-- API request populates summaries here -->
              </div>
              <div id="modal-summaries-added-locally">
                  <!-- New summaries successfully added with the form populate here without going to the BE -->
              </div>
            </p>
            <div> <!-- add summary functionality -->
              <br>
              <p class="text-link" id="addSummaryToggle">Add summary</p>
              <form id="addSummaryForm">
                <span>Title:</span>
                <input type="text" id="addSummaryTitle" name="title" placeholder="Summary title">
                <span>URL:</span>
                <input type="text" id="addSummaryUrl" name="url" placeholder="www.summary.com">
                <p class="text-error" id="modalError"></p>
                <input class="button-submit" type="submit" id="addSummarySubmit" value="Add">
              </form>
            </div>
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
  </div>
</div>
    <script type="text/javascript">
        
        // Triggers function to make Ajax call to populate bookWall
        displayBookWall();


    </script>
