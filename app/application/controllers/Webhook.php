<?php

class Webhook extends CI_Controller {
    public function pedido_status() {
        $input = json_decode(file_get_contents('php://input'), true);

        if (!isset($input['id'], $input['status_id'])) {
            return $this->output->set_status_header(400)->set_output(json_encode(['erro' => 'Dados inválidos']));
        }

        $this->load->model('Pedido_model');
        if ($input['status_id'] == 5) {
            $this->Pedido_model->remover($input['id']);
            return $this->output->set_output(json_encode(['mensagem' => 'Pedido cancelado e removido']));
        } else {
            $this->Pedido_model->atualizarStatus($input['id'], $input['status_id']);
            return $this->output->set_output(json_encode(['mensagem' => 'Status atualizado']));
        }
    }
}
