<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Weather_model extends CI_Model
{
    protected $table = 'weather';

    public function insert_or_update($city, $data)
    {
        $now = date('Y-m-d H:i:s');
        $row = $this->get_by_city($city);
        $payload = [
            'city' => $city,
            'temperature' => isset($data['temperature']) ? $data['temperature'] : null,
            'description' => isset($data['description']) ? $data['description'] : null,
            'raw' => json_encode($data),
            'fetched_at' => $now,
        ];

        if ($row) {
            $this->db->where('id', $row['id']);
            $this->db->update($this->table, $payload);
            return $row['id'];
        }

        $this->db->insert($this->table, $payload);
        return $this->db->insert_id();
    }

    public function get_by_city($city)
    {
        return $this->db->get_where($this->table, ['city' => $city])->row_array();
    }
}
