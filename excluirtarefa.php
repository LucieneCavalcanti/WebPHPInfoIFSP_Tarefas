<?php
session_start();
require_once("includes/topo.php");

if(isset($_SESSION['tipoUsuario']) && $_SESSION['tipoUsuario']=="Administrador"){
    require_once("banco/conexao.php");
    try{
        if(isset($_GET['id'])){
            $id = $_GET['id'];
            
            // Verificar se a tarefa existe
            $checkStmt = $conn->prepare("SELECT id FROM tarefa WHERE id = :id");
            $checkStmt->bindParam(":id", $id, PDO::PARAM_INT);
            $checkStmt->execute();
            
            if($checkStmt->rowCount() > 0) {
                // Tarefa existe, pode excluir
                $stmt = $conn->prepare("DELETE FROM tarefa WHERE id = :id");
                $stmt->bindParam(":id", $id, PDO::PARAM_INT);
                $stmt->execute();
                
                $linhas_deletadas = $stmt->rowCount();
                if($linhas_deletadas == 1) {
                    ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <strong>Sucesso!</strong> Tarefa excluída com sucesso.
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    <div class="text-center mt-3">
                        <a href="listatarefas.php" class="btn btn-primary">Voltar para a listagem</a>
                    </div>
                    <script>
                        // Redirecionar após 2 segundos
                        setTimeout(function() {
                            window.location.href = 'listatarefas.php';
                        }, 2000);
                    </script>
                    <?php
                } else {
                    ?>
                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                        <strong>Atenção!</strong> Erro ao excluir a tarefa.
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    <div class="text-center mt-3">
                        <a href="listatarefas.php" class="btn btn-primary">Voltar para a listagem</a>
                    </div>
                    <?php
                }
            } else {
                ?>
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <strong>Atenção!</strong> Tarefa não encontrada.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                <div class="text-center mt-3">
                    <a href="listatarefas.php" class="btn btn-primary">Voltar para a listagem</a>
                </div>
                <?php
            }
        } else {
            ?>
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                <strong>Atenção!</strong> Você precisa selecionar uma tarefa.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <div class="text-center mt-3">
                <a href="listatarefas.php" class="btn btn-primary">Voltar para a listagem</a>
            </div>
            <?php
        }
    } catch(Exception $erro) {
        ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Erro:</strong> <?php echo $erro->getMessage(); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <div class="text-center mt-3">
            <a href="listatarefas.php" class="btn btn-primary">Voltar para a listagem</a>
        </div>
        <?php
    }
} else {
    ?>
    <div class="alert alert-danger">
        <strong>Acesso Negado!</strong> Você não tem permissão para acessar este conteúdo.
    </div>
    <?php
} 
require_once("includes/rodape.php"); 
?>
