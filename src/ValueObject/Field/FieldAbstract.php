<?php

/**
 * @author: Julien Mercier-Rojas <julien@jeckel-lab.fr>
 * Created at: 19/10/2023
 */

declare(strict_types=1);

namespace JeckelLab\MauticWebhookParser\ValueObject\Field;

use JeckelLab\MauticWebhookParser\Exception\InvalidArgumentException;
use JeckelLab\MauticWebhookParser\Identity\FieldTypeId;
use JeckelLab\MauticWebhookParser\ValueObject\FieldType;
use JeckelLab\MauticWebhookParser\ValueObject\FieldTypeGroup;

/**
 * @template FieldValueType
 * @property string $alias
 * @property FieldTypeGroup $group
 * @property FieldTypeId $id
 * @property string $label
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

    public function __get(string $field): mixed
    {
        if (property_exists($this->type, $field)) {
            /** @phpstan-ignore-next-line */
            return $this->type->$field;
        }
        throw new InvalidArgumentException("Unknown property $field");
    }

    public function alias(): string
    {
        return $this->type->alias;
    }
}
