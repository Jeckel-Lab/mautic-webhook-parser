<?php

/**
 * @author: Julien Mercier-Rojas <julien@jeckel-lab.fr>
 * Created at: 18/10/2023
 */

declare(strict_types=1);

namespace JeckelLab\MauticWebhookParser\ValueObject;

use JeckelLab\MauticWebhookParser\Exception\InvalidArgumentException;
use ResourceBundle;

final readonly class Locale
{
    public function __construct(
        public string $locale
    ) {
        static $locales = null;
        if ($locales === null) {
            $locales = ResourceBundle::getLocales('');
        }
        if (!in_array($locale, $locales, true)) {
            throw new InvalidArgumentException("Invalid locale $locale provided");
        }
    }
}
