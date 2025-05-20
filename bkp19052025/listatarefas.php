<?php
include "conexao.php";

$sql = "SELECT Tarefa.*, Categoria.descricao as categoria FROM Tarefa
        LEFT JOIN Categoria ON Tarefa.fk_Categoria_id = Categoria.id";
$result = $conn->query($sql);

echo "<h1>Lista de Tarefas</h1>";
echo "<a href='cadastrartarefa.php'>Nova Tarefa</a><br><br>";

while($row = $result->fetch_assoc()) {
    echo "ID: {$row['id']} - Descrição: {$row['descricao']} - Criada em: {$row['dataHoraCriacao']} - Término: {$row['dataHoraTermino']} - Categoria: {$row['categoria']}";
    echo " | <a href='editartarefa.php?id={$row['id']}'>Editar</a>";
    echo " | <a href='excluirtarefa.php?id={$row['id']}'>Excluir</a><br>";
}
$conn->close();
?>