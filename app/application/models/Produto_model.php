<?php
class Produto_model extends CI_Model {

    public function getAll($busca = null)
    {
        if (!empty($busca)) {
            $this->db->like('nome', $busca);
        }   
        return $this->db->get('produtos')->result();
    }


    public function getById($id) {
        return $this->db->get_where('produtos', ['id' => $id])->row();
    }

    public function insert($data) {
        $this->db->insert('produtos', $data);
        return $this->db->insert_id();
    }

    public function update($id, $data) {
        $this->db->where('id', $id)->update('produtos', $data);
    }

    public function delete($id) {
        $this->db->where('id', $id)->delete('produtos');
    }
    public function countAll($busca = null)
    {
        if (!empty($busca)) {
            $this->db->like('nome', $busca);
        }
        return $this->db->count_all_results('produtos');
    }

    public function getPaginados($limit, $offset, $busca = null)
    {
        if (!empty($busca)) {
            $this->db->like('nome', $busca);
        }
        return $this->db->get('produtos', $limit, $offset)->result();
    }

}
