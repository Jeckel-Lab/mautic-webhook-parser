<?php

namespace JeckelLab\MauticWebhookParser\Tests\Factory;

use JeckelLab\MauticWebhookParser\Factory\FieldCollectionFactory;
use PHPUnit\Framework\TestCase;

class FieldCollectionFactoryTest extends TestCase
{
    public function testFactoryWithEmptyArrayShouldReturnEmptyCollection(): void
    {
        $data = [];
        $collection = (new FieldCollectionFactory())->constructFromJson($data);
        self::assertCount(0, $collection);
    }
}
