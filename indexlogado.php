<?php
session_start();
require_once("includes/topo.php");

if(isset($_SESSION['idUsuario'])) {
    $nomeUsuario = isset($_SESSION['nomeUsuario']) ? $_SESSION['nomeUsuario'] : 'Usuário';
    $tipoUsuario = isset($_SESSION['tipoUsuario']) ? $_SESSION['tipoUsuario'] : '';
?>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">Bem-vindo, <?php echo htmlspecialchars($nomeUsuario); ?>!</h4>
                </div>
                <div class="card-body">
                    <div class="alert alert-info">
                        <p>Você está logado como: <strong><?php echo htmlspecialchars($tipoUsuario); ?></strong></p>
                    </div>
                    
                    <div class="row mt-4">
                        <div class="col-md-4 mb-3">
                            <div class="card h-100">
                                <div class="card-body text-center">
                                    <i class="material-icons" style="font-size: 48px; color: #0d6efd;">person</i>
                                    <h5 class="card-title mt-3">Meu Perfil</h5>
                                    <p class="card-text">Visualize e edite suas informações pessoais</p>
                                    <a href="perfil.php" class="btn btn-primary">Acessar</a>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-4 mb-3">
                            <div class="card h-100">
                                <div class="card-body text-center">
                                    <i class="material-icons" style="font-size: 48px; color: #0d6efd;">assignment</i>
                                    <h5 class="card-title mt-3">Minhas Tarefas</h5>
                                    <p class="card-text">Gerencie suas tarefas selecionadas</p>
                                    <a href="minhas_tarefas.php" class="btn btn-primary">Acessar</a>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-4 mb-3">
                            <div class="card h-100">
                                <div class="card-body text-center">
                                    <i class="material-icons" style="font-size: 48px; color: #0d6efd;">add_task</i>
                                    <h5 class="card-title mt-3">Tarefas Disponíveis</h5>
                                    <p class="card-text">Visualize e selecione novas tarefas</p>
                                    <a href="tarefas_disponiveis.php" class="btn btn-primary">Acessar</a>
                                </div>
                            </div>
                        </div>
                        
                        <?php if($tipoUsuario == "Administrador"): ?>
                        <div class="col-md-4 mb-3">
                            <div class="card h-100">
                                <div class="card-body text-center">
                                    <i class="material-icons" style="font-size: 48px; color: #0d6efd;">group</i>
                                    <h5 class="card-title mt-3">Usuários</h5>
                                    <p class="card-text">Gerencie os usuários do sistema</p>
                                    <a href="listausuarios.php" class="btn btn-primary">Acessar</a>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-4 mb-3">
                            <div class="card h-100">
                                <div class="card-body text-center">
                                    <i class="material-icons" style="font-size: 48px; color: #0d6efd;">category</i>
                                    <h5 class="card-title mt-3">Categorias</h5>
                                    <p class="card-text">Gerencie as categorias de tarefas</p>
                                    <a href="listacategorias.php" class="btn btn-primary">Acessar</a>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-4 mb-3">
                            <div class="card h-100">
                                <div class="card-body text-center">
                                    <i class="material-icons" style="font-size: 48px; color: #0d6efd;">task</i>
                                    <h5 class="card-title mt-3">Tarefas</h5>
                                    <p class="card-text">Gerencie todas as tarefas do sistema</p>
                                    <a href="listatarefas.php" class="btn btn-primary">Acessar</a>
                                </div>
                            </div>
                        </div>
                        <?php endif; ?>
                        
                        <div class="col-md-4 mb-3">
                            <div class="card h-100">
                                <div class="card-body text-center">
                                    <i class="material-icons" style="font-size: 48px; color: #dc3545;">logout</i>
                                    <h5 class="card-title mt-3">Sair</h5>
                                    <p class="card-text">Encerrar a sessão atual</p>
                                    <a href="logout.php" class="btn btn-danger">Sair</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php
} else {
    ?>
    <div class="alert alert-danger">
        <strong>Acesso Negado!</strong> Você precisa fazer login para acessar este conteúdo.
    </div>
    <div class="text-center mt-3">
        <a href="login.php" class="btn btn-primary">Ir para o login</a>
    </div>
    <?php
}
require_once("includes/rodape.php");
?>
