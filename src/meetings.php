<?PHP
$path = '';
require("includes/header.php");
require("../config.php");
require("functions/basic_html_functions.php");
require("functions/database_functions.php");
#require("functions/student_form_functions.php");
require("functions/meeting_form_functions.php");

$page = isset($_GET["page"])?$_GET["page"]:"search";
if(isset($_POST) && isset($_POST["page"]) && $_POST["page"]=="save"){
  #debug_to_console($_POST);
  process_meeting_form_data($_POST);
  exit;
}

?>
 <!-- Header -->
  <?php
    display_page_heading("Meetings","");
    display_meeting_page_navigation("Meetings");
  ?>
  <?php
  //$page = isset($_GET["page"])?$_GET["page"]:"search";
  switch($page){
    // Adding the search, add, edit, and meeting functionality
    case "search":
      $search = isset($_GET["search"])?$_GET["search"]:"";

      //Search by date
      $searchDate = isset($_GET["searchDate"])?$_GET["searchDate"]:"";

      //Search by location
      $searchLoc = isset($_GET["searchLoc"])?$_GET["searchLoc"]:"";

      #$meetings = get_meetings_by_name($search);

      //Throwing search results into $meetings
      $meetings = get_meetings_by_search($search, $searchDate, $searchLoc);

      //Display meeting data on page
      display_search_meeting_form();
      display_meeting_list($meetings);
      
      break;
    case "add":
      display_meeting_form();
      break;
    case "edit":
      $mid = isset($_GET["mid"])?$_GET["mid"]:"";
      $meeting = get_meeting($mid);
      #echo "<h2><b>".$meeting["meetingID"]."</b></h2>";
      display_meeting_list($meeting);
      display_meeting_form($meeting);
      break;
    case "meeting":
      $mid = isset($_GET["mid"])?$_GET["mid"]:"";
      $meeting = get_meeting($mid);
      display_meeting_info($meeting);
      break;
  }
  
  require("includes/footer.php");
  ?>

