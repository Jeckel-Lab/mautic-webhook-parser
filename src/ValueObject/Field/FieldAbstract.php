<?php

/**
 * @author: Julien Mercier-Rojas <julien@jeckel-lab.fr>
 * Created at: 19/10/2023
 */

declare(strict_types=1);

namespace JeckelLab\MauticWebhookParser\ValueObject\Field;

use JeckelLab\MauticWebhookParser\ValueObject\FieldType;

/**
 * @template FieldValueType
 */
abstract readonly class FieldAbstract implements Field
{
    /**
     * @param FieldValueType $value
     */
    public function __construct(
        public FieldType $type,
        public mixed $value
    ) {}
}
