<?php

namespace JeckelLab\MauticWebhookParser\Tests\Parser;

use DateTimeImmutable;
use JeckelLab\MauticWebhookParser\Parser\FieldParser;
use JeckelLab\MauticWebhookParser\ValueObject\Email;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\Attributes\TestWith;
use PHPUnit\Framework\TestCase;

/**
 * @SuppressWarnings(PHPMD.TooManyPublicMethods)
 */
class FieldParserTest extends TestCase
{
    #[TestWith(['country', 'my country value'])]
    #[TestWith(['locale', 'fr_FR'])]
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
        $parsedData = (new FieldParser())->parseField($data);
        self::assertIsString($parsedData);
        self::assertSame($value, $parsedData);
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
        $parsedData = (new FieldParser())->parseField($data);
        self::assertIsInt($parsedData);
        self::assertSame(32, $parsedData);
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
        $parsedData = (new FieldParser())->parseField($data);
        self::assertInstanceOf(DateTimeImmutable::class, $parsedData);
        self::assertEquals("2017-06-14 11:30:00", $parsedData->format('Y-m-d H:i:s'));
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
        $parsedData = (new FieldParser())->parseField($data);
        self::assertIsBool($parsedData);
        self::assertFalse($parsedData);
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
        $parsedData = (new FieldParser())->parseField($data);
        self::assertInstanceOf(Email::class, $parsedData);
        self::assertSame("john@doe.name", $parsedData->email);
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
        $parsedData = (new FieldParser())->parseField($data);
        self::assertIsArray($parsedData);
        self::assertEquals(['php', 'js'], $parsedData);
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
        $parsedData = (new FieldParser())->parseField($data);
        self::assertNull($parsedData);
    }
}
