<?php


namespace DataRangers;

include_once "Content.class.php";

class ContentBuilder
{
    private Content $content;

    /**
     * ContentBuilder constructor.
     * @param $content
     */
    public function __construct(Content $content)
    {
        $this->content = $content;
    }

    public function queryType($queryType)
    {
        $this->content->setQueryType($queryType);
        return $this;
    }

    public function profileFilter($profileFilter)
    {
        $this->content->addProfileFilter($profileFilter);
        return $this;
    }

    public function profileGroup($profileGroup)
    {
        $this->content->addProfileGroup($profileGroup);
        return $this;
    }

    public function orders($orders, $direction = "asc")
    {
        $this->content->addOrders($orders,$direction);
        return $this;
    }

    public function page(int $limit,int $offset)
    {
        $this->content->setPage(["limit" => $limit, "offset" => $offset]);
        return $this;
    }

    public function limit(int $limit)
    {
        $this->content->addPageLimit($limit);
        return $this;
    }

    public function offset(int $offset)
    {
        $this->content->addPageOffset($offset);
        return $this;
    }

    public function option($key, $value)
    {
        $this->content->addOption($key, $value);
        return $this;
    }

    public function showOption($key, $value)
    {
        $this->content->addShowOption($key, $value);
        return $this;
    }

    public function query($query)
    {
        $this->content->addQuery($query);
        return $this;
    }

    public function build()
    {
        return $this->content;
    }

    public static function getBuilder(): ContentBuilder
    {
        return new ContentBuilder(new Content());
    }

}