<?php 
session_start();
require_once("includes/topo.php");

if(isset($_SESSION['tipoUsuario']) && $_SESSION['tipoUsuario']=="Administrador"){
    try {
        if(isset($_POST['nome']) && isset($_POST['email']) && isset($_POST['senha'])){
            //validações
            $nomeUsuario = $_POST['nome'];
            $emailUsuario = $_POST['email'];
            $senhaUsuario = $_POST['senha'];
            $idUsuario = $_POST['id']; //campo hidden

            require_once("banco/conexao.php");
            $sql = "UPDATE tbusuarios SET nome=:nome, email=:email, senha=:senha WHERE id=:id";

            $stmt = $conn->prepare($sql);
            // Define os parâmetros
            $stmt->bindParam(":nome", $nomeUsuario, PDO::PARAM_STR);
            $stmt->bindParam(":email", $emailUsuario, PDO::PARAM_STR);
            $stmt->bindParam(":senha", $senhaUsuario, PDO::PARAM_STR);
            $stmt->bindParam(":id", $idUsuario, PDO::PARAM_INT);
            // Executa a instrução
            $stmt->execute();
            // Obtém o número de linhas afetadas
            $linhas_atualizadas = $stmt->rowCount();
            
            if($linhas_atualizadas == 1) {
                ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>Sucesso!</strong> Usuário atualizado com sucesso.
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
                    <strong>Atenção!</strong> Nenhuma alteração foi realizada.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                <div class="text-center mt-3">
                    <a href="listausuarios.php" class="btn btn-primary">Voltar para a listagem</a>
                </div>
                <?php
            }
        } else {
            ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Erro!</strong> Você deve preencher todos os campos.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <div class="text-center mt-3">
                <a href="cadastrousuario.php" class="btn btn-primary">Voltar para o cadastro</a>
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
            <a href="listausuarios.php" class="btn btn-primary">Voltar para a listagem</a>
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
