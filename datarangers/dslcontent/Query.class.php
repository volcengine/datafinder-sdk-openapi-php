<?php


namespace DataRangers;


class Query implements \JsonSerializable
{
    private $samplePercent = 100;
    private $showName;
    private $showLabel;
    private $eventId;
    private $eventType;
    private $eventName;
    private $eventIndicator;
    private $measureInfo;
    private $filters = [];
    private $groups = [];

    /**
     * @return mixed
     */
    public function getSamplePercent()
    {
        return $this->samplePercent;
    }

    /**
     * @param mixed $samplePercent
     */
    public function setSamplePercent($samplePercent): void
    {
        $this->samplePercent = $samplePercent;
    }

    /**
     * @return mixed
     */
    public function getShowName()
    {
        return $this->showName;
    }

    /**
     * @param mixed $showName
     */
    public function setShowName($showName): void
    {
        $this->showName = $showName;
    }

    /**
     * @return mixed
     */
    public function getShowLabel()
    {
        return $this->showLabel;
    }

    /**
     * @param mixed $showLabel
     */
    public function setShowLabel($showLabel): void
    {
        $this->showLabel = $showLabel;
    }

    /**
     * @return mixed
     */
    public function getEventId()
    {
        return $this->eventId;
    }

    /**
     * @param mixed $eventId
     */
    public function setEventId($eventId): void
    {
        $this->eventId = $eventId;
    }

    /**
     * @return mixed
     */
    public function getEventType()
    {
        return $this->eventType;
    }

    /**
     * @param mixed $eventType
     */
    public function setEventType($eventType): void
    {
        $this->eventType = $eventType;
    }

    /**
     * @return mixed
     */
    public function getEventName()
    {
        return $this->eventName;
    }

    /**
     * @param mixed $eventName
     */
    public function setEventName($eventName): void
    {
        $this->eventName = $eventName;
    }

    /**
     * @return mixed
     */
    public function getEventIndicator()
    {
        return $this->eventIndicator;
    }

    /**
     * @param mixed $eventIndicator
     */
    public function setEventIndicator($eventIndicator): void
    {
        $this->eventIndicator = $eventIndicator;
    }

    /**
     * @return mixed
     */
    public function getMeasureInfo()
    {
        return $this->measureInfo;
    }

    /**
     * @param mixed $measureInfo
     */
    public function setMeasureInfo($measureInfo): void
    {
        $this->measureInfo = $measureInfo;
    }

    /**
     * @return array
     */
    public function getFilters(): array
    {
        return $this->filters;
    }

    /**
     * @param array $filters
     */
    public function setFilters(array $filters): void
    {
        $this->filters = $filters;
    }

    public function addFilter($filter)
    {
        array_push($this->filters, $filter);
    }

    /**
     * @return array
     */
    public function getGroups(): array
    {
        return $this->groups;
    }

    /**
     * @param array $groups
     */
    public function setGroups(array $groups): void
    {
        $this->groups = $groups;
    }


    public function addGroup($group)
    {
        if (is_array($group)) $this->groups = array_merge($this->groups, $group);
        else array_push($this->groups, $group);
    }


    public function jsonSerialize()
    {
        $data = [];
        if ($this->samplePercent != null) $data["sample_percent"] = $this->samplePercent;
        if ($this->showName != null) $data["show_name"] = $this->showName;
        if ($this->showLabel != null) $data["show_label"] = $this->showLabel;
        if ($this->eventId != null) $data["event_id"] = $this->eventId;
        if ($this->eventType != null) $data["event_type"] = $this->eventType;
        if ($this->eventName != null) $data["event_name"] = $this->eventName;
        if ($this->eventIndicator != null) $data["event_indicator"] = $this->eventIndicator;
        if ($this->measureInfo != null) $data["measure_info"] = $this->measureInfo;
        if ($this->filters != null) $data["filters"] = $this->filters;
        if ($this->groups != null) $data["groups"] = $this->groups;
        return $data;
    }
}