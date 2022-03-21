<?php


namespace DataRangers;
include_once "DSL.class.php";
include_once "FilterBuilder.class.php";

class DSLBuilder
{
    private DSL $dsl;
    private $queryType;

    /**
     * DSLBuilder constructor.
     * @param DSL $dsl
     * @param $queryType
     */
    public function __construct(DSL $dsl, $queryType = null)
    {
        $this->dsl = $dsl;
        $this->queryType = $queryType;
    }

    public function appIds($appIds)
    {
        $this->dsl->addAppIds($appIds);
        return $this;
    }

    public function optimized($opt)
    {
        $this->dsl->getContentBuilder()->option("optimized", $opt);
        return $this;
    }

    public function queryType($queryType)
    {
        $this->dsl->getContentBuilder()->queryType($queryType);
        if ("funnel" == $queryType) $this->optimized(true);
        else $this->optimized(false);
        return $this;
    }

    public function rangePeriod($granularity, $start, $end, $realtime = false)
    {
        $period = ["type" => "range", "granularity" => $granularity, "range" => [$start, $end]];
        if ($realtime) $period["real_time"] = $realtime;
        $this->dsl->addPeriod($period);
        return $this;
    }

    public function lastPeriod($granularity, $amount, $unit, $realtime = false)
    {
        $period = ["type" => "last", "granularity" => $granularity, "last" => ["amount" => $amount, "unit" => $unit]];
        if ($realtime) $period["real_time"] = $realtime;
        $this->dsl->addPeriod($period);
        return $this;
    }

    public function todayPeriod($granularity, $realtime = false)
    {
        $period = ["type" => "today", "granularity" => $granularity];
        if ($realtime) $period["real_time"] = $realtime;
        $this->dsl->addPeriod($period);
        return $this;
    }

    public function group($pg)
    {
        $this->dsl->getContentBuilder()->profileGroup($pg);
        return $this;
    }

    public function order($order, $direction = "asc")
    {
        $this->dsl->getContentBuilder()->orders($order, $direction);
        return $this;
    }

    public function page(int $limit, int $offset)
    {
        $this->dsl->getContentBuilder()->page($limit, $offset);
        return $this;
    }

    public function limit(int $limit)
    {
        $this->dsl->getContentBuilder()->limit($limit);
        return $this;
    }

    public function offset(int $offset)
    {
        $this->dsl->getContentBuilder()->offset($offset);
        return $this;
    }

    public function skipCache(bool $sc)
    {
        $this->dsl->getContentBuilder()->option("skip_cache", $sc);
        return $this;
    }

    public function isStack(bool $stack)
    {
        $this->dsl->getContentBuilder()->option("is_stack", $stack);
        return $this;
    }

    public function lifeCycle($granularity, int $interval, $type = "stickiness")
    {
        $this->dsl->getContentBuilder()->option("lifecycle_query_type", $type);
        $this->dsl->getContentBuilder()->option("lifecycle_period", ["granularity" => $granularity, "period" => $interval]);
        return $this;
    }

    public function retention($granularity, int $interval)
    {
        $this->dsl->getContentBuilder()->option("retention_type", $granularity);
        $this->dsl->getContentBuilder()->option("retention_n_days", $interval);
        return $this;
    }

    public function web($type, int $timeout)
    {
        $this->dsl->getContentBuilder()->option("web_session_params", ["session_params_type" => $type, "session_timeout" => $timeout]);
        return $this;
    }

    public function product($product)
    {
        $this->dsl->getContentBuilder()->option("product", $product);
        return $this;
    }

    public function option(array $options)
    {
        foreach ($options as $key => $value) {
            $this->dsl->getContentBuilder()->option($key, $value);
        }
        return $this;
    }

    public function advertise(array $adp)
    {
        return $this->option($adp);
    }

    public function tags($tags)
    {
        foreach ($tags as $key => $value) {
            if (is_array($value) && count($value) == 0) continue;
            $this->dsl->getContentBuilder()->showOption($key, $value);
        }
        return $this;
    }

    public function andProfileFilter(FilterBuilder $fb)
    {
        $this->dsl->getContentBuilder()->profileFilter($fb->logic("and")->build());
        return $this;
    }

    public function orProfileFilter(FilterBuilder $fb)
    {
        $this->dsl->getContentBuilder()->profileFilter($fb->logic("or")->build());
        return $this;
    }

    public function query($qbs)
    {
        if ($qbs == null) return $this;
        $queries = null;
        if (is_array($qbs)) {
            $queries = [];
            foreach ($qbs as $qb) {
                array_push($queries, $qb->build());
            }
        } else {
            $queries = $qbs->build();
        }
        $this->dsl->getContentBuilder()->query($queries);
        return $this;
    }

    public function periods($periods)
    {
        $this->dsl->setPeriods($periods);
        return $this;
    }

    public function build(): DSL
    {
        $this->dsl->setContent($this->dsl->getContentBuilder()->build());
        return $this->dsl;
    }

    public function window($granularity, int $interval)
    {
        if ("life_cycle" == $this->queryType) {
            $this->lifeCycle($granularity, $interval);
        } else if ("retention" == $this->queryType) {
            $this->retention($granularity, $interval);
        } else {
            $this->dsl->getContentBuilder()->option("window_period_type", $granularity);
            $this->dsl->getContentBuilder()->option("window_period", $interval);
        }
        return $this;
    }

    public static function builder($queryType)
    {
        return new DSLBuilder(new DSL(), $queryType);
    }

    public static function funnelBuilder()
    {
        return new DSLBuilder(new DSL(), "funnel");
    }

    public static function lifeCycleBuilder()
    {
        return new DSLBuilder(new DSL(), "life_cycle");
    }

    public static function pathFindBuilder()
    {
        return new DSLBuilder(new DSL(), "path_find");
    }

    public static function retentionBuilder()
    {
        return new DSLBuilder(new DSL(), "retention");
    }

    public static function webBuilder()
    {
        return new DSLBuilder(new DSL(), "web_session");
    }

    public static function confidenceBuilder()
    {
        return new DSLBuilder(new DSL(), "confidence");
    }

    public static function topKBuilder()
    {
        return new DSLBuilder(new DSL(), "event_topk");
    }

    public static function advertiseBuilder()
    {
        return new DSLBuilder(new DSL(), "advertise");
    }

}