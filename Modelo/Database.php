<?php
class Database{

private $host = 'mysql.webcindario.com';
private $user = 'php3f';
private $password = "php3fpass";
private $database = "php3f"; 

public function getConnection(){ 
$conn = new mysqli($this->host, $this->user, $this->password, $this->database);
if($conn->connect_error){
die("Error failed to connect to MySQL: " . $conn->connect_error);
} else {
return $conn;
}
}
}
?>