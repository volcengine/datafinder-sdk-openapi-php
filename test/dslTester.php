<?php


include_once "../datarangers/dslcontent/DSL.class.php";
include_once "../datarangers/dslcontent/DSLBuilder.class.php";
include_once "../datarangers/dslcontent/Expr.class.php";

class TestDslCommon
{
    public static function getEventDsl()
    {
        $dsl = DataRangers\DSLBuilder::builder("event")
            ->appIds(0)
            ->rangePeriod("day", 1562688000, 1563206400, false)
            ->rangePeriod("hour", 1562688000, 1563206400, false)
            ->group("app_channel")->skipCache(false)
            ->tags(["contains_today" => 0, "show_yesterday" => 0, "series_type" => "line", "show_map" => []])
            ->andProfileFilter(
                DataRangers\Expr::intExpr("user_is_new", "=", [0])
                    ->show("老用户", "1")
            )
            ->andProfileFilter(
                DataRangers\Expr::stringExpr("language", "=", ["zj_CN", "zh_cn"])
                    ->stringExpr("age", "!=", ["20"])
                    ->show("zh_CN, zh_cn; not(20)", "2")
            )
            ->query(DataRangers\Expr::show("A", "A")
                ->group("app_name")
                ->event("origin", "predefine_pageview", "pv")
                ->measureInfo("pct", "event_index", 100)
                ->andFilter(DataRangers\Expr::stringExpr("os_name", "=", ["windows"])
                    ->stringExpr("network_type", "!=", ["wifi"])
                    ->show("referer", "referrer_label")
                )
            )->query(DataRangers\Expr::show("B", "B")
                ->group("app_name")
                ->event("origin", "page_open", "pv")
                ->andFilter(DataRangers\Expr::emptyExpr()->show("app_id", "app_id_label"))
            )->build();
        return $dsl;
    }

    public static function getFunnelDSL()
    {
        $dsl = \DataRangers\DSLBuilder::funnelBuilder()
            ->appIds(0)
            ->rangePeriod("day", 1560268800, 1562774400)
            ->group("os_name")
            ->page(10, 2)
            ->window("day", 10)
            ->skipCache(false)
            ->andProfileFilter(\DataRangers\Expr::intExpr("user_is_new", "=", [0])
                ->stringExpr("network_type", "!=", ["4g,3g"])
                ->show("1", "老用户; not(4g, 3g)")
            )->query([\DataRangers\Expr::show("1", "查询1")
                ->sample(100)
                ->event("origin", "play_time", "pv")
                ->andFilter(\DataRangers\Expr::stringExpr("os_name", "=", ["windows"])
                    ->show("referer_label", "referrer")
                ),
                \DataRangers\Expr::show("2", "查询2")->sample(100)
                    ->event("origin", "app_launch", "pv")
            ])->build();
        return $dsl;
    }

    public static function getLifeCycleDSL()
    {
        $dsl = \DataRangers\DSLBuilder::lifeCycleBuilder()
            ->appIds(162251)
            ->rangePeriod("day", 1561910400, 1562428800)
            ->page(10, 2)
            ->window("day", 1)
            ->skipCache(false)
            ->tags([
                "series_type" => "line",
                "contains_today" => 0,
                "metrics_type" => "number",
                "disabled_in_dashboard" => true
            ])
            ->andProfileFilter(\DataRangers\Expr::stringExpr("custom_mp_platform", "=", ["2"])
                ->stringExpr("app_channel", "in", ["alibaba", "baidu"])
                ->show("1", "全体用户")
            )
            ->query(\DataRangers\Expr::show("active_user", "active_user")
                ->sample(100)->event("origin", "app_launch", "pv"))
            ->build();
        return $dsl;
    }

    public static function getPathFinderDSL()
    {
        $dsl = \DataRangers\DSLBuilder::pathFindBuilder()
            ->appIds(0)
            ->rangePeriod("day", 1563120000, 1563638400)
            ->page(10, 2)
            ->window("minute", 10)
            ->skipCache(false)
            ->isStack(false)
            ->andProfileFilter(\DataRangers\Expr::stringExpr("os_name", "in", ["android", "ios"])
                ->stringExpr("network_type", "in", ["wifi", "4g"])
                ->show("1", "android, ios; wifi, 4g"))
            ->query([\DataRangers\Expr::show("1", "查询1")
                    ->sample(100)->event("origin", "app_launch")
                    ->andFilter(\DataRangers\Expr::emptyExpr()->show("1", "全体用户")),
                    \DataRangers\Expr::show("2", "查询2")->sample(100)
                        ->event("origin", "register")
                        ->andFilter(\DataRangers\Expr::emptyExpr()->show("1", "全体用户")),
                    \DataRangers\Expr::show("3", "查询3")->sample(100)
                        ->event("origin", "register")
                        ->andFilter(\DataRangers\Expr::emptyExpr()->show("1", "全体用户"))]
            )
            ->build();
        return $dsl;
    }

