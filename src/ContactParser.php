<?php

/**
 * @author: Julien Mercier-Rojas <julien@jeckel-lab.fr>
 * Created at: 13/10/2023
 */

declare(strict_types=1);

namespace JeckelLab\MauticWebhookParser;

use Exception;
use JeckelLab\MauticWebhookParser\Builder\ContactBuilder;
use JeckelLab\MauticWebhookParser\Director\UserDirector;
use JeckelLab\MauticWebhookParser\Exception\InvalidArgumentException;
use JeckelLab\MauticWebhookParser\Exception\LogicException;
use JeckelLab\MauticWebhookParser\Model\Contact;

class ContactParser
{
    private UserDirector $userDirector;

    public function __construct(?UserDirector $userDirector = null)
    {
        $this->userDirector = $userDirector ?? new UserDirector();
    }

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
            $owner = $this->userDirector->constructFromJson($ownerData);
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
}
