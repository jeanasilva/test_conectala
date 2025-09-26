<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('User_model');
        $this->load->library('Token');
        $this->load->library('form_validation');
        // don't force JSON content type here because this controller
        // serves both API endpoints and HTML views for the UI.
        $this->load->library('session');
        $this->_set_cors_headers();
    }

    // GET shows registration form; POST creates user (supports form POST and JSON API)
    public function register()
    {
        if ($this->input->method(TRUE) === 'OPTIONS') return $this->_respond(null, 204);

        if ($this->input->method(TRUE) === 'GET') {
            // show UI registration form
            $this->load->view('auth/register');
            return;
        }

        if ($this->input->method(TRUE) !== 'POST') return $this->_error('Method Not Allowed', 405);

        // accept JSON payloads (API) or form-encoded POST (UI)
        $content_type = $this->input->get_request_header('Content-Type');
        if (!$content_type) $content_type = $this->input->server('CONTENT_TYPE');
        if ($content_type && stripos($content_type, 'application/json') !== false) {
            $body = $this->_json_input();
        } else {
            $body = [
                'name' => $this->input->post('name'),
                'email' => $this->input->post('email'),
                'password' => $this->input->post('password'),
            ];
        }

        $body = $this->security->xss_clean($body);
        if (!is_array($body)) return $this->_error('Invalid payload', 400);

        $this->form_validation->set_data($body);
        $this->form_validation->set_rules('name', 'Name', 'required|min_length[2]|max_length[100]');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email|max_length[150]');
        $this->form_validation->set_rules('password', 'Password', 'required|min_length[6]|max_length[255]');
        if (!$this->form_validation->run()) {
            // If it's a form request, show view with errors
            if ($this->input->post()) {
                $data['error'] = implode('<br>', $this->form_validation->error_array());
                $this->load->view('auth/register', $data);
                return;
            }
            return $this->_error($this->form_validation->error_array(), 422);
        }

        if ($this->User_model->email_exists($body['email'])) {
            if ($this->input->post()) {
                $data['error'] = 'Email já em uso';
                $this->load->view('auth/register', $data);
                return;
            }
            return $this->_error(['email' => 'Email already in use'], 409);
        }

        $id = $this->User_model->insert([
            'name' => $body['name'],
            'email' => $body['email'],
            'password_hash' => password_hash($body['password'], PASSWORD_DEFAULT),
        ]);

        // If form POST (UI), create session and redirect to dashboard
        if ($this->input->post()) {
            $this->session->set_userdata('user_id', $id);
            $this->session->set_userdata('user_name', $body['name']);
            header('Location: /index.php/dashboard', true, 303);
            exit;
        }

        // API flow: return token or basic response
        if (!$this->token->is_ready()) {
            return $this->_respond(['message' => 'Registered', 'id' => $id], 201);
        }

        $token = $this->token->encode(['sub' => $id, 'email' => $body['email']], 86400);
        return $this->_respond(['message' => 'Registered', 'id' => $id, 'token' => $token], 201);
    }

    // GET shows login form; POST authenticates (supports form POST and JSON API)
    public function login()
    {
        if ($this->input->method(TRUE) === 'OPTIONS') return $this->_respond(null, 204);

        if ($this->input->method(TRUE) === 'GET') {
            $this->load->view('auth/login');
            return;
        }

        if ($this->input->method(TRUE) !== 'POST') return $this->_error('Method Not Allowed', 405);

        // allow JSON API or form post
        $content_type = $this->input->get_request_header('Content-Type');
        if (!$content_type) $content_type = $this->input->server('CONTENT_TYPE');
        if ($content_type && stripos($content_type, 'application/json') !== false) {
            $body = $this->_json_input();
        } else {
            $body = [
                'email' => $this->input->post('email'),
                'password' => $this->input->post('password'),
            ];
        }

        $body = $this->security->xss_clean($body);
        if (!is_array($body)) return $this->_error('Invalid payload', 400);

        $this->form_validation->set_data($body);
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
        $this->form_validation->set_rules('password', 'Password', 'required');
        if (!$this->form_validation->run()) {
            if ($this->input->post()) {
                $data['error'] = implode('<br>', $this->form_validation->error_array());
                $this->load->view('auth/login', $data);
                return;
            }
            return $this->_error($this->form_validation->error_array(), 422);
        }

        $user = $this->User_model->get_by_email($body['email']);
        if (!$user || !password_verify($body['password'], $user['password_hash'])) {
            if ($this->input->post()) {
                $data['error'] = 'Credenciais inválidas';
                $this->load->view('auth/login', $data);
                return;
            }
            return $this->_error('Invalid credentials', 401);
        }

        // form POST: set session and redirect
        if ($this->input->post()) {
            $this->session->set_userdata('user_id', $user['id']);
            $this->session->set_userdata('user_name', $user['name']);
            header('Location: /index.php/dashboard', true, 303);
            exit;
        }

        // API flow: token or basic response
        if (!$this->token->is_ready()) {
            return $this->_respond(['message' => 'Authenticated', 'user' => [
                'id' => $user['id'], 'name' => $user['name'], 'email' => $user['email'],
            ]], 200);
        }

        $token = $this->token->encode(['sub' => $user['id'], 'email' => $user['email']], 86400);
        return $this->_respond(['token' => $token, 'user' => [
            'id' => $user['id'], 'name' => $user['name'], 'email' => $user['email'],
        ]], 200);
    }

    // Logout for UI
    public function logout()
    {
        $this->session->sess_destroy();
        header('Location: /index.php', true, 303);
        exit;
    }

    // GET /auth/me
    public function me()
    {
        if ($this->input->method(TRUE) === 'OPTIONS') return $this->_respond(null, 204);
        $auth = $this->_bearer_user();
        if (!$auth) return $this->_error('Unauthorized', 401);
        $user = $this->User_model->get_by_id($auth['sub']);
        if (!$user) return $this->_error('User not found', 404);
        return $this->_respond(['user' => $user], 200);
    }

    private function _bearer_user()
    {
        $header = $this->input->get_request_header('Authorization');
        if (!$header || stripos($header, 'Bearer ') !== 0) return null;
        $jwt = trim(substr($header, 7));
        if (!$jwt) return null;
        $payload = $this->token->decode($jwt);
        return $payload;
    }

    private function _json_input()
    {
        $raw = $this->input->raw_input_stream;
        if (!$raw) return [];
        return json_decode($raw, true);
    }

    private function _respond($data, $status = 200)
    {
        $this->output->set_status_header($status);
        if ($data !== null) {
            $this->output->set_output(json_encode($data));
        }
        return;
    }

    private function _error($message, $status)
    {
        return $this->_respond(['error' => $message], $status);
    }

    private function _set_cors_headers()
    {
        $this->output
            ->set_header('Access-Control-Allow-Origin: *')
            ->set_header('Access-Control-Allow-Headers: Content-Type, Authorization, X-API-Key')
            ->set_header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
    }
}
