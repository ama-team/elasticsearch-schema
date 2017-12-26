<?php

namespace AmaTeam\ElasticSearch\Schema\Definition;

class Reader
{
    /**
     * Reads schema for bundled in product (if it exists)
     *
     * @param string $product
     *
     * @return string|null
     */
    public static function readSchema($product)
    {
        $path = Locator::locateSchema($product);
        return $path ? file_get_contents($path) : null;
    }
}
