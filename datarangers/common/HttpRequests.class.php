<?php


namespace DataRangers;


class HttpRequests
{
    public static function do($method, $url, $headers, $params, $body, $timeout = 120)
    {
        $method = strtoupper($method);
        if ($params != null) $url = $url . HttpRequests::formatParams($params);
        $options = array(
            "http" => array(
                "method" => $method,
                'timeout' => $timeout
            )
        );
        if ($headers != null) $options["http"]["header"] = HttpRequests::formatHeaders($headers);
        if ($body != null) $options["http"]["content"] = is_array($body) ? json_encode($body) : $body;
        return HttpRequests::request($url, $options);
    }

    public static function post($url, $headers, $params, $body, $timeout = 120)
    {
        return HttpRequests::do("POST", $url, $headers, $params, $body, $timeout);
    }

    public static function get($url, $headers = null, $params = null, $body = null, $timeout = 120)
    {
        return HttpRequests::do("GET", $url, $headers, $params, $body, $timeout);
    }

    private static function request($url, $options)
    {
        $context = stream_context_create($options);
        return file_get_contents($url, false, $context);
    }

    private static function formatParams($params)
    {
        $param = "?";
        foreach ($params as $key => $value) {
            $param = $param . $key . "=" . $value . "&";
        }
        return substr($param, 0, strlen($param) - 1);
    }

    private static function formatHeaders($headers)
    {
        $header = "";
        foreach ($headers as $key => $value) {
            $header = $header . $key . ": " . $value . "\r\n";
        }
        return $header;
    }

}