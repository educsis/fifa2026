<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Installer {
    protected $CI;

    public function __construct()
    {
        $this->CI =& get_instance();
        $this->CI->load->database();
    }

    public function install_needed()
    {
        return !$this->CI->db->table_exists('users');
    }

    public function run()
    {
        $path = APPPATH . 'database/seed.sql';
        if (!is_file($path)) {
            return;
        }

        $sql = file_get_contents($path);
        $statements = preg_split('/;\s*\n/', trim($sql));

        foreach ($statements as $statement) {
            $statement = trim($statement);
            if (empty($statement)) {
                continue;
            }

            $this->CI->db->query($statement);
        }

        $this->ensure_admin();
    }

    protected function ensure_admin()
    {
        $admin = $this->CI->db->get_where('admin_users', ['username' => 'admin'])->row_array();
        if ($admin) {
            return;
        }

        $this->CI->db->insert('admin_users', [
            'username' => 'admin',
            'password_hash' => password_hash('Evolute2026!', PASSWORD_BCRYPT),
            'created_at' => date('Y-m-d H:i:s')
        ]);
    }
}
