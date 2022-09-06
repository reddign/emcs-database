<?PHP

function display_page_heading($mainHeading = "Change Main Heading",$subHeading){
    echo '<!-- Header -->';
    echo '<div class="w3-container" style="margin-top:40px" id="showcase">';
    echo '<h1 class="w3-jumbo"><b>'.$mainHeading.'</h1>';
    if($subHeading!=""){
        echo '<h1 class="w3-xxxlarge w3-text-red"><b>'.$subHeading.'.</b></h1>';
    }
    echo '<hr style="width:50px;border:5px solid red" class="w3-round">';
    echo '</div>';
}