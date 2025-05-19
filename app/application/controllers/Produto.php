<?php


class Produto extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('Produto_model');
        $this->load->model('Variacao_model');
    }

    public function index() {
        $busca = $this->input->get('busca');
        $config = [];
        $config['base_url'] = base_url('produto');
        $config['total_rows'] = $this->Produto_model->countAll($busca);
        $config['per_page'] = 10;
        $config['page_query_string'] = TRUE;
        $config['query_string_segment'] = 'page';
        $config['reuse_query_string'] = TRUE;

        $config['full_tag_open'] = '<nav class="mt-4"><ul class="pagination justify-content-center">';
        $config['full_tag_close'] = '</ul></nav>';
        $config['first_link'] = 'Primeira';
        $config['last_link'] = 'Última';
        $config['first_tag_open'] = '<li class="page-item">';
        $config['first_tag_close'] = '</li>';
        $config['prev_tag_open'] = '<li class="page-item">';
        $config['prev_tag_close'] = '</li>';
        $config['next_tag_open'] = '<li class="page-item">';
        $config['next_tag_close'] = '</li>';
        $config['last_tag_open'] = '<li class="page-item">';
        $config['last_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="page-item active"><span class="page-link">';
        $config['cur_tag_close'] = '</span></li>';
        $config['num_tag_open'] = '<li class="page-item">';
        $config['num_tag_close'] = '</li>';
        $config['attributes'] = ['class' => 'page-link'];


        $this->pagination->initialize($config);
        $pagina = $this->input->get('page') ?? 0;

        $produtos = $this->Produto_model->getPaginados($config['per_page'], $pagina, $busca);
        foreach ($produtos as &$produto) {
            $produto->variacoes = $this->Variacao_model->getByProdutoId($produto->id);
            $produto->estoque_total = array_sum(array_column($produto->variacoes, 'estoque'));
        }

        $data['produtos'] = $produtos;
        $data['busca'] = $busca;
        $data['links'] = $this->pagination->create_links();

        $this->load->view('templates/_header');
        $this->load->view('produto/index', $data);
        $this->load->view('templates/_footer');
    }

    public function visualizar_ajax($id) {
        $produto = $this->Produto_model->getById($id);
        $variacoes = $this->Variacao_model->getByProdutoId($id);

        if (!$produto) {
            show_404();
        }

        echo json_encode([
            'produto' => $produto,
            'variacoes' => $variacoes
        ]);
    }
    public function form($id = null) {
        if ($id) {
            $data['produto'] = $this->Produto_model->getById($id);
            $data['variacoes'] = $this->Variacao_model->getByProdutoId($id);
        }
        $this->load->view('templates/_header');
        $this->load->view('produto/form', $data ?? []);
        $this->load->view('templates/_footer');
    }

    public function salvar() {
        $dados = [
            'nome' => $this->input->post('nome'),
            'preco' => $this->input->post('preco')
        ];

        $variacoes = $this->input->post('variacoes');
        $id = $this->input->post('id');

        if ($id) {
            $this->Produto_model->update($id, $dados);
            $this->Variacao_model->deleteByProdutoId($id);
            $produtoId = $id;
            $this->session->set_flashdata('success', 'Produto atualizado com sucesso!');
        } else {
            $produtoId = $this->Produto_model->insert($dados);
            $this->session->set_flashdata('success', 'Produto cadastrado com sucesso!');
        }

        foreach ($variacoes as $v) {
            $this->Variacao_model->insert([
                'produto_id' => $produtoId,
                'descricao' => $v['descricao'],
                'estoque' => $v['estoque']
            ]);
        }

        redirect('produto');
    }

    public function excluir($id) {
        $this->Produto_model->delete($id);
        $this->Variacao_model->deleteByProdutoId($id);
        $this->session->set_flashdata('success', 'Produto excluído com sucesso!');
        redirect('produto');
    }
}
