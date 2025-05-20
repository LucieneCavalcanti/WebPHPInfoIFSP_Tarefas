<?php
session_start();
require_once("includes/topo.php");

if(isset($_SESSION['idUsuario'])){
    require_once("banco/conexao.php");
    try{
        if(isset($_GET['id'])){
            $id = $_GET['id'];
            $idUsuario = $_SESSION['idUsuario'];
            
            // Verificar se a tarefa existe e pertence ao usuário
            $checkTarefa = $conn->prepare("SELECT tu.id, t.id as tarefa_id, t.descricao, tu.status
                                          FROM tarefa_usuario tu
                                          JOIN tarefa t ON tu.fk_Tarefa_id = t.id
                                          WHERE tu.id = :id AND tu.fk_Usuario_id = :idUsuario
                                          AND tu.status = 'Em andamento'");
            $checkTarefa->bindParam(":id", $id, PDO::PARAM_INT);
            $checkTarefa->bindParam(":idUsuario", $idUsuario, PDO::PARAM_INT);
            $checkTarefa->execute();
            
            if($checkTarefa->rowCount() > 0) {
                $tarefa = $checkTarefa->fetch(PDO::FETCH_ASSOC);
                
                // Se o formulário foi enviado
                if(isset($_POST['confirmar']) && $_POST['confirmar'] == '1') {
                    // Atualizar status da tarefa
                    $stmt = $conn->prepare("UPDATE tarefa_usuario SET status = 'Cancelada' WHERE id = :id");
                    $stmt->bindParam(":id", $id, PDO::PARAM_INT);
                    $stmt->execute();
                    
                    if($stmt->rowCount() > 0) {
                        ?>
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <strong>Sucesso!</strong> Tarefa cancelada com sucesso.
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
                            <strong>Atenção!</strong> Erro ao cancelar a tarefa.
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                        <div class="text-center mt-3">
                            <a href="minhas_tarefas.php" class="btn btn-primary">Voltar para minhas tarefas</a>
                        </div>
                        <?php
                    }
                } else {
                    // Exibir formulário de confirmação
                    ?>
                    <div class="row">
                        <div class="col-md-8 offset-md-2">
                            <div class="card">
                                <div class="card-header bg-primary text-white">
                                    <h4 class="mb-0">Cancelar Tarefa</h4>
                                </div>
                                <div class="card-body">
                                    <div class="alert alert-warning">
                                        <p><strong>Atenção!</strong> Você está prestes a cancelar a seguinte tarefa:</p>
                                        <p><strong>ID:</strong> <?php echo $tarefa['tarefa_id']; ?></p>
                                        <p><strong>Descrição:</strong> <?php echo htmlspecialchars($tarefa['descricao']); ?></p>
                                        <p>Esta ação não pode ser desfeita. A tarefa ficará disponível para outros usuários.</p>
                                    </div>
                                    
                                    <form action="cancelar_tarefa.php?id=<?php echo $id; ?>" method="post">
                                        <input type="hidden" name="confirmar" value="1">
                                        
                                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                            <button type="submit" class="btn btn-danger me-md-2">Confirmar Cancelamento</button>
                                            <a href="minhas_tarefas.php" class="btn btn-secondary">Voltar</a>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                }
            } else {
                echo "<div class='alert alert-warning'>Tarefa não encontrada, já concluída/cancelada ou você não tem permissão para cancelá-la. <a href='minhas_tarefas.php' class='alert-link'>Voltar para minhas tarefas</a></div>";
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
