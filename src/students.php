<?PHP
$path = '';
require("../config.php");
require("includes/header.php");

?>
 <!-- Header -->
  <div class="w3-container" style="margin-top:80px" id="showcase">
    <h1 class="w3-jumbo"><b>Students</b></h1>
    <h1 class="w3-xxxlarge w3-text-red"><b>Search.</b></h1>
    <hr style="width:50px;border:5px solid red" class="w3-round">
  </div>

  <?php
  echo "A search of students will appear below.<BR/><BR/>";
  

$dsn = "mysql:host=$databasehost;dbname=$database;charset=UTF8";

try {
	$pdo = new PDO($dsn, $databaseuser, $databasepassword);

	if ($pdo) {

    $sid = isset($_GET["sid"])?$_GET["sid"]:"";
    if($sid==""){    
      $data = $pdo->query("SELECT * FROM student order by lastName,firstName")->fetchAll();
      foreach ($data as $row) {
          echo "<a href='students.php?sid=".$row['studentID']."'>";
          echo $row['firstName']." ".$row['lastName']."<br />\n";
          echo "</a>";
      }
    }else{
      $stmt = $pdo->prepare("SELECT * FROM student WHERE studentID=:sid");
      $stmt->execute(['sid' => $sid]); 
      $student = $stmt->fetch();
      echo $student["firstName"]." ".$student["lastName"]." is a member of the class of ".$student["gradYear"].".";
    }
	}
} catch (PDOException $e) {
	echo $e->getMessage();
}


  ?>



<?PHP
require("includes/footer.php");
