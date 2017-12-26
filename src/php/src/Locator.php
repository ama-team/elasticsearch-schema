<?php

namespace AmaTeam\ElasticSearch\Schema\Definition;

class Locator
{
    /**
     * Returns path to schema for specified product (or null if no
     * such product is registered).
     *
     * @param string $product
     *
     * @return string|null
     */
    public static function locateSchema($product)
    {
        $segments = [ProjectStructure::getProductSchemaRoot(), $product . '.yml'];
        $path = implode(DIRECTORY_SEPARATOR, $segments);
        return file_exists($path) ? $path : null;
    }

    /**
     * Returns path to validation schema
     *
     * @return string
     */
    public static function locateMetaSchema()
    {
        $segments = [ProjectStructure::getSchemaRoot(), 'meta-schema.yml'];
        return implode(DIRECTORY_SEPARATOR, $segments);
    }
}
