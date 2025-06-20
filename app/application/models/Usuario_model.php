<?php

class Usuario_model extends CI_Model {

    private $tabela = 'usuarios';

    public function listar() {
        $this->db->select('usuarios.*, usuario_perfis.nome as nome_perfil');
        $this->db->from('usuarios');
        $this->db->join('usuario_perfis', 'usuario_perfis.id = usuarios.usuario_perfil_id', 'left');
        return $this->db->get()->result();
    }

    public function buscar($id) {
        return $this->db->get_where($this->tabela, ['id' => $id])->row();
    }

    public function inserir($dados) {
        return $this->db->insert($this->tabela, $dados);
    }

    public function atualizar($id, $dados) {
        $this->db->where('id', $id);
        $this->db->set($dados);
        return $this->db->update($this->tabela);
    }

    public function excluir($id) {
        return $this->db->where('id', $id)->delete($this->tabela);
    }

    public function listarPerfis() {
        return $this->db->get('usuario_perfis')->result(); 
    }
    public function buscarPorEmail($email) {
        $this->db->select('usuarios.*, usuario_perfis.nome as nome_perfil');
        $this->db->from('usuarios');
        $this->db->join('usuario_perfis', 'usuario_perfis.id = usuarios.usuario_perfil_id', 'left');
        $this->db->where('usuarios.email', $email);
        return $this->db->get()->row();
    }
    
    
}