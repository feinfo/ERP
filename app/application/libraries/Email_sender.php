<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Email_sender {

    protected $CI;

    public function __construct() {
        $this->CI =& get_instance();

        $this->CI->load->library('email');
        $this->CI->email->initialize([
            'protocol'    => 'smtp',
            'smtp_host'   => getenv('smtp_host'),
            'smtp_port'   => 587,
            'smtp_user'   => getenv('SES_SMTP_USER'),
            'smtp_pass'   => getenv('SES_SMTP_PASS'),
            'smtp_crypto' => 'tls',
            'mailtype'    => 'html',
            'charset'     => 'utf-8',
            'newline'     => "\r\n",
            'crlf'        => "\r\n",
        ]);
    }

    public function enviar($para, $assunto, $mensagem, $de = 'noreply@techbuilders.com.br', $nomeDe = 'TechBuilders') {
        $this->CI->email->from($de, $nomeDe);
        $this->CI->email->to($para);
        $this->CI->email->subject($assunto);
        $this->CI->email->message($mensagem);

        return $this->CI->email->send();
    }
}
