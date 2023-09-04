<?php
session_start();

if (!isset($_SESSION['idi'])) {
    header('Location: ../screen/log.php');
    exit();
}

?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" type="text/css" href="../css/adm1.css">
  <link rel="icon" type="image/x-icon" href="../logo.png">
  <title>Detalhes do Livro</title>
</head>
<body>
<?php
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "biblioteca";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
  die("Falha na conexão com o banco de dados: " . $conn->connect_error);
}

$id = $_GET['id'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $titulo = $_POST["titulo"];
  $turma = $_POST["autor"];
  $datin = $_POST["dataini"];
  $datfim = $_POST["datafim"];

  $sql_update = "UPDATE reservas SET livro = '$titulo', dataini = '$datin', datafim = '$datfim' WHERE id = '$id'";
  $conn->query($sql_update);

  header("Location: detalhesreserva.php?id=$id");
  exit();
}

$sql = "SELECT * FROM reservas WHERE id = '$id'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
  $row = $result->fetch_assoc();
  $dataini = $row['dataini'];
  $datafim = $row['datafim'];
  ?>

  <h2 style="margin-right: 80px; margin-left: 20px;">Editar</h2>

  <form method="POST" action="detalhesreserva.php?id=<?php echo $id; ?>" enctype="multipart/form-data">
    <label for="titulo">Título do Livro</label><br>
    <select name="titulo" id="">
      <?php
        $servername = "localhost";
        $username = "root";
        $password = "root";
        $dbname = "biblioteca";
        
        $conn = new mysqli($servername, $username, $password, $dbname);
        if ($conn->connect_error) {
          die("Falha na conexão com o banco de dados: " . $conn->connect_error);
        }

        $sql = "SELECT * FROM livros";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
          while ($row = $result->fetch_assoc()) {
            echo '<option value="' . $row["id"] . '">' . $row["titulo"] . '</option>';
          }
        }
      ?>
    </select><br>
    <label for="autor">Data de reserva</label><br>
    <input class="in" type="date" name="dataini" id="" value="<?php echo $dataini; ?>"><br>
    <label for="autor">Data final</label><br>
    <input class="in" type="date" name="datafim" id="" value="<?php echo $datafim; ?>"><br>

    <div class="gengen">
      <button class="lin" type="submit">Editar</button>
      <a href="reservas.php">Voltar</a>
    </div>
  </form>

<?php
} else {
  echo "<p>Nenhum livro encontrado.</p>";
}

$conn->close();
?>

</body>
</html>