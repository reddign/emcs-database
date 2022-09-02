<?PHP
function display_meeting_form($meeting=""){

    if($meeting==""){
        $formHTML = "<h2>Add Meeting</h2>";
        $meeting = [];
        $meeting["meetingName"] = "";
        $meeting["date"] = "";
        $meeting["starttime"] = "";
        $meeting["location"] = "";
        $meeting["notes"] = "";
        $submitText = "Add Meeting";
    }else{
        $formHTML = "<h2>Edit Meeting</h2>";
        $submitText = "Save Meeting";
    }
    echo '<form method=post action=meetings.php>
        Meeting Name: <input style="margin-bottom:14px;" name="meetingName" type="text" value="'.$meeting["meetingName"].'"><BR/>
        Date: <input style="margin-bottom:14px;" name="date" type="text" value='.$meeting["date"].'><BR/>
        Start Time: <input style="margin-bottom:14px;" name="starttime" type="text" value='.$meeting["starttime"].'><BR/>
        Location: <input style="margin-bottom:14px;" name="location" type="text" value='.$meeting["location"].'><BR/>
        Meeting Notes:<BR/>
        <textarea style="width:60%;" rows="5" name="notes" type="text">'.$meeting["notes"].'</textarea><BR/>
        <input name="mid" type="hidden">
        <input name="page" type="hidden" value="save">
        <input type="submit" value="'.$submitText.'">
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
    echo '<h2>Search for a meeting by Name</h2><form method=get action="meetings.php">
        Enter Meeting Name: <input name="search" type="text">
        <input name="page" type="hidden" value="search">
        <input type="submit" value="Search">
    </form><br/><br/>';
}

function display_meeting_list($data=null){
    if(!is_array($data[0])){
        echo "";
    }
    else{
        foreach ($data as $row) {
                echo "<a href='meetings.php?page=meeting&mid=".$row['meetingID']."'>";
                echo $row['date'].", ".$row['meetingName']."<br/>\n";
                echo "</a>";
        }
    }
}

function display_meeting_info($meeting){
    if(!is_array($meeting)){
        echo "Meeting Information not found";
    }
    #echo "<h4><b>Testing: </b>".array_keys($meeting)[4]."</h4>";
    #echo "<h4><b>Testing2: </b>".$meeting[2]."</h4>";
    echo "<a href='meetings.php?page=edit&mid=".$meeting['meetingID']."'> Edit Info </a>\n";
    echo "<h4><b>Meeting Name:</b> ".$meeting['meetingName']."</h4>\n";
    echo "<h4><b>Date:</b> ".$meeting['date']."</h4>\n";
    echo "<h4><b>Start Time:</b> ".$meeting['starttime']."</h4>\n";
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
    $stmt = $pdo->prepare("SELECT * FROM meeting WHERE meetingName LIKE :mName;");
    $stmt->execute([':mName' => $word."%"]); 
    $data = $stmt->fetchall();
    
    return $data;
}    
function get_all_meetings_from_db(){
    $pdo = connect_to_db();
    $data = $pdo->query("SELECT * FROM meeting order by date;")->fetchAll();
    return $data;
}
function process_meeting_form_data($arrayData){
    print_r($arrayData);
    debug_to_console($arrayData);
    $mid = $arrayData["mid"];
    if($mid==""){
        addMeeting($arrayData);
    }else{
        editMeeting($arrayData);
    }
    
}
function addMeeting($arrayData){
    $name = $arrayData["meetingName"];
    $date = $arrayData["date"];
    $start_time = $arrayData["starttime"];
    $location = $arrayData["location"];
    $notes = $arrayData["notes"];
    $pdo = connect_to_db();
    $stmt = $pdo->prepare("INSERT INTO meeting (meetingName,date,starttime,notes,location) VALUES (:mName,STR_TO_DATE(:mDate, '%m/%d/%y'),:start_time,:mNotes,:mLocation)");
    $stmt->execute([':mName'=>$name, ":mDate"=>$date, ":start_time"=>$start_time,":mNotes"=>$notes, ":mLocation"=>$location]);
    $mid = $pdo->lastInsertId();
    header("location:meetings.php?page=meeting&mid=".$mid."&message=Meeting Added");
  
}
function editMeeting($arrayData){
    $name = $arrayData["meetingName"];
    $date = $arrayData["date"];
    $start_time = $arrayData["starttime"];
    $location = $arrayData["location"];
    $notes = $arrayData["notes"];
    $mid = $arrayData["mid"];
    $pdo = connect_to_db();
    $stmt = $pdo->prepare("UPDATE meeting SET meetingName=:mName, date=STR_TO_DATE(:mDate, '%m/%d/%y'), starttime=:start_time, notes=:mNotes, location=:mLocation WHERE meetingID=:mid");
    $stmt->execute([':mName' => $name, ":mDate"=> $date, ":start_time"=>$start_time,":mNotes"=>$notes,":mLocation"=>$location,":mid"=>$mid]);
    header("location:meetings.php?page=meeting&mid=".$mid."&message=Meeting Updated");
}

function debug_to_console($data) {
    $output = $data;
    if (is_array($output))
        $output = implode(',', $output);

    echo "<script>console.log('Debug Objects: " . $output . "' );</script>";
}