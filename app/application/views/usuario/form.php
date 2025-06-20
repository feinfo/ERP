<?php
    $perfilLogado = $this->session->userdata('usuario_perfil_id');
    $ehAdmin = $perfilLogado == 1; 
    $protocol = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') || (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https') ? 'https' : 'http';
?>
<div class="container-fluid mt-4">
    <div class="row justify-content-center">
        <div class="col-12 col-md-8 col-lg-6">
            <h2 class="mt-3"><?= isset($usuario) ? 'Editar' : 'Novo' ?> Usuário</h2>
            <form method="post" action="<?= site_url('usuario/salvar', $protocol) ?>">
                <input type="hidden" name="id" value="<?= isset($usuario) ? $usuario->id : '' ?>">

                <div class="mb-3">
                    <label>Nome</label>
                    <input type="text" name="nome" class="form-control" value="<?= isset($usuario) ? $usuario->nome : '' ?>" required>
                </div>

                <div class="mb-3">
                    <label>Email</label>
                    <input type="email" name="email" class="form-control" value="<?= isset($usuario) ? $usuario->email : '' ?>" required>
                </div>

                <?php if ($ehAdmin): ?>
                    <div class="mb-3">
                        <label>Perfil</label>
                        <select name="usuario_perfil_id" class="form-control" required>
                            <option value="">Selecione</option>
                            <?php foreach ($perfis as $p): ?>
                                <option value="<?= $p->id ?>" <?= (isset($usuario) && $usuario->usuario_perfil_id == $p->id) ? 'selected' : '' ?>>
                                    <?= $p->nome ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                <?php else: ?>
                    <input type="hidden" name="usuario_perfil_id" value="<?= $perfilLogado ?>">
                <?php endif; ?>
                <div class="mb-3">
                    <label>Senha <?= isset($usuario) ? '(deixe em branco para manter a atual)' : '' ?></label>
                    <input type="password" name="senha" class="form-control" <?= isset($usuario) ? '' : 'required' ?>>
                </div>

                <button type="submit" class="btn btn-primary w-100 mb-2">Salvar</button>
                <a href="<?= site_url('usuario') ?>" class="btn btn-secondary w-100">Voltar</a>
            </form>
        </div>
    </div>
</div>