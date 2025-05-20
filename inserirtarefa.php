<?php 
session_start();
require_once("includes/topo.php"); 

if(isset($_SESSION['tipoUsuario']) && $_SESSION['tipoUsuario']=="Administrador"){
    try {
        // Verificar se os dados foram enviados
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Verificar se os campos obrigatórios existem e não estão vazios
            if (empty($_POST['descricao'])) {
                throw new Exception("A descrição da tarefa é obrigatória.");
            }
            
            if (empty($_POST['categoria'])) {
                throw new Exception("A categoria da tarefa é obrigatória.");
            }
            
            $descricaoTarefa = $_POST['descricao'];
            $categoriaTarefa = $_POST['categoria'];
            $dataHoraCriacao = date('Y-m-d H:i:s');

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
                    <a href="cadastrotarefa.php" class="btn btn-primary">Voltar para o cadastro</a>
                </div>
                <?php
            } else {
                // Usar prepared statement para inserção segura
                $sql = "INSERT INTO tarefa (descricao, dataHoraCriacao, fk_Categoria_id) VALUES (:descricao, :dataHoraCriacao, :categoria)";
                $stmt = $conn->prepare($sql);
                $stmt->bindParam(":descricao", $descricaoTarefa, PDO::PARAM_STR);
                $stmt->bindParam(":dataHoraCriacao", $dataHoraCriacao, PDO::PARAM_STR);
                $stmt->bindParam(":categoria", $categoriaTarefa, PDO::PARAM_INT);
                $stmt->execute();
                
                $linhas_inseridas = $stmt->rowCount();
                
                if($linhas_inseridas == 1) {
                    ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <strong>Sucesso!</strong> Tarefa cadastrada com sucesso.
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
                        <strong>Atenção!</strong> Erro ao cadastrar tarefa.
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    <div class="text-center mt-3">
                        <a href="cadastrotarefa.php" class="btn btn-primary">Voltar para o cadastro</a>
                    </div>
                    <?php
                }
            }
        }
    } catch(Exception $e) {
        ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Erro!</strong> <?php echo $e->getMessage(); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <div class="text-center mt-3">
            <a href="cadastrotarefa.php" class="btn btn-primary">Voltar para o cadastro</a>
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
