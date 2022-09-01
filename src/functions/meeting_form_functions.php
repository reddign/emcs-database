<?PHP
function display_meeting_form($meeting=""){

    if($meeting==""){
        $formHTML = "<h2>Add Meeting</h2>";
        $meeting = [];
        $meeting["name"] = "";
        $meeting["date"] = "";
        $meeting["start_time"] = "";
        $meeting["location"] = "";
        $meeting["notes"] = "";
        #$checked = "";
    }else{
        $formHTML = "<h2>Edit Meeting</h2>";
        #$checked = ($student["alumni"]==1)? " checked " : "";
    }
    echo '<form method=post action=meetings.php>
        Meeting Name: <input style="margin-bottom:14px;" name="name" type="text" value='.$meeting["name"].'><BR/>
        Date: <input style="margin-bottom:14px;" name="date" type="text" value='.$meeting["date"].'><BR/>
        Start Time: <input style="margin-bottom:14px;" name="start_time" type="text" value='.$meeting["start_time"].'><BR/>
        Location: <input style="margin-bottom:14px;" name="location" type="text" value='.$meeting["location"].'><BR/>
        Meeting Notes:<BR/>
        <textarea style="width:60%;" name="notes" type="text" value='.$meeting["notes"].'></textarea><BR/>
        <input name="mid" type="hidden">
        <input name="page" type="hidden" value="save">
        <input type="submit" value="Add Meeting">
    </form>';

}

function display_meeting_page_navigation($currentPage){
    $navHTML  = '<h4><div style="margin-top:5px;margin-bottom:45px;">';
    $navHTML .= '<a href="meetings.php?page=search" class="selected">Search</a>';
    $navHTML .= ' | ';
    $navHTML .= '<a href="meetings.php?page=add">Add Meeting</a>';
    $navHTML .= ' <div> </h4>';
    
    echo $navHTML;
}
function display_search_meeting_form(){
    echo '<h2>Search for a meeting by name.</h2><form method=get action=_self>
        Enter Meeting Name: <input name="word" type="text">
        <input type="submit" value="Search">
    </form><br/><br/>';

}

function display_meeting_list($data=null){
    if(!is_array($data)){
        echo "";
    }
    foreach ($data as $row) {
            echo "<a href='meetings.php?page=meeting&sid=".$row['meetingID']."'>";
            echo $row['meetingName']." ".$row['date']."<br />\n";
            echo "</a>";
    }
}

function display_meeting_info($meeting){
    if(!is_array($meeting)){
        echo "Meeting Information not found";
    }
    echo "<h4><b>Meeting Name:</b> ".$meeting['name']."</h4>\n";
    echo "<h4><b>Date:</b> ".$meeting['date']."</h4>\n";
    echo "<h4><b>Start Time:</b> ".$meeting['start_time']."</h4>\n";
    echo "<h4><b>Location:</b> ".$meeting['location']."</h4>\n";
    echo "<h4><b>Notes:</b> ".$meeting['notes']."</h4>\n";
}

function get_meeting($mid){
    $pdo = connect_to_db();
    $stmt = $pdo->prepare("SELECT * FROM meeting WHERE meetingID=:mid");
    $stmt->execute([':mid' => $mid]); 
    $data = $stmt->fetch();
    return $data;
} 
function get_meeting_by_name($word){
    if($word==""){
        return get_all_meetings_from_db();
    }
    $pdo = connect_to_db();
    $stmt = $pdo->prepare("SELECT * FROM meeting WHERE meetingName like :name or last_name like :name");
    $stmt->execute([':name' => $word]); 
    $data = $stmt->fetch();
    return $data;
}    
function get_all_meetings_from_db(){
    $pdo = connect_to_db();
    $data = $pdo->query("SELECT * FROM meeting order by date;")->fetchAll();
    return $data;
}
function process_meeting_form_data($arrayData){
    print_r($arrayData);
    $mid = $arrayData["mid"];
    if($mid==""){
        addMeeting($arrayData);
    }else{
        editMeeting($arrayData);
    }
    
}
function addMeeting($arrayData){
    $meeting_name = $arrayData["name"];
    $date = $date["date"];
    $start_time = $arrayData["start_time"];
    $location = $arrayData["location"];
    $notes = $arrayData["notes"];
    $pdo = connect_to_db();
    $stmt = $pdo->prepare("INSERT INTO meeting (meetingName,date,starttime,notes,location) VALUES (:mName,:mDate,:start_time,:mNotes,:mLocation)");
    $stmt->execute([':mName' => $meeting_name, ":mDate"=> $date, ":start_time"=>$start_time,":mNotes"=>$notes, ":mLocation"=>$location]);
    $mid = $pdo->lastInsertId();
    header("location:meetings.php?page=meeting&mid=".$mid."&message=Meeting Added");
  
}
function editMeeting($arrayData){
    $last_name = $arrayData["last_name"];
    $first_name = $arrayData["first_name"];
    $gradYear = $arrayData["grad_year"];
    $alumni = $arrayData["alumni"];
    $sid = $arrayData["studentID"];
    $pdo = connect_to_db();
    $stmt = $pdo->prepare("update student  set firstName = :first, lastName = :last, gradYear = :gradYr,alumni=:alum where studentID=:sid");
    $stmt->execute([':first' => $first_name, ":last"=> $last_name, ":gradYr"=>$gradYear,":alum"=>$alumni,":sid"=>$sid]);
    header("location:students.php?page=student&sid=".$mid."&message=Student Updated");
}