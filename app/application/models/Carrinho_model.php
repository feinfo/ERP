<?php
    class Carrinho_model extends CI_Model {
        
        public function calcularSubtotal($carrinho)
        {
            $subtotal = 0;

            foreach ($carrinho as $item) {
                $subtotal += $item['quantidade'] * $item['preco_unitario'];
            }

            return $subtotal;
        }

        public function calcularFrete($subtotal)
        {
            if ($subtotal > 200) {
                return 0.00;
            } elseif ($subtotal >= 52 && $subtotal <= 166.59) {
                return 15.00;
            } else {
                return 20.00;
            }
        }
        public function calcularDesconto($subtotal, $cupom)
        {
            if (!$cupom) {
                return 0.00;
            }

            if ($cupom['tipo'] === 'percentual') {
                return ($cupom['valor'] / 100) * $subtotal;
            }

            return $cupom['valor'];
        }

    }
    