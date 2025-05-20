<?php 
require_once("includes/topo.php");
session_start();
if(isset($_SESSION['idUsuario'])){
    try {
        if(isset($_POST['nome']) && isset($_POST['email'])
         && isset($_POST['senha'])){
            //validações ????
            $nomeUsuario=$_POST['nome'];
            $emailUsuario=$_POST['email'];
            $senhaUsuario=$_POST['senha'];
            $idUsuario=$_SESSION['idUsuario'];

            require_once("banco/conexao.php");
            $sql = "update tbusuarios set nome=:nome,email=:email,
            senha=:senha where id=:id";

            $stmt = $conn->prepare($sql);
            // Define o parâmetro
            $stmt->bindParam(":nome", $nomeUsuario, PDO::PARAM_STR);
            $stmt->bindParam(":email", $emailUsuario, PDO::PARAM_STR);
            $stmt->bindParam(":senha", $senhaUsuario, PDO::PARAM_STR);
            $stmt->bindParam(":id", $idUsuario, PDO::PARAM_INT);
            // Executa a instrução
            $stmt->execute();
            // Obtém o número de linhas afetadas
            $linhas_atualizadas = $stmt->rowCount();
            if($linhas_atualizadas==1)
                //echo "<p style='color:blue;'>Usuário excluído com Sucesso!</p>";
                echo "<script>window.alert('Usuário atualizado com Sucesso!')
                window.location.href='indexlogado.php'</script>";
            else
                echo "<p style='color:red;'>Erro ao atualizar!</p>";
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