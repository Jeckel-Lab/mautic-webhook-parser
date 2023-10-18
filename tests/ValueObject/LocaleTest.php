<?php

/**
 * @author: Julien Mercier-Rojas <julien@jeckel-lab.fr>
 * Created at: 18/10/2023
 */

namespace JeckelLab\MauticWebhookParser\Tests\ValueObject;

use JeckelLab\MauticWebhookParser\Exception\InvalidArgumentException;
use JeckelLab\MauticWebhookParser\ValueObject\Locale;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\Attributes\TestWith;
use PHPUnit\Framework\TestCase;

class LocaleTest extends TestCase
{
    #[TestWith(['fr_FR'])]
    #[TestWith(['fr_CA'])]
    #[TestWith(['en_US'])]
    #[TestWith(['en_GB'])]
    #[TestDox('Create locale $localeToTest with should return Locale instance')]
    public function testValidLocaleShouldReturnLocaleInstance(string $localeToTest): void
    {
        $locale = new Locale($localeToTest);
        self::assertSame($localeToTest, $locale->locale);
    }

    #[TestWith(['fr_DE'])]
    #[TestWith(['en_UK'])]
    #[TestWith(['foobar'])]
    #[TestDox('Create locale $localeToTest with should fail')]
    public function testWithInvalidLocaleShouldFail(string $localeToTest): void
    {
        $this->expectException(InvalidArgumentException::class);
        new Locale($localeToTest);
    }
}
