    </div> <!-- fecha container -->

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    

    <?php if ($this->session->flashdata('success')): ?>
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Sucesso!',
                text: '<?= $this->session->flashdata('success') ?>',
                showConfirmButton: false,
                timer: 3000
            });
        </script>
    <?php elseif ($this->session->flashdata('error')): ?>
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Erro!',
                text: '<?= $this->session->flashdata('error') ?>',
                showConfirmButton: false,
                timer: 3000
            });
        </script>
    <?php endif; ?>
    <?php if (isset($scripts[0])) : ?>
        <?php foreach ($scripts as $script) : ?>
            <script src="<?= base_url($script) ?>"></script>
        <?php endforeach; ?>
    <?php endif; ?>
</body>
</html>
