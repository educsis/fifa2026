<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_model extends CI_Model {
    public function __construct()
    {
        parent::__construct();
    }

    public function authenticate($username, $password)
    {
        $admin = $this->db->get_where('admin_users', ['username' => $username])->row_array();
        if (!$admin) {
            return false;
        }

        if (password_verify($password, $admin['password_hash'])) {
            return $admin;
        }

        return false;
    }
}
