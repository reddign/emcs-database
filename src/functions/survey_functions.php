<?PHP


function email_survey_send($student_email) {
$to = $student_email;
$subject = "Student Interest Survey";
$txt = "Dear Blah, you have not completed your student interest survey. Please follow the link *link*
and complete the survey. Thank you, Yo motha";

mail($to,$subject,$txt);
}

function code_checker() {
    
}
function addSurvey($arrayData){
    $surveyID = $arrayData["surveyID"];
    $interests = $arrayData["interests"];
    $careerGoals = $arrayData["careerGoals"];
    $studentID = $arrayData["studentID"];
    $pdo = connect_to_db();
    $stmt = $pdo->prepare("insert into student (firstName,lastName,gradYear,alumni) VALUES (:first,:last,:gradYr,:alum)");
    $stmt->execute([':first' => $first_name, ":last"=> $last_name, ":gradYr"=>$gradYear,":alum"=>$alumni]);
    $sid = $pdo->lastInsertId();
    header("location:students.php?page=student&sid=".$sid."&message=Student Added");
  
}

function display_survey_page_navigation($currentPage){
    $navHTML  = '<h4><div style="margin-top:5px;margin-bottom:45px;">';
    $navHTML .= '<a href="students.php?page=search" class="selected">Email Code</a>';
    $navHTML .= ' | ';
    $navHTML .= '<a href="students.php?page=add">Take Survey</a>';
    $navHTML .= ' <div> </h4>';
    
    echo $navHTML;
}

?>