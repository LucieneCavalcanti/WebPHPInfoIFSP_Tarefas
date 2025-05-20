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
                                     DATE_FORMAT(t.dataHoraCriacao, '%d/%m/%Y %H:%i:%s') as dataHoraCriacao,
                                     DATE_FORMAT(t.dataHoraTermino, '%d/%m/%Y %H:%i:%s') as dataHoraTermino,
                                     DATE_FORMAT(tu.dataSelecao, '%d/%m/%Y %H:%i:%s') as dataSelecao,
                                     c.descricao as categoria, tu.status, tu.observacao
                                     FROM tarefa_usuario tu
                                     JOIN tarefa t ON tu.fk_Tarefa_id = t.id
                                     LEFT JOIN categoria c ON t.fk_Categoria_id = c.id
                                     WHERE tu.id = :id AND tu.fk_Usuario_id = :idUsuario");
            $select->bindParam(":id", $id, PDO::PARAM_INT);
            $select->bindParam(":idUsuario", $idUsuario, PDO::PARAM_INT);
            $select->execute();
            
            if($select->rowCount() > 0) {
                $tarefa = $select->fetch(PDO::FETCH_ASSOC);
                ?>
                <div class="row">
                    <div class="col-md-8 offset-md-2">
                        <div class="card">
                            <div class="card-header bg-primary text-white">
                                <h4 class="mb-0">Detalhes da Tarefa</h4>
                            </div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <h5>Informações da Tarefa</h5>
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <tr>
                                                <th width="30%">ID da Tarefa</th>
                                                <td><?php echo $tarefa['tarefa_id']; ?></td>
                                            </tr>
                                            <tr>
                                                <th>Descrição</th>
                                                <td><?php echo htmlspecialchars($tarefa['descricao']); ?></td>
                                            </tr>
                                            <tr>
                                                <th>Categoria</th>
                                                <td><?php echo htmlspecialchars($tarefa['categoria']); ?></td>
                                            </tr>
                                            <tr>
                                                <th>Data de Criação</th>
                                                <td><?php echo $tarefa['dataHoraCriacao']; ?></td>
                                            </tr>
                                            <tr>
                                                <th>Data de Término</th>
                                                <td><?php echo $tarefa['dataHoraTermino'] ? $tarefa['dataHoraTermino'] : 'Não concluída'; ?></td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                                
                                <div class="mb-3">
                                    <h5>Sua Atribuição</h5>
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <tr>
                                                <th width="30%">Data de Seleção</th>
                                                <td><?php echo $tarefa['dataSelecao']; ?></td>
                                            </tr>
                                            <tr>
                                                <th>Status</th>
                                                <td>
                                                    <?php 
                                                    $statusClass = '';
                                                    switch($tarefa['status']) {
                                                        case 'Em andamento':
                                                            $statusClass = 'bg-warning text-dark';
                                                            break;
                                                        case 'Concluída':
                                                            $statusClass = 'bg-success text-white';
                                                            break;
                                                        case 'Cancelada':
                                                            $statusClass = 'bg-danger text-white';
                                                            break;
                                                    }
                                                    ?>
                                                    <span class="badge <?php echo $statusClass; ?>"><?php echo $tarefa['status']; ?></span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>Observações</th>
                                                <td><?php echo htmlspecialchars($tarefa['observacao'] ? $tarefa['observacao'] : 'Nenhuma observação'); ?></td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                                
                                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                    <?php if($tarefa['status'] == 'Em andamento'): ?>
                                        <a href="editar_minha_tarefa.php?id=<?php echo $tarefa['id']; ?>" class="btn btn-warning me-md-2">
                                            <i class="material-icons align-middle">edit</i> Editar
                                        </a>
                                        <a href="concluir_minha_tarefa.php?id=<?php echo $tarefa['id']; ?>" class="btn btn-success me-md-2">
                                            <i class="material-icons align-middle">check</i> Concluir
                                        </a>
                                        <a href="cancelar_tarefa.php?id=<?php echo $tarefa['id']; ?>" class="btn btn-danger me-md-2">
                                            <i class="material-icons align-middle">cancel</i> Cancelar
                                        </a>
                                    <?php endif; ?>
                                    <a href="minhas_tarefas.php" class="btn btn-secondary">
                                        <i class="material-icons align-middle">arrow_back</i> Voltar
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
            } else {
                echo "<div class='alert alert-warning'>Tarefa não encontrada ou você não tem permissão para visualizá-la. <a href='minhas_tarefas.php' class='alert-link'>Voltar para minhas tarefas</a></div>";
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
