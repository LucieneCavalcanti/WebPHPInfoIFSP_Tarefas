<?php
session_start();
require_once("includes/topo.php");

if(isset($_SESSION['idUsuario'])){
    require_once("banco/conexao.php");
    try{
        if(isset($_GET['id'])){
            $id = $_GET['id'];
            $idUsuario = $_SESSION['idUsuario'];
            
            // Buscar a tarefa do usuário
            $select = $conn->prepare("SELECT tu.id, t.id as tarefa_id, t.descricao, 
                                     c.descricao as categoria, tu.status, tu.observacao
                                     FROM tarefa_usuario tu
                                     JOIN tarefa t ON tu.fk_Tarefa_id = t.id
                                     LEFT JOIN categoria c ON t.fk_Categoria_id = c.id
                                     WHERE tu.id = :id AND tu.fk_Usuario_id = :idUsuario
                                     AND tu.status = 'Em andamento'");
            $select->bindParam(":id", $id, PDO::PARAM_INT);
            $select->bindParam(":idUsuario", $idUsuario, PDO::PARAM_INT);
            $select->execute();
            
            if($select->rowCount() > 0) {
                $tarefa = $select->fetch(PDO::FETCH_ASSOC);
                
                // Se o formulário foi enviado
                if(isset($_POST['observacao'])) {
                    $observacao = $_POST['observacao'];
                    
                    // Atualizar observação
                    $stmt = $conn->prepare("UPDATE tarefa_usuario SET observacao = :observacao WHERE id = :id");
                    $stmt->bindParam(":observacao", $observacao, PDO::PARAM_STR);
                    $stmt->bindParam(":id", $id, PDO::PARAM_INT);
                    $stmt->execute();
                    
                    if($stmt->rowCount() > 0) {
                        ?>
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <strong>Sucesso!</strong> Observações atualizadas com sucesso.
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                        <div class="text-center mt-3">
                            <a href="minhas_tarefas.php" class="btn btn-primary">Voltar para minhas tarefas</a>
                        </div>
                        <script>
                            // Redirecionar após 2 segundos
                            setTimeout(function() {
                                window.location.href = 'minhas_tarefas.php';
                            }, 2000);
                        </script>
                        <?php
                    } else {
                        ?>
                        <div class="alert alert-warning alert-dismissible fade show" role="alert">
                            <strong>Atenção!</strong> Nenhuma alteração foi realizada.
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                        <div class="text-center mt-3">
                            <a href="minhas_tarefas.php" class="btn btn-primary">Voltar para minhas tarefas</a>
                        </div>
                        <?php
                    }
                } else {
                    // Exibir formulário de edição
                    ?>
                    <div class="row">
                        <div class="col-md-8 offset-md-2">
                            <div class="card">
                                <div class="card-header bg-primary text-white">
                                    <h4 class="mb-0">Editar Observações da Tarefa</h4>
                                </div>
                                <div class="card-body">
                                    <div class="mb-3">
                                        <h5>Informações da Tarefa</h5>
                                        <p><strong>ID:</strong> <?php echo $tarefa['tarefa_id']; ?></p>
                                        <p><strong>Descrição:</strong> <?php echo htmlspecialchars($tarefa['descricao']); ?></p>
                                        <p><strong>Categoria:</strong> <?php echo htmlspecialchars($tarefa['categoria']); ?></p>
                                    </div>
                                    
                                    <form action="editar_minha_tarefa.php?id=<?php echo $id; ?>" method="post" class="needs-validation" novalidate>
                                        <div class="mb-3">
                                            <label for="observacao" class="form-label">Observações:</label>
                                            <textarea name="observacao" id="observacao" class="form-control" rows="5" placeholder="Adicione suas observações sobre esta tarefa"><?php echo htmlspecialchars($tarefa['observacao']); ?></textarea>
                                        </div>
                                        
                                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                            <button type="submit" class="btn btn-primary me-md-2">Salvar Alterações</button>
                                            <a href="minhas_tarefas.php" class="btn btn-secondary">Cancelar</a>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                }
            } else {
                echo "<div class='alert alert-warning'>Tarefa não encontrada, já concluída/cancelada ou você não tem permissão para editá-la. <a href='minhas_tarefas.php' class='alert-link'>Voltar para minhas tarefas</a></div>";
            }
        } else {
            echo "<div class='alert alert-warning'>Selecione uma tarefa. <a href='minhas_tarefas.php' class='alert-link'>Voltar para minhas tarefas</a></div>";
        }
    } catch(PDOException $e) {
        echo "<div class='alert alert-danger'>Erro: " . $e->getMessage() . "</div>";
    }
} else {
    echo "<div class='alert alert-danger'>Você precisa estar logado para acessar este conteúdo.</div>";
    echo "<div class='text-center mt-3'><a href='login.php' class='btn btn-primary'>Ir para o login</a></div>";
} 
require_once("includes/rodape.php"); 
?>
