<?php

namespace JeckelLab\MauticWebhookParser\Tests\Parser;

use DateTimeImmutable;
use JeckelLab\MauticWebhookParser\Parser\FieldParser;
use JeckelLab\MauticWebhookParser\ValueObject\Country;
use JeckelLab\MauticWebhookParser\ValueObject\Email;
use PHPUnit\Framework\TestCase;

/**
 * @SuppressWarnings(PHPMD.TooManyPublicMethods)
 */
class FieldParserTest extends TestCase
{
    public function testParseTextFieldReturnString(): void
    {
        $data = [
            'alias' => 'address1',
            'group' => 'core',
            'id' => 10,
            'label' => 'Address Line 1',
            'type' => 'text',
            'value' => '1 rue du pont'
        ];
        $parsedData = (new FieldParser())->parseField($data);
        self::assertTrue(is_string($parsedData));
        self::assertSame('1 rue du pont', $parsedData);
    }

    public function testParseTextFieldWithNullValueReturnNull(): void
    {
        $data = [
            'alias' => 'address1',
            'group' => 'core',
            'id' => 10,
            'label' => 'Address Line 1',
            'type' => 'text',
            'value' => null
        ];
        $parsedData = (new FieldParser())->parseField($data);
        self::assertNull($parsedData);
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
        self::assertTrue(is_int($parsedData));
        self::assertSame(32, $parsedData);
    }

    public function testParseNumberFieldWithNullValueReturnNull(): void
    {
        $data = [
            'alias' => 'attribution',
            'group' => 'core',
            'id' => 18,
            'label' => 'Attribution',
            'type' => 'number',
            'value' => null
        ];
        $parsedData = (new FieldParser())->parseField($data);
        self::assertNull($parsedData);
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

    public function testParseDatetimeFieldWithNullValueReturnNull(): void
    {
        $data = [
            'alias' => 'attribution_date',
            'group' => 'core',
            'id' => 17,
            'label' => 'Attribution Date',
            'type' => 'datetime',
            'value' => null
        ];
        $parsedData = (new FieldParser())->parseField($data);
        self::assertNull($parsedData);
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
        self::assertTrue(is_bool($parsedData));
        self::assertFalse($parsedData);
    }

    public function testParseBooleanFieldWithNullValueReturnNull(): void
    {
        $data = [
            'alias' => 'boolean',
            'group' => 'core',
            'id' => 44,
            'label' => 'boolean',
            'type' => 'boolean',
            'value' => null
        ];
        $parsedData = (new FieldParser())->parseField($data);
        self::assertNull($parsedData);
    }

    public function testParseCountryFieldReturnCountry(): void
    {
        $data = [
            'alias' => 'country',
            'group' => 'core',
            'id' => 15,
            'label' => 'Country',
            'type' => 'country',
            'value' => "Czech Republic"
        ];
        $parsedData = (new FieldParser())->parseField($data);
        self::assertInstanceOf(Country::class, $parsedData);
        self::assertSame("Czech Republic", $parsedData->country);
    }

    public function testParseCountryFieldWithNullValueReturnNull(): void
    {
        $data = [
            'alias' => 'country',
            'group' => 'core',
            'id' => 15,
            'label' => 'Country',
            'type' => 'country',
            'value' => null
        ];
        $parsedData = (new FieldParser())->parseField($data);
        self::assertNull($parsedData);
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

    public function testParseEmailFieldWithNullValueReturnNull(): void
    {
        $data = [
            'alias' => 'email',
            'group' => 'core',
            'id' => 6,
            'label' => 'Email',
            'type' => 'email',
            'value' => null
        ];
        $parsedData = (new FieldParser())->parseField($data);
        self::assertNull($parsedData);
    }
}
