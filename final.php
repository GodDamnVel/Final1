<html>
<body>
<?php

class keys {
            public static $sqlhost = 'localhost';
            public static $sqluser = 'root';
            public static $sqlpass = 'password';
            public static $sqldb = 'project';
        }



//singleton connection from php tut
class dbaccess {

private $connection;

public static function getInstance(){
  static $instance = null;
  if (null === $instance){
        $instance = new dbaccess();
        $instance->connect();
 }
  return $instance;

}
//conencting to mysql database
private function connect(){
 $this->connection = new PDO('mysql:host=' .keys::$sqlhost . 'dbname' . keys::$sqldb, keys::$sqldb, keys::$sqlpass);
}

public function result($query){

 $stmt = $this->connection->prepare($query);
 $stmt->execute();
 $result = $stmt->fetch();
 return $result;

 }
}

class main {
   
  // accessing db
   private $db;
 
   public function __construct() {
   $this->db = dbaccess::getInstance();
  }
  //page output
  public function __destruct() {
  if (!(isset($_GET["entry"]))) {
             $this->menu();
             } 
             else {
              $id = $_GET["entry"];
              $this->compile($id);
               }
            }

public function menu() {
  echo <<< INS
       <p>Please Select what you want answered</p>
    <ul>
      <li><a href='{$_SERVER['PHP_SELF']}?entry=1'>College with highest percetnage of female students</a></li>
      <li><a href='{$_SERVER['PHP_SELF']}?entry=2'>College with highest percentage of male students</a></li>
      <li><a href='{$_SERVER['PHP_SELF']}?entry=3'>College with largest endowment</a></li>
      <li><a href='{$_SERVER['PHP_SELF']}?entry=4'>College with largest enrollment of freshmen</a></li>
      <li><a href='{$_SERVER['PHP_SELF']}?entry=5'>College with highest revenue from tuition</a></li>
      <li><a href='{$_SERVER['PHP_SELF']}?entry=6'>College with lowest non-zero tuition</a></li>
   </ul>
INS;
}
          
public function comp($num) {
    switch ($num) {
  case 1:
         $query = 'select first_name, last_name, max(salary) from (select first_name, last_name, salary from employees right join salaries on employees.emp_no=salaries.emp_no) as employeesalaries';
         $result = $this->db->Result($query);
        echo '<h3>Colleges with the highest percentage of women students?</h3>';
        echo ' ';
          break;
  case 2:
        $query = ' ';
        $result = $this->db->Result($query);
        echo '<h3>Colleges with the highest percentage of male students?</h3>';
        echo ' ';
            break;
  case 3:
      $query = 'select college.name, college.city, college.state, financial.endowment from financial join college on college.id = financial.college_id order by financial.endowment DESC limit 10 ';
      $result = $this->db->Result($query);
      echo '<h3>Colleges with the largest endowment?</h3>';

      break;
 case 4:
      $query = 'select college.name, college.city, college.state, enrollment.total, from enrollment join college on college.id = enrollment.college_id where enrollment.status = 3 order by enrollment.total DESC limit 10 ';
      $result = $this->db->Result($query);
      echo '<h3>Colleges with largest enrollment of freshmen?</h3>';

      break;
  case 5:
      $query = 'college.name, college.city, college.state, financial.tuition from financial join college on college.id = financial.college_id order by financial.tuition DESC limit 10 ';
      $result = $this->db->Result($query);
      echo '<h3>Colleges with the highest revenue from tuition?</h3>';
      
      break;
  case 6:
     $query= ' ';
    $result = $this->db->Result($query);
    echo '<h3>Colleges with the lowest non-zero tuition?</h3>';

    break;
                  
                }
                echo "<a href='".$_SERVER['PHP_SELF']."'>Return to Menu</a>";
            }
}


        
        
$main = new main();


        
            

</body>
</html>
