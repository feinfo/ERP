<?php

class Carrinho extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('Variacao_model');
        $this->load->model('Produto_model');
        $this->load->model('Carrinho_model');
    }

    public function adicionar_ajax() {
        $id_variacao = $this->input->post('id_variacao');
        $quantidade = (int) $this->input->post('quantidade') ?: 1;

        $variacao = $this->Variacao_model->getById($id_variacao);
        if (!$variacao) {
            echo json_encode(['status' => false, 'mensagem' => 'Variação inválida.']);
            return;
        }

        $produto = $this->Produto_model->getById($variacao->produto_id);

        $carrinho = $this->session->userdata('carrinho') ?? [];

        if (isset($carrinho[$id_variacao])) {
            $carrinho[$id_variacao]['quantidade'] += $quantidade;
        } else {
            $carrinho[$id_variacao] = [
                'produto_id' => $produto->id,
                'nome' => $produto->nome,
                'descricao' => $variacao->descricao,
                'quantidade' => $quantidade,
                'preco_unitario' => $produto->preco
            ];
        }

        $this->session->set_userdata('carrinho', $carrinho);
        $qtdTotal = array_sum(array_column($carrinho, 'quantidade'));
        echo json_encode(['status' => true, 'mensagem' => 'Adicionado ao carrinho!', 'quantidade_total' => $qtdTotal]);
    }

    public function listar() {
        $carrinho = $this->session->userdata('carrinho') ?? [];
        $cupom = $this->session->userdata('cupom');

        $subtotal = $this->Carrinho_model->calcularSubtotal($carrinho);
        $frete = $this->Carrinho_model->calcularFrete($subtotal);
        $desconto = $this->Carrinho_model->calcularDesconto($subtotal, $cupom);
        $total_com_desconto = max(0, ($subtotal - $desconto) + $frete);

        $data = [
            'carrinho'            => $carrinho,
            'cupom_aplicado'      => $cupom,
            'subtotal'            => $subtotal,
            'frete'               => $frete,
            'desconto'            => $desconto,
            'total'               => $subtotal, 
            'total_com_desconto'  => $total_com_desconto,
            'scripts'             => ['assets/js/endereco.js', 'assets/js/carrinho.js'],
        ];

        $this->load->view('templates/_header');
        $this->load->view('carrinho/listar', $data);
        $this->load->view('templates/_footer');
    }

    public function remover($id_variacao) {
        $carrinho = $this->session->userdata('carrinho') ?? [];
        unset($carrinho[$id_variacao]);
        $this->session->set_userdata('carrinho', $carrinho);
        redirect('carrinho/listar');
    }
    public function aplicar_cupom() {
        $codigo = $this->input->post('codigo');
    
        if (!$codigo) {
            $this->session->set_flashdata('error', 'Informe um código de cupom.');
            redirect('carrinho/listar');
        }
    
        $this->load->model('Cupom_model');
        $cupom = $this->Cupom_model->buscar($codigo);
    
        if (!$cupom) {
            $this->session->set_flashdata('error', 'Cupom inválido ou expirado.');
            redirect('carrinho/listar');
        }
    
        $carrinho = $this->session->userdata('carrinho') ?? [];
        $subtotal = 0;
        foreach ($carrinho as $item) {
            $subtotal += $item['quantidade'] * $item['preco_unitario'];
        }
    
        if ($subtotal < $cupom->valor_minimo) {
            $this->session->set_flashdata('error', 'Cupom exige valor mínimo de R$ ' . number_format($cupom->valor_minimo, 2, ',', '.'));
            redirect('carrinho/listar');
        }
    
        $this->session->set_userdata('cupom', [
            'codigo' => $cupom->codigo,
            'tipo' => $cupom->tipo,
            'valor' => $cupom->valor,
            'valor_minimo' => $cupom->valor_minimo
        ]);
    
        $this->session->set_flashdata('success', 'Cupom aplicado com sucesso!');
        redirect('carrinho/listar');
    }
    public function remover_cupom() {
        $this->session->unset_userdata('cupom');
        $this->session->set_flashdata('success', 'Cupom removido com sucesso.');
        redirect('carrinho/listar');
    }
    
}
