<?php

namespace JeckelLab\MauticWebhookParser\Tests\Parser;

use JeckelLab\MauticWebhookParser\Parser\FieldParser;
use PHPUnit\Framework\TestCase;

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
}
