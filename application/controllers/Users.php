<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('User_model');
        $this->load->helper(['security']);
        $this->load->config('api', TRUE);
        $this->load->library('Token');
        $this->output->set_content_type('application/json');
        $this->_set_cors_headers();
    }

    public function router($id = null)
    {
        $method = $this->input->method(TRUE); // GET, POST, PUT, DELETE, OPTIONS

        if ($method === 'OPTIONS') {
            return $this->_respond(null, 204);
        }

        try {
            switch ($method) {
                case 'GET':
                    if ($id === null) {
                        return $this->index();
                    }
                    return $this->show((int) $id);
                case 'POST':
                    $this->_require_auth();
                    return $this->store();
                case 'PUT':
                    $this->_require_auth();
                    if ($id === null) return $this->_error('Missing resource ID', 400);
                    return $this->update((int) $id);
                case 'DELETE':
                    $this->_require_auth();
                    if ($id === null) return $this->_error('Missing resource ID', 400);
                    return $this->destroy((int) $id);
                default:
                    return $this->_error('Method Not Allowed', 405);
            }
        } catch (Exception $e) {
            log_message('error', 'API error: '.$e->getMessage());
            return $this->_error('Internal Server Error', 500);
        }
    }

    // GET /users
    public function index()
    {
        $users = $this->User_model->get_all();
        return $this->_respond(['data' => $users], 200);
    }

    // GET /users/{id}
    public function show($id)
    {
        $user = $this->User_model->get_by_id($id);
        if (!$user) return $this->_error('User not found', 404);
        return $this->_respond(['data' => $user], 200);
    }

    // POST /users
    public function store()
    {
        $data = $this->_json_input();
        if (!is_array($data)) return $this->_error('Invalid JSON payload', 400);

        $data = $this->security->xss_clean($data);

        $this->form_validation->set_data($data);
        $this->form_validation->set_rules('name', 'Name', 'required|min_length[2]|max_length[100]');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email|max_length[150]');
        $this->form_validation->set_rules('password', 'Password', 'required|min_length[6]|max_length[255]');

        if (!$this->form_validation->run()) {
            return $this->_error($this->form_validation->error_array(), 422);
        }

        if ($this->User_model->email_exists($data['email'])) {
            return $this->_error(['email' => 'Email already in use'], 409);
        }

        $insert = [
            'name'  => $data['name'],
            'email' => $data['email'],
            'password_hash' => password_hash($data['password'], PASSWORD_DEFAULT),
        ];

        $id = $this->User_model->insert($insert);
        return $this->_respond(['message' => 'User created', 'id' => $id], 201);
    }

    // PUT /users/{id}
    public function update($id)
    {
        $existing = $this->User_model->get_by_id($id);
        if (!$existing) return $this->_error('User not found', 404);

        $data = $this->_json_input();
        if (!is_array($data)) return $this->_error('Invalid JSON payload', 400);

        $data = $this->security->xss_clean($data);

        // Build validation selectively (partial update allowed)
        if (array_key_exists('name', $data)) {
            $this->form_validation->set_rules('name', 'Name', 'required|min_length[2]|max_length[100]');
        }
        if (array_key_exists('email', $data)) {
            $this->form_validation->set_rules('email', 'Email', 'required|valid_email|max_length[150]');
        }
        if (array_key_exists('password', $data)) {
            $this->form_validation->set_rules('password', 'Password', 'min_length[6]|max_length[255]');
        }
        $this->form_validation->set_data($data);
        if (!$this->form_validation->run()) {
            return $this->_error($this->form_validation->error_array(), 422);
        }

        if (isset($data['email']) && $this->User_model->email_exists($data['email'], $id)) {
            return $this->_error(['email' => 'Email already in use'], 409);
        }

        $update = [];
        if (isset($data['name'])) $update['name'] = $data['name'];
        if (isset($data['email'])) $update['email'] = $data['email'];
        if (isset($data['password']) && $data['password'] !== '') {
            $update['password_hash'] = password_hash($data['password'], PASSWORD_DEFAULT);
        }

        if (empty($update)) {
            return $this->_respond(['message' => 'Nothing to update'], 200);
        }

        $this->User_model->update($id, $update);
        return $this->_respond(['message' => 'User updated'], 200);
    }

    // DELETE /users/{id}
    public function destroy($id)
    {
        $existing = $this->User_model->get_by_id($id);
        if (!$existing) return $this->_error('User not found', 404);

        $this->User_model->delete($id);
        return $this->_respond(['message' => 'User deleted'], 200);
    }

    // Helpers
    private function _json_input()
    {
        $raw = $this->input->raw_input_stream;
        if (!$raw) return [];
        $data = json_decode($raw, true);
        return $data;
    }

    private function _respond($data, $status = 200)
    {
        $this->output->set_status_header($status);
        if ($data !== null) {
            $this->output->set_output(json_encode($data));
        }
        return; // CI handles final output
    }

    private function _error($message, $status)
    {
        return $this->_respond(['error' => $message], $status);
    }

    private function _require_auth()
    {
        // 1) JWT Bearer
        $auth = $this->input->get_request_header('Authorization');
        if ($auth && stripos($auth, 'Bearer ') === 0) {
            $jwt = trim(substr($auth, 7));
            $payload = $this->token->decode($jwt);
            if ($payload) return; // ok
        }

        // 2) X-API-Key fallback
        $required = $this->config->item('api_key', 'api');
        if ($required) {
            $headerKey = $this->input->get_request_header('X-API-Key');
            if ($headerKey && hash_equals($required, $headerKey)) return; // ok
        }

        $this->_error('Unauthorized', 401);
        exit;
    }

    private function _set_cors_headers()
    {
        $this->output
            ->set_header('Access-Control-Allow-Origin: *')
            ->set_header('Access-Control-Allow-Headers: Content-Type, X-API-Key')
            ->set_header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
    }
}
