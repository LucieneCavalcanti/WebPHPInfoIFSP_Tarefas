<?php
session_start();
require_once("includes/topo.php");

if(isset($_SESSION['tipoUsuario']) && $_SESSION['tipoUsuario']=="Administrador"){
    require_once("banco/conexao.php");
    try{
        if(isset($_GET['id'])){
            $id = $_GET['id'];
            
            // Buscar a tarefa
            $select = $conn->prepare("SELECT * FROM tarefa WHERE id=:id");
            $select->bindParam(":id", $id, PDO::PARAM_INT);
            $select->execute();
            $tarefas = $select->fetchAll(PDO::FETCH_ASSOC);
            
            // Buscar todas as categorias para o select
            $sqlCategorias = "SELECT id, descricao FROM categoria ORDER BY descricao";
            $stmtCategorias = $conn->prepare($sqlCategorias);
            $stmtCategorias->execute();
            $categorias = $stmtCategorias->fetchAll(PDO::FETCH_ASSOC);
            
            if(count($tarefas)==1) {
                ?>
                <div class="row">
                    <div class="col-md-8 offset-md-2">
                        <div class="card">
                            <div class="card-header bg-primary text-white">
                                <h4 class="mb-0">Editar Tarefa</h4>
                            </div>
                            <div class="card-body">
                                <form name="cadastro" action="atualizartarefa.php" method="post" class="needs-validation" novalidate>
                                    <input type="hidden" name="id" value="<?php echo $tarefas[0]['id']; ?>">
                                    
                                    <div class="mb-3">
                                        <label for="descricao" class="form-label">Descrição:</label>
                                        <textarea name="descricao" id="descricao" class="form-control" 
                                            placeholder="Digite a descrição da tarefa" rows="3" required><?php echo htmlspecialchars($tarefas[0]['descricao']); ?></textarea>
                                        <div class="invalid-feedback">
                                            Por favor, informe a descrição da tarefa.
                                        </div>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label for="categoria" class="form-label">Categoria:</label>
                                        <select name="categoria" id="categoria" class="form-select" required>
                                            <option value="">Selecione uma categoria</option>
                                            <?php foreach($categorias as $categoria): ?>
                                            <option value="<?php echo $categoria['id']; ?>" <?php echo ($categoria['id'] == $tarefas[0]['fk_Categoria_id']) ? 'selected' : ''; ?>>
                                                <?php echo htmlspecialchars($categoria['descricao']); ?>
                                            </option>
                                            <?php endforeach; ?>
                                        </select>
                                        <div class="invalid-feedback">
                                            Por favor, selecione uma categoria.
                                        </div>
                                    </div>
                                    
                                    <?php if($tarefas[0]['dataHoraTermino']): ?>
                                    <div class="mb-3">
                                        <div class="alert alert-success">
                                            Esta tarefa foi concluída em: <?php echo date('d/m/Y H:i:s', strtotime($tarefas[0]['dataHoraTermino'])); ?>
                                        </div>
                                    </div>
                                    <?php endif; ?>
                                    
                                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                        <button type="submit" class="btn btn-primary me-md-2">Atualizar</button>
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
                echo "<div class='alert alert-warning'>Tarefa não encontrada. <a href='listatarefas.php' class='alert-link'>Voltar para a listagem</a></div>";
            }
        } else {
            echo "<div class='alert alert-warning'>Selecione uma tarefa. <a href='listatarefas.php' class='alert-link'>Voltar para a listagem</a></div>";
        }
    } catch(PDOException $e) {
        echo "<div class='alert alert-danger'>Erro: " . $e->getMessage() . "</div>";
    }
} else {
    echo "<div class='alert alert-danger'>Você não tem permissão para acessar este conteúdo.</div>";
} 
require_once("includes/rodape.php"); 
?>
