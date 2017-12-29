<?php

namespace AmaTeam\ElasticSearch\Schema\Definition;

final class Locator
{
    const RESOURCE_ROOT = 'resources';
    const SCHEMA_ROOT = 'schema';
    const SCHEMA_FILE = 'schema.yml';
    const VALIDATION_SCHEMA_FILE = 'validation-schema.yml';

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
    public static function getSchemaLocation()
    {
        return self::getSchemaRoot() . DIRECTORY_SEPARATOR . self::SCHEMA_FILE;
    }

    /**
     * @return string
     */
    public static function getValidationSchemaLocation()
    {
        return self::getSchemaRoot() . DIRECTORY_SEPARATOR . self::VALIDATION_SCHEMA_FILE;
    }
}
