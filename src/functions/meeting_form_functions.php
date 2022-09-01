<?PHP
function display_meeting_form($student=""){

    if($student==""){
        $formHTML = "<h2>Add Student</h2>";
        $student["sid"] = "";
        $student["last_name"] = "";
        $student["first_name"] = "";
        $student["grad_year"] = "";
        $student["alumni"] = "";
        $checked = "";
    }else{
        $formHTML = "<h2>Edit Student</h2>";
        $checked = ($student["alumni"]==1)? " checked " : "";
    }
    echo '<form method=post action=students.php>
        First Name:<input name="first_name" type="text" value={$student["first_name"]}><BR/>
        Last Name:<input name="last_name" type="text" value={$student["last_name"]}><BR/>
        Grad Year:<input name="grad_year" type="text" value={$student["grad_year"]}><BR/>
        <input name="sid" type="hidden">
        <input name="page" type="hidden" value="save">
        alumni<input name="alumni" type="checkbox" value="1" $checked><BR/>
        <input type="submit" value="Add Student">
    </form>';

}
function display_meeting_page_navigation($currentPage){
    $navHTML  = '<h4><div style="margin-top:5px;margin-bottom:45px;">';
    $navHTML .= '<a href="students.php?page=search" class="selected">Search</a>';
    $navHTML .= ' | ';
    $navHTML .= '<a href="students.php?page=add">Add Student</a>';
    $navHTML .= ' <div> </h4>';
    
    echo $navHTML;
}
function display_search_form(){
    echo '<h2>Search for a student by Name</h2><form method=get action=_self>
        Enter Student Name:<input name="word" type="text">
        <input type="submit" value="Search">
    </form><br/><br/>';

}

function display_meeting_list($data=null){
    if(!is_array($data)){
        echo "";
    }
    foreach ($data as $row) {
            echo "<a href='students.php?page=student&sid=".$row['studentID']."'>";
            echo $row['firstName']." ".$row['lastName']."<br />\n";
            echo "</a>";
    }
}

function display_student_info($student){
    if(!is_array($student)){
        echo "Student Information not found";
    }
    echo "<h4><b>Name:</b> ".$student['firstName']." ".$student['lastName']."</h4>\n";
    echo "<h4><b>Grad Year:</b> ".$student['gradYear']."</h4>\n";
}

function get_student($sid){
    $pdo = connect_to_db();
    $stmt = $pdo->prepare("SELECT * FROM student WHERE studentID=:sid");
    $stmt->execute([':sid' => $sid]); 
    $data = $stmt->fetch();
    return $data;
} 
function get_student_by_name($word){
    if($word==""){
        return get_all_students_from_db();
    }
    $pdo = connect_to_db();
    $stmt = $pdo->prepare("SELECT * FROM student WHERE first_name like :name or last_name like :name");
    $stmt->execute([':name' => $word]); 
    $data = $stmt->fetch();
    return $data;
}    
function get_all_students_from_db(){
    $pdo = connect_to_db();
    $data = $pdo->query("SELECT * FROM student order by lastName,firstName")->fetchAll();
    return $data;
}