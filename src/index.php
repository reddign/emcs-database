<?PHP
$path = '';
require("includes/header.php");

?>
 <!-- Header -->
  <div class="w3-container" style="margin-top:80px" id="showcase">
    <h1 class="w3-jumbo"><b>EMCS Career</b></h1>
    <h1 class="w3-xxxlarge w3-text-red"><b>Database.</b></h1>
    <hr style="width:50px;border:5px solid red" class="w3-round">
  </div>

  <?php
  echo "Welcome to the main page of the EMCS database.";
  ?>
  
  <!-- Photo grid (modal) -->
  <div class="w3-row-padding">
    <div class="w3-half">
      <img src="images/student1.jfif" style="width:100%" onclick="onClick(this)" alt="CS Students in a Summer SCARP project">
      <img src="images/student2.jpg" style="width:100%" onclick="onClick(this)" alt="Students using tech">
      <img src="images/student3.png" style="width:100%" onclick="onClick(this)" alt="Students using tech">
    </div>

    <div class="w3-half">
      <img src="images/industry1.jfif" style="width:100%" onclick="onClick(this)" alt="Phoenix Connect employee works in the lab">
      <img src="images/industry2.jfif" style="width:100%" onclick="onClick(this)" alt="Company with an opportunity">
      <img src="images/industry3.jpeg" style="width:100%" onclick="onClick(this)" alt="Instacarts first software intern">
    </div>
  </div>

  <!-- Modal for full size images on click-->
  <div id="modal01" class="w3-modal w3-black" style="padding-top:0" onclick="this.style.display='none'">
    <span class="w3-button w3-black w3-xxlarge w3-display-topright">�</span>
    <div class="w3-modal-content w3-animate-zoom w3-center w3-transparent w3-padding-64">
      <img id="img01" class="w3-image">
      <p id="caption"></p>
    </div>
  </div>


<?PHP
require("includes/footer.php");
