<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Match_model extends CI_Model {
    public function __construct()
    {
        parent::__construct();
    }

    public function all()
    {
        return $this->db->order_by('match_date', 'asc')->order_by('match_time', 'asc')->get('matches')->result_array();
    }

    public function grouped_by_date()
    {
        $matches = $this->all();
        $grouped = [];
        foreach ($matches as $match) {
            $grouped[$match['match_date']][] = $match;
        }
        return $grouped;
    }

    public function find($id)
    {
        return $this->db->get_where('matches', ['id' => $id])->row_array();
    }
}
