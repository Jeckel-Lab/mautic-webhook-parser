<?php

namespace JeckelLab\MauticWebhookParser\Tests\Factory;

use JeckelLab\MauticWebhookParser\Factory\FieldCollectionFactory;
use JeckelLab\MauticWebhookParser\Identity\FieldTypeId;
use JeckelLab\MauticWebhookParser\ValueObject\Field\StringField;
use JeckelLab\MauticWebhookParser\ValueObject\FieldTypeGroup;
use PHPUnit\Framework\TestCase;

class FieldCollectionFactoryTest extends TestCase
{
    public function testFactoryWithEmptyArrayShouldReturnEmptyCollection(): void
    {
        $data = [];
        $collection = (new FieldCollectionFactory())->constructFromJson($data);
        self::assertCount(0, $collection);
    }

    public function testFactoryWithSingleFieldShouldReturnCollection(): void
    {
        $data = [
            'address1' => [
                'alias' => 'address1',
                'group' => 'core',
                'id' => 10,
                'label' => 'Address Line 1',
                'type' => 'text',
                'value' => '1 rue du port'
            ]
        ];
        $collection = (new FieldCollectionFactory())->constructFromJson($data);
        self::assertCount(1, $collection);
        $field = $collection->get('address1');
        self::assertInstanceOf(StringField::class, $field);
        self::assertSame('address1', $field->alias);
        self::assertSame(FieldTypeGroup::CORE, $field->group);
        self::assertSame(FieldTypeId::from(10), $field->id);
        self::assertSame('Address Line 1', $field->label);
        self::assertSame('1 rue du port', $field->value);
    }
}
