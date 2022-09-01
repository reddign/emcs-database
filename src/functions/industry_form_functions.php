<?PHP
/* function display_contact_form($contact=""){

    if($contact==""){
        $formHTML = "<h2>Add Contact</h2>";
        $contact["sid"] = "";
        $industry["last_name"] = "";
        $industry["first_name"] = "";
        $industry["grad_year"] = "";
        $industry["alumni"] = "";
        $checked = "";
    }else{
        $formHTML = "<h2>Edit Industry</h2>";
        $checked = ($industry["alumni"]==1)? " checked " : "";
    }
    echo '<form method=post action=industries.php>
        First Name:<input name="first_name" type="text" value={$industry["first_name"]}><BR/>
        Last Name:<input name="last_name" type="text" value={$industry["last_name"]}><BR/>
        Grad Year:<input name="grad_year" type="text" value={$industry["grad_year"]}><BR/>
        <input name="sid" type="hidden">
        <input name="page" type="hidden" value="save">
        alumni<input name="alumni" type="checkbox" value="1" $checked><BR/>
        <input type="submit" value="Add Industry">
    </form>';

}
function display_industry_page_navigation($currentPage){
    $navHTML  = '<h4><div style="margin-top:5px;margin-bottom:45px;">';
    $navHTML .= '<a href="industries.php?page=search" class="selected">Search</a>';
    $navHTML .= ' | ';
    $navHTML .= '<a href="industries.php?page=add">Add Industry</a>';
    $navHTML .= ' <div> </h4>';
    
    echo $navHTML;
}
*/

function display_contact_search_form(){
    echo '<h2>Search for an industry contact by name</h2><form method=get action=_self>
        Enter Industry Contact Name:<input name="word" type="text">
        <input type="submit" value="Search">
    </form><br/><br/>';
}

function display_contact_list($data=null){
    if(!is_array($data)){
        echo "";
    }
    foreach ($data as $row) {
            echo "<a href='contacts.php?page=contact&id=".$row['contactID']."'>";
            echo $row['firstName']." ".$row['lastName']."<br />\n";
            echo "</a>";
    }
}

function display_contact_info($contact){
    if(!is_array($contact)){
        echo "Industry Information not found";
    }
    echo "<h4><b>Name:</b> ".$contact['firstName']." ".$contact['lastName']."</h4>\n";
    echo "<h4><b>Workphone:</b> ".$contact['workphone']."</h4>\n";
    echo "<h4><b>Cellphone:</b> ".$contact['cellphone']."</h4>\n";
    echo "<h4><b>Homephone:</b> ".$contact['homephone']."</h4>\n";
    if ($contact['formerStudentID'] != NULL) {
        echo "<h4><em>This person is an Etown College Alumni</em></h4> ";
    }
    
}

function get_contact_by_name($id){
    $pdo = connect_to_db();
    $stmt = $pdo->prepare("SELECT * FROM contact WHERE contactID=:id");
    $stmt->execute([':id' => $id]); 
    $data = $stmt->fetch();
    return $data;
} 
function get_contacts_by_name($word){
    if($word==""){
        return get_all_industries_from_db();
    }
    $pdo = connect_to_db();
    $stmt = $pdo->prepare("SELECT * FROM contact WHERE first_name like :name or last_name like :name");
    $stmt->execute([':name' => $word]); 
    $data = $stmt->fetch();
    return $data;
}    
function get_all_contacts_from_db(){
    $pdo = connect_to_db();
    $data = $pdo->query("SELECT * FROM contact order by lastName,firstName")->fetchAll();
    return $data;
}
