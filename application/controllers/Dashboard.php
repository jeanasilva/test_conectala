<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {
    public function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $this->load->helper('url');
    }

    public function index()
    {
        if (!$this->session->userdata('user_id')) {
            redirect('auth/login');
        }

        $data['user_name'] = $this->session->userdata('user_name');
        $this->load->view('dashboard/index', $data);
    }
}
