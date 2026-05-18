<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Result_model extends CI_Model {
    public function __construct()
    {
        parent::__construct();
    }

    public function all()
    {
        return $this->db->select('r.*, m.group_name, m.home_team, m.away_team, m.home_flag, m.away_flag, m.match_date, m.match_time')
            ->from('results r')
            ->join('matches m', 'm.id = r.match_id', 'left')
            ->order_by('m.match_date', 'asc')
            ->order_by('m.match_time', 'asc')
            ->get()
            ->result_array();
    }

    public function find_by_match($match_id)
    {
        return $this->db->get_where('results', ['match_id' => $match_id])->row_array();
    }

    public function save($match_id, $home_score, $away_score)
    {
        $existing = $this->find_by_match($match_id);
        $data = [
            'match_id' => $match_id,
            'home_score' => $home_score,
            'away_score' => $away_score,
            'updated_at' => date('Y-m-d H:i:s')
        ];

        if ($existing) {
            $this->db->where('match_id', $match_id)->update('results', $data);
            return $existing['id'];
        }

        $this->db->insert('results', $data);
        return $this->db->insert_id();
    }
}
