<?php
defined('BASEPATH') OR exit('No direct script access allowed');

function check_acl($rota = '') {
    $CI =& get_instance();
    $perfil = $CI->session->userdata('usuario_perfil_id');

    if (!$perfil) {
        redirect('login');
    }

    $rotaAtual = $rota ?: $CI->router->class . '/' . $CI->router->method;

    $permissoes = get_permissoes_acl();

    if (isset($permissoes[$rotaAtual]) && !in_array($perfil, $permissoes[$rotaAtual])) {
        show_error('Acesso negado.', 403);
    }
}

function get_permissoes_acl() {
    return [
        'usuario/criar' => [1],
        'usuario/salvar' => [1],
        'usuario/excluir' => [1],
        'usuario/index' => [1, 2],
        'usuario/editar' => [1],
    ];
}
