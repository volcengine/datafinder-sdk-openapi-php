<?php

namespace DataRangers;
include_once "Content.class.php";
include_once "ContentBuilder.class.php";

class DSL implements \JsonSerializable
{
    private $version = 3;
    private $userAppCloudId = true;
    private $appIds;
    private $periods;
    private Content $content;
    private $contents;
    private $option = null;
    private ContentBuilder $contentBuilder;

    /**
     * DSL constructor.
     */
    public function __construct()
    {
        $this->contentBuilder = ContentBuilder::getBuilder();
    }

    /**
     * @return int
     */
    public function getVersion(): int
    {
        return $this->version;
    }

    /**
     * @param int $version
     */
    public function setVersion(int $version): void
    {
        $this->version = $version;
    }

    /**
     * @return bool
     */
    public function isUserAppCloudId(): bool
    {
        return $this->userAppCloudId;
    }

    /**
     * @param bool $userAppCloudId
     */
    public function setUserAppCloudId(bool $userAppCloudId): void
    {
        $this->userAppCloudId = $userAppCloudId;
    }

    /**
     * @return mixed
     */
    public function getAppIds()
    {
        return $this->appIds;
    }

    /**
     * @param mixed $appIds
     */
    public function setAppIds($appIds): void
    {
        $this->appIds = $appIds;
    }

    public function addAppIds($appIds)
    {
        if ($this->appIds == null) $this->appIds = [];
        if (is_array($appIds)) $this->appIds = array_merge($this->appIds, $appIds);
        else array_push($this->appIds, $appIds);
    }

    /**
     * @return mixed
     */
    public function getPeriods()
    {
        return $this->periods;
    }

    /**
     * @param mixed $periods
     */
    public function setPeriods($periods): void
    {
        $this->periods = $periods;
    }

    public function addPeriod($periods)
    {
        if ($this->periods == null) $this->periods = [];
        array_push($this->periods, $periods);
    }

    /**
     * @return Content
     */
    public function getContent(): Content
    {
        return $this->content;
    }

    /**
     * @param Content $content
     */
    public function setContent(Content $content): void
    {
        $this->content = $content;
    }

    /**
     * @return null
     */
    public function getOption()
    {
        return $this->option;
    }

    /**
     * @param null $option
     */
    public function setOption($option): void
    {
        $this->option = $option;
    }

    /**
     * @return ContentBuilder
     */
    public function getContentBuilder(): ContentBuilder
    {
        return $this->contentBuilder;
    }

    /**
     * @param ContentBuilder $contentBuilder
     */
    public function setContentBuilder(ContentBuilder $contentBuilder): void
    {
        $this->contentBuilder = $contentBuilder;
    }

    /**
     * @return mixed
     */
    public function getContents()
    {
        return $this->contents;
    }

    /**
     * @param mixed $contents
     */
    public function setContents($contents): void
    {
        $this->contents = $contents;
    }


    private function moveContentToContents()
    {
        if ($this->content != null && $this->contents == null) {
            $this->contents = [];
            array_push($this->contents, $this->content);
//            $this->content = null;
        }
    }

    public function addContents($content)
    {
        if ($this->contents == null) $this->contents = [];
        if ($content != null) array_push($this->contents, $content);
    }

    private static function mergeDSLs($params, $dsls): DSL
    {
        $dsl = null;
        foreach ($dsls as $d) {
            if ($dsl == null) {
                $dsl = $d;
                $dsl->moveContentToContents();
            } else {
                $dsl->addContents($d->getContent());
            }
        }
        if ($params != null && is_array($params) && $dsl != null) {
            $dsl->setOption($params);
        }
        return $dsl;
    }

    public static function blendDSLs($base, $dsls): DSL
    {
        return DSL::mergeDSLs(["blend" => ["status" => true, "base" => $base]], $dsls);
    }


    public function jsonSerialize()
    {
        $data["version"] = $this->version;
        $data["use_app_cloud_id"] = $this->userAppCloudId;
        $data["app_ids"] = $this->appIds;
        $data["periods"] = $this->periods;
        if ($this->option != null) $data["option"] = $this->option;
        if ($this->contents != null) $data["contents"] = $this->contents;
        else if ($this->content != null) $data["content"] = $this->content;
        return $data;
    }
}
