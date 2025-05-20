<?php
include "conexao.php";

$sql = "SELECT * FROM Categoria";
$result = $conn->query($sql);

echo "<h1>Lista de Categorias</h1>";
echo "<a href='cadastrarcategoria.php'>Nova Categoria</a><br><br>";

while($row = $result->fetch_assoc()) {
    echo "ID: " . $row["id"] . " - Descrição: " . $row["descricao"];
    echo " | <a href='editarcategoria.php?id=" . $row["id"] . "'>Editar</a>";
    echo " | <a href='excluircategoria.php?id=" . $row["id"] . "'>Excluir</a><br>";
}
$conn->close();
?>