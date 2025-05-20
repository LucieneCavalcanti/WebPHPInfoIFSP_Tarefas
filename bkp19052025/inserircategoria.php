<?php
include "conexao.php";

$descricao = $_POST["descricao"];

$sql = "INSERT INTO Categoria (descricao) VALUES ('$descricao')";
$conn->query($sql);
$conn->close();

header("Location: listacategorias.php");
?>