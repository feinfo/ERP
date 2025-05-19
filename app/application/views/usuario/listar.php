
<div class="container mt-5">
    <h2>Usuários</h2>
    <a href="<?= site_url('usuario/criar') ?>" class="btn btn-success">Novo Usuário</a>
    <table class="table table-striped table-bordered mt-3">
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
                        <a href="<?= site_url('usuario/editar/' . $u->id) ?>" class="btn btn-primary btn-sm">Editar</a>
                        <a href="<?= site_url('usuario/excluir/' . $u->id) ?>" class="btn btn-danger btn-sm" onclick="return confirm('Excluir este usuário?')">Excluir</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
