<?php
session_start();

if (!isset($_SESSION['nomeUsuario'])) {
    header('Location: log.php');
    exit();
}

$nomeUsuario = $_SESSION['nomeUsuario'];
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../css/reserva2.css">
    <link rel="icon" type="image/x-icon" href="../logo.png">
    <title>Multas</title>
</head>
<body>
    <h1 class="favoritos">Multas</h1>
    <div class="multas-container">
    <?php
        $servername = "localhost";
        $username = "root";
        $password = "root";
        $dbname = "biblioteca";

        $conn = new mysqli($servername, $username, $password, $dbname);
        if ($conn->connect_error) {
            die("Falha na conexão com o banco de dados: " . $conn->connect_error);
        }

        $userId = $_SESSION['idu'];
        $sql = "SELECT * FROM reservas WHERE user = $userId";
        $result = $conn->query($sql);

        if ($result && $result->num_rows > 0) {
            echo "<ul>";
            while ($multa = $result->fetch_assoc()) {

                $livro = $multa["livro"];
                $atraso = $multa["atraso"];
                
                $sqllivros = "SELECT * FROM livros WHERE id = $livro";
                $resultlivros = $conn->query($sqllivros);

                if ($resultlivros && $resultlivros->num_rows > 0) {
                    echo "<ul>";
                    while ($row = $resultlivros->fetch_assoc()) {

                        echo "<div class='livro'>";
                        echo "<img class='livro-imagem' src='" . $row["imagem"] . "' alt='" . $row["titulo"] . "'>";
                        echo "<h3>Título: " . $row["titulo"] . "</h3>";
                        echo "<p>Multa: R$ " . $atraso . "</p>";
                        echo "</div>";

                    }
                }
            }
            echo "</ul>";
        } else {
            echo "<p>Nenhuma multa encontrada.</p>";
        }

        $conn->close();
    ?>
    </div>
</body>
</html>
