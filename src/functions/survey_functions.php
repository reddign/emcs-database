<?PHP

// TODO: tests if logged in as student or teacher/admin 
// which allows for hiding the email button from students
function login_checker($role) {
    if($role == "admin"){

    }
    else if ($role == "teacher"){

    }
    else if ($role == "student"){

    }
    else {

    }
}

/*  TODO: I imagine the students.php page will display student survey information if it exists. 
    Student entries lacking in survey information would likely be the best place to have a button 
    saying something like 'Email this student the survey form.'Additionally this button should only 
    be visibile/usable by someone with priveleged access to the site.

    Also, it looks like we're currently only storing students' full names in the DB. Since not all student emails
    follow the standard format of last name first initial @etown.edu. We will need to have these emails in the database in
    order to be able to send
*/


// called to send email to students who have not taken the survey
function email_survey_send($student_email,$link) {
$to = $student_email;
$name = ""; # TODO Get name from DB via email, or get email from DB via name.
$subject = "Student Interest Survey";
$code = 0; # TODO generate access code, store it with the student DB entry?
$txt = "Dear $name, \n\nYou have not completed your student interest survey. Please follow this link ($link)
and complete the survey. Your access code is $code. \n\nThank you.\n Etown EMCS Department";

mail($to,$subject,$txt);
}

/*
// checks for valid code
function code_checker($Code) {
    for(i=0; i < count($Code); i++) {
        if ($Code = $Code[i]){
            return true;
        }
    }
    echo "CODE IS INVALID!!!"
    return false;
}

*/
function display_survey_form($student_survey=""){

    $formHTML = "<h2>Add Student</h2>";
    $student_survey = [];
    $student_survey["surveyID"] = "";
    $student_survey["interests"] = "";
    $student_survey["careerGoals"] = "";
    $student_survey["studentID"] = "";
    $buttonString = "Submit Survey";
    
    echo '<form method=post action=survey.php>
        Survey Code: <input name="surveyID" type="text" value="'.$student_survey["surveyID"].'"><BR/>
        Interests: <input name="interests" type="text" value="'.$student_survey["interests"].'"><BR/>
        Career Goals: <input name="careerGoals" type="text" value="'.$student_survey["careerGoals"].'"><BR/>
        Student ID: <input name="studentID" type="text" value="'.$student_survey["studentID"].'"><BR/>
        <input name="page" type="hidden" value="Submit Survey">
        <input type="submit" value="'.$buttonString.'">
    </form>';

}
function addSurvey($arrayData){
    $surveyID = $arrayData["surveyID"];
    $interests = $arrayData["interests"];
    $careerGoals = $arrayData["careerGoals"];
    $sid = $arrayData["studentID"];
    $pdo = connect_to_db();
    $stmt = $pdo->prepare("insert into student_survey (surveyID,interests,careerGoals,studentID) VALUES (:surv,:inter,:caree,:stu)");
    $stmt->execute([':surv' => $surveyID, ":inter"=> $interests, ":caree"=>$careerGoals,":stu"=>$studentID]);
    $sid = $pdo->lastInsertId();
    header("location:survey.php?page=survey&sid=".$sid."&message=Survey Accepted");
  
}

function display_survey_page_navigation($currentPage){
    $navHTML  = '<h4><div style="margin-top:5px;margin-bottom:45px;">';
    $navHTML .= '<a href="survey.php?page=search" class="selected">View Results</a>';
    $navHTML .= ' | ';
    $navHTML .= '<a href="survey.php?page=add">Take Survey</a>';
    $navHTML .= ' <div> </h4>';
    
    echo $navHTML;
}

?>