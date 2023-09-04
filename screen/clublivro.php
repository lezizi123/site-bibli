<?php
session_start();

if (!isset($_SESSION['idu'])) {
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
    <link rel="stylesheet" type="text/css" href="../css/destaques.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="icon" type="image/x-icon" href="../logo.png">
    <title>Clube do Livro</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <header>
        <div class="logo">
            <h1 class="sp">Clube do livro</h1>
        </div>
        <div style="display: flex;">
            <div style="margin-right: 30px; background-color: ">
            </div>
            <div class="search-box2">
                <li class="search-btn2">
                    <a href="tela1.php" class="fa fa-arrow-left dropbtn3" aria-hidden="true"></a>
                </li>
            </div>
        </div>
    </header>
    <div class="livros-container">
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
            $sql = "SELECT nomelivro FROM projetolivro WHERE user = $userId";
            $result = $conn->query($sql);

            if ($result && $result->num_rows > 0) {
                
                while ($livro = $result->fetch_assoc()) {
                    $livrosid = $livro["nomelivro"];
                    
                    $sql = "SELECT * FROM livros WHERE id = $livrosid";
                    $result2 = $conn->query($sql);

                    if($result2 && $result2->num_rows > 0) {
                        echo "<ul>";    
                    
                        while ($row = $result2->fetch_assoc()) {
                            echo "<div class='livro'>";
                            echo "<img class='livro-imagem' src='" . $row["imagem"] . "' alt='" . $row["titulo"] . "'>";
                            echo "<h3>Título: " . $row["titulo"] . "</h3>";
                            echo "</div>";
                        }
                        echo "</ul>"; 
                    }
                }
            }

            $conn->close();
        ?>
    </div>
</body>
</html>
