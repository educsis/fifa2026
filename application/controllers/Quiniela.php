<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Quiniela extends MY_Controller {
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->library(['session', 'form_validation']);
        $this->load->helper(['url', 'form', 'security', 'text']);
        $this->load->model(['Match_model', 'Prediction_model', 'User_model', 'Result_model']);
        $this->load->library('installer');

        if ($this->installer->install_needed()) {
            $this->installer->run();
        }

        if (!$this->session->userdata('user_id')) {
            redirect('auth');
        }
    }

    public function rules()
    {
        $data = [
            'page_title' => 'Reglas de la Quiniela',
            'user_name' => $this->session->userdata('user_name')
        ];

        $this->load->view('layouts/header', $data);
        $this->load->view('auth/rules', $data);
        $this->load->view('layouts/footer', $data);
    }

    public function matches()
    {
        $user_id = $this->session->userdata('user_id');
        $matches = $this->Match_model->grouped_by_date();
        $predictions = $this->Prediction_model->get_map_by_user($user_id);
        $completed = $this->Prediction_model->count_completed($user_id);
        $total = 48;

        $data = [
            'page_title' => 'Pronósticos de Grupo',
            'matches' => $matches,
            'predictions' => $predictions,
            'completed' => $completed,
            'total_matches' => $total,
            'user_name' => $this->session->userdata('user_name')
        ];

        $this->load->view('layouts/header', $data);
        $this->load->view('quiniela/matches', $data);
        $this->load->view('layouts/footer', $data);
    }

    public function save_prediction()
    {
        if ($this->input->server('REQUEST_METHOD') !== 'POST') {
            show_error('Método no permitido', 405);
        }

        $matchId = (int) $this->input->post('match_id', TRUE);
        $homeGoals = $this->input->post('home_goals', TRUE);
        $awayGoals = $this->input->post('away_goals', TRUE);

        $match = $this->Match_model->find($matchId);
        if (!$match) {
            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode(['success' => false, 'message' => 'Partido no encontrado.', 'csrf_hash' => $this->security->get_csrf_hash()]));
            return;
        }

        if ((int) $match['started'] === 1) {
            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode(['success' => false, 'message' => 'Este partido ya inició y no puede modificarse.', 'csrf_hash' => $this->security->get_csrf_hash()]));
            return;
        }

        if (!is_numeric($homeGoals) || !is_numeric($awayGoals) || $homeGoals < 0 || $awayGoals < 0) {
            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode(['success' => false, 'message' => 'Por favor ingresa goles válidos.', 'csrf_hash' => $this->security->get_csrf_hash()]));
            return;
        }

        $homeGoals = (int) $homeGoals;
        $awayGoals = (int) $awayGoals;
        $this->Prediction_model->save($this->session->userdata('user_id'), $matchId, $homeGoals, $awayGoals);

        $completed = $this->Prediction_model->count_completed($this->session->userdata('user_id'));
        $message = 'Pronóstico guardado. ¡Vamos por la gloria!';

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode([ 'success' => true, 'message' => $message, 'completed' => $completed, 'csrf_hash' => $this->security->get_csrf_hash() ]));
    }

    public function leaderboard()
    {
        $data = [
            'page_title' => 'Leaderboard Mundial 2026',
            'leaderboard' => $this->User_model->leaderboard(),
            'user_name' => $this->session->userdata('user_name')
        ];

        $this->load->view('layouts/header', $data);
        $this->load->view('quiniela/leaderboard', $data);
        $this->load->view('layouts/footer', $data);
    }
}
