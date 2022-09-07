<?PHP
$path = '';
require("includes/header.php");
require("../config.php");
require("functions/database_functions.php");
require("functions/basic_html_functions.php");
require("functions/contacts_form_functions.php");
require("functions/industry_form_functions.php");
$page = isset($_GET["page"])?$_GET["page"]:"search";

  #<!-- Header -->
  display_page_heading("Industry Contacts","");
  display_contacts_page_navigation($page);

  
  switch($page){
    case "search":
      $string = isset($_GET["search"])?$_GET["search"]:"";
      $contacts = get_contact_by_name($string);
      display_contact_search_form();
      display_contact_list($contacts);
      break;
    case "add":
      #display_contact_form();
      break;
    case "edit":
      #$id = isset($_GET["id"])?$_GET["id"]:"";
      #$contact = get_contact($id);
      #display_contact_form($contact);
      break;
    case "contact":
      $id = isset($_GET["id"])?$_GET["id"]:"";
      $contact = get_contact($id);
      display_contact_info($contact);
      break;
  }
  ?>
  


<?PHP
require("includes/footer.php");
