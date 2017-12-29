<?php

namespace AmaTeam\ElasticSearch\Schema\Definition;

class Loader
{
    public static function loadSchema()
    {
        return file_get_contents(Locator::getSchemaLocation());
    }

    public static function loadValidationSchema()
    {
        return file_get_contents(Locator::getValidationSchemaLocation());
    }
}
