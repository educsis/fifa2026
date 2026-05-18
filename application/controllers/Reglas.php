<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Reglas extends CI_Controller {
	public function __construct()
    {
        parent::__construct();
        $this->load->helper(['url', 'form', 'security', 'text']);
		$this->load->library(['session', 'form_validation']);
        $this->load->library('installer');

        if ($this->installer->install_needed()) {
            $this->installer->run();
        }
    }

	public function index()
	{
		// die($this->config->item('language'));
		$data = [
            'page_title' => 'Reglas de la Quiniela',
            'user_name' => 'No usuario'
        ];

        $this->load->view('layouts/header', $data);
        $this->load->view('auth/rules', $data);
        $this->load->view('layouts/footer', $data);
	}
}
