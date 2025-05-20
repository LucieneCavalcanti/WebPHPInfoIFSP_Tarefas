<?php 
require_once("includes/topo.php"); 
session_start();
if(isset($_SESSION['tipoUsuario']) && $_SESSION['tipoUsuario']=="Administrador"){
?>
    <h2>Cadastro de Usuários</h2>
    <form name="cadastro" action="inserirusuario.php"
     method="post">
        <label for="nome">Digite seu nome:</label>
        <input type="text" name="nome" id="nome" value=""
        placeholder="Digite seu nome aqui" maxlength="200"
        required><span id="vnome">*</span>
        <br>
        <label for="email">Digite seu email:</label>
        <input type="email" name="email" id="email" value=""
        placeholder="Digite seu email aqui" maxlength="200"
        required><span id="vemail">*</span>
        <br>
        <label for="senha">Digite sua senha:</label>
        <input type="password" name="senha" id="senha" value=""
        placeholder="Digite sua senha aqui" maxlength="20"
        required><span id="vsenha">*</span>
        <br>
        <input type="submit" value="Cadastrar">
        <input type="reset" value="Limpar">
    </form>
    <?php     
    }
    else {
        echo "<h2 style='color:red;'>Você não tem permissão para acessar este conteúdo.</h2>";
    } 
    require_once("includes/rodape.php"); 
    ?>