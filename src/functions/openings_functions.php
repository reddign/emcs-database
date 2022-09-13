<?PHP
function display_openings_form($openings=""){

}
function display_openings_navigation($currentPage){
    $navHTML  = '<h4><div style="margin-top:5px;margin-bottom:45px;">';
    $navHTML .= '<a href="openings.php?page=search" class="selected">Search Jobs</a>';
    $navHTML .= ' | ';
    $navHTML .= '<a href="openings.php?page=add">Add Jobs</a>';

    
    echo $navHTML;
}
function display_search_openings(){
    echo '<h2>Search for an opening</h2><form method=get action="students.php">
        Enter Opening Name:<input name="search" type="text">
        <input name="page" type="hidden" value="search">
        <input type="submit" value="Search">
    </form><br/><br/>';

}
function get_job_by_name($word){
    if($word==""){
        return get_all_openings_from_db();
    }
    $pdo = connect_to_db();
    $stmt = $pdo->prepare("SELECT * FROM job_opportunity WHERE title like :title");
    $stmt->execute([':title' => "%".$word."%"]);
    $data = [];
    while($job =  $stmt->fetch(PDO::FETCH_ASSOC)){
        $data[] = $job;
    } 
    
    return $data;
}    
function get_all_openings_from_db(){
    $pdo = connect_to_db();
    $data = $pdo->query("SELECT * FROM job_opportunity order by title")->fetchAll();
    return $data;
}
function display_search_form(){
    echo '<h2>Search For A Job Opening By Title:</h2><form method=get action="openings.php">
        Enter Job Opening: <input name="search" type="text">
        <input job="page" type="hidden" value="search">
        <input type="submit" value="Search">
    </form><br/><br/>';

}
function display_job_list($data=null){
    if(!is_array($data)){
        echo "";
        return;
    }
    foreach ($data as $row) {
            echo "<a href='openings.php?page=opening&jid=".$row['jobID']."'>";
            echo $row['title']."<br />\n";
            echo "</a>";
    }
}