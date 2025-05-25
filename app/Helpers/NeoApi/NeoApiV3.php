<?php

namespace App\Helpers\NeoApi;

class NeoApiV3
{
    private $api_key;
    private $api_version;
    private $use_ssl;
    private $host;
    private $debug;
    private $port;

    public function __construct($attributes)
    {
        $this->host = $attributes["host"];
        $this->api_key = $attributes["api_key"];
        $this->api_version = $attributes["api_version"];
        $this->use_ssl = $attributes["use_ssl"];
        $this->debug = $attributes["debug"] ?? false;
        $this->port = $attributes["port"] ?? ($this->use_ssl ? 443 : 80);
    }

    private function get($method, $args = [])
    {
        if (strlen($this->api_key)) {
            $args["api_key"] = $this->api_key;
        }
        if (strlen($this->api_version)) {
            $args["api_version"] = $this->api_version;
        }

        $parts = [];
        foreach ($args as $key => $value) {
            if (is_array($value)) {
                foreach ($value as $part) {
                    $parts[] = urlencode($key) . "[]=" . urlencode($part);
                }
            } else {
                $parts[] = urlencode($key) . "=" . urlencode($value);
            }
        }

        $path = ($this->use_ssl ? "https://" : "http://") .
                $this->host .
                "/api/v3/" .
                $method .
                "?" .
                implode("&", $parts);

        if ($this->debug) {
            $path;
        }

        $result = file_get_contents($path);
        return json_decode($result);
    }

    public function to_array($ids)
    {
        return is_array($ids) ? $ids : explode(",", $ids);
    }

    private function to_json_string($array)
    {
        $string = "";
        foreach ($array as $key => $value) {
            $string .= ', "' . (string) $key . '": "' . (string) $value . '"';
        }
        return "{" . ltrim($string, ', ') . "}";
    }

    public function get_all_users(arry $constraints)
    {
        return $this->get("users", $constraints);
    }

    public function get_all_organization(array $constraints)
    {
        return $this->get("organizations", $constraints);
    }
    public function get_users_by_organization(int $id, array $constraints)
    {
        return $this->get("organizations/{$id}/users", $constraints);
    }
    public function get_classes_by_organization(int $id, array $constraints)
    {
        return $this->get("organizations/{$id}/classes", $constraints);
    }
}
