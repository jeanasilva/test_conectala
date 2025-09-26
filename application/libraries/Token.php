<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Token
{
    protected $secret;

    public function __construct()
    {
        $this->secret = getenv('JWT_SECRET') ?: getenv('ENCRYPTION_KEY');
    }

    public function is_ready()
    {
        return !empty($this->secret);
    }

    public function encode(array $payload, $ttlSeconds = 3600)
    {
        $header = ['typ' => 'JWT', 'alg' => 'HS256'];
        $now = time();
        $payload['iat'] = $payload['iat'] ?? $now;
        $payload['exp'] = $payload['exp'] ?? ($now + $ttlSeconds);

        $segments = [
            $this->b64(json_encode($header)),
            $this->b64(json_encode($payload)),
        ];
        $signing_input = implode('.', $segments);
        $signature = hash_hmac('sha256', $signing_input, $this->secret, true);
        $segments[] = $this->b64($signature);
        return implode('.', $segments);
    }

    public function decode($token)
    {
        $parts = explode('.', $token);
        if (count($parts) !== 3) return null;
        list($h, $p, $s) = $parts;
        $payload = json_decode($this->ub64($p), true);
        if (!is_array($payload)) return null;

        // Verify signature
        $signing_input = $h.'.'.$p;
        $expected = $this->b64(hash_hmac('sha256', $signing_input, $this->secret, true));
        if (!hash_equals($expected, $s)) return null;

        // Verify exp
        if (isset($payload['exp']) && time() >= (int) $payload['exp']) {
            return null;
        }
        return $payload;
    }

    private function b64($data)
    {
        return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
    }

    private function ub64($data)
    {
        $remainder = strlen($data) % 4;
        if ($remainder) {
            $padlen = 4 - $remainder;
            $data .= str_repeat('=', $padlen);
        }
        return base64_decode(strtr($data, '-_', '+/'));
    }
}

