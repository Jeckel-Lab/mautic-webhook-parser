<?php

/**
 * @author: Julien Mercier-Rojas <julien@jeckel-lab.fr>
 * Created at: 13/10/2023
 */

declare(strict_types=1);

namespace JeckelLab\MauticWebhookParser\Model;

use DateTimeImmutable;
use JeckelLab\MauticWebhookParser\Identity\ContactId;

readonly class Contact
{
    public function __construct(
        public DateTimeImmutable $dateAdded,
        public DateTimeImmutable $dateIdentified,
        public ?DateTimeImmutable $dateModified,
        public ContactId $id,
        public bool $isPublished,
        public ?User $owner,
        public int $points,
        public FieldCollection $fields,
    ) {}

    public function __get(string $alias): mixed
    {
        return $this->fields->get($alias)?->value();
    }
}
