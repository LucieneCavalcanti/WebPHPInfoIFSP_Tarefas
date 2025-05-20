<?php
    require_once("banco/conexao.php");
    require_once("includes/topo.php");
    try{
        if(isset($_POST['email']) && isset($_POST['senha'])){
            $email = $_POST['email']; //pega o email
            $senha = $_POST['senha'];
            $select = $conn->prepare("select * from tbusuarios where email=:email
            and senha=:senha");
            // Define o parâmetro
            $select->bindParam(":email", $email, PDO::PARAM_STR);
            $select->bindParam(":senha", $senha, PDO::PARAM_STR);
            $select->execute();

            $usuarios = $select->fetchAll(PDO::FETCH_ASSOC); //pegar o registro
            if(count($usuarios)==1) { //encontrou o usuario 
                //echo $usuarios[0]['id']; //mostrando na tela o id do usuário
                //logica do login
                if($usuarios[0]['status']==1)
                    echo "<p>Seu login está inativo, entre em contato com o administrador.</p>";
                if($usuarios[0]['status']==2){
                    session_start();
                    $_SESSION['idUsuario']= $usuarios[0]['id'];
                    $_SESSION['nomeUsuario']= $usuarios[0]['nome'];
                    $_SESSION['tipoUsuario'] = $usuarios[0]['tipo'];
                    //usuário ativo
                    header('location:indexlogado.php');
                }
            }else {
                echo "<h2>Usuário ou senha inválidos!</h2>";
                echo "<p>Faça <a href='login.php'>login</a> novamente.";
            }
        }else{
            echo "<script>window.alert('Digite seu e-mail e senha!')
                window.location.href='login.php'</script>";
        }
    } catch(PDOException $e) {
        echo "<h2 style='color:red;'>Erro: " . $e->getMessage() . "</h2>";
    }
?>



<?php require_once("includes/rodape.php"); ?>