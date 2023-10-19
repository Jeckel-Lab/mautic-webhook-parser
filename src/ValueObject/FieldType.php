<?php

/**
 * @author: Julien Mercier-Rojas <julien@jeckel-lab.fr>
 * Created at: 19/10/2023
 */

declare(strict_types=1);

namespace JeckelLab\MauticWebhookParser\ValueObject;

use JeckelLab\MauticWebhookParser\Identity\FieldTypeId;

final readonly class FieldType
{
    public function __construct(
        public FieldTypeType $type,
        public string $alias,
        public FieldTypeGroup $group,
        public FieldTypeId $id,
        public string $label
    ) {}
}
