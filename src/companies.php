<?PHP
$path = '';
require("../config.php");
require("functions/basic_html_functions.php");
require("functions/database_functions.php");
require("functions/company_form_functions.php");
$page = isset($_GET["page"])?$_GET["page"]:"search";
require("includes/header.php");

?>
 <!-- Header -->
  <div class="w3-container" style="margin-top:80px" id="showcase">
    <h1 class="w3-jumbo"><b>Companies</b></h1>
    <h1 class="w3-xxxlarge w3-text-red"><b>Search.</b></h1>
    <hr style="width:50px;border:5px solid red" class="w3-round">
  </div>

  <?php
  echo "A search of companies will appear below.";
  ?>



<?PHP
require("includes/footer.php");
