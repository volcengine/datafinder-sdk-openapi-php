<?php

include_once "../datarangers/RangersClient.class.php";
include_once "../datarangers/dslcontent/DSL.class.php";
include_once "dslTester.php";

class TestClient
{
    private $ak = "xxx";
    private $sk = "xxx";
    private \DataRangers\RangersClient $client;

    /**
     * TestClient constructor.
     */
    public function __construct($ak, $sk)
    {
        $this->client = new \DataRangers\RangersClient($ak, $sk);
    }


    public function analysisRequest(\DataRangers\DSL $dsl)
    {
        echo $this->client->dataFinder("/openapi/v1/analysis", "post", null, null, json_encode($dsl));
    }

    public function testFunnel()
    {
        $this->analysisRequest(TestDslCommon::getFunnelDSL());
    }

    public function testPathFinder(){
        $this->analysisRequest(TestDslCommon::getPathFinderDSL());
    }

    public function testTopK(){
        $this->analysisRequest(TestDslCommon::getTopKDSL());
    }
}

$testCase = new TestClient("xxx", "xxx");
$testCase->testFunnel();
