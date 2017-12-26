<?php

namespace AmaTeam\ElasticSearch\Schema\Definition;

use Symfony\Component\Yaml\Yaml;

class Reader
{
    /**
     * Reads schema for bundled in product (if it exists)
     *
     * @param string $product
     *
     * @return object|null
     */
    public static function readSchema($product)
    {
        return self::read(Locator::locateSchema($product));
    }

    /**
     * Reads meta schema (validation schema)
     *
     * @return object
     */
    public static function readMetaSchema()
    {
        return self::read(Locator::locateMetaSchema());
    }

    private static function read($path)
    {
        if (!$path) {
            return null;
        }
        $contents = file_get_contents($path);
        return Yaml::parse($contents, Yaml::PARSE_OBJECT_FOR_MAP);
    }
}
