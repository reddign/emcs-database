<?PHP
function display_company_form($student=""){

    if($student==""){
        $formHTML = "<h2>Add Company</h2>";
        $student = [];
        $student["companyID"] = "";
        $student["companyName"] = "";
        $student["address"] = "";
        $student["city"] = "";
        $student["state"] = "";
        $student["zip"] = "";
        $student["phone"] = "";
        $buttonString = "Add Company";
    }else{
        $formHTML = "<h2>Edit Company</h2>";
        $buttonString = "Edit Company Info";
    }
    echo '<form method=post action=company.php>
        Company Name:<input name="company_name" type="text" value="'.$student["companyName"].'"><BR/><BR/>
        Address:<input name="address" type="text" value="'.$student["address"].'"><BR/><BR/>
        City:<input name="city" type="text" value="'.$student["city"].'"><BR/><BR/>
        State:<input name="state" type="text" value="'.$student["state"].'"><BR/><BR/>
        Zip:<input name="zip" type="text" value="'.$student["zip"].'"><BR/><BR/>
        Phone:<input name="phone" type="text" value="'.$student["phone"].'"><BR/><BR/>
        <input name="companyid" type="hidden"  value="'.$student["companyID"].'"><BR/>
        <input name="page" type="hidden" value="save">  
        <input type="submit" value="'.$buttonString.'">
    </form>';

}
function display_company_page_navigation($currentPage){
    $navHTML  = '<h4><div style="margin-top:5px;margin-bottom:45px;">';
    $navHTML .= '<a href="companies.php?page=search" class="selected">Search</a>';
    $navHTML .= ' | ';
    $navHTML .= '<a href="companies.php?page=add">Add Company Info</a>';
    $navHTML .= ' <div> </h4>';
    
    echo $navHTML;
}
function display_search_form(){
    echo '<h2>Search for a company by Name</h2><form method=get action="companies.php">
        Enter Company Name:<input name="search" type="text">
        <input name="page" type="hidden" value="search">
        <input type="submit" value="Search">
    </form><br/><br/>';

}

function display_company_list($data=null){
    if(!is_array($data)){
        echo "";
        return;
    }
    foreach ($data as $row) {
            echo "<a href='companies.php?page=student&sid=".$row['companyID']."'>";
            echo $row['companyName']."<br />\n";
            echo "</a>";
    }
}

function display_company_info($student){
    if(!is_array($student)){
        echo "Company Information not found";
    }
    echo "<h4><b>Name:</b> ".$student['companyName']."</h4>\n";
    echo "<h4><b>Address:</b> ".$student['address']."</h4>\n";
    echo "<h4><b>City:</b> ".$student['city']."</h4>\n";
    echo "<h4><b>State:</b> ".$student['state']."</h4>\n";
    echo "<h4><b>Zip:</b> ".$student['zip']."</h4>\n";
    echo "<h4><b>Phone:</b> ".$student['phone']."</h4>\n";
    echo "<a href='companies.php?page=edit&sid=".$student['companyID']."'> Edit Info </a>\n";
    
}

function get_company($sid){
    $pdo = connect_to_db();
    $stmt = $pdo->prepare("SELECT * FROM student WHERE studentID=:sid");
    $stmt->execute([':sid' => $sid]); 
    $student = $stmt->fetch(PDO::FETCH_ASSOC);
   
    return $student;
} 
function get_company_by_name($word){
    if($word==""){
        return get_all_company_from_db();
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
function get_all_company_from_db(){
    $pdo = connect_to_db();
    $data = $pdo->query("SELECT * FROM student order by lastName,firstName")->fetchAll();
    return $data;
}
function process_company_form_data($arrayData){
    print_r($arrayData);
    $sid = $arrayData["sid"];
    if($sid==""){
        addcompany($arrayData);
    }else{
        editcompany($arrayData);
    }
    
}
function addcompany($arrayData){
    $company_name = $arrayData["company_name"];
    $address = $arrayData["address"];
    $city = $arrayData["city"];
    $state = $arrayData["state"];
    $zip = $arrayData["zip"];
    $phone = $arrayData["phone"];
    $pdo = connect_to_db();
    $stmt = $pdo->prepare("insert into student (firstName,lastName,gradYear,alumni) VALUES (:first,:last,:gradYr,:alum)");
    $stmt->execute([':first' => $first_name, ":last"=> $last_name, ":gradYr"=>$gradYear,":alum"=>$alumni]);
    $sid = $pdo->lastInsertId();
    header("location:students.php?page=student&sid=".$sid."&message=Student Added");
  
}
function editcompany($arrayData){
    $last_name = $arrayData["last_name"];
    $first_name = $arrayData["first_name"];
    $gradYear = $arrayData["grad_year"];
    $alumni = $arrayData["alumni"];
    $sid = $arrayData["sid"];
    $pdo = connect_to_db();
    $stmt = $pdo->prepare("update student  set firstName = :first, lastName = :last, gradYear = :gradYr,alumni=:alum where studentID=:sid");
    $stmt->execute([':first' => $first_name, ":last"=> $last_name, ":gradYr"=>$gradYear,":alum"=>$alumni,":sid"=>$sid]);
    header("location:students.php?page=student&sid=".$sid."&message=Student Updated");
}