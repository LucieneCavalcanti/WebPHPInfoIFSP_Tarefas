<?php
require_once("includes/topo.php");
session_start();
if(isset($_SESSION['tipoUsuario']) && $_SESSION['tipoUsuario']=="Administrador"){
    require_once("banco/conexao.php");
    try{
        if(isset($_GET['id'])){//enviou o id ??
            $id = $_GET['id']; //pega o id
            $select = $conn->prepare("select * from tbusuarios where id=:id");
            // Define o parâmetro
            $select->bindParam(":id", $id, PDO::PARAM_INT);
            $select->execute();

            $usuarios = $select->fetchAll(PDO::FETCH_ASSOC); //pegar o registro
            if(count($usuarios)==1) { //encontrou o usuario com id = :id
                echo $usuarios[0]['id']; //mostrando na tela o id do usuário
                echo $usuarios[0]['nome']; //mostrando na tela o nome do usuário
                //mostrar o formulário preenchido
                ?>
                <h2>Cadastro de Usuários</h2>
                    <form name="cadastro" action="atualizarusuario.php"
                    method="post">
                        <label><?php echo  $usuarios[0]['id']; ?></label><br>
                        <input type="hidden" name="id" 
                        value="<?php echo  $usuarios[0]['id']; ?>">

                        <label for="nome">Digite seu nome:</label>
                        <input type="text" name="nome" id="nome" 
                        value="<?php echo  $usuarios[0]['nome']; ?>"
                        placeholder="Digite seu nome aqui" maxlength="200"
                        required><span id="vnome">*</span>
                        <br>
                        <label for="email">Digite seu email:</label>
                        <input type="email" name="email" id="email" 
                        value="<?php echo  $usuarios[0]['email']; ?>"
                        placeholder="Digite seu email aqui" maxlength="200"
                        required><span id="vemail">*</span>
                        <br>
                        <label for="senha">Digite sua senha:</label>
                        <input type="password" name="senha" id="senha" 
                        value="<?php echo  $usuarios[0]['senha']; ?>"
                        placeholder="Digite sua senha aqui" maxlength="20"
                        required><span id="vsenha">*</span>
                        <br>
                        <input type="submit" value="Atualizar">
                        <input type="reset" value="Limpar">
                    </form>
                
                <?php
            }else {
                echo "<script>window.alert('Selecione um registro!')
                window.location.href='listausuarios.php'</script>";
            }
        }else{
            echo "<script>window.alert('Selecione um registro!')
                window.location.href='listausuarios.php'</script>";
        }
    } catch(PDOException $e) {
        echo "<h2 style='color:red;'>Erro: " . $e->getMessage() . "</h2>";
    }
}
else {
    echo "<h2 style='color:red;'>Você não tem permissão para acessar este conteúdo.</h2>";
} 
require_once("includes/rodape.php"); 
?>