    public static function getRetentionDSL()
    {
        $dsl = \DataRangers\DSLBuilder::retentionBuilder()
            ->appIds(0)
            ->rangePeriod("day", 1561910400, 1563033600)
            ->page(10, 2)
            ->group("network_type")
            ->window("day", 30)
            ->skipCache(false)
            ->isStack(false)
            ->tags(["retention_from" => "custom",
                "series_type" => "table"])
            ->andProfileFilter(\DataRangers\Expr::intExpr("user_is_new", "=", [0])
                ->show("1", "老用户"))
            ->query([\DataRangers\Expr::show("first", "起始事件")
                    ->event("origin", "page_open", "pv")
                    ->andFilter(
                        \DataRangers\Expr::stringExpr("os_name", "=", ["windows", "mac", "ios"])
                            ->stringExpr("network_type", "!=", ["4g"])->show("os_name_label", "os_name,network_type")
                    ), \DataRangers\Expr::show("return", "回访事件")
                    ->event("origin", "any_event")
                    ->andFilter(\DataRangers\Expr::stringExpr("os_name", "=", ["windows", "mac"])
                        ->stringExpr("os_name", "=", ["Chrome", "Internet Explore"])
                        ->show("1", "全体用户")
                    )]
            )
            ->build();
        return $dsl;
    }

    public static function getWebDSL()
    {
        $dsl = \DataRangers\DSLBuilder::webBuilder()
            ->appIds(0)
            ->rangePeriod("day", 1562774400, 1563292800)
            ->page(10, 2)
            ->group("browser")
            ->web("first", 1200)
            ->skipCache(false)
            ->isStack(false)
            ->tags(["contains_today" => 0,
                "series_type" => "line"])
            ->andProfileFilter(\DataRangers\Expr::stringExpr("os_name", "=", ["windows", "android"])
                ->show("1", "操作系统"))
            ->query([
                \DataRangers\Expr::show("session_count", "会话数")
                    ->sample(100)
                    ->event("origin", "predefine_pageview", "session_count")
                    ->andFilter(\DataRangers\Expr::emptyExpr()->show("1", "source")),
                \DataRangers\Expr::show("average_session_duration", "平均会话时长")
                    ->event("origin", "predefine_pageview", "average_session_duration")
                    ->andFilter(\DataRangers\Expr::emptyExpr()->show("1", "source")),
                \DataRangers\Expr::show("bounce_rate", "跳出率")
                    ->event("origin", "predefine_pageview", "bounce_rate")
                    ->andFilter(\DataRangers\Expr::emptyExpr()->show("1", "source")),
                \DataRangers\Expr::show("average_session_depth", "平均会话深度")
                    ->event("origin", "predefine_pageview", "average_session_depth")
                    ->andFilter(\DataRangers\Expr::emptyExpr()->show("1", "source"))
            ])
            ->build();
        return $dsl;
    }

    public static function getTopKDSL()
    {
        $dsl = \DataRangers\DSLBuilder::topKBuilder()
            ->appIds(0)
            ->rangePeriod("day", 1563379200, 1563897600)
            ->order("app_version")
            ->page(10, 2)
            ->skipCache(true)
            ->tags([
                "contains_today" => 0,
                "show_yesterday" => 0,
                "series_type" => "line",
            ])
            ->andProfileFilter(\DataRangers\Expr::intExpr("ab_version", "=", [1])
                ->intExpr("user_is_new", "=", [0])
                ->show("B", "新用户"))
            ->query(\DataRangers\Expr::show("A", "查询A")->sample(100)
                ->event("origin", "predefine_pageview", "pv")
                ->measureInfo("pct", "event_index", 100)
                ->andFilter(\DataRangers\Expr::stringExpr("referrer", "=", ["http://www->baidu->com", "http://www->bytedance->com"], "event_param")
                    ->show("referer_label", "referer")
                ))
            ->build();
        return $dsl;
    }

    public static function getTracerTableDSL()
    {
        $dsl = \DataRangers\DSLBuilder::advertiseBuilder()
            ->advertise([
                "timeout" => 1000,
                "alias_convert" => false,
                "blend_params" => [
                    "group_by" => "date"
                ]
            ])
            ->product("bytetracer")
            ->appIds(0)
            ->lastPeriod("day", 7, "day")
            ->todayPeriod("day", true)
            ->limit(1000)->offset(0)
            ->andProfileFilter(
                \DataRangers\Expr::emptyExpr()->show("1", "channel_1, traceing_1, group_id_1")
            )->query(
                \DataRangers\Expr::show("impression_count", "impression_count")
                    ->event("customed", "impression", "impression_count")
            )->query(
                \DataRangers\Expr::show("click_count", "click_count")
                    ->event("customed", "click", "click_count")
            )->query(
                \DataRangers\Expr::show("promotion_activation_count", "promotion_activation_count")
                    ->event("customed", "activation", "promotion_activation_count")
            )
            ->build();
        $dsl_rete = \DataRangers\DSLBuilder::retentionBuilder()
            ->product("bytefinder")
            ->appIds(0)
            ->lastPeriod("day", 7, "day")
            ->todayPeriod("day", true)
            ->page(1000, 0)
            ->andProfileFilter(
                \DataRangers\Expr::emptyExpr()->show("1", "channel_1, traceing_1, group_id_1")
            )->query([
                    \DataRangers\Expr::show("1", "查询1")
                        ->sample(100)
                        ->event("origin", "app_launch")
                        ->andFilter(
                            \DataRangers\Expr::intExpr("user_is_new", "=", [1], "profile")
                                ->show("new_user", "new_user")
                        ),
                    \DataRangers\Expr::show("2", "查询2")->sample(100)->event("origin", "app_launch")]
            )
            ->build();

//        echo json_encode($dsl) . "<br>";
//        echo json_encode($dsl_rete) . "<br>";

        return \DataRangers\DSL::blendDSLs(0, [$dsl, $dsl_rete]);
    }

}

//TestDslCommon::getTracerTableDSL();
