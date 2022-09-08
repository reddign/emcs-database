<?PHP
require("functions/basic_html_functions.php");
require("functions/database_functions.php");
function display_contact_form($industry=""){

    if($industry==""){
        $formHTML = "<h2>Add Contact</h2>";
        $industry["contactID"] = "";
        $industry["last_name"] = "";
        $industry["first_name"] = "";
        $industry["work_phone"] = "";
        $industry["cell_phone"] = "";
        $industry["home_phone"] = "";
        $industry["formerStudentID"] = "";
        $checked = "";
        $buttonString = "Add Contact";
    }else{
        $formHTML = "<h2>Edit Contact</h2>";
        $checked = ($industry["FormerStudentID"]==1)? " checked " : "";
        $buttonString = "Edit Contact";
    }
    echo '<form method=post action=industries.php>
        First Name:<input name="first_name" type="text" value="' .$industry["first_name"].'"><BR/>
        Last Name:<input name="last_name" type="text" value="' .$industry["last_name"].'"><BR/>
        Work Phone:<input name="work_phone" type="text" value="' .$industry["work_phone"].'"><BR/>
        Cell Phone:<input name="cell_phone" type="text" value="' .$industry["cell_phone"].'"><BR/>
        Home Phone:<input name="home_phone" type="text" value="' .$industry["home_phone"].'"><BR/>
        Former Student ID:<input name="home_ph" type="text" value="' .$industry["formerStudentID"].'"><BR/>
        <input name="contactID" type="text" value="' .$industry["contactID"].'">
        <input name="page" type="hidden" value="save">
        <input type="submit" value="'.$buttonString.'">

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
function display_industry_search_form(){
    echo '<h2>Search for an industry by Name</h2><form method=get action=_self>
        Enter Industry Name:<input name="word" type="text">
        <input type="submit" value="Search">
    </form><br/><br/>';

}

function display_industry_list($data=null){
    if(!is_array($data)){
        echo "";
    }
    foreach ($data as $row) {
            echo "<a href='industries.php?page=industry&sid=".$row['industryID']."'>";
            echo $row['firstName']." ".$row['lastName']."<br />\n";
            echo "</a>";
    }
}

function display_industry_info($industry){
    if(!is_array($industry)){
        echo "Industry Information not found";
    }
    echo "<h4><b>Name:</b> ".$industry['firstName']." ".$industry['lastName']."</h4>\n";
    echo "<h4><b>Grad Year:</b> ".$industry['gradYear']."</h4>\n";
}

function get_industry_by_name($sid){
    $pdo = connect_to_db();
    $stmt = $pdo->prepare("SELECT * FROM industry WHERE industryID=:sid");
    $stmt->execute([':sid' => $sid]); 
    $data = $stmt->fetch();
    return $data;
} 
function get_industries_by_name($word){
    if($word==""){
        return get_all_industries_from_db();
    }
    $pdo = connect_to_db();
    $stmt = $pdo->prepare("SELECT * FROM industry WHERE first_name like :name or last_name like :name");
    $stmt->execute([':name' => $word]); 
    $data = $stmt->fetch();
    return $data;
}    
function get_all_industry_from_db(){
    $pdo = connect_to_db();
    $data = $pdo->query("SELECT * FROM industry order by lastName,firstName")->fetchAll();
    return $data;
}
