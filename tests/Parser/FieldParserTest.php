<?php

namespace JeckelLab\MauticWebhookParser\Tests\Parser;

use JeckelLab\MauticWebhookParser\Parser\FieldParser;
use JeckelLab\MauticWebhookParser\ValueObject\Field\ArrayField;
use JeckelLab\MauticWebhookParser\ValueObject\Field\BoolField;
use JeckelLab\MauticWebhookParser\ValueObject\Field\DateTimeField;
use JeckelLab\MauticWebhookParser\ValueObject\Field\EmailField;
use JeckelLab\MauticWebhookParser\ValueObject\Field\IntField;
use JeckelLab\MauticWebhookParser\ValueObject\Field\LocaleField;
use JeckelLab\MauticWebhookParser\ValueObject\Field\StringField;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\Attributes\TestWith;
use PHPUnit\Framework\TestCase;

/**
 * @SuppressWarnings(PHPMD.TooManyPublicMethods)
 */
class FieldParserTest extends TestCase
{
    #[TestWith(['country', 'my country value'])]
    #[TestWith(['lookup', 'Mr.'])]
    #[TestWith(['region', 'my region value'])]
    #[TestWith(['select', 'my select value'])]
    #[TestWith(['tel', '01 23 45 67 89'])]
    #[TestWith(['text', 'my text value'])]
    #[TestWith(['timezone', 'Europe/Paris'])]
    #[TestWith(['url', 'https://jeckel-lab.fr'])]
    #[TestDox('Parse field of type $type with value $value should return string')]
    public function testParseFieldWhichShouldReturnString(string $type, string $value): void
    {
        $data = [
            'alias' => 'address1',
            'group' => 'core',
            'id' => 10,
            'label' => 'Address Line 1',
            'type' => $type,
            'value' => $value
        ];
        $parsedData = (new FieldParser())->parseFieldValue($data);
        self::assertInstanceOf(StringField::class, $parsedData);
        self::assertSame($value, $parsedData->value);
    }

    public function testParseNumberFieldReturnInt(): void
    {
        $data = [
            'alias' => 'attribution',
            'group' => 'core',
            'id' => 18,
            'label' => 'Attribution',
            'type' => 'number',
            'value' => 32
        ];
        $parsedData = (new FieldParser())->parseFieldValue($data);
        self::assertInstanceOf(IntField::class, $parsedData);
        self::assertSame(32, $parsedData->value);
    }

    public function testParseDatetimeFieldReturnDateTimeImmutable(): void
    {
        $data = [
            'alias' => 'attribution_date',
            'group' => 'core',
            'id' => 17,
            'label' => 'Attribution Date',
            'type' => 'datetime',
            'value' => "2017-06-14 11:30:00"
        ];
        $parsedData = (new FieldParser())->parseFieldValue($data);
        self::assertInstanceOf(DateTimeField::class, $parsedData);
        self::assertEquals("2017-06-14 11:30:00", $parsedData->value->format('Y-m-d H:i:s'));
    }

    public function testParseBooleanFieldReturnBoolean(): void
    {
        $data = [
            'alias' => 'boolean',
            'group' => 'core',
            'id' => 44,
            'label' => 'boolean',
            'type' => 'boolean',
            'value' => false
        ];
        $parsedData = (new FieldParser())->parseFieldValue($data);
        self::assertInstanceOf(BoolField::class, $parsedData);
        self::assertFalse($parsedData->value);
    }

    public function testParseEmailFieldReturnEmail(): void
    {
        $data = [
            'alias' => 'email',
            'group' => 'core',
            'id' => 6,
            'label' => 'Email',
            'type' => 'email',
            'value' => "john@doe.name"
        ];
        $parsedData = (new FieldParser())->parseFieldValue($data);
        self::assertInstanceOf(EmailField::class, $parsedData);
        self::assertSame("john@doe.name", $parsedData->value->email);
    }

    public function testParseLocaleFieldReturnLocale(): void
    {
        $data = [
            'alias' => 'preferred_locale',
            'group' => 'core',
            'id' => 6,
            'label' => 'Preferred Locale',
            'type' => 'locale',
            'value' => "fr_FR"
        ];
        $parsedData = (new FieldParser())->parseFieldValue($data);
        self::assertInstanceOf(LocaleField::class, $parsedData);
        self::assertSame("fr_FR", $parsedData->value->locale);
    }

    public function testParseFieldOfTypeMultiselectShouldReturnArray(): void
    {
        $data = [
            'alias' => 'multiselect',
            'group' => 'core',
            'id' => 42,
            'label' => 'Multiselect',
            'type' => 'multiselect',
            'value' => "php|js"
        ];
        $parsedData = (new FieldParser())->parseFieldValue($data);
        self::assertInstanceOf(ArrayField::class, $parsedData);
        self::assertEquals(['php', 'js'], $parsedData->value);
    }

    #[TestWith(['boolean'])]
    #[TestWith(['country'])]
    #[TestWith(['datetime'])]
    #[TestWith(['email'])]
    #[TestWith(['locale'])]
    #[TestWith(['lookup'])]
    #[TestWith(['multiselect'])]
    #[TestWith(['number'])]
    #[TestWith(['region'])]
    #[TestWith(['select'])]
    #[TestWith(['tel'])]
    #[TestWith(['text'])]
    #[TestWith(['timezone'])]
    #[TestWith(['url'])]
    #[TestDox('Parse field of type $type with null value should return null')]
    public function testParseFieldWithNullValueReturnNull(string $type): void
    {
        $data = [
            'alias' => 'address1',
            'group' => 'core',
            'id' => 10,
            'label' => 'Address Line 1',
            'type' => $type,
            'value' => null
        ];
        $parsedData = (new FieldParser())->parseFieldValue($data);
        self::assertNull($parsedData);
    }
}
