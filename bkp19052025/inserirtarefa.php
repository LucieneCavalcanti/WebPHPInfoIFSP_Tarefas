<?php
include "conexao.php";

$descricao = $_POST["descricao"];
$dataHoraCriacao = $_POST["dataHoraCriacao"];
$dataHoraTermino = $_POST["dataHoraTermino"];
$categoria_id = $_POST["fk_Categoria_id"];

$sql = "INSERT INTO Tarefa (descricao, dataHoraCriacao, dataHoraTermino, fk_Categoria_id)
        VALUES ('$descricao', '$dataHoraCriacao', '$dataHoraTermino', $categoria_id)";
$conn->query($sql);
$conn->close();

header("Location: listatarefas.php");
?>