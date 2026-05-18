<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Prediction_model extends CI_Model {
    public function __construct()
    {
        parent::__construct();
    }

    public function get_by_user($user_id)
    {
        return $this->db->get_where('predictions', ['user_id' => $user_id])->result_array();
    }

    public function get_map_by_user($user_id)
    {
        $rows = $this->get_by_user($user_id);
        $map = [];
        foreach ($rows as $row) {
            $map[$row['match_id']] = $row;
        }
        return $map;
    }

    public function save($user_id, $match_id, $home_goals, $away_goals)
    {
        $existing = $this->db->get_where('predictions', ['user_id' => $user_id, 'match_id' => $match_id])->row_array();
        $data = [
            'user_id' => $user_id,
            'match_id' => $match_id,
            'home_goals' => $home_goals,
            'away_goals' => $away_goals,
            'updated_at' => date('Y-m-d H:i:s')
        ];

        if ($existing) {
            $this->db->where('id', $existing['id'])->update('predictions', $data);
            return $existing['id'];
        }

        $this->db->insert('predictions', $data);
        return $this->db->insert_id();
    }

    public function count_completed($user_id)
    {
        return $this->db->where('user_id', $user_id)->count_all_results('predictions');
    }
}
