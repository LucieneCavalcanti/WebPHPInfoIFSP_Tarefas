<?php
include "conexao.php";
$categorias = $conn->query("SELECT * FROM Categoria");
?>

<form action="inserirtarefa.php" method="POST">
    Descrição: <input type="text" name="descricao" required><br>
    Data/Hora Criação: <input type="datetime-local" name="dataHoraCriacao" required><br>
    Data/Hora Término: <input type="datetime-local" name="dataHoraTermino"><br>
    Categoria:
    <select name="fk_Categoria_id">
        <?php while($cat = $categorias->fetch_assoc()): ?>
            <option value="<?php echo $cat['id']; ?>"><?php echo $cat['descricao']; ?></option>
        <?php endwhile; ?>
    </select><br>
    <input type="submit" value="Salvar">
</form>