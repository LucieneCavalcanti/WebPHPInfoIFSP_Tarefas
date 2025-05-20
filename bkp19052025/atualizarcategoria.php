<?php
include "conexao.php";

$id = $_POST["id"];
$descricao = $_POST["descricao"];

$sql = "UPDATE Categoria SET descricao = '$descricao' WHERE id = $id";
$conn->query($sql);
$conn->close();

header("Location: listacategorias.php");
?>