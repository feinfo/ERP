<?php

class Pedido extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('Pedido_model');
        $this->load->model('Pedido_item_model');
        $this->load->model('Variacao_model');
        $this->load->model('Cupom_model');
        $this->load->library('Email_sender');
    }

    public function finalizar() {
        $carrinho = $this->session->userdata('carrinho') ?? [];
        $cupom = $this->session->userdata('cupom');

        if (empty($carrinho)) {
            $this->session->set_flashdata('error', 'Carrinho vazio!');
            redirect('carrinho/listar');
        }

        $subtotal = 0;
        foreach ($carrinho as $item) {
            $subtotal += $item['quantidade'] * $item['preco_unitario'];
        }

        $desconto = 0;
        if ($cupom) {
            if ($cupom['tipo'] == 'percentual') {
                $desconto = ($subtotal * $cupom['valor']) / 100;
            } else {
                $desconto = $cupom['valor'];
            }
        }

        $total = max(0, $subtotal - $desconto);

        $data_pedido = date('Y-m-d H:i:s');

        
            
        $dados_pedido = [
            'criado_em' => $data_pedido,
            'total' => $total,
            'subtotal' => $subtotal,
            'desconto'  => $desconto
        ];

        $pedido_id = $this->Pedido_model->inserir($dados_pedido);

        foreach ($carrinho as $id_variacao => $item) {
            $this->Pedido_item_model->inserir([
                'pedido_id' => $pedido_id,
                'produto_id' => $item['produto_id'],
                'variacao_id' => $id_variacao,
                'quantidade' => $item['quantidade'],
                'preco_unitario' => $item['preco_unitario']
            ]);

            $this->Variacao_model->baixarEstoque($id_variacao, $item['quantidade']);
        }

        $endereco = [
            'cep'        => $this->input->post('cep'),
            'logradouro' => $this->input->post('logradouro') ?: $this->input->post('logradouro_manual'),
            'numero'     => $this->input->post('numero'),
            'complemento'=> $this->input->post('complemento'),
            'bairro'     => $this->input->post('bairro') ?: $this->input->post('bairro_manual'),
            'localidade' => $this->input->post('localidade') ?: $this->input->post('localidade_manual'),
            'uf'         => $this->input->post('uf') ?: $this->input->post('uf_manual'),
        ];

        $this->Pedido_model->salvarEnderecoEntrega($pedido_id, $endereco);

        $emailCliente = 'felipec.conceicao@outlook.com';
        $nomeCliente  = $this->input->post('nome') ?? 'Cliente';

        $mensagem = "
            <h3>Olá, {$nomeCliente}!</h3>
            <p>Seu pedido de número <strong>#{$pedido_id}</strong> foi recebido com sucesso.</p>
            <p>Agradecemos por comprar com a gente!</p>
        ";

        // Envia o e-mail
        $enviado = $this->email_sender->enviar($emailCliente, 'Confirmação de Pedido', $mensagem);

        if (!$enviado) {
            log_message('error', 'Erro ao enviar e-mail de confirmação para ' . $emailCliente);
        }


        $this->session->unset_userdata('carrinho');
        $this->session->unset_userdata('cupom');
        $this->session->set_flashdata('success', 'Pedido finalizado com sucesso!');
        redirect('pedido/sucesso/' . $pedido_id);
    }

    public function sucesso($id) {
        $pedido = $this->Pedido_model->getById($id);
        $data['pedido_id'] = $id;
        $data['pedido_data'] = $pedido ? $pedido->criado_em : null;

        $this->load->view('templates/_header');
        $this->load->view('pedido/sucesso', $data);
        $this->load->view('templates/_footer');
    }

    public function listar() {
        $data['pedidos'] = $this->Pedido_model->listarTodos();
        $this->load->view('templates/_header');
        $this->load->view('pedido/listar', $data);
        $this->load->view('templates/_footer');
    }

    public function visualizar($id) {
        $this->load->model('Pedido_model');
    
        $pedido = $this->Pedido_model->buscar($id);
        $itens = $this->Pedido_model->buscarItens($id);
    
        if (!$pedido) {
            show_404();
        }

        $this->load->view('templates/_header');
        $this->load->view('pedido/pedido_visualizar', [
            'pedido' => $pedido,
            'itens' => $itens
        ]);
        $this->load->view('templates/_footer');
    }
    
    
}