<?php require_once("includes/topo.php"); ?>
<?php
    session_start();
    if(isset($_SESSION['tipoUsuario']) && $_SESSION['tipoUsuario']=="Administrador"){
    require_once("banco/conexao.php");

    try {
        $sql = "select id
                , nome
                , email 
                , DATE_FORMAT(datacadastro, '%d/%m/%Y %H:%i:%s') as datacadastro
            from tbusuarios
            order by datacadastro desc;
        ";

        $select = $conn->prepare($sql);
        $select->execute();

        $usuarios = $select->fetchAll(PDO::FETCH_ASSOC);
        $titulo = "Projeto - CRUD";
    } catch(PDOException $e) {
        echo "<h2 style='color:red;'>Erro: " . $e->getMessage() . "</h2>";
    }
?>



    <div class="container">
        <h2>
            <?php echo $titulo; ?>
        </h2>

        <p>
            Faça seu cadastro, clique 
            <a href="cadastrousuario.php">
                aqui
            </a>
        </p>

        <h2>Tabela Feita com FOR</h2>
        <!-- TABELA FOR -->
        <table class="table table-striped table-bordered">
            <!-- CABEÇALHO -->
            <thead class="text-center">
                <tr>
                    <th class="w-10">ID Usuário</th>
                    <th class="w-50">Nome Usuário</th>
                    <th>E-mail Usuário</th>
                    <th>Data Cadastro Usuário</th>
                    <th>Ações</th>
                </tr>
            </thead>

            <!-- CORPO DA TABELA -->
            <tbody class="text-left">
                <?php for ($i=0; $i < count($usuarios); $i++) { ?>
                    <tr>
                        <td><?php echo $usuarios[$i]['id']; ?></td>
                        <td><?php echo $usuarios[$i]['nome']; ?></td>
                        <td><?php echo $usuarios[$i]['email']; ?></td>
                        <td><?php echo $usuarios[$i]['datacadastro']; ?></td>
                        <td>
                            <a href="editarusuario.php?id=<?php echo $usuarios[$i]['id']; ?>">
                            <i class="material-icons">edit</i></a>
                            <a href="excluirusuario.php?id=<?php echo $usuarios[$i]['id']; ?>">
                            <i class="material-icons">delete</i></a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

<?php }
else {
    echo "<h2 style='color:red;'>Você não tem permissão para acessar este conteúdo.</h2>";
} 
require_once("includes/rodape.php"); 
?>