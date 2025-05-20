<?php 
session_start();
require_once("includes/topo.php"); 

if(isset($_SESSION['tipoUsuario']) && $_SESSION['tipoUsuario']=="Administrador"){
    require_once("banco/conexao.php");
    
    try {
        // Buscar todas as categorias para o select
        $sqlCategorias = "SELECT id, descricao FROM categoria ORDER BY descricao";
        $stmtCategorias = $conn->prepare($sqlCategorias);
        $stmtCategorias->execute();
        $categorias = $stmtCategorias->fetchAll(PDO::FETCH_ASSOC);
    } catch(PDOException $e) {
        echo "<div class='alert alert-danger'>Erro ao carregar categorias: " . $e->getMessage() . "</div>";
        $categorias = [];
    }
?>
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">Cadastro de Tarefa</h4>
                </div>
                <div class="card-body">
                    <form name="cadastro" action="inserirtarefa.php" method="post" class="needs-validation" novalidate>
                        <div class="mb-3">
                            <label for="descricao" class="form-label">Descrição:</label>
                            <textarea name="descricao" id="descricao" class="form-control" 
                                placeholder="Digite a descrição da tarefa" rows="3" required></textarea>
                            <div class="invalid-feedback">
                                Por favor, informe a descrição da tarefa.
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="categoria" class="form-label">Categoria:</label>
                            <select name="categoria" id="categoria" class="form-select" required>
                                <option value="">Selecione uma categoria</option>
                                <?php foreach($categorias as $categoria): ?>
                                <option value="<?php echo $categoria['id']; ?>"><?php echo htmlspecialchars($categoria['descricao']); ?></option>
                                <?php endforeach; ?>
                            </select>
                            <div class="invalid-feedback">
                                Por favor, selecione uma categoria.
                            </div>
                            <?php if(count($categorias) == 0): ?>
                            <div class="form-text text-danger">
                                Não há categorias cadastradas. <a href="cadastrocategoria.php">Cadastrar uma categoria</a>
                            </div>
                            <?php endif; ?>
                        </div>
                        
                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <button type="submit" class="btn btn-primary me-md-2" <?php echo count($categorias) == 0 ? 'disabled' : ''; ?>>Cadastrar</button>
                            <a href="listatarefas.php" class="btn btn-secondary">Cancelar</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
    // Validação do formulário
    (function () {
        'use strict'
        var forms = document.querySelectorAll('.needs-validation')
        Array.prototype.slice.call(forms)
            .forEach(function (form) {
                form.addEventListener('submit', function (event) {
                    if (!form.checkValidity()) {
                        event.preventDefault()
                        event.stopPropagation()
                    }
                    form.classList.add('was-validated')
                }, false)
            })
    })()
    </script>
<?php     
} else {
    echo "<div class='alert alert-danger'>Você não tem permissão para acessar este conteúdo.</div>";
} 
require_once("includes/rodape.php"); 
?>
