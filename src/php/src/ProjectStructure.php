<?php

namespace AmaTeam\ElasticSearch\Schema\Definition;

class ProjectStructure
{
    const RESOURCE_ROOT = 'resources';
    const SCHEMA_ROOT = 'schema';
    const PRODUCT_SCHEMA_ROOT = 'schema';

    /**
     * @return string
     */
    public static function getProjectRoot()
    {
        $cursor = __DIR__;
        for ($i = 0; $i < 3; $i++) {
            $cursor = dirname($cursor);
        }
        return $cursor;
    }

    /**
     * @return string
     */
    public static function getResourcesRoot()
    {
        return self::getProjectRoot() . DIRECTORY_SEPARATOR . self::RESOURCE_ROOT;
    }

    /**
     * @return string
     */
    public static function getSchemaRoot()
    {
        return self::getResourcesRoot() . DIRECTORY_SEPARATOR . self::SCHEMA_ROOT;
    }

    /**
     * @return string
     */
    public static function getProductSchemaRoot()
    {
        return self::getSchemaRoot() . DIRECTORY_SEPARATOR . self::PRODUCT_SCHEMA_ROOT;
    }
}
