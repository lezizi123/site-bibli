<?php
session_start();

if (!isset($_SESSION['idi'])) {
    header('Location: ../screen/log.php');
    exit();
}

?>

<?php
$host = "localhost";
$user = "root";
$password = "root";
$database = "biblioteca";


$con = mysqli_connect($host, $user, $password, $database);


if (isset($_POST['cadastrar'])) {
    $nome = $_POST['nome'];
    $user = $_POST['users'];
    $email = $_POST['email'];
    $code = $_POST['code'];
    $senha = $_POST['senha'];
    $senha_check = $_POST['senha_check'];


    if ($senha_check != $senha) {
        die("Senhas não correspondem");
    } else {
        $query = mysqli_query($con, "SELECT * FROM adm WHERE usuario='$user'");
        if (mysqli_num_rows($query) > 0) {
            echo "<p class='dio'>Adm já existe. Por favor, escolha outro usuário.</p>";
        } else {
            $query = mysqli_query($con, "SELECT * FROM adm WHERE email='$email'");
            if (mysqli_num_rows($query) > 0) {
                echo "<p class='dio'>Email já cadastrado. Por favor, escolha outro email.</p>";
            } else {
                $query = mysqli_query($con, "INSERT INTO Adm (nome, usuario, email, codigo, senha) VALUES ('$nome', '$user', '$email', '$code', '$senha')");

                if ($query) {
                    header("Location: gerenciar.php");
                    exit();
                } else {
                    echo "<p class='dio'>Erro ao cadastrar o administrador. Por favor, tente novamente.</p>";
                }
            }
        }
    }
}

?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="../css/login8.css">
    <link rel="icon" type="image/png" href="https://diretoaoponto-tech.com.br/icon-target.png"/>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="../logo.png">



    <title>Virtual library</title>
    <script>
        setTimeout(function() {
            var invalidMsg = document.getElementById("invalid-msg");
            if (invalidMsg) {
                var opacity = 1;
                var interval = setInterval(function() {
                    if (opacity <= 0) {
                        clearInterval(interval);
                        invalidMsg.style.display = "none";
                    } else {
                        invalidMsg.style.opacity = opacity;
                        opacity -= 0.1;
                    }
                }, 50);
            }
        }, 1500);


        function togglePassword() {
                    var passwordInput = document.getElementById("password");
                    var eyeIcon = document.getElementById("eyeIcon");

                    if (passwordInput.type === "password") {
                        passwordInput.type = "text";
                        eyeIcon.className = "fa fa-eye-slash";
                    } else {
                        passwordInput.type = "password";
                        eyeIcon.className = "fa fa-eye";
                    }
                }

                function togglePasswordRegister() {
                    var passwordInput = document.getElementById("password_register");
                    var eyeIcon = document.getElementById("eyeIcon_register");

                    if (passwordInput.type === "password") {
                        passwordInput.type = "text";
                        eyeIcon.className = "fa fa-eye-slash";
                    } else {
                        passwordInput.type = "password";
                        eyeIcon.className = "fa fa-eye";
                    }
                }

                function toggleRepeatPasswordRegister() {
        var passwordInput = document.getElementById("senha_check");
        var eyeIcon = document.getElementById("eyeIcon_repeat");

        if (passwordInput.type === "password") {
            passwordInput.type = "text";
            eyeIcon.className = "fa fa-eye-slash";
        } else {
            passwordInput.type = "password";
            eyeIcon.className = "fa fa-eye";
        }
    }

    </script>
</head>

<body>



<style>
    .password-container {
        position: relative;
    }

    .eye-icon {
        position: absolute;
        top: 50%;
        right: 20px;
        transform: translateY(-50%);
        cursor: pointer;
    }
</style>
    <form class="cadin" method="post">
        <h2>Cadastro Adm</h2>
        <div class="non1">
            <div>
                <label>Nome</label>
                <input style="background-color: rgba(255, 255, 255, 0.1);" type="text" name="nome" placeholder="Nome" required><br>
                <label>Adm</label>
                <input style="background-color: rgba(255, 255, 255, 0.1);" type="text" name="users" placeholder="Usuário" required><br>
                <label>Email</label>
                <input style="background-color: rgba(255, 255, 255, 0.1);" type="email" name="email" placeholder="Email" required><br>
            </div>
            <div class="non2">
                <label>Código de segurança</label>
                <input style="background-color: rgba(255, 255, 255, 0.1);" type="text"  MAXLENGTH = 8 name="code" placeholder="Código" required><br>
                <label>Senha</label>
<div class="password-container">
    <input style="background-color: rgba(255, 255, 255, 0.1);" type="password" id="password" name="senha" placeholder="Senha">
    <span class="eye-icon" onclick="togglePassword()">
        <i id="eyeIcon" class="fa fa-eye"></i>
    </span>
</div><br>
<label>Repetir senha</label>
<div class="password-container">
    <input style="background-color: rgba(255, 255, 255, 0.1);" type="password" id="senha_check" name="senha_check" placeholder="Repetir senha">
    <span class="eye-icon" onclick="toggleRepeatPasswordRegister()">
        <i id="eyeIcon_repeat" class="fa fa-eye"></i>
    </span>
</div>

                <button type="submit" name="cadastrar">Cadastrar</button>
                <a class="cr" href="gerenciar.php">Voltar</a>
        </div>
    </form>
</body>
</html>
