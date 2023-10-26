<?php

/**
 * @author: Julien Mercier-Rojas <julien@jeckel-lab.fr>
 * Created at: 18/10/2023
 */

declare(strict_types=1);

namespace JeckelLab\MauticWebhookParser\ValueObject;

use JeckelLab\MauticWebhookParser\Exception\InvalidArgumentException;
use ResourceBundle;
use Stringable;

final readonly class Locale implements Stringable
{
    private function __construct(public string $locale) {}

    public static function from(string $locale): self
    {
        static $locales = null;
        static $instances = [];
        if ($locales === null) {
            $locales = ResourceBundle::getLocales('');
        }
        $parts = \Locale::parseLocale($locale);
        if (! isset($parts['language'], $parts['region'])) {
            throw new InvalidArgumentException("Invalid locale $locale provided");
        }
        $normalizedLocale = $parts['language'] . '_' . strtoupper($parts['region']);
        if (!in_array($normalizedLocale, $locales, true)) {
            throw new InvalidArgumentException("Invalid locale $locale provided");
        }
        if (! isset($instances[$normalizedLocale])) {
            $instances[$normalizedLocale] = new self($normalizedLocale);
        }
        return $instances[$normalizedLocale];
    }

    public function __toString(): string
    {
        return $this->locale;
    }
}
