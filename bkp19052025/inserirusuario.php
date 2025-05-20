<?php 
require_once("includes/topo.php"); 
session_start();
if(isset($_SESSION['tipoUsuario']) && $_SESSION['tipoUsuario']=="Administrador"){
    try {
        if(isset($_POST['nome']) && isset($_POST['email'])
         && isset($_POST['senha'])){
            //validações ????
            $nomeUsuario=$_POST['nome'];
            $emailUsuario=$_POST['email'];
            $senhaUsuario=$_POST['senha'];

            require_once("banco/conexao.php");
            $sql = "insert into tbusuarios (nome,email,senha)
            values('".$nomeUsuario."','".$emailUsuario."','".
            $senhaUsuario."')";
        // echo $sql;
            $conn->exec($sql);
            //echo "<p style='color:blue;'>Usuário Salvo com Sucesso!</p>";
            //header("location:listausuarios.php");
            echo "<script>window.alert('Usuário Salvo com Sucesso!')
            window.location.href='listausuarios.php'</script>";
            echo "<a href='listausuarios.php'>Voltar para a Listagem</a>";
            exit;
        } else {
            echo "<p>Você deve preencher os campos, clique 
            <a href='cadastrousuario.php'>aqui</a> para voltar.</p>";
        }
    } catch(PDOException $e) {
        echo "<h2 style='color:red;'>Erro: " . $e->getMessage() . 
        "</h2>";
    }
    $conn=null;
    }
    else {
        echo "<h2 style='color:red;'>Você não tem permissão para acessar este conteúdo.</h2>";
    } 
    require_once("includes/rodape.php"); 
    ?>