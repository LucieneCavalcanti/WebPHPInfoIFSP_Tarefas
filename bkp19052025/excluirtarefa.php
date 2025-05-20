<?php
include "conexao.php";

$id = $_GET["id"];
$sql = "DELETE FROM Tarefa WHERE id = $id";
$conn->query($sql);
$conn->close();

header("Location: listatarefas.php");
?>