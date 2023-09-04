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

  $sql_livv = "SELECT livro FROM reservas WHERE id = '$id'";
  $result_livv = $conn->query($sql_livv);

  if ($result_livv->num_rows > 0) {
    while ($row_livv = $result_livv->fetch_assoc()) {

      $livro = $row_livv["livro"];

      echo $livro;

      $sql_atualizar = "UPDATE livros SET disponivel = disponivel + 1 WHERE id = $livro";
  
      if ($conn->query($sql_atualizar) === TRUE) {
          $sql = "DELETE FROM reservas WHERE id = '$id'";
          $result = $conn->query($sql);

          if ($sql) {
            header("Location: reservas.php");
            exit();
          }
      }
      
    }


  

  
  }

?>
