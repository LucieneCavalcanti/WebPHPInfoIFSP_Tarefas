<?php
require_once "includes/topo.php";
?>
<form name="formcadastro" action="validarlogin.php" method="post">
    <label for="usuario">Usuário</label>
    <input type="email" name="email" id="email" 
    placeholder="Digite seu e-mail" value="" maxlength="200" size="50" required><br>
    
    <label for="senha">Senha</label>
    <input type="password" name="senha" id="senha" 
    placeholder="Digite a senha" value="" maxlength="20" size="22" required><br>
    <input type="submit" value="Acessar">
    <input type="reset" value="Limpar">
    </form>
    <p>Você é novo por aqui? <br>
    Clique <a href="">aqui</a> e cadastre-se.</p>
<?php
require_once "includes/rodape.php";
?>