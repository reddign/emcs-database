<?PHP
$path = '';
require("display_openings_navigation.php");

?>
 <!-- Header -->
  <div class="w3-container" style="margin-top:80px" id="showcase">
    <h1 class="w3-jumbo"><b>Job Openings</b></h1>
    <h1 class="w3-xxxlarge w3-text-red"><b>Search.</b></h1>
    <hr style="width:50px;border:5px solid red" class="w3-round">
  </div>

<?PHP

require("includes/header.php");

display_openings_navigation("Openings");

require("includes/footer.php");
