<?PHP
$path = '';
require("includes/header.php");

?>
 <!-- Header -->
  <div class="w3-container" style="margin-top:80px" id="showcase">
    <h1 class="w3-jumbo"><b>Survey</b></h1>
    <h1 class="w3-xxxlarge w3-text-red"><b>Student Interest.</b></h1>
    <hr style="width:50px;border:5px solid red" class="w3-round">
  </div>

  <?php
  echo "This page will allow student's to complete an interest survey.";
  ?>
  <p>
    <label for="interest_txt">What are your interests:</label>
  </p> 
  <p>
    <textarea rows = "3"></textarea>
</p>
 


<?PHP
require("includes/footer.php");
