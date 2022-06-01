<?php


namespace DataRangers;
include_once "common/Constants.class.php";
include_once "common/ClientNotSupportException.class.php";
include_once "util/DslSign.class.php";
include_once "common/HttpRequests.class.php";

class Client
{
    private $ak;
    private $sk;
    private $org = "dataRangers";
    private $url = "https://analytics.volcengineapi.com";
    private $expiration = 1800;
    private static $services = null;

    /**
     * Client constructor.
     * @param $ak
     * @param $sk
     * @param string $url
     * @param int $expiration
     */
    public function __construct($ak, $sk, $url = "https://analytics.volcengineapi.com", $expiration = 1800)
    {
        $this->ak = $ak;
        $this->sk = $sk;
        $this->url = $url;
        $this->expiration = $expiration;
        $this->setService();
    }

    /**
     *
     */
    private function setService()
    {
        if (Client::$services == null) {
            Client::$services = [
                Constants::$DATA_FINDER => Constants::$DATA_FINDER_URL,
                Constants::$DATA_TRACER => Constants::$DATA_TRACER_URL,
                Constants::$DATA_TESTER => Constants::$DATA_TESTER_URL,
                Constants::$DATA_ANALYZER => Constants::$DATA_ANALYZER_URL,
                Constants::$DATA_RANGERS => Constants::$DATA_RANGERS_URL,
                Constants::$DATA_PROFILE => Constants::$DATA_PROFILE_URL
            ];
        }
    }

    protected function getServicePath($service)
    {
        if (array_key_exists($service, Client::$services)) {
            return Client::$services[$service];
        } else {
            return "";
        }
    }

    protected function requestService($service, $method, $path, $headers, $params, $body,$timeout=120)
    {
        $method = strtoupper($method);
        if (!in_array($method, Constants::$METHOD_ALLODED)) {
            throw new ClientNotSupportException(Constants::$METHOD_NOT_SUPPORT . ":" . $method);
        }
        $servicePath = $this->getServicePath($service);
        if ($servicePath == "") {
            throw new ClientNotSupportException(Constants::$SERVICE_NOT_SUPPORT . ":" . $service);
        }
        $serviceUrl = $servicePath . $path;
        return $this->doRequest($method, $serviceUrl, $headers, $params, $body, $timeout);
    }


    /**
     * @return mixed
     */
    public function getAk()
    {
        return $this->ak;
    }

    /**
     * @param mixed $ak
     */
    public function setAk($ak)
    {
        $this->ak = $ak;
    }

    /**
     * @return mixed
     */
    public function getSk()
    {
        return $this->sk;
    }

    /**
     * @param mixed $sk
     */
    public function setSk($sk)
    {
        $this->sk = $sk;
    }

    /**
     * @return string
     */
    public function getOrg()
    {
        return $this->org;
    }

    /**
     * @param string $org
     */
    public function setOrg($org)
    {
        $this->org = $org;
    }

    /**
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @param string $url
     */
    public function setUrl($url)
    {
        $this->url = $url;
    }

    /**
     * @return int
     */
    public function getExpiration()
    {
        return $this->expiration;
    }

    /**
     * @param int $expiration
     */
    public function setExpiration($expiration)
    {
        $this->expiration = $expiration;
    }

    /**
     * @param string $method
     * @param string $serviceUrl
     * @param $params
     * @param $body
     * @param $headers
     * @param $timeout
     * @return false|string
     */
    protected function doRequest(string $method, string $serviceUrl, $headers, $params, $body, $timeout)
    {
        $method = strtoupper($method);
        $authorization = DslSign::sign($this->ak, $this->sk, $this->expiration, $method, $serviceUrl, $params, $body);
        if ($headers == null) {
            $headers = [];
            $headers[Constants::$CONTENT_TYPE] = Constants::$APPLICATION_JSON;
        }
        $headers[Constants::$AUTHORIZATION] = $authorization;
        $url = $this->url . $serviceUrl;
        return HttpRequests::do($method, $url, $headers, $params, $body, $timeout);
    }
}