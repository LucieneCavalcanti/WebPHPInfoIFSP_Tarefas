<?php
session_start();
require_once("includes/topo.php");

if(isset($_SESSION['tipoUsuario']) && $_SESSION['tipoUsuario']=="Administrador"){
    require_once("banco/conexao.php");
    try{
        if(isset($_GET['id'])){
            $id = $_GET['id'];
            
            // Primeiro verifica se o usuário existe
            $checkStmt = $conn->prepare("SELECT id FROM tbusuarios WHERE id = :id");
            $checkStmt->bindParam(":id", $id, PDO::PARAM_INT);
            $checkStmt->execute();
            
            if($checkStmt->rowCount() > 0) {
                // Usuário existe, pode excluir
                $stmt = $conn->prepare("DELETE FROM tbusuarios WHERE id = :id");
                $stmt->bindParam(":id", $id, PDO::PARAM_INT);
                $stmt->execute();
                
                $linhas_deletadas = $stmt->rowCount();
                if($linhas_deletadas == 1) {
                    ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <strong>Sucesso!</strong> Usuário excluído com sucesso.
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    <div class="text-center mt-3">
                        <a href="listausuarios.php" class="btn btn-primary">Voltar para a listagem</a>
                    </div>
                    <script>
                        // Redirecionar após 2 segundos
                        setTimeout(function() {
                            window.location.href = 'listausuarios.php';
                        }, 2000);
                    </script>
                    <?php
                } else {
                    ?>
                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                        <strong>Atenção!</strong> Erro ao excluir o usuário.
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    <div class="text-center mt-3">
                        <a href="listausuarios.php" class="btn btn-primary">Voltar para a listagem</a>
                    </div>
                    <?php
                }
            } else {
                ?>
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <strong>Atenção!</strong> Usuário não encontrado.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                <div class="text-center mt-3">
                    <a href="listausuarios.php" class="btn btn-primary">Voltar para a listagem</a>
                </div>
                <?php
            }
        } else {
            ?>
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                <strong>Atenção!</strong> Você precisa selecionar um registro.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <div class="text-center mt-3">
                <a href="listausuarios.php" class="btn btn-primary">Voltar para a listagem</a>
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
            <a href="listausuarios.php" class="btn btn-primary">Voltar para a listagem</a>
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
