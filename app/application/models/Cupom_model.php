<?php

    class Cupom_model extends CI_Model {
        public function buscar($codigo) {
            $this->db->where('codigo', $codigo);
            $this->db->where('validade >=', date('Y-m-d'));
            return $this->db->get('cupons')->row();
        }

        public function listarTodos() {
            return $this->db->order_by('validade', 'DESC')->get('cupons')->result();
        }

        public function inserir($dados) {
            return $this->db->insert('cupons', $dados);
        }

        public function getById($id) {
            return $this->db->get_where('cupons', ['id' => $id])->row();
        }

        public function atualizar($id, $dados) {
            $this->db->where('id', $id);
            return $this->db->update('cupons', $dados);
        }

        public function excluir($id) {
            $this->db->where('id', $id);
            return $this->db->delete('cupons');
        }
    }