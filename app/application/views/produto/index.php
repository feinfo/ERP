<div class="modal fade" id="modalAddCarrinho" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Adicionar ao Carrinho</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <form id="formAddCarrinho">
          <input type="hidden" name="id_variacao" id="inputIdVariacao">
          <div class="mb-3">
            <label for="selectVariacao" class="form-label">Escolha a Variação</label>
            <select name="id_variacao" id="selectVariacao" class="form-select" required></select>
          </div>
          <div class="mb-3">
            <label for="inputQuantidade" class="form-label">Quantidade</label>
            <input type="number" name="quantidade" id="inputQuantidade" class="form-control" value="1" min="1">
          </div>
          <button type="submit" class="btn btn-success">Adicionar</button>
        </form>
      </div>
    </div>
  </div>
</div>
<div class="container mt-5">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Produtos</h2>
        <a href="<?= base_url('produto/form') ?>" class="btn btn-primary">Novo Produto</a>
    </div>

    <form class="mb-3" method="get" action="<?= base_url('produto') ?>">
        <div class="input-group">
            <input type="text" name="busca" class="form-control" placeholder="Buscar por nome..." value="<?= htmlspecialchars($busca ?? '') ?>">
            <button type="submit" class="btn btn-outline-secondary">Buscar</button>
        </div>
    </form>

    <table class="table table-striped table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>Preço</th>
                <th>Estoque Total</th>
                <th>Variações</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($produtos as $p): ?>
            <tr>
                <td><?= $p->id ?></td>
                <td><?= $p->nome ?></td>
                <td>R$ <?= number_format($p->preco, 2, ',', '.') ?></td>
                <td><?= $p->estoque_total ?> un</td>
                <td>
                    <?php if (!empty($p->variacoes)): ?>
                        <ul class="mb-0">
                            <?php foreach ($p->variacoes as $v): ?>
                                <li>
                                    <?= $v->descricao ?> (<?= $v->estoque ?> un)
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    <?php else: ?>
                        <em>Sem variações</em>
                    <?php endif; ?>
                </td>
                <td>
                    <a href="<?= base_url("produto/form/$p->id") ?>" class="btn btn-sm btn-warning" title="Editar">
                        <i class="bi bi-pencil"></i>
                    </a>
                    <a href="<?= base_url("produto/excluir/$p->id") ?>" class="btn btn-sm btn-danger" title="Excluir" onclick="return confirm('Deseja realmente excluir?')">
                        <i class="bi bi-trash"></i>
                    </a>
                    <button class="btn btn-sm btn-info btn-visualizar" data-id="<?= $p->id ?>" title="Visualizar">
                        <i class="bi bi-eye"></i>
                    </button>
                    <button type="button" onclick="carregarVariacoes(<?= $p->id ?>)" class="btn btn-sm btn-success" title="Adicionar ao carrinho">
                        <i class="bi bi-cart-plus"></i>
                    </button>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?= $links ?? '' ?>

<!-- Modal Visualização -->
<div class="modal fade" id="modalProduto" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalLabel">Detalhes do Produto</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
      </div>
      <div class="modal-body">
        <p><strong>Nome:</strong> <span id="modal-nome"></span></p>
        <p><strong>Preço:</strong> R$ <span id="modal-preco"></span></p>
        <p><strong>Variações:</strong></p>
        <ul id="modal-variacoes"></ul>
      </div>
    </div>
  </div>
</div>

<script>
document.querySelectorAll('.btn-visualizar').forEach(btn => {
    btn.addEventListener('click', () => {
        const id = btn.getAttribute('data-id');
        fetch(`<?= base_url('produto/visualizar_ajax/') ?>${id}`)
            .then(res => res.json())
            .then(data => {
                document.getElementById('modal-nome').textContent = data.produto.nome;
                document.getElementById('modal-preco').textContent = parseFloat(data.produto.preco).toFixed(2);

                const ul = document.getElementById('modal-variacoes');
                ul.innerHTML = '';
                if (data.variacoes.length) {
                    data.variacoes.forEach(v => {
                        const li = document.createElement('li');
                        li.textContent = `${v.descricao} (${v.estoque} un)`;
                        ul.appendChild(li);
                    });
                } else {
                    ul.innerHTML = '<li><em>Sem variações</em></li>';
                }

                new bootstrap.Modal(document.getElementById('modalProduto')).show();
            });
    });
});
function carregarVariacoes(produtoId) {
    fetch(`<?= base_url('api/variacoes_por_produto/') ?>${produtoId}`)
        .then(res => res.json())
        .then(data => {
            const select = document.getElementById('selectVariacao');
            select.innerHTML = '';
            data.forEach(v => {
                const opt = document.createElement('option');
                opt.value = v.id;
                opt.textContent = `${v.descricao} (${v.estoque} un)`;
                select.appendChild(opt);
            });
            new bootstrap.Modal(document.getElementById('modalAddCarrinho')).show();
        });
}

document.getElementById('formAddCarrinho').addEventListener('submit', function (e) {
    e.preventDefault();
    const formData = new FormData(this);

    fetch('<?= base_url('carrinho/adicionar_ajax') ?>', {
        method: 'POST',
        body: formData
    })
    .then(res => res.json())
    .then(data => {
        if (data.status) {
            Swal.fire({
                icon: 'success',
                title: data.mensagem,
                showConfirmButton: false,
                timer: 1500
            });
            document.querySelector('#icone-carrinho span').textContent = data.quantidade_total;
        } else {
            Swal.fire('Erro', data.mensagem, 'error');
        }
        bootstrap.Modal.getInstance(document.getElementById('modalAddCarrinho')).hide();
    });
});
</script>