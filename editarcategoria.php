<?php
session_start();
require_once("includes/topo.php");

if(isset($_SESSION['tipoUsuario']) && $_SESSION['tipoUsuario']=="Administrador"){
    require_once("banco/conexao.php");
    try{
        if(isset($_GET['id'])){
            $id = $_GET['id'];
            $select = $conn->prepare("SELECT * FROM categoria WHERE id=:id");
            $select->bindParam(":id", $id, PDO::PARAM_INT);
            $select->execute();

            $categorias = $select->fetchAll(PDO::FETCH_ASSOC);
            if(count($categorias)==1) {
                ?>
                <div class="row">
                    <div class="col-md-8 offset-md-2">
                        <div class="card">
                            <div class="card-header bg-primary text-white">
                                <h4 class="mb-0">Editar Categoria</h4>
                            </div>
                            <div class="card-body">
                                <form name="cadastro" action="atualizarcategoria.php" method="post" class="needs-validation" novalidate>
                                    <input type="hidden" name="id" value="<?php echo $categorias[0]['id']; ?>">
                                    
                                    <div class="mb-3">
                                        <label for="descricao" class="form-label">Descrição:</label>
                                        <input type="text" name="descricao" id="descricao" class="form-control" 
                                            value="<?php echo htmlspecialchars($categorias[0]['descricao']); ?>"
                                            placeholder="Digite a descrição da categoria" maxlength="20" required>
                                        <div class="invalid-feedback">
                                            Por favor, informe a descrição da categoria.
                                        </div>
                                    </div>
                                    
                                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                        <button type="submit" class="btn btn-primary me-md-2">Atualizar</button>
                                        <a href="listacategorias.php" class="btn btn-secondary">Cancelar</a>
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
                echo "<div class='alert alert-warning'>Categoria não encontrada. <a href='listacategorias.php' class='alert-link'>Voltar para a listagem</a></div>";
            }
        } else {
            echo "<div class='alert alert-warning'>Selecione uma categoria. <a href='listacategorias.php' class='alert-link'>Voltar para a listagem</a></div>";
        }
    } catch(PDOException $e) {
        echo "<div class='alert alert-danger'>Erro: " . $e->getMessage() . "</div>";
    }
} else {
    echo "<div class='alert alert-danger'>Você não tem permissão para acessar este conteúdo.</div>";
} 
require_once("includes/rodape.php"); 
?>
