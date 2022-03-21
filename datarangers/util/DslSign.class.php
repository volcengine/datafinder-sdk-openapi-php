<?php

namespace DataRangers;
class DslSign
{
    public static function doSign($ak, $sk, $expiration, $text)
    {
        $sign_key_info = "ak-v1/" . $ak . "/" . time() . "/" . $expiration;
        $sign_key = hash_hmac("sha256", $sign_key_info, $sk);
        $sign_result = hash_hmac("sha256", $text, $sign_key);
        return $sign_key_info . "/" . $sign_result;
    }

    public static function sign($ak, $sk, $expiration, $method, $url, $params, $body)
    {
        $text = DslSign::canonicalRequest($method, $url, $params, $body);
        return DslSign::doSign($ak, $sk, $expiration, $text);
    }

    public static function canonicalRequest($method, $url, $params, $body)
    {
        $canonical_method = DslSign::canonicalMethod($method);
        $canonical_url = DslSign::canonicalUrl($url);
        $canonical_param = DslSign::canonicalParam($params);
        $canonical_body = DslSign::canonicalBody($body);
        return $canonical_method . "\n" . $canonical_url . "\n" . $canonical_param . "\n" . $canonical_body;
    }

    public static function canonicalMethod($method)
    {
        return "HTTPMethod:" . $method;
    }

    public static function canonicalUrl($url)
    {
        return "CanonicalURI:" . $url;
    }

    public static function canonicalParam($params)
    {
        $res = "CanonicalQueryString:";
        if ($params == null) {
            return $res;
        }
        foreach ($params as $key => $value) {
            $res = $res . $key . "=" . $value . "&";
        }
        return substr($res, 0, strlen($res) - 1);
    }

    public static function canonicalBody($body)
    {
        $res = "CanonicalBody:";
        if ($body == null) return $res;
        return $res . $body;
    }
}