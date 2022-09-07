<?PHP
function display_contacts_page_navigation($currentPage){
    $navHTML  = '<h4><div style="margin-top:5px;margin-bottom:45px;">';
    $navHTML .= '<a href="contacts.php?page=search" class="selected">Search</a>';
    $navHTML .= ' | ';
    $navHTML .= '<a href="contacts.php?page=add">Add Contact</a>';
    $navHTML .= ' <div> </h4>';
    
    echo $navHTML;
}
?>