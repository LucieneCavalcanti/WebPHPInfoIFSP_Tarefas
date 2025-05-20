<?php
require_once("includes/topo.php");
session_start();
if(isset($_SESSION['tipoUsuario']) && $_SESSION['tipoUsuario']=="Administrador"){
    require_once("banco/conexao.php");
    try{
        if(isset($_GET['id'])){
            $id = $_GET['id'];
            // $sql = "delete from tbusuarios where id=".$id;
            // $conn->exec($sql);
            $stmt = $conn->prepare("delete from tbusuarios where id = :id");
            // Define o parâmetro
            $stmt->bindParam(":id", $id, PDO::PARAM_INT);
            // Executa a instrução
            $stmt->execute();
            // Obtém o número de linhas afetadas
            $linhas_deletadas = $stmt->rowCount();
            if($linhas_deletadas==1)
                //echo "<p style='color:blue;'>Usuário excluído com Sucesso!</p>";
                echo "<script>window.alert('Usuário excluído com Sucesso!')
                window.location.href='listausuarios.php'</script>";
            else
                echo "<p style='color:red;'>Erro ao excluir!</p>";
            //echo "você quer excluir o id " . $id ;
        }else{
            echo "<p>Você precisa selecionar um registro, volte 
            para a página da <a href='index.php'>listagem</a></p>";
        }
    }catch(Exception $erro){
        echo "<p style='color:red;'>Ocorreu um erro:". 
        $erro->getMessage() . "</p>";
    }

}
else {
    echo "<h2 style='color:red;'>Você não tem permissão para acessar este conteúdo.</h2>";
} 
require_once("includes/rodape.php"); 
?>