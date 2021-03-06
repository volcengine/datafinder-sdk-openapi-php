<?php


namespace DataRangers;
include_once "Client.class.php";
include_once "common/Constants.class.php";

class RangersClient extends Client
{

    /**
     * RangersClient constructor.
     * @param $ak :ak
     * @param $sk :sk
     * @param string $url :rangers域名 如https://analytics.volcengineapi.com
     * @param int $expiration :过期时间,用于AK SK认证,超过$expiration秒会返回超时,一般不需要配置
     */
    public function __construct($ak, $sk, $url = "https://analytics.volcengineapi.com", $expiration = 1800)
    {
        parent::__construct($ak, $sk, $url, $expiration);
    }

    /**
     * @param $path :请求路径
     * @param string $method : 请求方法.get或者post
     * @param null $headers : 请求headers
     * @param null $params : 请求参数,一般get需要使用params
     * @param null $body : 请求内容,一般post需要带上body
     * @param int $timeout : 请求的超时时间
     * @return false|string
     * @throws ClientNotSupportException
     */
    public function dataRangers($path, $method = "GET", $headers = null, $params = null, $body = null, $timeout = 120)
    {
        return $this->requestService(Constants::$DATA_RANGERS, $method, $path, $headers, $params, $body, $timeout);
    }

    public function dataFinder($path, $method = "GET", $headers = null, $params = null, $body = null, $timeout = 120)
    {
        return $this->requestService(Constants::$DATA_FINDER, $method, $path, $headers, $params, $body, $timeout);
    }

    public function dataTracer($path, $method = "GET", $headers = null, $params = null, $body = null, $timeout = 120)
    {
        return $this->requestService(Constants::$DATA_TRACER, $method, $path, $headers, $params, $body, $timeout);
    }

    public function dataTester($path, $method = "GET", $headers = null, $params = null, $body = null, $timeout = 120)
    {
        return $this->requestService(Constants::$DATA_TESTER, $method, $path, $headers, $params, $body, $timeout);
    }

    public function dataAnalyzer($path, $method = "GET", $headers = null, $params = null, $body = null, $timeout = 120)
    {
        return $this->requestService(Constants::$DATA_ANALYZER, $method, $path, $headers, $params, $body, $timeout);
    }

    public function dataProfile($path, $method = "GET", $headers = null, $params = null, $body = null, $timeout = 120)
    {
        return $this->requestService(Constants::$DATA_PROFILE, $method, $path, $headers, $params, $body, $timeout);
    }

    public function request($serviceUrl, $method = "GET", $headers = null, $params = null, $body = null, $timeout = 120)
    {
        return $this->doRequest($method, $serviceUrl, $headers, $params, $body, $timeout);
    }

    public function uploadFile($serviceUrl, $method = "GET", $headers = null, $params = null, $fileName = null, $timeout = 120)
    {
        $file_contents = file_get_contents($fileName);
        $boundary = $this->getBoundary();
        $content_type = mime_content_type($fileName);

        $body = "--" . $boundary . "\r\n" .
            "Content-Disposition: form-data; name=\"file\"; filename=\"" . basename($fileName) . "\"\r\n" .
            "Content-Type: " . $content_type . "\r\n\r\n" .
            $file_contents . "\r\n";

        $body .= "--" . $boundary . "--\r\n";
        $headers["Content-Type"] = "multipart/form-data; boundary=" . $boundary;

        return $this->doRequest($method, $serviceUrl, $headers, $params, $body, $timeout);
    }

    private function getBoundary()
    {
        $boundary = floor(microtime(true) * 1000);
        $boundary .= floor(rand(10000000, 100000000));
        return $boundary;
    }

}
