<?php

/**
 * @author: Julien Mercier-Rojas <julien@jeckel-lab.fr>
 * Created at: 16/10/2023
 */

declare(strict_types=1);

namespace JeckelLab\MauticWebhookParser\Tests;

use JsonException;

trait JsonHelperTrait
{
    /**
     * @throws JsonException
     * @return array<string, mixed>
     */
    public static function getParsedDataFromJsonFixtureFile(string $filename): array
    {
        /** @var string $payloadString */
        $payloadString = file_get_contents(__DIR__ . '/fixtures/' . $filename);

        /** @var array<string, mixed> $payload */
        $payload = json_decode($payloadString, true, 512, JSON_THROW_ON_ERROR);

        return $payload;
    }
}
