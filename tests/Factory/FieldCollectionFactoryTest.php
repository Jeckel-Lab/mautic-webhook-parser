<?php

namespace JeckelLab\MauticWebhookParser\Tests\Factory;

use JeckelLab\MauticWebhookParser\Factory\FieldCollectionFactory;
use JeckelLab\MauticWebhookParser\Identity\FieldTypeId;
use JeckelLab\MauticWebhookParser\ValueObject\Field\LocaleField;
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
        self::assertNull($collection->get('address1'));
    }

    public function testFactoryWithSingleFieldShouldReturnCollection(): void
    {
        $data = [
            'core' => [
                'address1' => [
                    'alias' => 'address1',
                    'group' => 'core',
                    'id' => 10,
                    'label' => 'Address Line 1',
                    'type' => 'text',
                    'value' => '1 rue du port'
                ]
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

    public function testFactoryWithSingleLocalFieldShouldReturnCollection(): void
    {
        $data = [
            'core' => [
                'preferred_locale' => [
                    'alias' => 'preferred_locale',
                    'group' => 'core',
                    'id' => 16,
                    'label' => 'Preferred Locale',
                    'type' => 'locale',
                    'value' => 'fr_FR'
                ]
            ]
        ];
        $collection = (new FieldCollectionFactory())->constructFromJson($data);
        self::assertCount(1, $collection);
        self::assertNull($collection->get('address1'));

        $field = $collection->get('preferred_locale');
        self::assertInstanceOf(LocaleField::class, $field);
        self::assertSame('preferred_locale', $field->alias);
        self::assertSame(FieldTypeGroup::CORE, $field->group);
        self::assertSame(FieldTypeId::from(16), $field->id);
        self::assertSame('Preferred Locale', $field->label);
        self::assertSame('fr_FR', (string) $field->value);
    }

    public function testFactoryWithMultipleFieldsShouldReturnCollection(): void
    {
        $data = [
            'core' =>  [
                'address1' => [
                    'alias' => 'address1',
                    'group' => 'core',
                    'id' => 10,
                    'label' => 'Address Line 1',
                    'type' => 'text',
                    'value' => '1 rue du port'
                ]
            ],
            'social' => [
                'preferred_locale' => [
                    'alias' => 'preferred_locale',
                    'group' => 'social',
                    'id' => 16,
                    'label' => 'Preferred Locale',
                    'type' => 'locale',
                    'value' => 'fr_FR'
                ]
            ]
        ];

        $collection = (new FieldCollectionFactory())->constructFromJson($data);
        self::assertCount(2, $collection);

        $field = $collection->get('address1');
        self::assertInstanceOf(StringField::class, $field);
        self::assertSame('address1', $field->alias);
        self::assertSame(FieldTypeGroup::CORE, $field->group);
        self::assertSame(FieldTypeId::from(10), $field->id);
        self::assertSame('Address Line 1', $field->label);
        self::assertSame('1 rue du port', $field->value);

        $field = $collection->get('preferred_locale');
        self::assertInstanceOf(LocaleField::class, $field);
        self::assertSame('preferred_locale', $field->alias);
        self::assertSame(FieldTypeGroup::SOCIAL, $field->group);
        self::assertSame(FieldTypeId::from(16), $field->id);
        self::assertSame('Preferred Locale', $field->label);
        self::assertSame('fr_FR', (string) $field->value);
    }
}
