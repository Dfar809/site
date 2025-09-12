<?php
$host = "localhost";
$user = "root";
$password = "";
$database = "quiz";

$conexao = mysqli_connect($host, $user, $password, $database);
if (!$conexao) {
    die("Falha na conexão: " . mysqli_connect_error());
}
?>
