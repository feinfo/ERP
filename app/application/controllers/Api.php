<?php

    class Api extends CI_Controller {
        public function variacoes_por_produto($id_produto) {
            $this->load->model('Variacao_model');
            $variacoes = $this->Variacao_model->getByProdutoId($id_produto);
            echo json_encode($variacoes);
        }
    }

?>