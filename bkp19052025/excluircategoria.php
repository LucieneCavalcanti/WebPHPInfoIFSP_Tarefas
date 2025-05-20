<?php
include "conexao.php";

$id = $_GET["id"];
$sql = "DELETE FROM Categoria WHERE id = $id";
$conn->query($sql);
$conn->close();

header("Location: listacategorias.php");
?>