<?php
class Pedido_model extends CI_Model {
    public function inserir($dados) {
        $this->db->insert('pedidos', $dados);
        return $this->db->insert_id();
    }
    public function getById($id) {
        return $this->db->get_where('pedidos', ['id' => $id])->row();
    }

    public function listarTodos() {
        return $this->db
        ->select('pedidos.*, pedido_status.nome as status_descricao')
        ->from('pedidos')
        ->join('pedido_status','pedido_status.id = pedidos.status_id','left')
        ->order_by('pedidos.criado_em','desc')
        ->get()
        ->result();
    }
    
    public function salvarEnderecoEntrega($pedido_id, $dados)
    {
        $dados['pedido_id'] = $pedido_id;
        return $this->db->insert('enderecos_entrega', $dados);
    }
    public function remover($id) {
        $this->db->where('pedido_id', $id)->delete('pedido_itens');
        $this->db->where('pedido_id', $id)->delete('enderecos_entrega'); 
        $this->db->where('id', $id)->delete('pedidos');
    }

    
    public function atualizarStatus($id, $status_id) {
        $this->db->where('id', $id)->update('pedidos', ['status_id' => $status_id]);
    }

    public function buscar($id) {
        return $this->db
            ->select('pedidos.*, pedido_status.nome as status_nome')
            ->from('pedidos')
            ->join('pedido_status', 'pedido_status.id = pedidos.status_id', 'left')
            ->where('pedidos.id', $id)
            ->get()
            ->row();
    }
    
    
    public function buscarItens($pedido_id) {
        return $this->db
            ->where('pedido_id', $pedido_id)
            ->join('produtos', 'produtos.id = pedido_itens.produto_id')
            ->get('pedido_itens')
            ->result();
    }
    

}