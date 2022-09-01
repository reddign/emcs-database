<?PHP
function display_student_form($student=""){

    if($student==""){
        $formHTML = "<h2>Add Student</h2>";
        $student = [];
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
        First Name:<input name="first_name" type="text" value="'.$student["first_name"].'"><BR/>
        Last Name:<input name="last_name" type="text" value="'.$student["last_name"].'"><BR/>
        Grad Year:<input name="grad_year" type="text" value="'.$student["grad_year"].'"><BR/>
        <input name="sid" type="hidden"  value="'.$student["sid"].'">
        <input name="page" type="hidden" value="save">
        alumni<input name="alumni" type="checkbox" value="1" $checked><BR/>
        <input type="submit" value="Add Student">
    </form>';

}
function display_student_page_navigation($currentPage){
    $navHTML  = '<h4><div style="margin-top:5px;margin-bottom:45px;">';
    $navHTML .= '<a href="students.php?page=search" class="selected">Search</a>';
    $navHTML .= ' | ';
    $navHTML .= '<a href="students.php?page=add">Add Student</a>';
    $navHTML .= ' <div> </h4>';
    
    echo $navHTML;
}
function display_search_form(){
    echo '<h2>Search for a student by Name</h2><form method=get action="students.php">
        Enter Student Name:<input name="search" type="text">
        <input name="page" type="hidden" value="search">
        <input type="submit" value="Search">
    </form><br/><br/>';

}

function display_student_list($data=null){
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
    echo "<h4><b>Alumni:</b> ".($student['alumni']?"YES":"NO")."</h4>\n";
    echo "<a href='students.php?page=edit&sid=".$student['studentID']."'> Edit Info </a>\n";
    
}

function get_student($sid){
    $pdo = connect_to_db();
    $stmt = $pdo->prepare("SELECT * FROM student WHERE studentID=:sid");
    $stmt->execute([':sid' => $sid]); 
    $student = $stmt->fetch(PDO::FETCH_ASSOC);
   
    return $student;
} 
function get_student_by_name($word){
    if($word==""){
        return get_all_students_from_db();
    }
    $pdo = connect_to_db();
    $stmt = $pdo->prepare("SELECT * FROM student WHERE firstName like :name or lastName like :name");
    $stmt->execute([':name' => $word."%"]);
    $data = [];
    while($student =  $stmt->fetch(PDO::FETCH_ASSOC)){
        $data[] = $student;
    } 
    
    return $data;
}    
function get_all_students_from_db(){
    $pdo = connect_to_db();
    $data = $pdo->query("SELECT * FROM student order by lastName,firstName")->fetchAll();
    return $data;
}
function process_student_form_data($arrayData){
    print_r($arrayData);
    $sid = $arrayData["sid"];
    if($sid==""){
        addStudent($arrayData);
    }else{
        editStudent($arrayData);
    }
    
}
function addStudent($arrayData){
    $last_name = $arrayData["last_name"];
    $first_name = $arrayData["first_name"];
    $gradYear = $arrayData["grad_year"];
    $alumni = isset($arrayData["alumni"])?1:0;
    $pdo = connect_to_db();
    $stmt = $pdo->prepare("insert into student (firstName,lastName,gradYear,alumni) VALUES (:first,:last,:gradYr,:alum)");
    $stmt->execute([':first' => $first_name, ":last"=> $last_name, ":gradYr"=>$gradYear,":alum"=>$alumni]);
    $sid = $pdo->lastInsertId();
    header("location:students.php?page=student&sid=".$sid."&message=Student Added");
  
}
function editStudent($arrayData){
    $last_name = $arrayData["last_name"];
    $first_name = $arrayData["first_name"];
    $gradYear = $arrayData["grad_year"];
    $alumni = $arrayData["alumni"];
    $sid = $arrayData["studentID"];
    $pdo = connect_to_db();
    $stmt = $pdo->prepare("update student  set firstName = :first, lastName = :last, gradYear = :gradYr,alumni=:alum where studentID=:sid");
    $stmt->execute([':first' => $first_name, ":last"=> $last_name, ":gradYr"=>$gradYear,":alum"=>$alumni,":sid"=>$sid]);
    header("location:students.php?page=student&sid=".$sid."&message=Student Updated");
}