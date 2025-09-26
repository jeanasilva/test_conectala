<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Docs extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        header('Content-Type: text/html; charset=utf-8');
        $specUrl = site_url('docs/openapi.json');
        echo '<!doctype html><html><head><meta charset="utf-8"><title>API Docs</title>';
        echo '<link rel="stylesheet" href="https://unpkg.com/swagger-ui-dist@5/swagger-ui.css">';
        echo '</head><body><div id="swagger"></div>';
        echo '<script src="https://unpkg.com/swagger-ui-dist@5/swagger-ui-bundle.js"></script>';
        echo '<script>window.ui = SwaggerUIBundle({ url: "'.$specUrl.'", dom_id: "#swagger" });</script>';
        echo '</body></html>';
    }

    public function openapi()
    {
        $this->output->set_content_type('application/json');
        $base = rtrim(site_url(), '/');
        $spec = [
            'openapi' => '3.0.3',
            'info' => [
                'title' => 'Users API (CodeIgniter 3)',
                'version' => '1.0.0',
            ],
            'servers' => [['url' => $base]],
            'paths' => [
                '/users' => [
                    'get' => [
                        'summary' => 'List users',
                        'responses' => ['200' => ['description' => 'OK']],
                    ],
                    'post' => [
                        'summary' => 'Create user',
                        'security' => [['bearerAuth' => []], ['apiKeyAuth' => []]],
                        'requestBody' => [
                            'required' => true,
                            'content' => [
                                'application/json' => [
                                    'schema' => [
                                        'type' => 'object',
                                        'required' => ['name', 'email', 'password'],
                                        'properties' => [
                                            'name' => ['type' => 'string'],
                                            'email' => ['type' => 'string', 'format' => 'email'],
                                            'password' => ['type' => 'string'],
                                        ]
                                    ]
                                ]
                            ]
                        ],
                        'responses' => ['201' => ['description' => 'Created']]
                    ],
                ],
                '/users/{id}' => [
                    'get' => [
                        'summary' => 'Get user',
                        'parameters' => [[
                            'name' => 'id', 'in' => 'path', 'required' => true, 'schema' => ['type' => 'integer']
                        ]],
                        'responses' => ['200' => ['description' => 'OK'], '404' => ['description' => 'Not Found']]
                    ],
                    'put' => [
                        'summary' => 'Update user',
                        'security' => [['bearerAuth' => []], ['apiKeyAuth' => []]],
                        'parameters' => [[
                            'name' => 'id', 'in' => 'path', 'required' => true, 'schema' => ['type' => 'integer']
                        ]],
                        'requestBody' => [
                            'required' => true,
                            'content' => [
                                'application/json' => [
                                    'schema' => [
                                        'type' => 'object',
                                        'properties' => [
                                            'name' => ['type' => 'string'],
                                            'email' => ['type' => 'string', 'format' => 'email'],
                                            'password' => ['type' => 'string'],
                                        ]
                                    ]
                                ]
                            ]
                        ],
                        'responses' => ['200' => ['description' => 'Updated']]
                    ],
                    'delete' => [
                        'summary' => 'Delete user',
                        'security' => [['bearerAuth' => []], ['apiKeyAuth' => []]],
                        'parameters' => [[
                            'name' => 'id', 'in' => 'path', 'required' => true, 'schema' => ['type' => 'integer']
                        ]],
                        'responses' => ['200' => ['description' => 'Deleted']]
                    ]
                ],
                '/auth/register' => [
                    'post' => [
                        'summary' => 'Register',
                        'requestBody' => [
                            'required' => true,
                            'content' => [
                                'application/json' => [
                                    'schema' => [
                                        'type' => 'object',
                                        'required' => ['name', 'email', 'password'],
                                        'properties' => [
                                            'name' => ['type' => 'string'],
                                            'email' => ['type' => 'string', 'format' => 'email'],
                                            'password' => ['type' => 'string']
                                        ]
                                    ]
                                ]
                            ]
                        ],
                        'responses' => ['201' => ['description' => 'Registered']]
                    ]
                ],
                '/auth/login' => [
                    'post' => [
                        'summary' => 'Login',
                        'requestBody' => [
                            'required' => true,
                            'content' => [
                                'application/json' => [
                                    'schema' => [
                                        'type' => 'object',
                                        'required' => ['email', 'password'],
                                        'properties' => [
                                            'email' => ['type' => 'string', 'format' => 'email'],
                                            'password' => ['type' => 'string']
                                        ]
                                    ]
                                ]
                            ]
                        ],
                        'responses' => ['200' => ['description' => 'OK'], '401' => ['description' => 'Unauthorized']]
                    ]
                ],
                '/auth/me' => [
                    'get' => [
                        'summary' => 'Current user',
                        'security' => [['bearerAuth' => []]],
                        'responses' => ['200' => ['description' => 'OK'], '401' => ['description' => 'Unauthorized']]
                    ]
                ]
            ],
            'components' => [
                'securitySchemes' => [
                    'bearerAuth' => [ 'type' => 'http', 'scheme' => 'bearer', 'bearerFormat' => 'JWT' ],
                    'apiKeyAuth' => [ 'type' => 'apiKey', 'in' => 'header', 'name' => 'X-API-Key' ]
                ]
            ]
        ];
        $this->output->set_output(json_encode($spec));
    }
}

