<?php
    class Variacao_model extends CI_Model {

        public function getByProdutoId($produto_id) {
            return $this->db->get_where('variacoes', ['produto_id' => $produto_id])->result();
        }

        public function insert($data) {
            return $this->db->insert('variacoes', $data);
        }

        public function deleteByProdutoId($produto_id) {
            return $this->db->where('produto_id', $produto_id)->delete('variacoes');
        }
        public function getById($id)
        {
            return $this->db->get_where('variacoes', ['id' => $id])->row();
        }
        public function baixarEstoque($id_variacao, $quantidade) {
            $this->db->set('estoque', "estoque - {$quantidade}", false);
            $this->db->where('id', $id_variacao);
            $this->db->update('variacoes');
        }
        

    } 

?>