document.addEventListener('DOMContentLoaded', function () {
    const collapse = document.getElementById('dadosEntrega');
    const icon = document.getElementById('iconeSetaEntrega');

    // Inicializa o estado com base na visibilidade do collapse
    if (collapse.classList.contains('show')) {
        icon.classList.remove('bi-chevron-down');
        icon.classList.add('bi-chevron-up');
    } else {
        icon.classList.remove('bi-chevron-up');
        icon.classList.add('bi-chevron-down');
    }

    collapse.addEventListener('show.bs.collapse', () => {
        icon.classList.remove('bi-chevron-down');
        icon.classList.add('bi-chevron-up');
    });

    collapse.addEventListener('hide.bs.collapse', () => {
        icon.classList.remove('bi-chevron-up');
        icon.classList.add('bi-chevron-down');
    });
});

function removerCupom() {
    fetch('remover_cupom', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' }
    })
    .then(res => {
        if (res.ok) {
            location.reload(); // recarrega a página após remover
        } else {
            alert('Erro ao remover cupom.');
        }
    });
}
