<?php

    class Pedido_item_model extends CI_Model {
        public function inserir($dados) {
            return $this->db->insert('pedido_itens', $dados);
        }
    }