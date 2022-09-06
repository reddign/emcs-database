<?PHP
function display_openings_form($openings=""){

}
function display_openings_navigation($currentPage){
    $navHTML  = '<h4><div style="margin-top:5px;margin-bottom:45px;">';
    $navHTML .= '<a href="openings.php?page=search" class="selected">Search</a>';
    $navHTML .= ' | ';
    $navHTML .= '<a href="openings.php?page=add">Add Opening</a>';
    $navHTML .= ' | ';
    $navHTML .= '<a href="openings.php?page=add">Edit Opening</a>';
    $navHTML .= ' | ';
    $navHTML .= '<a href="openings.php?page=add">Complete Opening</a>';
    $navHTML .= ' <div> </h4>';
    
    echo $navHTML;
}
function display_search_form(){
    echo '<h2>Search for an opening</h2><form method=get action="students.php">
        Enter Opening Name:<input name="search" type="text">
        <input name="page" type="hidden" value="search">
        <input type="submit" value="Search">
    </form><br/><br/>';

}