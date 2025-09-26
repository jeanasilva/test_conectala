<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migrate extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('migration');
        $this->load->config('api', TRUE);
    }

    // Run migrations to latest. Intended for CLI usage, but can be triggered via HTTP if API_KEY provided.
    public function index()
    {
        // If called from web, require API key when configured
        if (!$this->input->is_cli_request()) {
            $required = $this->config->item('api_key', 'api');
            if ($required) {
                $header = $this->input->get_request_header('X-API-Key');
                if (!$header || $header !== $required) {
                    $this->output->set_status_header(401)->set_output(json_encode(['error' => 'Unauthorized']));
                    return;
                }
            }
        }

        if ($this->migration->latest() === FALSE) {
            $message = $this->migration->error_string();
            if ($this->input->is_cli_request()) {
                echo "Migration failed: ".PHP_EOL.$message.PHP_EOL;
            } else {
                $this->output->set_status_header(500)->set_output(json_encode(['error' => $message]));
            }
            return;
        }

        if ($this->input->is_cli_request()) {
            echo "Migrations applied successfully.".PHP_EOL;
        } else {
            $this->output->set_output(json_encode(['message' => 'Migrations applied successfully.']));
        }
    }
}
