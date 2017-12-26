<?php

namespace AmaTeam\ElasticSearch\Schema\Definition\Test\tests\Suite\Acceptance;

use AmaTeam\ElasticSearch\Schema\Definition\Reader;
use Codeception\Test\Unit;
use PHPUnit\Framework\Assert;

class PresenceTest extends Unit
{
    /**
     * @test
     */
    public function elasticSearchSchemaExists()
    {
        Assert::assertNotNull(Reader::readSchema('elasticsearch'));
    }

    /**
     * @test
     */
    public function missingSchemaIsMissing()
    {
        Assert::assertNull(Reader::readSchema('missing'));
    }

    /**
     * @test
     */
    public function metaSchemaExists()
    {
        Assert::assertNotNull(Reader::readMetaSchema());
    }
}
