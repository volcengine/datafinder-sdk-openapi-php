<?php


namespace DataRangers;


class Constants
{
    public static $METHOD_ALLODED = ["POST", "GET", "DELETE", "PUT", "PATCH"];
    public static $METHOD_NOT_SUPPORT = "method not support";
    public static $POST = "POST";
    public static $GET = "GET";
    public static $POST_BODY_NULL = "post method mush contains body";
    public static $SERVICE_NOT_SUPPORT = "service not support";
    public static $AUTHORIZATION = "Authorization";
    public static $CONTENT_TYPE = "Content-Type";
    public static $APPLICATION_JSON = "application/json;charset=utf-8";

    public static $DATA_FINDER = "data_finder";
    public static $DATA_TRACER = "data_tracer";
    public static $DATA_TESTER = "data_tester";
    public static $DATA_ANALYZER = "data_analyzer";
    public static $DATA_RANGERS = "data_rangers";

    public static $DATA_FINDER_URL = "/datafinder";
    public static $DATA_TRACER_URL = "/datatracer";
    public static $DATA_TESTER_URL = "/datatester";
    public static $DATA_ANALYZER_URL = "/dataanalyzer";
    public static $DATA_RANGERS_URL = "/datarangers";

    public static $DATA_PROFILE = "dataprofile";
    public static $DATA_PROFILE_URL = "/dataprofile";

}