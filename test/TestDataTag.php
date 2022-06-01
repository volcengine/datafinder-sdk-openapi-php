<?php

include_once "../datarangers/RangersClient.class.php";
include_once "../datarangers/dslcontent/DSL.class.php";
include_once "dslTester.php";

class TestDataTag
{
    private \DataRangers\RangersClient $client;

    /**
     * TestClient constructor.
     */
    public function __construct($ak, $sk, $url)
    {
        $this->client = new \DataRangers\RangersClient($ak, $sk, $url);
    }


    public function testUploadFile()
    {
        $method = 'POST';
        $serviceUrl = '/datatag/openapi/v1/app/xxx/tag/file/upload';
        $fileName = '/xxx/user_tag.csv';
        $result = $this->client->uploadFile($serviceUrl, $method, null, null, $fileName);
        echo $result;
    }

    public function testCreateTag()
    {
        $method = 'POST';
        $serviceUrl = '/datatag/openapi/v1/app/xxx/tag';
        $body = '{
            "name": "tag_test_php",
            "show_name": "测试标签_php",
            "value_type": "string",
            "description": "",
            "create_type": "upload",
            "refresh_rule": "manual",
            "tag_rule": {
                "file": {
                    "file_key": "tag_upload_uuid/xxx/20220601/db21b6f660154e9ab9293ad419337bf6.json",
                    "detail": {
                        "name": "user_tag.csv"
                    }
                }
            }
         }';
        $result = $this->client->request($serviceUrl, $method, null, null, $body);
        echo $result;
    }

    public function testQueryResult()
    {
        $method = "GET";
        $serviceUrl = "/datatag/openapi/v1/app/xxx/tag/tag_test_php/result";
        $result = $this->client->request($serviceUrl, $method);
        echo $result;
    }

    public function testQueryHistory()
    {
        $method = "POST";
        $serviceUrl = "/datatag/openapi/v1/app/xxx/tag/tag_test_php/result/history";
        $body = '{
            "granularity":"day",
            "type":"past_range",
            "spans":[
                {
                    "type":"past",
                    "past":{
                        "amount":7,
                        "unit":"day"
                    }
                },
                {
                    "type":"past",
                    "past":{
                        "amount":1,
                        "unit":"day"
                    }
                }
            ],
            "timezone":"Asia/Shanghai",
            "week_start":1
        }';
        $result = $this->client->request($serviceUrl, $method, null, null, $body);
        echo $result;
    }

    public function testExportTag()
    {
        $method = "POST";
        $serviceUrl = "/datatag/openapi/v1/app/xxx/tag/tag_test_php/download";
        $body = '{
            "type": "user",
            "condition": {
                "property_operation": "is_not_null",
                "snapshot": {
                    "type": "day",
                    "day": "2022-06-01"
                }
            },
            "period": {
                "timezone": "Asia/Shanghai"
            }
        }';
        $result = $this->client->request($serviceUrl, $method, null, null, $body);
        echo $result;
    }

    public function testQueryTagInfo()
    {
        $method = "GET";
        $serviceUrl = "/datatag/openapi/v1/app/xxx/tag/tag_test_php";
        $result = $this->client->request($serviceUrl, $method);
        echo $result;
    }

    public function testQueryTags()
    {
        $method = "GET";
        $serviceUrl = "/datatag/openapi/v1/app/xxx/tag";
        $result = $this->client->request($serviceUrl, $method);
        echo $result;
    }

    public function testCalTag()
    {
        $method = "POST";
        $serviceUrl = "/datatag/openapi/v1/app/xxx/tag/tag_test_php/calculation";
        $result = $this->client->request($serviceUrl, $method);
        echo $result;
    }
}

$ak = "xxx";
$sk = "xxx";
$url = "xxx";
$testCase = new TestDataTag($ak, $sk, $url);
//$testCase->testUploadFile();
//$testCase->testCreateTag();
//$testCase->testQueryResult();
//$testCase->testQueryHistory();
//$testCase->testExportTag();
//$testCase->testQueryTagInfo();
//$testCase->testQueryTags();
$testCase->testCalTag();


