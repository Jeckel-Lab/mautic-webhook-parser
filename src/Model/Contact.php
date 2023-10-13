<?php

/**
 * @author: Julien Mercier-Rojas <julien@jeckel-lab.fr>
 * Created at: 13/10/2023
 */

declare(strict_types=1);

namespace JeckelLab\MauticWebhookParser\Model;

use DateTimeImmutable;

readonly class Contact
{
    public function __construct(
        public DateTimeImmutable $dateAdded,
        public DateTimeImmutable $dateIdentified,
        public ?DateTimeImmutable $dateModified,
        public int $id,
        public bool $isPublished,
    ) {}
}
