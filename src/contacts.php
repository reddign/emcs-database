<?PHP
$path = '';
require("includes/header.php");
require("functions/basic_html_functions.php");
require("functions/contacts_form_functions.php");
$page = isset($_GET["page"])?$_GET["page"]:"search";

  #<!-- Header -->
  display_page_heading("Industry Contacts","");
  display_contacts_page_navigation($page);

  
  echo "A search of company contacts will appear below.";
  switch($page){
    case "search":
      $string = isset($_GET["search"])?$_GET["search"]:"";
      #$students = get_student_by_name($string);
      #display_search_form();
      #display_student_list($students);
      break;
    case "add":
      #display_student_form();
      break;
    case "edit":
      #$sid = isset($_GET["sid"])?$_GET["sid"]:"";
      #$student = get_student($sid);
      #display_student_list($student);
      #display_student_form($student);
      break;
  }
  ?>
  


<?PHP
require("includes/footer.php");
