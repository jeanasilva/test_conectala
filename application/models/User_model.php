<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends CI_Model
{
    protected $table = 'users';

    public function get_all()
    {
        $this->db->select('id, name, email, created_at, updated_at');
        return $this->db->get($this->table)->result_array();
    }

    public function get_by_id($id)
    {
        $this->db->select('id, name, email, created_at, updated_at');
        return $this->db->get_where($this->table, ['id' => (int) $id])->row_array();
    }

    public function get_by_email($email)
    {
        return $this->db->get_where($this->table, ['email' => $email])->row_array();
    }

    public function email_exists($email, $exclude_id = null)
    {
        $this->db->from($this->table);
        $this->db->where('email', $email);
        if ($exclude_id !== null) {
            $this->db->where('id <>', (int) $exclude_id);
        }
        return $this->db->count_all_results() > 0;
    }

    public function insert(array $data)
    {
        $now = date('Y-m-d H:i:s');
        $data['created_at'] = $now;
        $data['updated_at'] = $now;
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }

    public function update($id, array $data)
    {
        $data['updated_at'] = date('Y-m-d H:i:s');
        $this->db->where('id', (int) $id);
        return $this->db->update($this->table, $data);
    }

    public function delete($id)
    {
        return $this->db->delete($this->table, ['id' => (int) $id]);
    }
}
