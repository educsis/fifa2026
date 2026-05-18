<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends CI_Model {
    public function __construct()
    {
        parent::__construct();
    }

    public function find_by_email($email)
    {
        return $this->db->get_where('users', ['email' => $email])->row_array();
    }

    public function get($id)
    {
        return $this->db->get_where('users', ['id' => $id])->row_array();
    }

    public function create($name, $email)
    {
        $data = [
            'name' => $name,
            'email' => $email,
            'created_at' => date('Y-m-d H:i:s')
        ];

        $this->db->insert('users', $data);
        return $this->db->insert_id();
    }

    public function all()
    {
        return $this->db->order_by('name', 'asc')->get('users')->result_array();
    }

    public function leaderboard()
    {
        $users = $this->db->select('id, name, email')->from('users')->order_by('name')->get()->result_array();
        $predictions = $this->db->select('user_id, match_id, home_goals, away_goals')->from('predictions')->get()->result_array();
        $results = $this->db->select('match_id, home_score, away_score')->from('results')->get()->result_array();

        $resultsByMatch = [];
        foreach ($results as $result) {
            $resultsByMatch[$result['match_id']] = $result;
        }

        $stats = [];
        foreach ($users as $user) {
            $stats[$user['id']] = [
                'name' => $user['name'],
                'points' => 0,
                'exacts' => 0,
                'predictions' => 0,
                'accuracy' => 0,
                'position_change' => 0
            ];
        }

        foreach ($predictions as $prediction) {
            if (!isset($stats[$prediction['user_id']])) {
                continue;
            }

            $stats[$prediction['user_id']]['predictions']++;
            $matchResult = isset($resultsByMatch[$prediction['match_id']]) ? $resultsByMatch[$prediction['match_id']] : null;
            if (!$matchResult || $matchResult['home_score'] === null || $matchResult['away_score'] === null) {
                continue;
            }

            $predictionScore = $this->calculate_score($prediction['home_goals'], $prediction['away_goals'], $matchResult['home_score'], $matchResult['away_score']);
            $stats[$prediction['user_id']]['points'] += $predictionScore;
            if ($predictionScore === 5) {
                $stats[$prediction['user_id']]['exacts']++;
            }
        }

        foreach ($stats as &$item) {
            $item['accuracy'] = $item['predictions'] ? round(($item['exacts'] / $item['predictions']) * 100, 1) : 0;
        }
        unset($item);

        usort($stats, function ($a, $b) {
            if ($a['points'] === $b['points']) {
                return $b['exacts'] <=> $a['exacts'];
            }
            return $b['points'] <=> $a['points'];
        });

        $position = 1;
        foreach ($stats as &$item) {
            $item['position'] = $position++;
        }
        unset($item);

        return $stats;
    }

    public function recalculate_leaderboard()
    {
        return $this->leaderboard();
    }

    public function calculate_score($homePredict, $awayPredict, $homeResult, $awayResult)
    {
        if ($homePredict === null || $awayPredict === null) {
            return 0;
        }

        if ($homePredict == $homeResult && $awayPredict == $awayResult) {
            return 5;
        }

        $predictResult = $this->compare_result($homePredict, $awayPredict);
        $realResult = $this->compare_result($homeResult, $awayResult);

        return $predictResult === $realResult ? 2 : 0;
    }

    protected function compare_result($home, $away)
    {
        if ($home === $away) {
            return 'draw';
        }
        return $home > $away ? 'home' : 'away';
    }
}
