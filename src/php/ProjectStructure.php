<?php

namespace AmaTeam\ElasticSearch\Schema\Definition;

class ProjectStructure
{
    const RESOURCE_ROOT = 'resources';
    const SCHEMA_ROOT = 'schema';

    public static function getProjectRoot(): string
    {
        return dirname(dirname(__DIR__));
    }

    public static function getResourcesRoot(): string
    {
        return self::getProjectRoot() . DIRECTORY_SEPARATOR . self::RESOURCE_ROOT;
    }

    public static function getSchemaRoot(): string
    {
        return self::getResourcesRoot() . DIRECTORY_SEPARATOR . self::SCHEMA_ROOT;
    }
}
