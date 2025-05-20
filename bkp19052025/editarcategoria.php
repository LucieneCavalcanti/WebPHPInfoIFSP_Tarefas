<?php
include "conexao.php";

$id = $_GET["id"];
$sql = "SELECT * FROM Categoria WHERE id = $id";
$result = $conn->query($sql);
$row = $result->fetch_assoc();
?>

<form action="atualizarcategoria.php" method="POST">
    <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
    Descrição: <input type="text" name="descricao" value="<?php echo $row['descricao']; ?>" required>
    <input type="submit" value="Atualizar">
</form>