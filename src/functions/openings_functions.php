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