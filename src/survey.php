<?PHP
$path = '';
require("includes/header.php");
require("functions/survey_functions.php");

display_survey_page_navigation("Survey");

?>
 <!-- Header -->
  <div class="w3-container" style="margin-top:80px" id="showcase">
    <h1 class="w3-jumbo"><b>Survey</b></h1>
    <h1 class="w3-xxxlarge w3-text-red"><b>Student Interest.</b></h1>
    <hr style="width:50px;border:5px solid red" class="w3-round">
  </div>

  <p>

    <label for="sCode">Enter your survey code:</label>
    <input type="text" name="code" id="sCode">
</p>


<?PHP
require("includes/footer.php");
