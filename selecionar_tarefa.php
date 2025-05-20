<?php
session_start();
require_once("includes/topo.php");

if(isset($_SESSION['idUsuario'])){
    require_once("banco/conexao.php");
    try{
        if(isset($_GET['id'])){
            $idTarefa = $_GET['id'];
            $idUsuario = $_SESSION['idUsuario'];
            
            // Verificar se a tarefa existe e não está concluída
            $checkTarefa = $conn->prepare("SELECT t.id, t.descricao, 
                                          DATE_FORMAT(t.dataHoraCriacao, '%d/%m/%Y %H:%i:%s') as dataHoraCriacao,
                                          c.descricao as categoria
                                          FROM tarefa t
                                          LEFT JOIN categoria c ON t.fk_Categoria_id = c.id
                                          WHERE t.id = :id AND t.dataHoraTermino IS NULL");
            $checkTarefa->bindParam(":id", $idTarefa, PDO::PARAM_INT);
            $checkTarefa->execute();
            
            // Verificar se o usuário já selecionou esta tarefa
            $checkSelecao = $conn->prepare("SELECT id FROM tarefa_usuario 
                                           WHERE fk_Tarefa_id = :idTarefa 
                                           AND fk_Usuario_id = :idUsuario");
            $checkSelecao->bindParam(":idTarefa", $idTarefa, PDO::PARAM_INT);
            $checkSelecao->bindParam(":idUsuario", $idUsuario, PDO::PARAM_INT);
            $checkSelecao->execute();
            
            if($checkTarefa->rowCount() > 0 && $checkSelecao->rowCount() == 0) {
                $tarefa = $checkTarefa->fetch(PDO::FETCH_ASSOC);
                
                // Se o formulário foi enviado
                if(isset($_POST['confirmar']) && $_POST['confirmar'] == '1') {
                    $observacao = isset($_POST['observacao']) ? $_POST['observacao'] : '';
                    $dataSelecao = date('Y-m-d H:i:s');
                    
                    // Inserir na tabela de associação
                    $stmt = $conn->prepare("INSERT INTO tarefa_usuario (fk_Tarefa_id, fk_Usuario_id, dataSelecao, status, observacao) 
                                           VALUES (:idTarefa, :idUsuario, :dataSelecao, 'Em andamento', :observacao)");
                    $stmt->bindParam(":idTarefa", $idTarefa, PDO::PARAM_INT);
                    $stmt->bindParam(":idUsuario", $idUsuario, PDO::PARAM_INT);
                    $stmt->bindParam(":dataSelecao", $dataSelecao, PDO::PARAM_STR);
                    $stmt->bindParam(":observacao", $observacao, PDO::PARAM_STR);
                    $stmt->execute();
                    
                    if($stmt->rowCount() > 0) {
                        ?>
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <strong>Sucesso!</strong> Tarefa selecionada com sucesso.
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                        <div class="text-center mt-3">
                            <a href="minhas_tarefas.php" class="btn btn-primary">Ver minhas tarefas</a>
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
                            <strong>Atenção!</strong> Erro ao selecionar a tarefa.
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                        <div class="text-center mt-3">
                            <a href="tarefas_disponiveis.php" class="btn btn-primary">Voltar para tarefas disponíveis</a>
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
                                    <h4 class="mb-0">Selecionar Tarefa</h4>
                                </div>
                                <div class="card-body">
                                    <h5>Detalhes da Tarefa</h5>
                                    <div class="mb-3">
                                        <p><strong>ID:</strong> <?php echo $tarefa['id']; ?></p>
                                        <p><strong>Descrição:</strong> <?php echo htmlspecialchars($tarefa['descricao']); ?></p>
                                        <p><strong>Categoria:</strong> <?php echo htmlspecialchars($tarefa['categoria']); ?></p>
                                        <p><strong>Data de Criação:</strong> <?php echo $tarefa['dataHoraCriacao']; ?></p>
                                    </div>
                                    
                                    <form action="selecionar_tarefa.php?id=<?php echo $idTarefa; ?>" method="post" class="needs-validation" novalidate>
                                        <input type="hidden" name="confirmar" value="1">
                                        
                                        <div class="mb-3">
                                            <label for="observacao" class="form-label">Observações (opcional):</label>
                                            <textarea name="observacao" id="observacao" class="form-control" rows="3" placeholder="Adicione observações sobre esta tarefa"></textarea>
                                        </div>
                                        
                                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                            <button type="submit" class="btn btn-success me-md-2">Confirmar Seleção</button>
                                            <a href="tarefas_disponiveis.php" class="btn btn-secondary">Cancelar</a>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                }
            } else {
                if($checkSelecao->rowCount() > 0) {
                    echo "<div class='alert alert-warning'>Você já selecionou esta tarefa. <a href='minhas_tarefas.php' class='alert-link'>Ver minhas tarefas</a></div>";
                } else {
                    echo "<div class='alert alert-warning'>Tarefa não encontrada ou já concluída. <a href='tarefas_disponiveis.php' class='alert-link'>Voltar para tarefas disponíveis</a></div>";
                }
            }
        } else {
            echo "<div class='alert alert-warning'>Selecione uma tarefa. <a href='tarefas_disponiveis.php' class='alert-link'>Voltar para tarefas disponíveis</a></div>";
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
