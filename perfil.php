<?php
session_start();
require_once("includes/topo.php");

if(isset($_SESSION['idUsuario'])){
    require_once("banco/conexao.php");
    try{
        $id = $_SESSION['idUsuario'];
        $select = $conn->prepare("SELECT * FROM tbusuarios WHERE id=:id");
        $select->bindParam(":id", $id, PDO::PARAM_INT);
        $select->execute();

        $usuarios = $select->fetchAll(PDO::FETCH_ASSOC);
        if(count($usuarios)==1) {
            ?>
            <div class="row">
                <div class="col-md-8 offset-md-2">
                    <div class="card">
                        <div class="card-header bg-primary text-white">
                            <h4 class="mb-0">Meu Perfil</h4>
                        </div>
                        <div class="card-body">
                            <form name="cadastro" action="atualizarperfil.php" method="post" class="needs-validation" novalidate>
                                <div class="mb-3">
                                    <label for="nome" class="form-label">Nome:</label>
                                    <input type="text" name="nome" id="nome" class="form-control" 
                                        value="<?php echo htmlspecialchars($usuarios[0]['nome']); ?>"
                                        placeholder="Digite seu nome aqui" maxlength="200" required>
                                    <div class="invalid-feedback">
                                        Por favor, informe o nome.
                                    </div>
                                </div>
                                
                                <div class="mb-3">
                                    <label for="email" class="form-label">E-mail:</label>
                                    <input type="email" name="email" id="email" class="form-control" 
                                        value="<?php echo htmlspecialchars($usuarios[0]['email']); ?>"
                                        placeholder="Digite seu email aqui" maxlength="200" required>
                                    <div class="invalid-feedback">
                                        Por favor, informe um e-mail válido.
                                    </div>
                                </div>
                                
                                <div class="mb-3">
                                    <label for="senha" class="form-label">Senha:</label>
                                    <input type="password" name="senha" id="senha" class="form-control" 
                                        value="<?php echo htmlspecialchars($usuarios[0]['senha']); ?>"
                                        placeholder="Digite sua senha aqui" maxlength="20" required>
                                    <div class="invalid-feedback">
                                        Por favor, informe uma senha.
                                    </div>
                                </div>
                                
                                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                    <button type="submit" class="btn btn-primary me-md-2">Atualizar</button>
                                    <a href="indexlogado.php" class="btn btn-secondary">Cancelar</a>
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
            echo "<div class='alert alert-warning'>Usuário não encontrado.</div>";
        }
    } catch(PDOException $e) {
        echo "<div class='alert alert-danger'>Erro: " . $e->getMessage() . "</div>";
    }
} else {
    echo "<div class='alert alert-danger'>Você não tem permissão para acessar este conteúdo.</div>";
} 
require_once("includes/rodape.php"); 
?>
