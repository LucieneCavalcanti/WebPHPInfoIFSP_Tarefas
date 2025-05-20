<?php
require_once("includes/topo.php");
session_start();

if($_SESSION['tipoUsuario']=="Comum"){
    echo "<p style='color:blue;'>Seja bem vindo(a) " . 
    $_SESSION['nomeUsuario'] . "</p>"; //mostrando na tela o nome do usuário
    echo "<p>Seu nível de usuário é Comum.</p>";
    echo "<p><a href='perfil.php'>Perfil</a></p>";
    echo "<p><a href='sair.php'>Sair</a></p>";
}
if($_SESSION['tipoUsuario']=="Administrador"){
    echo "<p style='color:pink;'>Seja bem vindo(a) " .
        $_SESSION['nomeUsuario'] . "</p>"; //mostrando na tela o nome do usuário
    echo "<p><a href='perfil.php'>Perfil</a></p>";
    echo "<p><a href='listausuarios.php'>Usuários</a></p>";
    echo "<p><a href='listaprodutos.php'>Produtos</a></p>";
    echo "<p><a href='listacategorias.php'>Categorias</a></p>";
    echo "<p><a href='listatarefas.php'>Tarefas</a></p>";
    echo "<p><a href='sair.php'>Sair</a></p>";
}

    require_once "includes/rodape.php";
?>
