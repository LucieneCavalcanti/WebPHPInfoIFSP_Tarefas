<?php 
session_start();
require_once("includes/topo.php"); 

if(isset($_SESSION['tipoUsuario']) && $_SESSION['tipoUsuario']=="Administrador"){
    try {
        if(isset($_POST['descricao']) && !empty($_POST['descricao'])){
            $descricaoCategoria = $_POST['descricao'];

            require_once("banco/conexao.php");
            
            // Verificar se a categoria já existe
            $checkCategoria = $conn->prepare("SELECT id FROM categoria WHERE descricao = :descricao");
            $checkCategoria->bindParam(":descricao", $descricaoCategoria, PDO::PARAM_STR);
            $checkCategoria->execute();
            
            if($checkCategoria->rowCount() > 0) {
                ?>
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <strong>Atenção!</strong> Esta categoria já está cadastrada.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                <div class="text-center mt-3">
                    <a href="cadastrocategoria.php" class="btn btn-primary">Voltar para o cadastro</a>
                </div>
                <?php
            } else {
                // Usar prepared statement para inserção segura
                $sql = "INSERT INTO categoria (descricao) VALUES (:descricao)";
                $stmt = $conn->prepare($sql);
                $stmt->bindParam(":descricao", $descricaoCategoria, PDO::PARAM_STR);
                $stmt->execute();
                
                $linhas_inseridas = $stmt->rowCount();
                
                if($linhas_inseridas == 1) {
                    ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <strong>Sucesso!</strong> Categoria cadastrada com sucesso.
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
                        <strong>Atenção!</strong> Erro ao cadastrar categoria.
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    <div class="text-center mt-3">
                        <a href="cadastrocategoria.php" class="btn btn-primary">Voltar para o cadastro</a>
                    </div>
                    <?php
                }
            }
        } else {
            ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Erro!</strong> Você deve preencher a descrição da categoria.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <div class="text-center mt-3">
                <a href="cadastrocategoria.php" class="btn btn-primary">Voltar para o cadastro</a>
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
            <a href="cadastrocategoria.php" class="btn btn-primary">Voltar para o cadastro</a>
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
