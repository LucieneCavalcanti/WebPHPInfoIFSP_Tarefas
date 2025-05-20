<?php
include "conexao.php";

$id = $_POST["id"];
$descricao = $_POST["descricao"];
$dataHoraCriacao = $_POST["dataHoraCriacao"];
$dataHoraTermino = $_POST["dataHoraTermino"];
$categoria_id = $_POST["fk_Categoria_id"];

$sql = "UPDATE Tarefa SET 
        descricao = '$descricao', 
        dataHoraCriacao = '$dataHoraCriacao',
        dataHoraTermino = '$dataHoraTermino',
        fk_Categoria_id = $categoria_id
        WHERE id = $id";

$conn->query($sql);
$conn->close();

header("Location: listatarefas.php");
?>