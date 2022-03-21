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
                Constants::$ANALYSIS_BASE => Constants::$ANALYSIS_BASE_URL,
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

    protected function request($service, $method, $path, $headers, $params, $body,$timeout=120)
    {
        $method = strtoupper($method);
        if (!in_array($method, Constants::$METHOD_ALLODED)) {
            throw new ClientNotSupportException(Constants::$METHOD_NOT_SUPPORT . ":" . $method);
        }
        if (Constants::$POST == $method && $body == null) {
            throw new ClientNotSupportException(Constants::$POST_BODY_NULL);
        }
        $servicePath = $this->getServicePath($service);
        if ($servicePath == "") {
            throw new ClientNotSupportException(Constants::$SERVICE_NOT_SUPPORT . ":" . $service);
        }
        $serviceUrl = $servicePath . $path;
        $authorization = DslSign::sign($this->ak, $this->sk, $this->expiration, $method, $serviceUrl, $params, $body);
        if ($headers == null) $headers = [];
        $headers[Constants::$AUTHORIZATION] = $authorization;
        if (Constants::$POST == $method) {
            $headers[Constants::$CONTENT_TYPE] = Constants::$APPLICATION_JSON;
        }
        $url = $this->url . $serviceUrl;
        return HttpRequests::do($method, $url, $headers, $params, $body,$timeout);
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
}