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
use JeckelLab\MauticWebhookParser\Factory\ContactFactory;
use JeckelLab\MauticWebhookParser\Model\Lead;
use JeckelLab\MauticWebhookParser\Model\MauticEvent;
use JeckelLab\MauticWebhookParser\ValueObject\MauticEventType;

class PayloadParser
{
    public function __construct(
        private readonly ContactFactory $clientParser,
    ) {}

    /**
     * @param array<string, array<array<string, mixed>>> $payload
     * @return iterable<MauticEvent>
     * @throws Exception
     */
    public function parse(array $payload): iterable
    {
        foreach ($payload as $eventName => $events) {
            if ($eventName === 'timestamp') {
                continue;
            }
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
        if (! is_array($eventPayload['contact'])) {
            throw new LogicException('Missing contact');
        }
        /** @var array<string, mixed> $contactPayload */
        $contactPayload = $eventPayload['contact'];
        return new MauticEvent(
            eventType: $event,
            client: $this->clientParser->constructFromJson($contactPayload),
            lead: new Lead(),
            timestamp: new DateTimeImmutable($eventPayload['timestamp'])
        );
    }
}
