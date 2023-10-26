<?php

/**
 * @author: Julien Mercier-Rojas <julien@jeckel-lab.fr>
 * Created at: 19/10/2023
 */

declare(strict_types=1);

namespace Factory;

use JeckelLab\MauticWebhookParser\Factory\FieldTypeFactory;
use PHPUnit\Framework\TestCase;

class FieldTypeFactoryTest extends TestCase
{
    public function testConstructTwiceSameFieldTypeReturnSameInstance(): void
    {
        $data = [
            'alias' => 'address1',
            'group' => 'core',
            'id' => 10,
            'label' => 'Address Line 1',
            'type' => 'text',
            'value' => 'my text value'
        ];
        $factory = new FieldTypeFactory();
        $fieldType1 = $factory->constructFromJson($data);
        $fieldType2 = $factory->constructFromJson($data);
        self::assertSame($fieldType1, $fieldType2);
    }
}
