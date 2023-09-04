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
  $turma = $_POST["turma"];

  $sql_update = "UPDATE turmas SET turma = '$turma' WHERE id = '$id'";
  $conn->query($sql_update);

  header("Location: detalhesturma.php?id=$id");
  exit();
}

$sql = "SELECT * FROM turmas WHERE id = '$id'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
  $row = $result->fetch_assoc();
  $turma = $row["turma"];
  ?>

  <h2 style="margin-right: 80px; margin-left: 20px;">Editar</h2>

  <form method="POST" action="detalhesturma.php?id=<?php echo $id; ?>" enctype="multipart/form-data">
    <label for="autor">Turma</label><br>
    <input type="text" placeholder="Turma" name="turma" value="<?php echo $turma; ?>">
    
    <div class="gengen">
      <br><button class="lin" type="submit">Editar</button>
      <a href="turmas.php">Voltar</a>
    </div>
  </form>

<?php
}

$conn->close();
?>

</body>
<script>
    const inputFile = document.querySelector("#picture__input");
    const pictureImage = document.querySelector(".picture__image");
    const pictureImageTxt = "Choose an image";
    pictureImage.innerHTML = pictureImageTxt;

    inputFile.addEventListener("change", function (e) {
      const inputTarget = e.target;
      const file = inputTarget.files[0];

      if (file) {
        const reader = new FileReader();

        reader.addEventListener("load", function (e) {
          const readerTarget = e.target;

          const img = document.createElement("img");
          img.src = readerTarget.result;
          img.classList.add("picture__img");

          pictureImage.innerHTML = "";
          pictureImage.appendChild(img);
        });

        reader.readAsDataURL(file);
      } else {
        pictureImage.innerHTML = pictureImageTxt;
      }
    });
</script>
</html>