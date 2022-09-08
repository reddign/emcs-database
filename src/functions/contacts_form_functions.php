<?PHP
////////// ADDING AND EDITING CONTACTS //////////
function display_contact_form($contact=NULL){

    if($contact==NULL){
        echo "<h2>Add Contact</h2>";
        $contact = [];
        $contact["contactID"] = "";
        $contact["lastName"] = "";
        $contact["firstName"] = "";
        $contact["workphone"] = "";
        $contact["cellphone"] = "";
        $contact["homephone"] = "";
        $contact["formerStudentID"] = "";
        $buttonString = "Add Contact";
    }else{
        echo "<h2>Edit Contact</h2>";
        $buttonString = "Edit Contact";
    }
    echo '<form method=post action=contacts.php>
        First Name:<input name="firstName" type="text" value="' .$contact["firstName"].'"><BR/>
        Last Name:<input name="lastName" type="text" value="' .$contact["lastName"].'"><BR/>
        Work Phone:<input name="workphone" type="text" value="' .$contact["workphone"].'"><BR/>
        Cell Phone:<input name="cellphone" type="text" value="' .$contact["cellphone"].'"><BR/>
        Home Phone:<input name="homephone" type="text" value="' .$contact["homephone"].'"><BR/>
        Former Student ID:<input name="formerStudentID" type="text" value="' .$contact["formerStudentID"].'"><BR/>
        <input name="page" type="hidden" value="save">
        <input name="contactID" type="hidden" value='.$contact["contactID"].'>
        <input type="submit" value="'.$buttonString.'">

    </form>';

}

function process_contact_form_data($arrayData){
    if($arrayData["contactID"] == ""){
        addContact($arrayData);
    }else{
        editContact($arrayData);
    }
    
}
function addContact($arrayData){
    $last_name = $arrayData["lastName"];
    $first_name = $arrayData["firstName"];
    $workphone = $arrayData["workphone"];
    $cellphone = $arrayData["cellphone"];
    $homephone = $arrayData["homephone"];
    $fsid = $arrayData["formerStudentID"];
    $pdo = connect_to_db();
    $stmt = $pdo->prepare("insert into contact (firstName,lastName,workphone,cellphone,homephone,formerStudentID) VALUES (:first,:last,:work,:cell,:home,:fsid)");
    $stmt->execute([':first' => $first_name, ":last"=> $last_name, ":work"=>$workphone,":cell"=>$cellphone,":home"=>$homephone,":fsid"=>$fsid]);
    $id = $pdo->lastInsertId();
    header("location:contacts.php?page=contact&id=".$id."&message=Contact Added");
  
}
function editContact($arrayData){
    $last_name = $arrayData["lastName"];
    $first_name = $arrayData["firstName"];
    $workphone = $arrayData["workphone"];
    $cellphone = $arrayData["cellphone"];
    $homephone = $arrayData["homephone"];
    $fsid = $arrayData["formerStudentID"];
    $id = $arrayData["contactID"];
    $pdo = connect_to_db();
    $stmt = $pdo->prepare("update contact  set firstName = :first, lastName = :last, workphone = :work, cellphone = :cell, homephone = :home, formerStudentID = :fsid where contactID=:id");
    $stmt->execute([':first' => $first_name, ":last"=> $last_name, ":work"=>$workphone,":cell"=>$cellphone,":home"=>$homephone,":fsid"=>$fsid, ":id"=>$id]);
    header("location:contacts.php?page=contact&id=".$id."&message=Contact Updated");
}

////////// SEARCHING FOR CONTACTS //////////
function display_contact_search_form(){
    echo '<h2>Search for an industry contact by name</h2><form method=get action="contacts.php">
        Enter Industry Contact Name: <input name="search" type="text">
        <input name="page" type="hidden" value="search">
        <input type="submit" value="Search">
    </form><br/><br/>';
}

function display_contact_list($data=null){
    if(!is_array($data)|| sizeof($data) == 0){
        echo "No matching contacts found";
    }
    foreach ($data as $row) {
        echo "<a href='contacts.php?page=contact&id=".$row['contactID']."'>";
        echo $row['firstName']." ".$row['lastName']."<br />\n";
        echo "</a>";
    }
}

function display_contact_info($contact){
    if(!is_array($contact)){
        echo "Contact Information not found";
    }
    else {
        echo "<h4><b>Name:</b> ".$contact['firstName']." ".$contact['lastName']."</h4>\n";
        echo "<h4><b>Work phone:</b> ".$contact['workphone']."</h4>\n";
        echo "<h4><b>Cell phone:</b> ".$contact['cellphone']."</h4>\n";
        echo "<h4><b>Home phone:</b> ".$contact['homephone']."</h4>\n";
        echo "<h4><b>Alumni:</b> ".(($contact['formerStudentID'] == NULL) ? "NO" : "YES")."</h4> ";   
        echo "<a href='contacts.php?page=edit&id=".$contact['contactID']."'> Edit Info </a>\n";
    }
}
/////////// DATABASE ACCESS //////////
function get_contact($id){
    $pdo = connect_to_db();
    $stmt = $pdo->prepare("SELECT * FROM contact WHERE contactID=:id");
    $stmt->execute([':id' => $id]); 
    $data = $stmt->fetch();
    return $data;
} 
function get_contact_by_name($word){
    if($word==""){
        return get_all_contacts_from_db();
    }
    $pdo = connect_to_db();
    $stmt = $pdo->prepare("SELECT * FROM contact WHERE firstName like :name or lastName like :name");
    $stmt->execute([':name' => "%".$word."%"]); 
    $data = [];
    while($student =  $stmt->fetch(PDO::FETCH_ASSOC)){
        $data[] = $student;
    } 
    
    return $data;
}    
function get_all_contacts_from_db(){
    $pdo = connect_to_db();
    $data = $pdo->query("SELECT * FROM contact order by lastName,firstName")->fetchAll();
    return $data;
}

////////// GENERAL //////////
function display_contacts_page_navigation($currentPage){
    $navHTML  = '<h4><div style="margin-top:5px;margin-bottom:45px;">';
    $navHTML .= '<a href="contacts.php?page=search" class="selected">Search</a>';
    $navHTML .= ' | ';
    $navHTML .= '<a href="contacts.php?page=add">Add Contact</a>';
    $navHTML .= ' <div> </h4>';
    
    echo $navHTML;
}
?>