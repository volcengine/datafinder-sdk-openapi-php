<?php


namespace DataRangers;
include_once "Filter.class.php";
include_once "Condition.class.php";

class FilterBuilder
{
    private Filter $filter;

    /**
     * FilterBuilder constructor.
     * @param Filter $filter
     */
    public function __construct(Filter $filter)
    {
        $this->filter = $filter;
    }

    public function showName($showName)
    {
        $this->filter->setShowName($showName);
        return $this;
    }

    public function showLabel($showLabel)
    {
        $this->filter->setShowLabel($showLabel);
        return $this;
    }

    public function show($showLabel, $showName)
    {
        return $this->showLabel($showLabel)->showName($showName);
    }

    public function logic($logic)
    {
        $this->filter->setExpressionLogic($logic);
        return $this;
    }

    public function conditions($conditions)
    {
        $this->filter->addExpressionCondition($conditions);
        return $this;
    }

    public function stringExpr($name, $operation, $value, $type_ = "profile")
    {
        return $this->conditions(new Condition("string", $name, $operation, $value, $type_));
    }

    public function intExpr($name, $operation, $value, $type_ = "profile")
    {
        return $this->conditions(new Condition("int", $name, $operation, $value, $type_));
    }

    public function build()
    {
        return $this->filter;
    }

    public static function getBuilder(): FilterBuilder
    {
        return new FilterBuilder(new Filter());
    }
}