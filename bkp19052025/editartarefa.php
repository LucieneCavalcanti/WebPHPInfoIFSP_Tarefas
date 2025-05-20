<?php
include "conexao.php";

$id = $_GET["id"];
$tarefa = $conn->query("SELECT * FROM Tarefa WHERE id = $id")->fetch_assoc();
$categorias = $conn->query("SELECT * FROM Categoria");
?>

<form action="atualizartarefa.php" method="POST">
    <input type="hidden" name="id" value="<?php echo $tarefa['id']; ?>">
    Descrição: <input type="text" name="descricao" value="<?php echo $tarefa['descricao']; ?>"><br>
    Data/Hora Criação: <input type="datetime-local" name="dataHoraCriacao" value="<?php echo date('Y-m-d\TH:i', strtotime($tarefa['dataHoraCriacao'])); ?>"><br>
    Data/Hora Término: <input type="datetime-local" name="dataHoraTermino" value="<?php echo date('Y-m-d\TH:i', strtotime($tarefa['dataHoraTermino'])); ?>"><br>
    Categoria:
    <select name="fk_Categoria_id">
        <?php while($cat = $categorias->fetch_assoc()): ?>
            <option value="<?php echo $cat['id']; ?>" <?php echo ($cat['id'] == $tarefa['fk_Categoria_id']) ? "selected" : ""; ?>>
                <?php echo $cat['descricao']; ?>
            </option>
        <?php endwhile; ?>
    </select><br>
    <input type="submit" value="Atualizar">
</form>