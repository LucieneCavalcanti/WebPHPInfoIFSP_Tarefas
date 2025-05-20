<?php 
session_start();
require_once("includes/topo.php");

if(isset($_SESSION['tipoUsuario']) && $_SESSION['tipoUsuario']=="Administrador"){
    try {
        if(isset($_POST['descricao']) && !empty($_POST['descricao']) && 
           isset($_POST['categoria']) && !empty($_POST['categoria']) && 
           isset($_POST['id'])){
            
            $descricaoTarefa = $_POST['descricao'];
            $categoriaTarefa = $_POST['categoria'];
            $idTarefa = $_POST['id'];

            require_once("banco/conexao.php");
            
            // Verificar se a categoria existe
            $checkCategoria = $conn->prepare("SELECT id FROM categoria WHERE id = :id");
            $checkCategoria->bindParam(":id", $categoriaTarefa, PDO::PARAM_INT);
            $checkCategoria->execute();
            
            if($checkCategoria->rowCount() == 0) {
                ?>
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <strong>Atenção!</strong> A categoria selecionada não existe.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                <div class="text-center mt-3">
                    <a href="editartarefa.php?id=<?php echo $idTarefa; ?>" class="btn btn-primary">Voltar para edição</a>
                </div>
                <?php
            } else {
                // Verificar se a tarefa existe
                $checkTarefa = $conn->prepare("SELECT id FROM tarefa WHERE id = :id");
                $checkTarefa->bindParam(":id", $idTarefa, PDO::PARAM_INT);
                $checkTarefa->execute();
                
                if($checkTarefa->rowCount() == 0) {
                    ?>
                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                        <strong>Atenção!</strong> A tarefa não existe.
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    <div class="text-center mt-3">
                        <a href="listatarefas.php" class="btn btn-primary">Voltar para a listagem</a>
                    </div>
                    <?php
                } else {
                    $sql = "UPDATE tarefa SET descricao=:descricao, fk_Categoria_id=:categoria WHERE id=:id";

                    $stmt = $conn->prepare($sql);
                    $stmt->bindParam(":descricao", $descricaoTarefa, PDO::PARAM_STR);
                    $stmt->bindParam(":categoria", $categoriaTarefa, PDO::PARAM_INT);
                    $stmt->bindParam(":id", $idTarefa, PDO::PARAM_INT);
                    $stmt->execute();
                    
                    $linhas_atualizadas = $stmt->rowCount();
                    
                    if($linhas_atualizadas == 1) {
                        ?>
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <strong>Sucesso!</strong> Tarefa atualizada com sucesso.
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
                            <strong>Atenção!</strong> Nenhuma alteração foi realizada.
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                        <div class="text-center mt-3">
                            <a href="listatarefas.php" class="btn btn-primary">Voltar para a listagem</a>
                        </div>
                        <?php
                    }
                }
            }
        } else {
            ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Erro!</strong> Você deve preencher todos os campos.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <div class="text-center mt-3">
                <a href="listatarefas.php" class="btn btn-primary">Voltar para a listagem</a>
            </div>
            <?php
        }
    } catch(PDOException $e) {
        ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Erro:</strong> <?php echo $e->getMessage(); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <div class="text-center mt-3">
            <a href="listatarefas.php" class="btn btn-primary">Voltar para a listagem</a>
        </div>
        <?php
    }
    $conn = null;
} else {
    ?>
    <div class="alert alert-danger">
        <strong>Acesso Negado!</strong> Você não tem permissão para acessar este conteúdo.
    </div>
    <?php
} 
require_once("includes/rodape.php"); 
?>
