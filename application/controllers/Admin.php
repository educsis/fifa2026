<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends MY_Controller {
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->library(['session', 'form_validation']);
        $this->load->helper(['url', 'form', 'security', 'text']);
        $this->load->model(['Admin_model', 'Match_model', 'Result_model', 'User_model', 'Prediction_model']);
        $this->load->library('installer');

        if ($this->installer->install_needed()) {
            $this->installer->run();
        }
    }

    public function login()
    {
        if ($this->session->userdata('admin_logged_in')) {
            redirect('admin/dashboard');
        }

        $data = ['page_title' => 'Panel Admin Quiniela'];
        $this->load->view('layouts/header', $data);
        $this->load->view('admin/login', $data);
        $this->load->view('layouts/footer', $data);
    }

    public function authenticate()
    {
        $this->form_validation->set_rules('username', 'Usuario', 'trim|required|xss_clean');
        $this->form_validation->set_rules('password', 'Contraseña', 'trim|required|xss_clean');

        if ($this->form_validation->run() === FALSE) {
            $data = [ 'page_title' => 'Panel Admin Quiniela', 'errors' => $this->form_validation->error_array() ];
            $this->load->view('layouts/header', $data);
            $this->load->view('admin/login', $data);
            $this->load->view('layouts/footer', $data);
            return;
        }

        $username = $this->input->post('username', TRUE);
        $password = $this->input->post('password', TRUE);
        $admin = $this->Admin_model->authenticate($username, $password);

        if (!$admin) {
            $this->session->set_flashdata('global_alert', 'Usuario o contraseña incorrectos.');
            redirect('admin/login');
            return;
        }

        $this->session->set_userdata(['admin_logged_in' => true, 'admin_username' => $admin['username']]);
        redirect('admin/dashboard');
    }

    public function dashboard()
    {
        $this->ensure_admin();
        $totalUsers = $this->User_model->all();
        $totalMatches = count($this->Match_model->all());
        $results = $this->Result_model->all();
        $leaderboard = $this->User_model->leaderboard();

        $data = [
            'page_title' => 'Admin Dashboard',
            'users_count' => count($totalUsers),
            'matches_count' => $totalMatches,
            'results_count' => count($results),
            'top_users' => array_slice($leaderboard, 0, 5)
        ];

        $this->load->view('layouts/header', $data);
        $this->load->view('admin/dashboard', $data);
        $this->load->view('layouts/footer', $data);
    }

    public function results()
    {
        $this->ensure_admin();
        $matches = $this->Match_model->all();
        $results = [];
        foreach ($matches as $match) {
            $results[$match['id']] = $this->Result_model->find_by_match($match['id']);
        }

        $data = [
            'page_title' => 'Resultados Reales',
            'matches' => $matches,
            'results' => $results
        ];

        $this->load->view('layouts/header', $data);
        $this->load->view('admin/results', $data);
        $this->load->view('layouts/footer', $data);
    }

    public function save_results()
    {
        $this->ensure_admin();

        $matches = $this->input->post('match', TRUE);
        if (!is_array($matches)) {
            $this->session->set_flashdata('global_alert', 'No se encontraron resultados válidos.');
            redirect('admin/results');
            return;
        }

        foreach ($matches as $matchId => $result) {
            $homeRaw = isset($result['home']) ? $result['home'] : null;
            $awayRaw = isset($result['away']) ? $result['away'] : null;
            if ($homeRaw === '' && $awayRaw === '') {
                continue;
            }
            if ($homeRaw === null || $awayRaw === null || !is_numeric($homeRaw) || !is_numeric($awayRaw)) {
                continue;
            }
            $home = (int) $homeRaw;
            $away = (int) $awayRaw;
            if ($home < 0 || $away < 0) {
                continue;
            }
            $this->Result_model->save($matchId, $home, $away);
        }

        // Recalculate leaderboard points after updating real match results.
        $this->User_model->recalculate_leaderboard();

        $this->session->set_flashdata('global_alert', 'Resultados reales actualizados. Se han recalculado los puntos de las personas que ingresaron pronósticos.');
        redirect('admin/results');
    }

    public function logout()
    {
        $this->session->unset_userdata(['admin_logged_in', 'admin_username']);
        $this->session->sess_destroy();
        redirect('admin/login');
    }

    protected function ensure_admin()
    {
        if (!$this->session->userdata('admin_logged_in')) {
            redirect('admin/login');
        }
    }
}
