<?PHP

/* tests if logged in as student or teacher/admin 
which allows for hiding the email button from students
*/

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

?>