<?php
session_start();
require_once("includes/topo.php");

if(isset($_SESSION['tipoUsuario']) && $_SESSION['tipoUsuario']=="Administrador"){
    require_once("banco/conexao.php");
    try{
        if(isset($_GET['id'])){
            $id = $_GET['id'];
            $dataHoraTermino = date('Y-m-d H:i:s');
            
            // Verificar se a tarefa existe e não está concluída
            $checkStmt = $conn->prepare("SELECT id FROM tarefa WHERE id = :id AND dataHoraTermino IS NULL");
            $checkStmt->bindParam(":id", $id, PDO::PARAM_INT);
            $checkStmt->execute();
            
            if($checkStmt->rowCount() > 0) {
                // Tarefa existe e não está concluída, pode marcar como concluída
                $stmt = $conn->prepare("UPDATE tarefa SET dataHoraTermino = :dataHoraTermino WHERE id = :id");
                $stmt->bindParam(":dataHoraTermino", $dataHoraTermino, PDO::PARAM_STR);
                $stmt->bindParam(":id", $id, PDO::PARAM_INT);
                $stmt->execute();
                
                $linhas_atualizadas = $stmt->rowCount();
                if($linhas_atualizadas == 1) {
                    ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <strong>Sucesso!</strong> Tarefa marcada como concluída.
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
                        <strong>Atenção!</strong> Erro ao concluir a tarefa.
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
                    <strong>Atenção!</strong> Tarefa não encontrada ou já concluída.
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
