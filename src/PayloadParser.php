<?php

/**
 * @author: Julien Mercier-Rojas <julien@jeckel-lab.fr>
 * Created at: 13/10/2023
 */

declare(strict_types=1);

namespace JeckelLab\MauticWebhookParser;

use DateTimeImmutable;
use Exception;
use JeckelLab\MauticWebhookParser\Exception\LogicException;
use JeckelLab\MauticWebhookParser\Model\Client;
use JeckelLab\MauticWebhookParser\Model\Lead;
use JeckelLab\MauticWebhookParser\Model\MauticEvent;
use JeckelLab\MauticWebhookParser\ValueObject\MauticEventType;

class PayloadParser
{
    /**
     * @param array<string, array<array<string, mixed>>> $payload
     * @return iterable<MauticEvent>
     * @throws Exception
     */
    public function parse(array $payload): iterable
    {
        foreach ($payload as $eventName => $events) {
            $event = MauticEventType::from($eventName);
            foreach ($events as $eventPayload) {
                yield $this->parseEvent($eventPayload, $event);
            }
        }
    }

    /**
     * @param array<string, mixed> $eventPayload
     * @throws Exception
     */
    public function parseEvent(array $eventPayload, MauticEventType $event): MauticEvent
    {
        if (! is_string($eventPayload['timestamp'])) {
            throw new LogicException('Missing timestamp');
        }
        return new MauticEvent(
            eventType: $event,
            client: new Client(),
            lead: new Lead(),
            timestamp: new DateTimeImmutable($eventPayload['timestamp'])
        );
    }
}
