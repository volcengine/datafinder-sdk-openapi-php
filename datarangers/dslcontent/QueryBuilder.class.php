<?php


namespace DataRangers;
include_once "Query.class.php";
include_once "FilterBuilder.class.php";

class QueryBuilder
{
    private Query $query;

    /**
     * QueryBuilder constructor.
     * @param Query $query
     */
    public function __construct(Query $query)
    {
        $this->query = $query;
    }

    public function sample($samplePercent = 100)
    {
        $this->query->setSamplePercent($samplePercent);
        return $this;
    }

    public function showName($showName)
    {
        $this->query->setShowName($showName);
        return $this;
    }

    public function showLabel($showLabel)
    {
        $this->query->setShowLabel($showLabel);
        return $this;
    }

    public function event($eventType, $eventName, $eventIndicator = null, $eventId = null)
    {
        $this->query->setEventId($eventId);
        $this->query->setEventType($eventType);
        $this->query->setEventName($eventName);
        $this->query->setEventIndicator($eventIndicator);
        return $this;
    }

    public function measureInfo($measureType, $propertyName, $measureValue)
    {
        $this->query->setMeasureInfo(["measure_type" => $measureType, "property_name" => $propertyName, "measure_value" => $measureValue]);
        return $this;
    }

    public function andFilter(FilterBuilder $fb)
    {
        $this->query->addFilter($fb->logic("and")->build());
        return $this;
    }

    public function orFilter(FilterBuilder $fb)
    {
        $this->query->addFilter($fb->logic("or")->build());
        return $this;
    }

    public function group($group)
    {
        $this->query->addGroup($group);
        return $this;
    }

    public function build()
    {
        return $this->query;
    }


    public static function getBuilder(): QueryBuilder
    {
        return new QueryBuilder(new Query());
    }

}