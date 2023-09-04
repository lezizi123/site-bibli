<?php
session_start();

if (!isset($_SESSION['idi'])) {
    header('Location: ../screen/log.php');
    exit();
}

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = $_GET['id'];

    $servername = "localhost";
    $username = "root";
    $password = "root";
    $dbname = "biblioteca";

    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Falha na conexão com o banco de dados: " . $conn->connect_error);
    }

    $sql = "DELETE FROM adm WHERE id = $id";
    if ($conn->query($sql) === TRUE) {
        // Registro excluído com sucesso
        header('Location: gerenciar.php'); // Redirecionar de volta para a página de gerenciamento
        exit();
    } else {
        echo "Erro ao excluir registro: " . $conn->error;
    }

    $conn->close();
} else {
    echo "ID inválido";
}
?>
