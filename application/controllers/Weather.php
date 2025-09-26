<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Weather extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Weather_model');
        $this->load->helper('url');
        $this->output->set_content_type('application/json');
        $this->_set_cors_headers();
    }

    // GET /weather/{city}
    public function show($city = null)
    {
        if (!$city) return $this->_respond(['error' => 'Missing city'], 400);

        $city = urldecode($city);
        $row = $this->Weather_model->get_by_city($city);
        if (!$row) return $this->_respond(['error' => 'No data for city'], 404);

        $row['raw'] = json_decode($row['raw'], true);
        return $this->_respond(['data' => $row], 200);
    }

    // POST /weather/fetch/{city}  -> trigger immediate fetch from external API (requires API key in env)
    public function fetch($city = null)
    {
        // Simple trigger; protect with API key if configured
        $required = $this->config->item('api_key', 'api');
        if ($required) {
            $header = $this->input->get_request_header('X-API-Key');
            if (!$header || $header !== $required) return $this->_respond(['error' => 'Unauthorized'], 401);
        }

        if (!$city) return $this->_respond(['error' => 'Missing city'], 400);
        $city = urldecode($city);

        // If WEATHER_API_KEY is present use OpenWeatherMap, otherwise use wttr.in (no API key required)
        $apiKey = getenv('WEATHER_API_KEY') ?: '';
        if ($apiKey) {
            $url = 'https://api.openweathermap.org/data/2.5/weather?q='.urlencode($city).'&appid='.urlencode($apiKey).'&units=metric&lang=pt';
        } else {
            // wttr.in j1 JSON format (no API key required)
            $url = 'https://wttr.in/'.urlencode($city).'?format=j1';
        }

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        $resp = curl_exec($ch);
        $err = curl_error($ch);
        curl_close($ch);

        if ($err) {
            return $this->_respond(['error' => 'External API request failed', 'detail' => $err], 502);
        }

        $json = json_decode($resp, true);
        if (!$json) {
            return $this->_respond(['error' => 'Invalid JSON from weather API', 'detail' => $resp], 502);
        }

        // Normalize response into temperature + description
        $data = ['temperature' => null, 'description' => null, 'raw' => $json];
        if ($apiKey) {
            if (isset($json['cod']) && (int)$json['cod'] !== 200) {
                return $this->_respond(['error' => 'Invalid response from OpenWeatherMap', 'detail' => $json], 502);
            }
            $data['temperature'] = isset($json['main']['temp']) ? $json['main']['temp'] : null;
            $data['description'] = isset($json['weather'][0]['description']) ? $json['weather'][0]['description'] : null;
        } else {
            // wttr.in (j1) structure: current_condition[0].temp_C and current_condition[0].weatherDesc[0].value
            if (isset($json['current_condition'][0])) {
                $cc = $json['current_condition'][0];
                $data['temperature'] = isset($cc['temp_C']) ? (float)$cc['temp_C'] : null;
                if (isset($cc['weatherDesc'][0]['value'])) {
                    $data['description'] = $cc['weatherDesc'][0]['value'];
                }
            }
        }

        $id = $this->Weather_model->insert_or_update($city, $data);
        return $this->_respond(['message' => 'Weather fetched', 'id' => $id], 200);
    }

    private function _respond($data, $status = 200)
    {
        $this->output->set_status_header($status);
        if ($data !== null) $this->output->set_output(json_encode($data));
        return;
    }

    private function _set_cors_headers()
    {
        $this->output
            ->set_header('Access-Control-Allow-Origin: *')
            ->set_header('Access-Control-Allow-Headers: Content-Type, X-API-Key')
            ->set_header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
    }
}
