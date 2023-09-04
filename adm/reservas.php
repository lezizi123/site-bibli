<?php
session_start();

date_default_timezone_set('America/Sao_Paulo');

if (!isset($_SESSION['idi'])) {
    header('Location: ../screen/log.php');
    exit();
}
?>
    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $servername = "localhost";
        $username = "root";
        $password = "root";
        $dbname = "biblioteca";

        $conn = new mysqli($servername, $username, $password, $dbname);
        if ($conn->connect_error) {
            die("Falha na conexão com o banco de dados: " . $conn->connect_error);
        }

        $titulo = $_POST["livro"];
        $turma = $_POST["turma"];
        $dataini = $_POST["ini"];
        $datafim = $_POST["fim"];
        
        // Ajuste o formato das datas para o formato de banco de dados (AAAA-MM-DD)
        $dataini_formatada = date('Y-m-d', strtotime($dataini));
        $datafim_formatada = date('Y-m-d', strtotime($datafim));
        
        $sql = "INSERT INTO reservas (user, livro, dataini, datafim) VALUES ('$titulo', '$turma', '$dataini_formatada', '$datafim_formatada')";
        

        if ($conn->query($sql) === TRUE) {
        $sql = "UPDATE livros SET disponivel =  disponivel - 1 WHERE id = $turma";
        if ($conn->query($sql) === TRUE) {
            header("Location: reservas.php");
            exit();
        }
        }
    
        $conn->close();
    }
        $servername = "localhost";
        $username = "root";
        $password = "root";
        $dbname = "biblioteca";

        $conn = new mysqli($servername, $username, $password, $dbname);
        if ($conn->connect_error) {
            die("Falha na conexão com o banco de dados: " . $conn->connect_error);
        }

        $sql = "SELECT * FROM reservas";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $today = date('Y-m-d');
                $diferenca_em_dias = (strtotime($today) - strtotime($row["datafim"])) / (60 * 60 * 24);
                
                if ($row["datafim"] < $today) {

                    $multa = $diferenca_em_dias * 0.5;
            
                    $update_sql = "UPDATE reservas SET atraso = $multa WHERE id = " . $row["id"];
                    $conn->query($update_sql);
            
                    $user_id = $row["user"];
                    $update_sql_pessoas = "UPDATE pessoas SET atraso = $multa WHERE id = $user_id";
                    $conn->query($update_sql_pessoas);
                } else {
                    $update_sql = "UPDATE reservas SET multa = 0 WHERE id = " . $row["id"];
                    $conn->query($update_sql);
            
                    $user_id = $row["user"];
                    $update_sql_pessoas = "UPDATE pessoas SET multa = 0 WHERE id = $user_id";
                    $conn->query($update_sql_pessoas);
                }
            }
        }

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
                <h3>Bibli.ON</h3>
            </div>
            <div>
                <a href="menuadm.php">Detalhes</a>
                <a href="gerenciar.php">Gerenciar usuários</a>
                <a href="turmas.php">Turmas</a>
                <a href="addlivro.php">Adicionar livro</a>
                <a href="projetolei.php">Projeto leitura</a>
                <a style="background-color: #c5deff;">Empréstimo</a>
                <a href="clublivro.php">Club do livro</a>
                <a href="logout.php">Sair</a>
            </div>
        </nav>
    </header>
    <div id="adicionar-livro-secao" class="addlivro">
        <div class="container1">
            <form method="POST" action="<?php echo $_SERVER["PHP_SELF"]; ?>" enctype="multipart/form-data">
                <h2>Empréstimo</h2>

                <label for="livro">Usuários</label><br>
                <select style="margin-bottom: 10px;" class="in" name="livro" required>
                <?php       
                    $host = "localhost";
                    $user = "root";
                    $password = "root";
                    $database = "biblioteca";
                    
                    $conn = mysqli_connect($host, $user, $password, $database);
        
                    $sql = "SELECT * FROM pessoas";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        echo '<option value="">Selecione usuários</option>'; 
                        while ($row = $result->fetch_assoc()) {
                            echo '<option value="' . $row["id"] . '">' . $row["user"] . '</option>';
                        }
                    } else {
                        echo '<option disabled>Nenhuma categoria encontrada para este evento.</option>';
                    }


                    $conn->close();
                ?>
                </select>

                <label for="turma">Livro</label><br>
                <select style="margin-bottom: 10px;" class="in" name="turma" required>
                <?php       
                    $host = "localhost";
                    $user = "root";
                    $password = "root";
                    $database = "biblioteca";
                    
                    
                    $conn = mysqli_connect($host, $user, $password, $database);
        
                    $sql = "SELECT * FROM livros";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        echo '<option value="">Selecione turma</option>'; 
                        while ($row = $result->fetch_assoc()) {
                            echo '<option value="' . $row["id"] . '">' . $row["titulo"] . '</option>';
                        }
                    } else {
                        echo '<option disabled>Nenhuma categoria encontrada para este evento.</option>';
                    }


                    $conn->close();
                ?>
                </select>
                <label for="">Data de reserva</label>
                <input style="margin-bottom: 10px;" class="in" type="date" name="ini" id="">
                <label for="">Data de entrega</label>
                <input style="margin-bottom: 10px;" class="in" type="date" name="fim" id=""><br>

                <button class="lin" type="submit" name="cadastrar" value="Cadastrar">Reservar</button>
            </form>
        </div>
        <div class="container2">
            <form class="bun" method="GET" action="<?php echo $_SERVER["PHP_SELF"]; ?>">
              <input class="bun1" type="text" name="search" id="search" class="search-input">
              <button class="bun2" type="submit" class="search-button"><i class="fa fa-search" aria-hidden="true"></i></button>
            </form>
            <table>
            <thead>
                <tr>
                <th>Usuário</th>
                <th>Livro</th>
                <th>Data reserva</th>
                <th>Data entrega</th>
                <th>Valor da multa</th>
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

    $sql = "SELECT * FROM reservas";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {

            $livro = $row["livro"];
            $usuario = $row["user"];
            $datin = $row["dataini"];
            $dafim = $row["datafim"];
            $atraso = $row["atraso"];

            $sql_pess = "SELECT * FROM livros WHERE id ='$livro'";
            $result_pess = $conn->query($sql_pess);

            if ($result_pess->num_rows > 0) {
                while ($row_pess = $result_pess->fetch_assoc()) {

                    $titulo = $row_pess["titulo"];
                    $livro_id = $row_pess["id"];

                    $sql_livv = "SELECT * FROM pessoas WHERE id ='$usuario' AND nome LIKE '%$search%'";
                    $result_livv = $conn->query($sql_livv);

                    if ($result_livv->num_rows > 0) {
                        while ($row_livv = $result_livv->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . $row_livv["nome"] . "</td>";
                            echo "<td>" . $titulo . "</td>";
                            echo "<td>" . $datin . "</td>";
                            echo "<td>" . $dafim . "</td>";
                            echo "<td>R$" . $atraso . "</td>";
                            echo "<td class='options'>
                                    <a class='fa fa-pencil-square-o ininn' href='detalhesreserva.php?id=" . $row["id"] . "'></a>";
                            echo "<a id='delete-button' class='fa fa-minus-square-o ininn' href='apagar3.php?id=" . $row["id"] . "' 
                                onclick=\"return confirm('Tem certeza que deseja excluir este registro?');\"></a>";
                                
                            echo "</td></tr>";
                        }
                    }
                } 
            }
        }  
    }

    $conn->close();
    ?>
            </tbody>
            </table>
        </div>
    </div>
    <script>
        const inputFile = document.querySelector("#picture__input");
            const pictureImage = document.querySelector(".picture__image");
            const pictureImageTxt = "Inserir imagem";
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
        const deleteButtons = document.querySelectorAll("#delete-button");

        deleteButtons.forEach(button => {
        button.addEventListener("click", function() {
            const id = this.dataset.id;

            fetch(`apagar3.php?id=${id}`)
                .then(response => response.text())
                .then(data => {
                location.reload();
                })
                .catch(error => {
                console.error("Erro ao apagar o livro:", error);
                });
        });
    });
    </script>
</body>
</html>
