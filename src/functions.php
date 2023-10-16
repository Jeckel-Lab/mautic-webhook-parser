<?php

/**
 * @author: Julien Mercier-Rojas <julien@jeckel-lab.fr>
 * Created at: 13/10/2023
 */

declare(strict_types=1);

namespace JeckelLab\MauticWebhookParser;

use DateTimeImmutable;
use Exception;
use JeckelLab\MauticWebhookParser\Exception\InvalidArgumentException;

function toNullableDateTime(mixed $date): ?DateTimeImmutable
{
    try {
        return is_string($date) ? new DateTimeImmutable($date) : null;
    } catch (Exception) {
        return null;
    }
}

function toDateTime(mixed $date): DateTimeImmutable
{
    try {
        return is_string($date) ? new DateTimeImmutable($date) : throw new InvalidArgumentException(
            "String datetime expected"
        );
    } catch (Exception) {
        throw new InvalidArgumentException(
            "Invalid datetime provided"
        );
    }
}
