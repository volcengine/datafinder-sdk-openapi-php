<?php


namespace DataRangers;

include_once "FilterBuilder.class.php";
include_once "Filter.class.php";
include_once "Condition.class.php";
include_once "QueryBuilder.class.php";
include_once "Query.class.php";

class Expr
{
    public static function expr($valueType, $name, $operation, $values, $type): FilterBuilder
    {
        return FilterBuilder::getBuilder()->conditions(new Condition($valueType, $name, $operation, $values, $type));
    }

    public static function emptyExpr(): FilterBuilder
    {
        return FilterBuilder::getBuilder();
    }

    public static function stringExpr($name, $operation, $values, $type = "profile"): FilterBuilder
    {
        return Expr::expr("string", $name, $operation, $values, $type);
    }

    public static function intExpr($name, $operation, $values, $type = "profile"): FilterBuilder
    {
        return Expr::expr("int", $name, $operation, $values, $type);
    }

    public static function show($label, $name): QueryBuilder
    {
        return QueryBuilder::getBuilder()->showLabel($label)->showName($name);
    }
}