<?php
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "biblioteca";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Falha na conexão com o banco de dados: " . $conn->connect_error);
}

if (isset($_POST['cadastrarTurma'])) {
    $novaTurma = $_POST['novaTurma'];

    $sql = "INSERT INTO turmas (turma) VALUES ('$novaTurma')";
    if ($conn->query($sql) === TRUE) {
        header("location: turmas.php");
        exit();
    }
}

$conn->close();
?>


<!DOCTYPE html>
<html>  
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../css/menuad.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="icon" type="image/x-icon" href="../logo.png">
    <title>Biblioteca</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <header>
        <nav class="navigation">
            <div>
                <h3>Bibli.ON</h3></a>
            </div>
            <div>
                <a href="menuadm.php">Detalhes</a>
                <a href="gerenciar.php">Gerenciar usuários</a>
                <a style="background-color: #c5deff;" href="turmas.php">Turmas</a>
                <a href="addlivro.php">Adicionar livro</a>
                <a href="projetolei.php">Projeto leitura</a>
                <a href="reservas.php">Empréstimo</a>
                <a href="clublivro.php">Club do livro</a>
                <a href="logout.php">Sair</a>

            </div>
        </nav>
    </header>
    <div id="adicionar-livro-secao" class="addlivro">
        <div class="container1">
        <h2>Cadastro de Turmas</h2>
        <form method="POST" action="turmas.php">
            <label for="novaTurma">Nova Turma</label><br>
            <input class='in' type="text" name="novaTurma" id="novaTurma" required><br><br>
            <button class="lin" type="submit" name="cadastrarTurma">Cadastrar</button>
        </form>

        </div>
        <div class="container2">
            <form class="bun" method="GET" action="<?php echo $_SERVER["PHP_SELF"]; ?>">
              <input class="bun1" type="text" name="search" id="search" class="search-input">
              <button class="bun2" type="submit" class="search-button"><i class="fa fa-search" aria-hidden="true"></i></button>
            </form>
            <table>
            <thead>
                <th>Turma</th>
                <th>Opções</th>
                </tr>
            </thead>
            <tbody>
            <?php
              $servername = "localhost";
              $username = "root";
              $password = "root";
              $dbname = "biblioteca";

              $conn = new mysqli($servername, $username, $password, $dbname);
              if ($conn->connect_error) {
                die("Falha na conexão com o banco de dados: " . $conn->connect_error);
              }

              $search = isset($_GET['search']) ? $_GET['search'] : '';

              $sql = "SELECT * FROM turmas WHERE turma LIKE '%$search%'";
              $result = $conn->query($sql);

              if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {

                        echo "<tr>";
                        echo "<td>" . $row["turma"] . "</td>";
                        echo "<td class='options'><a class='fa fa-pencil-square-o ininn' href='detalhesturma.php?id=" . $row["id"] . "'></a>";
                        echo "<a id='delete-button' class='fa fa-minus-square-o ininn' href='apagar5.php?id=" . $row["id"] . "'></a></td>";
                        echo "</tr>"; 
                    }
                } else {
                echo "<tr><td colspan='6'>Nenhum livro encontrado.</td></tr>";
                }

                $conn->close();
                ?>
            </tbody>
            </table>
        </div>
    </div>
    <script>
    const deleteButtons = document.querySelectorAll("#delete-button");

    deleteButtons.forEach(button => {
        button.addEventListener("click", function(e) {
            e.preventDefault();
            const deleteUrl = this.getAttribute('href');

            if (confirm("Tem certeza que deseja excluir este registro?")) {
                fetch(deleteUrl)
                    .then(response => response.text())
                    .then(data => {
                        location.reload();
                    })
                    .catch(error => {
                        console.error("Erro ao apagar o registro:", error);
                    });
            }
        });
    });
</script>
</body>
</html>