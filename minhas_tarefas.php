<?php 
session_start();
require_once("includes/topo.php"); 

if(isset($_SESSION['idUsuario'])){
    require_once("banco/conexao.php");

    try {
        $idUsuario = $_SESSION['idUsuario'];
        
        // Configuração da paginação
        $registrosPorPagina = 5;
        $paginaAtual = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
        $offset = ($paginaAtual - 1) * $registrosPorPagina;
        
        // Configuração da busca
        $termoBusca = isset($_GET['busca']) ? $_GET['busca'] : '';
        $condicaoBusca = '';
        
        if (!empty($termoBusca)) {
            $condicaoBusca = " AND (t.descricao LIKE :termo OR c.descricao LIKE :termo) ";
        }
        
        // Filtro de status
        $statusFiltro = isset($_GET['status']) ? $_GET['status'] : '';
        $condicaoStatus = '';
        
        if (!empty($statusFiltro)) {
            $condicaoStatus = " AND tu.status = :status ";
        }
        
        // Consulta para contar o total de registros
        $sqlCount = "SELECT COUNT(*) as total 
                     FROM tarefa_usuario tu
                     JOIN tarefa t ON tu.fk_Tarefa_id = t.id
                     LEFT JOIN categoria c ON t.fk_Categoria_id = c.id
                     WHERE tu.fk_Usuario_id = :idUsuario" . $condicaoBusca . $condicaoStatus;
        
        $stmtCount = $conn->prepare($sqlCount);
        $stmtCount->bindParam(':idUsuario', $idUsuario, PDO::PARAM_INT);
        
        if (!empty($termoBusca)) {
            $termoParam = '%' . $termoBusca . '%';
            $stmtCount->bindParam(':termo', $termoParam, PDO::PARAM_STR);
        }
        
        if (!empty($statusFiltro)) {
            $stmtCount->bindParam(':status', $statusFiltro, PDO::PARAM_STR);
        }
        
        $stmtCount->execute();
        $totalRegistros = $stmtCount->fetch(PDO::FETCH_ASSOC)['total'];
        $totalPaginas = ceil($totalRegistros / $registrosPorPagina);
        
        // Consulta para buscar os registros da página atual
        $sql = "SELECT tu.id, t.id as tarefa_id, t.descricao, 
                DATE_FORMAT(t.dataHoraCriacao, '%d/%m/%Y %H:%i:%s') as dataHoraCriacao,
                DATE_FORMAT(t.dataHoraTermino, '%d/%m/%Y %H:%i:%s') as dataHoraTermino,
                DATE_FORMAT(tu.dataSelecao, '%d/%m/%Y %H:%i:%s') as dataSelecao,
                c.descricao as categoria, tu.status, tu.observacao
                FROM tarefa_usuario tu
                JOIN tarefa t ON tu.fk_Tarefa_id = t.id
                LEFT JOIN categoria c ON t.fk_Categoria_id = c.id
                WHERE tu.fk_Usuario_id = :idUsuario" . 
                $condicaoBusca . $condicaoStatus . "
                ORDER BY 
                    CASE 
                        WHEN tu.status = 'Em andamento' THEN 1
                        WHEN tu.status = 'Concluída' THEN 2
                        WHEN tu.status = 'Cancelada' THEN 3
                    END,
                    tu.dataSelecao DESC
                LIMIT :offset, :limit";
        
        $select = $conn->prepare($sql);
        $select->bindParam(':idUsuario', $idUsuario, PDO::PARAM_INT);
        
        if (!empty($termoBusca)) {
            $termoParam = '%' . $termoBusca . '%';
            $select->bindParam(':termo', $termoParam, PDO::PARAM_STR);
        }
        
        if (!empty($statusFiltro)) {
            $select->bindParam(':status', $statusFiltro, PDO::PARAM_STR);
        }
        
        $select->bindParam(':offset', $offset, PDO::PARAM_INT);
        $select->bindParam(':limit', $registrosPorPagina, PDO::PARAM_INT);
        $select->execute();
        
        $tarefas = $select->fetchAll(PDO::FETCH_ASSOC);
        $titulo = "Minhas Tarefas";
    } catch(PDOException $e) {
        echo "<div class='alert alert-danger'>Erro: " . $e->getMessage() . "</div>";
    }
?>

<div class="row">
    <div class="col-md-12">
        <h2 class="page-header"><?php echo $titulo; ?></h2>
        
        <div class="row search-container">
            <div class="col-md-6">
                <form method="GET" action="minhas_tarefas.php" class="d-flex">
                    <input type="text" name="busca" class="form-control me-2" placeholder="Buscar por descrição ou categoria" value="<?php echo htmlspecialchars($termoBusca); ?>">
                    <select name="status" class="form-select me-2" style="width: 150px;">
                        <option value="">Todos</option>
                        <option value="Em andamento" <?php echo $statusFiltro == 'Em andamento' ? 'selected' : ''; ?>>Em andamento</option>
                        <option value="Concluída" <?php echo $statusFiltro == 'Concluída' ? 'selected' : ''; ?>>Concluída</option>
                        <option value="Cancelada" <?php echo $statusFiltro == 'Cancelada' ? 'selected' : ''; ?>>Cancelada</option>
                    </select>
                    <button type="submit" class="btn btn-primary">Filtrar</button>
                </form>
            </div>
            <div class="col-md-6 text-end">
                <a href="tarefas_disponiveis.php" class="btn btn-success">
                    <i class="material-icons align-middle">add_task</i> Selecionar Novas Tarefas
                </a>
            </div>
        </div>

        <?php if (count($tarefas) > 0): ?>
            <div class="table-responsive">
                <table class="table table-striped table-hover table-bordered">
                    <thead class="table-primary">
                        <tr>
                            <th width="5%">ID</th>
                            <th width="30%">Descrição</th>
                            <th width="10%">Categoria</th>
                            <th width="15%">Data Seleção</th>
                            <th width="10%">Status</th>
                            <th width="30%">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($tarefas as $tarefa): ?>
                            <tr>
                                <td><?php echo $tarefa['tarefa_id']; ?></td>
                                <td><?php echo htmlspecialchars($tarefa['descricao']); ?></td>
                                <td><?php echo htmlspecialchars($tarefa['categoria']); ?></td>
                                <td><?php echo $tarefa['dataSelecao']; ?></td>
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
                                <td class="action-icons text-center">
                                    <a href="visualizar_minha_tarefa.php?id=<?php echo $tarefa['id']; ?>" class="btn btn-sm btn-info">
                                        <i class="material-icons">visibility</i>
                                    </a>
                                    
                                    <?php if($tarefa['status'] == 'Em andamento'): ?>
                                        <a href="editar_minha_tarefa.php?id=<?php echo $tarefa['id']; ?>" class="btn btn-sm btn-warning">
                                            <i class="material-icons">edit</i>
                                        </a>
                                        <a href="concluir_minha_tarefa.php?id=<?php echo $tarefa['id']; ?>" class="btn btn-sm btn-success">
                                            <i class="material-icons">check</i>
                                        </a>
                                        <a href="cancelar_tarefa.php?id=<?php echo $tarefa['id']; ?>" class="btn btn-sm btn-danger">
                                            <i class="material-icons">cancel</i>
                                        </a>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            
            <!-- Paginação -->
            <nav aria-label="Navegação de página">
                <ul class="pagination justify-content-center">
                    <?php if ($paginaAtual > 1): ?>
                        <li class="page-item">
                            <a class="page-link" href="?pagina=<?php echo $paginaAtual - 1; ?><?php echo !empty($termoBusca) ? '&busca=' . urlencode($termoBusca) : ''; ?><?php echo !empty($statusFiltro) ? '&status=' . urlencode($statusFiltro) : ''; ?>">Anterior</a>
                        </li>
                    <?php else: ?>
                        <li class="page-item disabled">
                            <a class="page-link" href="#">Anterior</a>
                        </li>
                    <?php endif; ?>
                    
                    <?php for ($i = 1; $i <= $totalPaginas; $i++): ?>
                        <li class="page-item <?php echo $i == $paginaAtual ? 'active' : ''; ?>">
                            <a class="page-link" href="?pagina=<?php echo $i; ?><?php echo !empty($termoBusca) ? '&busca=' . urlencode($termoBusca) : ''; ?><?php echo !empty($statusFiltro) ? '&status=' . urlencode($statusFiltro) : ''; ?>"><?php echo $i; ?></a>
                        </li>
                    <?php endfor; ?>
                    
                    <?php if ($paginaAtual < $totalPaginas): ?>
                        <li class="page-item">
                            <a class="page-link" href="?pagina=<?php echo $paginaAtual + 1; ?><?php echo !empty($termoBusca) ? '&busca=' . urlencode($termoBusca) : ''; ?><?php echo !empty($statusFiltro) ? '&status=' . urlencode($statusFiltro) : ''; ?>">Próxima</a>
                        </li>
                    <?php else: ?>
                        <li class="page-item disabled">
                            <a class="page-link" href="#">Próxima</a>
                        </li>
                    <?php endif; ?>
                </ul>
            </nav>
        <?php else: ?>
            <div class="alert alert-info">
                Você não possui tarefas. <a href="tarefas_disponiveis.php" class="alert-link">Selecione tarefas disponíveis</a>.
            </div>
        <?php endif; ?>
    </div>
</div>

<?php 
} else {
    echo "<div class='alert alert-danger'>Você precisa estar logado para acessar este conteúdo.</div>";
    echo "<div class='text-center mt-3'><a href='login.php' class='btn btn-primary'>Ir para o login</a></div>";
} 
require_once("includes/rodape.php"); 
?>
