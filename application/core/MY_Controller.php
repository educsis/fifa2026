<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Controller extends CI_Controller {
    public function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $this->load->helper('language');

        $siteLang = $this->session->userdata('site_lang');
        if (!$siteLang) {
            $siteLang = 'es';
            $this->session->set_userdata('site_lang', $siteLang);
        }

        $ciLang = $siteLang === 'en' ? 'english' : 'spanish';
        $this->lang->load('app', $ciLang);
    }
}
