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
use JeckelLab\MauticWebhookParser\Identity\ContactId;
use JeckelLab\MauticWebhookParser\Model\Contact;

class ContactParser
{
    /**
     * @param array<string, mixed> $payload
     * @return Contact
     * @throws Exception|LogicException
     */
    public function parse(array $payload): Contact
    {
        return new Contact(
            dateAdded: is_string($payload['dateAdded']) ? new DateTimeImmutable($payload['dateAdded']) : throw new LogicException('Missing dateAdded'),
            dateIdentified: is_string($payload['dateIdentified']) ? new DateTimeImmutable($payload['dateIdentified']) : throw new LogicException('Missing dateIdentified'),
            dateModified: toNullableDateTime($payload['dateModified'] ?? null),
            id: is_int($payload['id']) ? ContactId::from($payload['id']) : throw new LogicException('Missing id'),
            isPublished: (bool) $payload['isPublished'],
        );
    }
}
