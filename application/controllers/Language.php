<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Language extends CI_Controller {
    public function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $this->load->helper('url');
    }

    public function set($lang = 'es')
    {
        $allowed = [
            'es' => 'es',
            'en' => 'en'
        ];

        $selected = isset($allowed[$lang]) ? $allowed[$lang] : 'es';
        $this->session->set_userdata('site_lang', $selected);

        $referrer = $this->input->server('HTTP_REFERER');
        if ($referrer) {
            redirect($referrer);
        }

        redirect();
    }
}
