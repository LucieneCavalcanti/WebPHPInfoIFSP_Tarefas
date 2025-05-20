<?php
session_start();
require_once("includes/topo.php");
require_once("banco/conexao.php");

try {
    if(isset($_POST['email']) && isset($_POST['senha'])) {
        $email = $_POST['email'];
        $senha = $_POST['senha'];
        
        $select = $conn->prepare("SELECT * FROM tbusuarios WHERE email=:email AND senha=:senha");
        $select->bindParam(":email", $email, PDO::PARAM_STR);
        $select->bindParam(":senha", $senha, PDO::PARAM_STR);
        $select->execute();

        $usuarios = $select->fetchAll(PDO::FETCH_ASSOC);
        
        if(count($usuarios) == 1) {
            if($usuarios[0]['status'] == 1) {
                ?>
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <strong>Atenção!</strong> Seu login está inativo, entre em contato com o administrador.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                <div class="text-center mt-3">
                    <a href="login.php" class="btn btn-primary">Voltar para o login</a>
                </div>
                <?php
            } elseif($usuarios[0]['status'] == 2) {
                $_SESSION['idUsuario'] = $usuarios[0]['id'];
                $_SESSION['nomeUsuario'] = $usuarios[0]['nome'];
                $_SESSION['tipoUsuario'] = $usuarios[0]['tipo'];
                
                header('location:indexlogado.php');
                exit;
            }
        } else {
            ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Erro!</strong> Usuário ou senha inválidos.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <div class="text-center mt-3">
                <a href="login.php" class="btn btn-primary">Voltar para o login</a>
            </div>
            <?php
        }
    } else {
        ?>
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
            <strong>Atenção!</strong> Digite seu e-mail e senha.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <div class="text-center mt-3">
            <a href="login.php" class="btn btn-primary">Voltar para o login</a>
        </div>
        <script>
            // Redirecionar após 2 segundos
            setTimeout(function() {
                window.location.href = 'login.php';
            }, 2000);
        </script>
        <?php
    }
} catch(PDOException $e) {
    ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong>Erro:</strong> <?php echo $e->getMessage(); ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    <div class="text-center mt-3">
        <a href="login.php" class="btn btn-primary">Voltar para o login</a>
    </div>
    <?php
}
require_once("includes/rodape.php");
?>
