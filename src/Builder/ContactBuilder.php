<?php

/**
 * @author: Julien Mercier-Rojas <julien@jeckel-lab.fr>
 * Created at: 16/10/2023
 */

declare(strict_types=1);

namespace JeckelLab\MauticWebhookParser\Builder;

use DateTimeImmutable;
use JeckelLab\MauticWebhookParser\Exception\InvalidArgumentException;
use JeckelLab\MauticWebhookParser\Identity\ContactId;
use JeckelLab\MauticWebhookParser\Model\Contact;

use JeckelLab\MauticWebhookParser\Model\User;

use function JeckelLab\MauticWebhookParser\toNullableDateTime;

class ContactBuilder
{
    private ?ContactId $id = null;
    private ?User $owner = null;
    private bool $isPublished = true;
    private int $points = 0;
    private ?DateTimeImmutable $dateAdded = null;
    private ?DateTimeImmutable $dateIdentified = null;
    private ?DateTimeImmutable $dateModified = null;

    public function __construct()
    {
        $this->reset();
    }

    public function reset(): self
    {
        $this->id = null;
        $this->owner = null;
        $this->isPublished = true;
        $this->points = 0;
        $this->dateAdded = null;
        $this->dateIdentified = null;
        $this->dateModified = null;
        return $this;
    }

    public function withId(int|ContactId $id): self
    {
        $this->id = is_int($id) ? ContactId::from($id) : $id;
        return $this;
    }

    public function withOwner(?User $owner): self
    {
        $this->owner = $owner;
        return $this;
    }

    public function withIsPublished(bool $isPublished): self
    {
        $this->isPublished = $isPublished;
        return $this;
    }

    public function withPoints(int $points): self
    {
        $this->points = $points;
        return $this;
    }

    public function withDates(
        DateTimeImmutable $dateAdded,
        DateTimeImmutable $dateIdentified,
        ?DateTimeImmutable $dateModified = null
    ): self {
        $this->dateAdded = $dateAdded;
        $this->dateIdentified = $dateIdentified;
        $this->dateModified = $dateModified;
        return $this;
    }

    public function build(): Contact
    {
        $result = new Contact(
            dateAdded: $this->dateAdded ?? throw new InvalidArgumentException('Missing dateAdded'),
            dateIdentified: $this->dateIdentified ?? throw new InvalidArgumentException('Missing dateIdentified'),
            dateModified: $this->dateModified,
            id: $this->id ?? throw new InvalidArgumentException('Missing id'),
            isPublished: $this->isPublished,
            owner: $this->owner,
            points: $this->points,
        );
        $this->reset();
        return $result;
    }
}
