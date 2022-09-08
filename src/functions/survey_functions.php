<?PHP

// TODO: tests if logged in as student or teacher/admin 
// which allows for hiding the email button from students
function login_checker($role) {
    if($role = "admin"){

    }
    else if ($role = "teacher"){

    }
    else if ($role = "student"){

    }
    else {

    }
}

// called to send email to students who have not taken the survey
function email_survey_send($student_email) {
$to = $student_email;
$subject = "Student Interest Survey";
$txt = "Dear Blah, you have not completed your student interest survey. Please follow the link *link*
and complete the survey. Here's your code 1111111 Thank you";

mail($to,$subject,$txt);
}


// checks for valid code
function code_checker($Code) {
    while(i=0; i < count($Code) i++) {
        if ($Code = $Code[i]){
            return true;
        }
    }
    echo "CODE IS INVALID!!!"
    return false;
}

// creates student interest survey/sends to student_interest_survey
function survey_sender () {
    if(code_checker($Code) = true){

    }
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