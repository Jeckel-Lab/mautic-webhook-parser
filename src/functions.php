<?php

/**
 * @author: Julien Mercier-Rojas <julien@jeckel-lab.fr>
 * Created at: 13/10/2023
 */

declare(strict_types=1);

namespace JeckelLab\MauticWebhookParser;

use DateTimeImmutable;
use Exception;

function toNullableDateTime(mixed $date): ?DateTimeImmutable
{
    try {
        return is_string($date) ? new DateTimeImmutable($date) : null;
    } catch (Exception) {
        return null;
    }
}
