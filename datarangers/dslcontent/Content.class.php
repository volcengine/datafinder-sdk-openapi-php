<?php


namespace DataRangers;


class Content implements \JsonSerializable
{
    private $queryType="event";
    private $profileFilters;
    private $profileGroups;
    private $orders;
    private $page = [];
    private $option = [];
    private $showOption = null;
    private $queries;

    /**
     * @return mixed
     */
    public function getQueryType()
    {
        return $this->queryType;
    }

    /**
     * @param mixed $queryType
     */
    public function setQueryType($queryType)
    {
        $this->queryType = $queryType;
    }

    /**
     * @return mixed
     */
    public function getProfileFilters()
    {
        return $this->profileFilters;
    }

    /**
     * @param mixed $profileFilters
     */
    public function setProfileFilters($profileFilters)
    {
        $this->profileFilters = $profileFilters;
    }

    public function addProfileFilter($profileFilters)
    {
        if ($this->profileFilters == null) $this->profileFilters = [];
        array_push($this->profileFilters, $profileFilters);
    }

    /**
     * @return mixed
     */
    public function getProfileGroups()
    {
        return $this->profileGroups;
    }

    /**
     * @param mixed $profileGroups
     */
    public function setProfileGroups($profileGroups)
    {
        $this->profileGroups = $profileGroups;
    }

    public function addProfileGroup($profileGroups)
    {
        if ($this->profileGroups == null) $this->profileGroups = [];
        if (is_array($profileGroups)) $this->profileGroups = array_merge($this->profileGroups, $profileGroups);
        else array_push($this->profileGroups, $profileGroups);
    }

    /**
     * @return mixed
     */
    public function getOrders()
    {
        return $this->orders;
    }

    /**
     * @param mixed $orders
     */
    public function setOrders($orders)
    {
        $this->orders = $orders;
    }

    public function addOrders($orders, $direction = "asc")
    {
        if ($this->orders == null) $this->orders = [];
        if (is_array($orders)) {
            foreach ($orders as $value) {
                if (is_string($value)) {
                    array_push($this->orders, ["field" => $value, "direction" => "asc"]);
                } else if (is_array($value)) {
                    array_push($value);
                }
            }
        } elseif (is_string($orders)) {
            array_push($this->orders, ["field" => $orders, "direction" => $direction]);
        }
    }

    /**
     * @return mixed
     */
    public function getPage()
    {
        return $this->page;
    }

    /**
     * @param mixed $page
     */
    public function setPage($page)
    {
        $this->page = $page;
    }

    public function addPageLimit($limit)
    {
        if ($this->page == null) $this->page = [];
        $this->page["limit"] = $limit;
    }

    public function addPageOffset($offset)
    {
        if ($this->page == null) $this->page = [];
        $this->page["offset"] = $offset;
    }

    /**
     * @return mixed
     */
    public function getOption()
    {
        return $this->option;
    }

    /**
     * @param mixed $option
     */
    public function setOption($option)
    {
        $this->option = $option;
    }

    public function addOption($key, $value)
    {
        if ($this->option == null) $this->option = [];
        $this->option[$key] = $value;
    }

    /**
     * @return mixed
     */
    public function getShowOption()
    {
        return $this->showOption;
    }

    /**
     * @param mixed $showOption
     */
    public function setShowOption($showOption)
    {
        $this->showOption = $showOption;
    }

    public function addShowOption($key, $value)
    {
        if ($this->showOption == null) $this->showOption = [];
        $this->showOption[$key] = $value;
    }

    /**
     * @return mixed
     */
    public function getQueries()
    {
        return $this->queries;
    }

    /**
     * @param mixed $queries
     */
    public function setQueries($queries)
    {
        $this->queries = $queries;
    }

    public function addQuery($query)
    {
        if ($this->queries == null) $this->queries = [];
        if (is_array($query)) array_push($this->queries, $query);
        else array_push($this->queries, [$query]);
    }

    public function jsonSerialize()
    {
        $data = [];
        if ($this->queryType != null) $data["query_type"] = $this->queryType;
        if ($this->profileFilters != null) $data["profile_filters"] = $this->profileFilters;
        if ($this->profileGroups != null) $data["profile_groups"] = $this->profileGroups;
        if ($this->orders != null) $data["orders"] = $this->orders;
        if ($this->page != null) $data["page"] = $this->page;
        if ($this->option != null) $data["option"] = $this->option;
        if ($this->showOption != null) $data["show_option"] = $this->showOption;
        if ($this->queries != null) $data["queries"] = $this->queries;
        return $data;
    }
}
