<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Usuario_model');
    }

    public function login() {
        if ($this->input->post()) {
            $email = $this->input->post('email');
            $senha = $this->input->post('senha');

            $usuario = $this->Usuario_model->buscarPorEmail($email);

            if ($usuario && password_verify($senha, $usuario->senha)) {
                // Cria sessão
                $this->session->set_userdata([
                    'usuario_id' => $usuario->id,
                    'usuario_nome' => $usuario->nome,
                    'usuario_perfil_id' => $usuario->usuario_perfil_id,
                    'usuario_perfil_nome' => $usuario->nome_perfil 
                ]);
                

                redirect('usuario');
            } else {
                $data['erro'] = 'E-mail ou senha inválidos.';
            }
        }

        $this->load->view('auth/login', isset($data) ? $data : []);
    }

    public function logout() {
        $this->session->sess_destroy();
        redirect('auth/login');
    }
}
