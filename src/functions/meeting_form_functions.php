<?PHP
//the function makes it so you can edit and add to the meeting tab
function display_meeting_form($meeting=""){

    if($meeting==""){
        $formHTML = "<h2>Add Meeting</h2>";
        $meeting = [];
        $meeting["meetingName"] = "";
        $meeting["date"] = "";
        $meeting["starttime"] = "";
        $meeting["location"] = "";
        $meeting["notes"] = "";
        $meeting["meetingID"] = "";
        $submitText = "Add Meeting";
    }else{
        $formHTML = "<h2>Edit Meeting</h2>";
        $submitText = "Save Meeting";
    //displaying the style of the page    
    }
    echo '<form method=post action=meetings.php>
        Meeting Name: <input style="margin-bottom:14px;" name="meetingName" type="text" value="'.$meeting["meetingName"].'"><BR/>
        Date: <input style="margin-bottom:14px;" name="date" type="date" value='.$meeting["date"].'><BR/>
        Start Time: <input style="margin-bottom:14px;" name="starttime" type="time" value='.$meeting["starttime"].'><BR/>
        Location: <input style="margin-bottom:14px;" name="location" type="text" value='.$meeting["location"].'><BR/>
        Meeting Notes:<BR/>
        <textarea style="width:60%;" rows="5" name="notes" type="text">'.$meeting["notes"].'</textarea><BR/>
        <input name="mid" type="hidden" value="'.$meeting["meetingID"].'">
        <input name="page" type="hidden" value="save">
        <input type="submit" value="'.$submitText.'">
    </form>';

}
//displaying the meeting page with functionalities 
function display_meeting_page_navigation($currentPage){
    $navHTML  = '<h4><div style="margin-top:5px;margin-bottom:45px;">';
    $navHTML .= '<a href="meetings.php?page=search" class="selected">Search</a>';
    $navHTML .= ' | ';
    $navHTML .= '<a href="meetings.php?page=add">Add Meeting</a>';
    $navHTML .= ' <div> </h4>';
    
    echo $navHTML;
}
//displaying the ability to search meeting with functionalities 
function display_search_meeting_form(){
    echo '<h2>Search for a meeting:</h2><form method=get action="meetings.php">
        Search By Name: <input style="margin-bottom:14px;" name="search" type="text"></br>
        Search By Date: <input style="margin-bottom:14px;" name="searchDate" type="date"></br>
        Search By Location: <input style="margin-bottom:14px;" name="searchLoc" type="text"></br>
        <input name="page" type="hidden" value="search">
        <input type="submit" value="Search">
    </form><br/><br/>';
}
//function to specify if a meeting is in the system or not 
function display_meeting_list($data=null){
    if($data==null){
        echo "<h3><b>No Meetings Found...</b></h2>";
    }
    else if(!is_array($data[0])){
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
//displaying meeting info
function display_meeting_info($meeting){
    if(!is_array($meeting)){
        echo "Meeting Information not found";
    }
    echo "<a href='meetings.php?page=edit&mid=".$meeting['meetingID']."'> Edit Info </a>\n";
    echo "<h4><b>Meeting Name:</b> ".$meeting['meetingName']."</h4>\n";
    echo "<h4><b>Date:</b> ".date('m/d/Y', strtotime($meeting['date']))."</h4>\n";
    echo "<h4><b>Start Time:</b> ".date('g:iA', strtotime($meeting['starttime']))."</h4>\n";
    echo "<h4><b>Location:</b> ".$meeting['location']."</h4>\n";
    echo "<h4><b>Notes:</b> ".$meeting['notes']."</h4>\n";

}
//function to tell the system where to pull the meeting info from 
function get_meeting($mid){
    $pdo = connect_to_db();
    $stmt = $pdo->prepare("SELECT * FROM meeting WHERE meetingID=:mid");
    $stmt->execute([':mid' => $mid]); 
    $data = $stmt->fetch();
    return $data;
} 
//function to tell the system to get the meeting by name
function get_meetings_by_name($word){
    if($word==""){
        return get_all_meetings_from_db();
    }
    $pdo = connect_to_db();
    $stmt = $pdo->prepare("SELECT * FROM meeting WHERE meetingName LIKE :mName;");
    $stmt->execute([':mName' => $word."%"]); 
    $data = $stmt->fetchall();
    
    return $data;
}
//function to tell the system to get the meeting by date
function get_meetings_by_date($date){
    if($date==""){
        return get_all_meetings_from_db();
    }
    $pdo = connect_to_db();
    #$stmt = $pdo->prepare("SELECT * FROM meeting WHERE date = STR_TO_DATE(:mDate, '%Y,%m,%d')");
    $stmt = $pdo->prepare("SELECT * FROM meeting WHERE date = :mDate;");
    $stmt->execute([':mDate' => $date]); 
    $data = $stmt->fetchall();
    
    return $data;
}
//function to tell the system to get the meeting by location
function get_meetings_by_loc($mLoc){
    if($mLoc==""){
        return get_all_meetings_from_db();
    }
    $pdo = connect_to_db();
    $stmt = $pdo->prepare("SELECT * FROM meeting WHERE location LIKE :mLoc;");
    $stmt->execute([':mLoc' => $mLoc."%"]); 
    $data = $stmt->fetchall();
    
    return $data;
}

function combined_search($mName, $mDate, $mLoc){
    $pdo = connect_to_db();
    if($mDate==""){
        $mDate="%";
    }
    $stmt = $pdo->prepare("SELECT * FROM meeting WHERE meetingName LIKE :mName AND location LIKE :mLoc AND date LIKE :mDate;");
    $stmt->execute([':mName'=>$mName."%", ':mLoc'=>$mLoc."%", ':mDate'=>$mDate]);
    $data = $stmt->fetchall();
    return $data;
}

function get_meetings_by_search($mName, $mDate, $mLoc){
    if($mName=="" && $mDate=="" && $mLoc==""){
        return get_all_meetings_from_db();
    }
    return combined_search($mName, $mDate, $mLoc);
}

function get_all_meetings_from_db(){
    $pdo = connect_to_db();
    $data = $pdo->query("SELECT * FROM meeting order by date;")->fetchAll();
    return $data;
}
function process_meeting_form_data($arrayData){
    print_r($arrayData);
    debug_to_console($arrayData["mid"]);
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
    $stmt = $pdo->prepare("INSERT INTO meeting (meetingName,date,starttime,notes,location) VALUES (:mName,:mDate,:start_time,:mNotes,:mLocation)");
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
    $stmt = $pdo->prepare("UPDATE meeting SET meetingName=:mName, date=:mDate, starttime=:start_time, notes=:mNotes, location=:mLocation WHERE meetingID=:mid");
    $stmt->execute([':mName' => $name, ":mDate"=> $date, ":start_time"=>$start_time,":mNotes"=>$notes,":mLocation"=>$location,":mid"=>$mid]);
    header("location:meetings.php?page=meeting&mid=".$mid."&message=Meeting Updated");
}


function debug_to_console($data) {
    $output = $data;
    if (is_array($output))
        $output = implode(',', $output);

    echo "<script>console.log('Debug Objects: " . $output . "' );</script>";
}