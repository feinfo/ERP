<?php

    class Cupom extends CI_Controller {
        public function __construct() {
            parent::__construct();
            $this->load->model('Cupom_model');
        }

        public function index() {
            $data['cupons'] = $this->Cupom_model->listarTodos();
            $this->load->view('templates/_header');
            $this->load->view('cupom/listar', $data);
            $this->load->view('templates/_footer');
        }

        public function form($id = null) {
            $data['cupom'] = $id ? $this->Cupom_model->getById($id) : null;
            $this->load->view('templates/_header');
            $this->load->view('cupom/form', $data);
            $this->load->view('templates/_footer');
        }

        public function salvar() {
            
            $id = $this->input->post('id');
            $dados = [
                'codigo' => $this->input->post('codigo'),
                'tipo' => $this->input->post('tipo'),
                'valor' => $this->input->post('valor'),
                'validade' => $this->input->post('validade'),
                'valor_minimo' => $this->input->post('valor_minimo')
            ];
            $this->load->library('form_validation');

            $this->form_validation->set_rules('codigo', 'Código', 'required');
            $this->form_validation->set_rules('valor', 'Valor', 'required|numeric');
            $this->form_validation->set_rules('valor_minimo', 'Valor Mínimo', 'required|numeric');
            $this->form_validation->set_rules('validade', 'Validade', 'required');

            if ($this->form_validation->run() == false) {
                $this->session->set_flashdata('error', validation_errors('<div>', '</div>'));
                redirect($id ? 'cupom/form/' . $id : 'cupom/form');
            }

            $this->load->model('Cupom_model');
            $existe = $this->db->get_where('cupons', ['codigo' => $dados['codigo']])->row();
            if ($existe && (!$id || $existe->id != $id)) {
                $this->session->set_flashdata('error', 'Código já utilizado por outro cupom.');
                redirect($id ? 'cupom/form/' . $id : 'cupom/form');
            }

            $id = $this->input->post('id');

            if ($id) {
                $this->Cupom_model->atualizar($id, $dados);
            } else {
                $this->Cupom_model->inserir($dados);
            }

            redirect('cupom');
        }

        public function excluir($id) {
            $this->Cupom_model->excluir($id);
            redirect('cupom');
        }
    }