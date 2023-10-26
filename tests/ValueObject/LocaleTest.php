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
    #[TestWith(['fr_FR', 'fr_FR'])]
    #[TestWith(['fr_CA', 'fr_CA'])]
    #[TestWith(['en_US', 'en_US'])]
    #[TestWith(['en_GB', 'en_GB'])]
    #[TestWith(['de-DE', 'de_DE'])]
    #[TestWith(['de-CH', 'de_CH'])]
    #[TestWith(['fr_CA.ISO-8895-1@euro', 'fr_CA'])]
    #[TestWith(['fr-CA-u-ca-gregorian-nu-arab', 'fr_CA'])]
    #[TestDox('Create locale $localeToTest with should return Locale instance with $expected value')]
    public function testValidLocaleShouldReturnLocaleInstance(string $localeToTest, string $expected): void
    {
        $locale = Locale::from($localeToTest);
        self::assertSame($expected, $locale->locale);
    }

    #[TestWith(['fr_DE'])]
    #[TestWith(['en_UK'])]
    #[TestWith(['foobar'])]
    #[TestDox('Create locale $localeToTest with should fail')]
    public function testWithInvalidLocaleShouldFail(string $localeToTest): void
    {
        $this->expectException(InvalidArgumentException::class);
        Locale::from($localeToTest);
    }

    public function testInstantiateTwiceSameLocaleReturnsSameInstance(): void
    {
        self::assertSame(
            Locale::from('fr_CA'),
            Locale::from('fr-CA-u-ca-gregorian-nu-arab')
        );
    }
}
