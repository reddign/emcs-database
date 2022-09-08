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

?>