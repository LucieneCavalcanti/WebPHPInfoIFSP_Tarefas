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
        
        // Consulta para contar o total de registros
        $sqlCount = "SELECT COUNT(*) as total 
                     FROM tarefa t
                     LEFT JOIN categoria c ON t.fk_Categoria_id = c.id
                     WHERE t.id NOT IN (
                         SELECT fk_Tarefa_id FROM tarefa_usuario WHERE fk_Usuario_id = :idUsuario
                     ) AND t.dataHoraTermino IS NULL" . $condicaoBusca;
        
        $stmtCount = $conn->prepare($sqlCount);
        $stmtCount->bindParam(':idUsuario', $idUsuario, PDO::PARAM_INT);
        
        if (!empty($termoBusca)) {
            $termoParam = '%' . $termoBusca . '%';
            $stmtCount->bindParam(':termo', $termoParam, PDO::PARAM_STR);
        }
        
        $stmtCount->execute();
        $totalRegistros = $stmtCount->fetch(PDO::FETCH_ASSOC)['total'];
        $totalPaginas = ceil($totalRegistros / $registrosPorPagina);
        
        // Consulta para buscar os registros da página atual
        $sql = "SELECT t.id, t.descricao, 
                DATE_FORMAT(t.dataHoraCriacao, '%d/%m/%Y %H:%i:%s') as dataHoraCriacao,
                c.descricao as categoria
                FROM tarefa t
                LEFT JOIN categoria c ON t.fk_Categoria_id = c.id
                WHERE t.id NOT IN (
                    SELECT fk_Tarefa_id FROM tarefa_usuario WHERE fk_Usuario_id = :idUsuario
                ) AND t.dataHoraTermino IS NULL" . 
                $condicaoBusca . "
                ORDER BY t.dataHoraCriacao DESC
                LIMIT :offset, :limit";
        
        $select = $conn->prepare($sql);
        $select->bindParam(':idUsuario', $idUsuario, PDO::PARAM_INT);
        
        if (!empty($termoBusca)) {
            $termoParam = '%' . $termoBusca . '%';
            $select->bindParam(':termo', $termoParam, PDO::PARAM_STR);
        }
        
        $select->bindParam(':offset', $offset, PDO::PARAM_INT);
        $select->bindParam(':limit', $registrosPorPagina, PDO::PARAM_INT);
        $select->execute();
        
        $tarefas = $select->fetchAll(PDO::FETCH_ASSOC);
        $titulo = "Tarefas Disponíveis";
    } catch(PDOException $e) {
        echo "<div class='alert alert-danger'>Erro: " . $e->getMessage() . "</div>";
    }
?>

<div class="row">
    <div class="col-md-12">
        <h2 class="page-header"><?php echo $titulo; ?></h2>
        
        <div class="row search-container">
            <div class="col-md-6">
                <form method="GET" action="tarefas_disponiveis.php" class="d-flex">
                    <input type="text" name="busca" class="form-control me-2" placeholder="Buscar por descrição ou categoria" value="<?php echo htmlspecialchars($termoBusca); ?>">
                    <button type="submit" class="btn btn-primary">Buscar</button>
                </form>
            </div>
            <div class="col-md-6 text-end">
                <a href="minhas_tarefas.php" class="btn btn-success">
                    <i class="material-icons align-middle">assignment</i> Minhas Tarefas
                </a>
            </div>
        </div>

        <?php if (count($tarefas) > 0): ?>
            <div class="table-responsive">
                <table class="table table-striped table-hover table-bordered">
                    <thead class="table-primary">
                        <tr>
                            <th width="5%">ID</th>
                            <th width="45%">Descrição</th>
                            <th width="15%">Categoria</th>
                            <th width="15%">Data Criação</th>
                            <th width="20%">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($tarefas as $tarefa): ?>
                            <tr>
                                <td><?php echo $tarefa['id']; ?></td>
                                <td><?php echo htmlspecialchars($tarefa['descricao']); ?></td>
                                <td><?php echo htmlspecialchars($tarefa['categoria']); ?></td>
                                <td><?php echo $tarefa['dataHoraCriacao']; ?></td>
                                <td class="action-icons text-center">
                                    <a href="visualizar_tarefa.php?id=<?php echo $tarefa['id']; ?>" class="btn btn-sm btn-info">
                                        <i class="material-icons">visibility</i>
                                    </a>
                                    <a href="selecionar_tarefa.php?id=<?php echo $tarefa['id']; ?>" class="btn btn-sm btn-success">
                                        <i class="material-icons">add_task</i>
                                    </a>
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
                            <a class="page-link" href="?pagina=<?php echo $paginaAtual - 1; ?><?php echo !empty($termoBusca) ? '&busca=' . urlencode($termoBusca) : ''; ?>">Anterior</a>
                        </li>
                    <?php else: ?>
                        <li class="page-item disabled">
                            <a class="page-link" href="#">Anterior</a>
                        </li>
                    <?php endif; ?>
                    
                    <?php for ($i = 1; $i <= $totalPaginas; $i++): ?>
                        <li class="page-item <?php echo $i == $paginaAtual ? 'active' : ''; ?>">
                            <a class="page-link" href="?pagina=<?php echo $i; ?><?php echo !empty($termoBusca) ? '&busca=' . urlencode($termoBusca) : ''; ?>"><?php echo $i; ?></a>
                        </li>
                    <?php endfor; ?>
                    
                    <?php if ($paginaAtual < $totalPaginas): ?>
                        <li class="page-item">
                            <a class="page-link" href="?pagina=<?php echo $paginaAtual + 1; ?><?php echo !empty($termoBusca) ? '&busca=' . urlencode($termoBusca) : ''; ?>">Próxima</a>
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
                Nenhuma tarefa disponível encontrada.
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
