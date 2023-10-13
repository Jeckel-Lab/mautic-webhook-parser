<?php

/**
 * @author: Julien Mercier-Rojas <julien@jeckel-lab.fr>
 * Created at: 13/10/2023
 */

declare(strict_types=1);

namespace JeckelLab\MauticWebhookParser\Model;

use DateTimeImmutable;
use JeckelLab\MauticWebhookParser\ValueObject\MauticEventType;

readonly class MauticEvent
{
    public function __construct(
        public MauticEventType $eventType,
        public Client $client,
        public Lead $lead,
        public DateTimeImmutable $timestamp
    ) {}
}
