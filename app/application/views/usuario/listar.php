<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 class="mt-3">Usuários</h2>
        <a href="<?= site_url('usuario/criar') ?>" class="btn btn-outline-primary">Novo Usuário</a>
    </div>
    <div class="table-responsive">
        <table class="table table-striped table-bordered w-100">
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
