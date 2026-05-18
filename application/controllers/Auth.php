<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends MY_Controller {
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->library('form_validation');
        $this->load->helper(['url', 'form', 'security']);
        $this->load->model(['User_model', 'Prediction_model']);
        $this->load->library('installer');

        if ($this->installer->install_needed()) {
            $this->installer->run();
        }
    }

    public function index()
    {
        if ($this->session->userdata('user_id')) {
            redirect('rules');
        }

        $data = [
            'page_title' => lang('page_title_auth'),
            'register_errors' => [],
            'login_errors' => [],
        ];

        $this->load->view('layouts/header', $data);
        $this->load->view('auth/login', $data);
        $this->load->view('layouts/footer', $data);
    }

    public function register_submit()
    {
        $this->form_validation->set_rules('name', lang('auth_name_label'), 'trim|required|min_length[3]|max_length[80]|xss_clean');
        $this->form_validation->set_rules('email', lang('auth_email_label'), 'trim|required|valid_email|callback_corporate_email_check|xss_clean');

        $data = [
            'page_title' => lang('page_title_auth'),
            'register_errors' => [],
            'login_errors' => [],
        ];

        if ($this->form_validation->run() === FALSE) {
            $data['register_errors'] = $this->form_validation->error_array();
            $this->load->view('layouts/header', $data);
            $this->load->view('auth/login', $data);
            $this->load->view('layouts/footer', $data);
            return;
        }

        $name = $this->input->post('name', TRUE);
        $email = strtolower($this->input->post('email', TRUE));
        $user = $this->User_model->find_by_email($email);

        if ($user) {
            $this->session->set_flashdata('global_alert', lang('register_exists'));
            redirect('auth');
            return;
        }

        $user_id = $this->User_model->create($name, $email);
        $this->session->set_userdata(['user_id' => $user_id, 'user_name' => $name]);
        $this->session->set_flashdata('global_alert', lang('user_created'));
        redirect('rules');
    }

    public function login_submit()
    {
        $this->form_validation->set_rules('email', lang('auth_email_label'), 'trim|required|valid_email|callback_corporate_email_check|xss_clean');

        $data = [
            'page_title' => lang('page_title_auth'),
            'register_errors' => [],
            'login_errors' => [],
        ];

        if ($this->form_validation->run() === FALSE) {
            $data['login_errors'] = $this->form_validation->error_array();
            $this->load->view('layouts/header', $data);
            $this->load->view('auth/login', $data);
            $this->load->view('layouts/footer', $data);
            return;
        }

        $email = strtolower($this->input->post('email', TRUE));
        $user = $this->User_model->find_by_email($email);

        if (!$user) {
            $data['login_errors'] = ['email' => lang('login_invalid_email')];
            $this->load->view('layouts/header', $data);
            $this->load->view('auth/login', $data);
            $this->load->view('layouts/footer', $data);
            return;
        }

        $this->session->set_userdata(['user_id' => $user['id'], 'user_name' => $user['name']]);
        $completed = $this->Prediction_model->count_completed($user['id']);
        $missing = max(0, 48 - $completed);
        if ($missing > 0) {
            $this->session->set_flashdata('score_reminder', sprintf('Aún te faltan %d resultados por ingresar.', $missing));
        }
        $this->session->set_flashdata('global_alert', lang('welcome_back'));
        redirect('rules');
    }

    public function corporate_email_check($email)
    {
        if (stripos($email, '@evoluteinc.com') === false) {
            $this->form_validation->set_message('corporate_email_check', lang('auth_valid_domain'));
            return false;
        }
        return true;
    }

    public function logout()
    {
        $siteLang = $this->session->userdata('site_lang');
        $this->session->sess_destroy();
        if ($siteLang) {
            $this->session->set_userdata('site_lang', $siteLang);
        }
        $this->session->set_flashdata('global_alert', lang('logout_success'));
        redirect();
    }
}
