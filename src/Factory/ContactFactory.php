<?php

/**
 * @author: Julien Mercier-Rojas <julien@jeckel-lab.fr>
 * Created at: 13/10/2023
 */

declare(strict_types=1);

namespace JeckelLab\MauticWebhookParser\Factory;

use Exception;
use JeckelLab\MauticWebhookParser\Builder\ContactBuilder;
use JeckelLab\MauticWebhookParser\Exception\InvalidArgumentException;
use JeckelLab\MauticWebhookParser\Exception\LogicException;
use JeckelLab\MauticWebhookParser\Model\Contact;

use function JeckelLab\MauticWebhookParser\toDateTime;
use function JeckelLab\MauticWebhookParser\toNullableDateTime;

class ContactFactory
{
    private UserFactory $userFactory;
    private FieldCollectionFactory $fieldsFactory;

    public function __construct(?UserFactory $userFactory = null, ?FieldCollectionFactory $fieldsFactory = null)
    {
        $this->userFactory = $userFactory ?? new UserFactory();
        $this->fieldsFactory = $fieldsFactory ?? new FieldCollectionFactory();
    }

    /**
     * @param array<string, mixed> $payload
     * @return Contact
     * @throws Exception|LogicException
     */
    public function constructFromJson(array $payload): Contact
    {
        $owner = null;
        if (is_array($payload["owner"])) {
            /** @var array<string, mixed> $ownerData */
            $ownerData = $payload["owner"];
            $owner = $this->userFactory->constructFromJson($ownerData);
        }
        if (! is_array($payload['fields'])) {
            throw new InvalidArgumentException('Missing fields');
        }
        /** @var array<string, mixed> $fieldsData */
        $fieldsData = $payload['fields'];
        $fields = $this->fieldsFactory->constructFromJson($fieldsData);

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
            ->withFields($fields)
            ->build();
    }
}
