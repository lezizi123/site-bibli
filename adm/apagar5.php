<?php
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "biblioteca";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
  die("Falha na conexão com o banco de dados: " . $conn->connect_error);
}

$id = $_GET["id"];

$sql = "DELETE FROM turmas WHERE id = '$id'";
$conn->query($sql);

if ($sql) {
  header("location: turmas.php");
  exit();

} else {
    header("location: turmas.php");
    exit();
  
}

exit();

?>