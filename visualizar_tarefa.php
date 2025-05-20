<?php
session_start();
require_once("includes/topo.php");

if(isset($_SESSION['idUsuario'])){
    require_once("banco/conexao.php");
    try{
        if(isset($_GET['id'])){
            $id = $_GET['id'];
            $idUsuario = $_SESSION['idUsuario'];
            
            // Buscar a tarefa
            $select = $conn->prepare("SELECT t.id, t.descricao, 
                                     DATE_FORMAT(t.dataHoraCriacao, '%d/%m/%Y %H:%i:%s') as dataHoraCriacao,
                                     c.descricao as categoria
                                     FROM tarefa t
                                     LEFT JOIN categoria c ON t.fk_Categoria_id = c.id
                                     WHERE t.id = :id AND t.dataHoraTermino IS NULL
                                     AND t.id NOT IN (
                                         SELECT fk_Tarefa_id FROM tarefa_usuario WHERE fk_Usuario_id = :idUsuario
                                     )");
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
                                                <th width="30%">ID</th>
                                                <td><?php echo $tarefa['id']; ?></td>
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
                                        </table>
                                    </div>
                                </div>
                                
                                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                    <a href="selecionar_tarefa.php?id=<?php echo $tarefa['id']; ?>" class="btn btn-success me-md-2">
                                        <i class="material-icons align-middle">add_task</i> Selecionar Tarefa
                                    </a>
                                    <a href="tarefas_disponiveis.php" class="btn btn-secondary">
                                        <i class="material-icons align-middle">arrow_back</i> Voltar
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
            } else {
                echo "<div class='alert alert-warning'>Tarefa não encontrada, já concluída ou você já selecionou esta tarefa. <a href='tarefas_disponiveis.php' class='alert-link'>Voltar para tarefas disponíveis</a></div>";
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
