<?php 
session_start();
require_once("includes/topo.php"); 

if(isset($_SESSION['tipoUsuario']) && $_SESSION['tipoUsuario']=="Administrador"){
?>
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">Cadastro de Categoria</h4>
                </div>
                <div class="card-body">
                    <form name="cadastro" action="inserircategoria.php" method="post" class="needs-validation" novalidate>
                        <div class="mb-3">
                            <label for="descricao" class="form-label">Descrição:</label>
                            <input type="text" name="descricao" id="descricao" class="form-control" 
                                placeholder="Digite a descrição da categoria" maxlength="20" required>
                            <div class="invalid-feedback">
                                Por favor, informe a descrição da categoria.
                            </div>
                        </div>
                        
                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <button type="submit" class="btn btn-primary me-md-2">Cadastrar</button>
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
    echo "<div class='alert alert-danger'>Você não tem permissão para acessar este conteúdo.</div>";
} 
require_once("includes/rodape.php"); 
?>
