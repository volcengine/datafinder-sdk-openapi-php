<?php


namespace DataRangers;


class Filter implements \JsonSerializable
{
    private $showName = null;
    private $showLabel = null;
    private $expression = ["logic" => null, "conditions" => []];

    /**
     * @return null
     */
    public function getShowName()
    {
        return $this->showName;
    }

    /**
     * @param null $showName
     */
    public function setShowName($showName): void
    {
        $this->showName = $showName;
    }

    /**
     * @return null
     */
    public function getShowLabel()
    {
        return $this->showLabel;
    }

    /**
     * @param null $showLabel
     */
    public function setShowLabel($showLabel): void
    {
        $this->showLabel = $showLabel;
    }

    /**
     * @return array
     */
    public function getExpression(): array
    {
        return $this->expression;
    }

    /**
     * @param array $expression
     */
    public function setExpression(array $expression): void
    {
        $this->expression = $expression;
    }

    public function setExpressionLogic($logic)
    {
        $this->expression["logic"] = $logic;
    }

    public function addExpressionCondition($condition)
    {
        if (is_array($condition)) {
            $this->expression["conditions"] = array_merge($this->expression["conditions"], $condition);
        } else {
            array_push($this->expression["conditions"], $condition);
        }
    }

    public function jsonSerialize()
    {
        $data = [];
        if ($this->showName != null) $data["show_name"] = $this->showName;
        if ($this->showLabel != null) $data["show_label"] = $this->showLabel;
        if ($this->expression != null) $data["expression"] = $this->expression;
        return $data;
    }
}