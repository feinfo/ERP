<div class="container-fluid mt-4">
    <div class="row justify-content-center">
        <div class="col-12 col-md-10 col-lg-8">
            <h2 class="mt-3">Usuários</h2>
            <a href="<?= site_url('usuario/criar') ?>" class="btn btn-success mb-3 w-100 w-md-auto">Novo Usuário</a>
            <div class="table-responsive">
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nome</th>
                            <th>E-mail</th>
                            <th>Perfil</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($usuarios as $u): ?>
                            <tr>
                                <td><?= $u->id ?></td>
                                <td><?= $u->nome ?></td>
                                <td><?= $u->email ?></td>
                                <td><?= $u->nome_perfil?></td>
                                <td>
                                    <a href="<?= site_url('usuario/editar/' . $u->id) ?>" class="btn btn-primary btn-sm mb-1">Editar</a>
                                    <a href="<?= site_url('usuario/excluir/' . $u->id) ?>" class="btn btn-danger btn-sm mb-1" onclick="return confirm('Excluir este usuário?')">Excluir</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
