<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Mini ERP</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    
    <style>
        .sidebar {
            width: 220px;
            min-height: 100vh;
            background-color: #343a40;
            transition: width 0.3s;
            position: fixed; /* <-- ESSENCIAL */
            top: 0;
            left: 0;
            z-index: 100;
        }

        .sidebar.collapsed {
            width: 60px;
        }

        .sidebar .nav-link {
            color: #fff;
            white-space: nowrap;
        }

        .sidebar .nav-link .text {
            transition: opacity 0.3s;
        }

        .sidebar.collapsed .nav-link .text {
            opacity: 0;
            pointer-events: none;
        }

        .toggle-btn {
            position: absolute;
            top: 10px;
            right: -15px;
            z-index: 1000;
            width: 30px;
            height: 30px;
            background-color: #6c757d;
            border-radius: 50%;
            border: none;
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .main-content {
            margin-left: 220px;
            transition: margin-left 0.3s;
        }

        .sidebar.collapsed ~ .main-content {
            margin-left: 60px;
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            <?php $carrinho = $this->session->userdata('carrinho') ?? []; ?>
            const total = <?= array_sum(array_column($carrinho, 'quantidade')) ?>;
            const icone = document.querySelector('#icone-carrinho span');
            if (icone) icone.textContent = total;
        });

        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const icon = document.getElementById('toggleIcon');
            sidebar.classList.toggle('collapsed');
            icon.classList.toggle('bi-chevron-left');
            icon.classList.toggle('bi-chevron-right');
        }
    </script>
</head>
<body>

<body class="d-flex">

    <!-- Sidebar -->
    <div id="sidebar" class="sidebar d-flex flex-column p-3 text-white position-fixed">
        <button class="toggle-btn" onclick="toggleSidebar()" title="Expandir/recolher menu">
            <i id="toggleIcon" class="bi bi-chevron-left"></i>
        </button>

        <ul class="nav nav-pills flex-column mt-4">
            <li class="nav-item">
                <a class="nav-link" href="<?= base_url('usuario') ?>">
                    <i class="bi bi-people"></i> <span class="text ms-2">Usuários</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="<?= base_url('produto') ?>">
                    <i class="bi bi-box"></i> <span class="text ms-2">Produtos</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="<?= base_url('estoque') ?>">
                    <i class="bi bi-archive"></i> <span class="text ms-2">Estoque</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="<?= base_url('cupom') ?>">
                    <i class="bi bi-tag"></i> <span class="text ms-2">Cupons</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="<?= base_url('pedido/listar') ?>">
                    <i class="bi bi-card-list"></i> <span class="text ms-2">Pedidos</span>
                </a>
            </li>
        </ul>
    </div>

    <!-- Main content -->
    <div class="main-content flex-grow-1">
        <nav class="navbar navbar-expand-lg navbar-light bg-light px-4 justify-content-between">
            <div class="d-flex align-items-center gap-3">
                <?php
                    $usuario_nome = $this->session->userdata('usuario_nome') ?? 'Usuário';
                    $usuario_perfil = $this->session->userdata('usuario_perfil_nome') ?? 'Perfil';
                ?>
                <span class="fw-bold"><?= $usuario_nome ?></span> (<?= $usuario_perfil ?>)
            </div>
            <div class="d-flex align-items-center gap-3">
                <a href="<?= base_url('carrinho/listar') ?>" class="btn btn-outline-primary" id="icone-carrinho" title="Carrinho">
                    🛒 <span>0</span>
                </a>
                <a href="<?= base_url('auth/logout') ?>" class="btn btn-outline-danger" title="Sair">
                    <i class="bi bi-box-arrow-right"></i> <span class="d-none d-md-inline">Sair</span>
                </a>
            </div>

        </nav>

        <div class="container-fluid mt-4">

