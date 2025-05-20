<?php
require_once "includes/topo.php";
?>
<div class="row">
    <div class="col-md-6 offset-md-3">
        <div class="card mt-5">
            <div class="card-header bg-primary text-white">
                <h4 class="mb-0">Login</h4>
            </div>
            <div class="card-body">
                <form name="formcadastro" action="validarlogin.php" method="post" class="needs-validation" novalidate>
                    <div class="mb-3">
                        <label for="email" class="form-label">E-mail:</label>
                        <input type="email" name="email" id="email" class="form-control" 
                            placeholder="Digite seu e-mail" maxlength="200" required>
                        <div class="invalid-feedback">
                            Por favor, informe um e-mail válido.
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="senha" class="form-label">Senha:</label>
                        <input type="password" name="senha" id="senha" class="form-control" 
                            placeholder="Digite a senha" maxlength="20" required>
                        <div class="invalid-feedback">
                            Por favor, informe sua senha.
                        </div>
                    </div>
                    
                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary">Acessar</button>
                        <button type="reset" class="btn btn-secondary">Limpar</button>
                    </div>
                </form>
            </div>
            <div class="card-footer">
                <p class="mb-0">Você é novo por aqui? <a href="#">Cadastre-se</a></p>
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
require_once "includes/rodape.php";
?>
