<?php

/**
 * @author: Julien Mercier-Rojas <julien@jeckel-lab.fr>
 * Created at: 13/10/2023
 */

declare(strict_types=1);

namespace JeckelLab\MauticWebhookParser;

use JeckelLab\MauticWebhookParser\ValueObject\MauticEvent;

class PayloadParser
{
    /**
     * @param array<string, mixed> $payload
     * @return iterable<array{event: MauticEvent}>
     * @SuppressWarnings(PHPMD.UnusedLocalVariable)
     */
    public function parse(array $payload): iterable
    {
        foreach ($payload as $eventName => $value) {
            $event = MauticEvent::from($eventName);
            yield ['event' => $event];
        }
    }
}
