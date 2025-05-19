<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class AclHook {
    public function verificar_acesso() {
        if (!function_exists('check_acl')) {
            require_once APPPATH . 'helpers/acl_helper.php';
        }

        check_acl(); 
    }
}
