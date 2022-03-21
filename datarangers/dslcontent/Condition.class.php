<?php


namespace DataRangers;


class Condition implements \JsonSerializable
{
    private $propertyValueType;
    private $propertyName;
    private $propertyOperation;
    private array $propertyValues;
    private $propertyType;

    /**
     * Condition constructor.
     * @param $propertyValueType
     * @param $propertyName
     * @param $propertyOperation
     * @param $propertyValues
     */
    public function __construct($propertyValueType, $propertyName, $propertyOperation, $propertyValues, $propertyType)
    {
        $this->propertyValueType = $propertyValueType;
        $this->propertyName = $propertyName;
        $this->propertyOperation = $propertyOperation;
        $this->propertyValues = [];
        if (is_array($propertyValues)) {
            $this->propertyValues = array_merge($this->propertyValues, $propertyValues);
        } else {
            $this->propertyValues[] = $propertyValues;
        }
        $this->propertyType = $propertyType;
    }

    /**
     * @return mixed
     */
    public function getPropertyType()
    {
        return $this->propertyType;
    }

    /**
     * @param mixed $propertyType
     */
    public function setPropertyType($propertyType)
    {
        $this->propertyType = $propertyType;
    }


    /**
     * @return mixed
     */
    public function getPropertyValueType()
    {
        return $this->propertyValueType;
    }

    /**
     * @param mixed $propertyValueType
     */
    public function setPropertyValueType($propertyValueType)
    {
        $this->propertyValueType = $propertyValueType;
    }

    /**
     * @return mixed
     */
    public function getPropertyName()
    {
        return $this->propertyName;
    }

    /**
     * @param mixed $propertyName
     */
    public function setPropertyName($propertyName)
    {
        $this->propertyName = $propertyName;
    }

    /**
     * @return mixed
     */
    public function getPropertyOperation()
    {
        return $this->propertyOperation;
    }

    /**
     * @param mixed $propertyOperation
     */
    public function setPropertyOperation($propertyOperation)
    {
        $this->propertyOperation = $propertyOperation;
    }

    /**
     * @return mixed
     */
    public function getPropertyValues()
    {
        return $this->propertyValues;
    }

    /**
     * @param mixed $propertyValues
     */
    public function setPropertyValues($propertyValues)
    {
        $this->propertyValues = $propertyValues;
    }

    public function jsonSerialize()
    {
        $data = [];
        if ($this->propertyValueType != null) $data["property_value_type"] = $this->propertyValueType;
        if ($this->propertyName != null) $data["property_name"] = $this->propertyName;
        if ($this->propertyOperation != null) $data["property_operation"] = $this->propertyOperation;
        if ($this->propertyValues != null) $data["property_values"] = $this->propertyValues;
        if ($this->propertyType != null) $data["property_type"] = $this->propertyType;
        return $data;
    }
}