<?PHP

/*  I imagine the students.php page will display student survey information if it exists. 
    Student entries lacking in survey information would likely be the best place to have a button saying something like 'Email this student the survey form.'
    Additionally this button should only be visibile/usable by someone with priveleged access to the site.
*/

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