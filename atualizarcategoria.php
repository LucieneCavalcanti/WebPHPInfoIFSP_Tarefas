<?php 
session_start();
require_once("includes/topo.php");

if(isset($_SESSION['tipoUsuario']) && $_SESSION['tipoUsuario']=="Administrador"){
    try {
        if(isset($_POST['descricao']) && !empty($_POST['descricao']) && isset($_POST['id'])){
            $descricaoCategoria = $_POST['descricao'];
            $idCategoria = $_POST['id'];

            require_once("banco/conexao.php");
            
            // Verificar se a categoria já existe com esse nome (exceto a própria)
            $checkCategoria = $conn->prepare("SELECT id FROM categoria WHERE descricao = :descricao AND id != :id");
            $checkCategoria->bindParam(":descricao", $descricaoCategoria, PDO::PARAM_STR);
            $checkCategoria->bindParam(":id", $idCategoria, PDO::PARAM_INT);
            $checkCategoria->execute();
            
            if($checkCategoria->rowCount() > 0) {
                ?>
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <strong>Atenção!</strong> Já existe outra categoria com esta descrição.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                <div class="text-center mt-3">
                    <a href="editarcategoria.php?id=<?php echo $idCategoria; ?>" class="btn btn-primary">Voltar para edição</a>
                </div>
                <?php
            } else {
                $sql = "UPDATE categoria SET descricao=:descricao WHERE id=:id";

                $stmt = $conn->prepare($sql);
                $stmt->bindParam(":descricao", $descricaoCategoria, PDO::PARAM_STR);
                $stmt->bindParam(":id", $idCategoria, PDO::PARAM_INT);
                $stmt->execute();
                
                $linhas_atualizadas = $stmt->rowCount();
                
                if($linhas_atualizadas == 1) {
                    ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <strong>Sucesso!</strong> Categoria atualizada com sucesso.
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    <div class="text-center mt-3">
                        <a href="listacategorias.php" class="btn btn-primary">Voltar para a listagem</a>
                    </div>
                    <script>
                        // Redirecionar após 2 segundos
                        setTimeout(function() {
                            window.location.href = 'listacategorias.php';
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
                        <a href="listacategorias.php" class="btn btn-primary">Voltar para a listagem</a>
                    </div>
                    <?php
                }
            }
        } else {
            ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Erro!</strong> Você deve preencher todos os campos.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <div class="text-center mt-3">
                <a href="listacategorias.php" class="btn btn-primary">Voltar para a listagem</a>
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
            <a href="listacategorias.php" class="btn btn-primary">Voltar para a listagem</a>
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
