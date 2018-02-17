<!-- MODAL TEST CODE START -->
      <div id="id01" class="w3-modal">
        <div class="w3-modal-content w3-animate-top w3-card-4">
          <header class="w3-container modal-header"> 
            <span onclick="document.getElementById('id01').style.display='none'" 
            class="w3-button w3-display-topright" id="modalCloseButton">&times;</span>
            <h2 id="modal-title"></h2>
          </header>
          <div class="w3-container">
            <div id="modal-summaries"></div>
            <div> <!-- add summary functionality -->
              <br>
              <p class="text-link" id="addSummaryToggle">Add summary</p>
              <form id="addSummaryForm">
                <span>Title:</span>
                <input type="text" id="addSummaryTitle" name="title" placeholder="Summary title">
                <span>URL:</span>
                <input type="text" id="addSummaryUrl" name="url" placeholder="www.summary.com">
                <input class="button-submit" type="submit" value="Add">
              </form>
              <!-- START: TEMPORARY SCRIPT. THEN PLACE ON FOOTER -->
              <script type="text/javascript">
                
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

                 })

              </script>
              <!-- END: TEMPORARY SCRIPT. THEN PLACE ON FOOTER -->
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
