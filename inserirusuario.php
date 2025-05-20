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

            require_once("banco/conexao.php");
            
            // Verificar se o email já existe
            $checkEmail = $conn->prepare("SELECT id FROM tbusuarios WHERE email = :email");
            $checkEmail->bindParam(":email", $emailUsuario, PDO::PARAM_STR);
            $checkEmail->execute();
            
            if($checkEmail->rowCount() > 0) {
                ?>
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <strong>Atenção!</strong> Este e-mail já está cadastrado.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                <div class="text-center mt-3">
                    <a href="cadastrousuario.php" class="btn btn-primary">Voltar para o cadastro</a>
                </div>
                <?php
            } else {
                // Usar prepared statement para inserção segura
                $sql = "INSERT INTO tbusuarios (nome, email, senha) VALUES (:nome, :email, :senha)";
                $stmt = $conn->prepare($sql);
                $stmt->bindParam(":nome", $nomeUsuario, PDO::PARAM_STR);
                $stmt->bindParam(":email", $emailUsuario, PDO::PARAM_STR);
                $stmt->bindParam(":senha", $senhaUsuario, PDO::PARAM_STR);
                $stmt->execute();
                
                $linhas_inseridas = $stmt->rowCount();
                
                if($linhas_inseridas == 1) {
                    ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <strong>Sucesso!</strong> Usuário cadastrado com sucesso.
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
                        <strong>Atenção!</strong> Erro ao cadastrar usuário.
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    <div class="text-center mt-3">
                        <a href="cadastrousuario.php" class="btn btn-primary">Voltar para o cadastro</a>
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
            <a href="cadastrousuario.php" class="btn btn-primary">Voltar para o cadastro</a>
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
