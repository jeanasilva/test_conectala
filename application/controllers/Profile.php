<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Profile extends CI_Controller {
    public function __construct()
    {
        parent::__construct();
        $this->load->library(['session','form_validation']);
        $this->load->helper(['url','form']);
        $this->load->model('User_model');
    }

    public function index()
    {
        if (!$this->session->userdata('user_id')) redirect('auth/login');

        $user = $this->User_model->get_by_id($this->session->userdata('user_id'));
        $this->load->view('profile/view', ['user' => $user]);
    }

    public function edit()
    {
        if (!$this->session->userdata('user_id')) redirect('auth/login');

        $userId = $this->session->userdata('user_id');
        $user = $this->User_model->get_by_id($userId);

        $this->form_validation->set_rules('name', 'Name', 'required|min_length[2]');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email');

        if ($this->form_validation->run() === FALSE) {
            $this->load->view('profile/edit', ['user' => $user]);
            return;
        }

        $update = ['name' => $this->input->post('name'), 'email' => $this->input->post('email')];
        if ($this->input->post('password')) {
            $update['password_hash'] = password_hash($this->input->post('password'), PASSWORD_DEFAULT);
        }

        $this->User_model->update($userId, $update);
        $this->session->set_userdata('user_name', $update['name']);
        redirect('profile');
    }
}
