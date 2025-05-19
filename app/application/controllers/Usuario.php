<?php

class Usuario extends CI_Controller {

    public function __construct() {
        parent::__construct();
        require_login();
        $this->load->model('Usuario_model');
    }

    public function index() {
        $data['usuarios'] = $this->Usuario_model->listar();
        $this->load->view('templates/_header');
        $this->load->view('usuario/listar', $data);
        $this->load->view('templates/_footer');
    }

    public function criar() {
        $data['perfis'] = $this->Usuario_model->listarPerfis();
        $this->load->view('templates/_header');
        $this->load->view('usuario/form', $data);
        $this->load->view('templates/_footer');
    }

    public function editar($id) {
        $data['usuario'] = $this->Usuario_model->buscar($id);
        $data['perfis'] = $this->Usuario_model->listarPerfis();
        $this->load->view('templates/_header');
        $this->load->view('usuario/form', $data);
        $this->load->view('templates/_footer');
    }

    public function salvar() {
        $dados = $this->input->post();
    
        // Se foi enviada uma senha, vamos aplicar hash
        if (!empty($dados['senha'])) {
            $dados['senha'] = password_hash($dados['senha'], PASSWORD_DEFAULT);
        } else {
            // Não altera a senha se for edição e o campo estiver vazio
            unset($dados['senha']);
        }
    
        if (!empty($dados['id'])) {
            $this->Usuario_model->atualizar($dados['id'], $dados);
        } else {
            unset($dados['id']);
            $this->Usuario_model->inserir($dados);
        }
    
        redirect('usuario');
    }
    

    public function excluir($id) {
        $this->Usuario_model->excluir($id);
        redirect('usuario');
    }
}