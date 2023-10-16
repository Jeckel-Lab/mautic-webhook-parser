<?php

/**
 * @author: Julien Mercier-Rojas <julien@jeckel-lab.fr>
 * Created at: 13/10/2023
 */

declare(strict_types=1);

namespace JeckelLab\MauticWebhookParser;

use Exception;
use JeckelLab\MauticWebhookParser\Builder\ContactBuilder;
use JeckelLab\MauticWebhookParser\Builder\UserBuilder;
use JeckelLab\MauticWebhookParser\Exception\InvalidArgumentException;
use JeckelLab\MauticWebhookParser\Exception\LogicException;
use JeckelLab\MauticWebhookParser\Model\Contact;
use JeckelLab\MauticWebhookParser\Model\User;

class ContactParser
{
    /**
     * @param array<string, mixed> $payload
     * @return Contact
     * @throws Exception|LogicException
     */
    public function parse(array $payload): Contact
    {
        $owner = null;
        if (is_array($payload["owner"])) {
            /** @var array<string, mixed> $ownerData */
            $ownerData = $payload["owner"];
            $owner = $this->parseOwner($ownerData);
        }

        return (new ContactBuilder())
            ->withId(
                is_numeric($payload['id']) ? (int) $payload['id'] : throw new InvalidArgumentException('Invalid id')
            )
            ->withOwner($owner)
            ->withIsPublished((bool) $payload['isPublished'])
            ->withPoints(is_numeric($payload['points']) ? (int) $payload['points'] : 0)
            ->withDates(
                toDateTime($payload['dateAdded']),
                toDateTime($payload['dateIdentified']),
                toNullableDateTime($payload['dateModified'])
            )
            ->build();
    }

    /**
     * @param array<string, mixed> $ownerData
     * @return User
     */
    protected function parseOwner(array $ownerData): User
    {
        return (new UserBuilder())
            ->withId(
                is_numeric($ownerData['id']) ?
                    (int) $ownerData['id'] :
                    throw new InvalidArgumentException('Invalid owner Id')
            )
            ->withName(
                is_string($ownerData['firstName']) ? $ownerData['firstName'] : null,
                is_string($ownerData['lastName']) ? $ownerData['lastName'] : null
            )
            ->withUsername(
                is_string($ownerData['username']) ?
                    $ownerData['username'] :
                    throw new InvalidArgumentException('Invalid owner username')
            )
            ->build();
    }
}
