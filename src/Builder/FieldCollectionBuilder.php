<?php

/**
 * @author: Julien Mercier-Rojas <julien@jeckel-lab.fr>
 * Created at: 19/10/2023
 */

declare(strict_types=1);

namespace JeckelLab\MauticWebhookParser\Builder;

use JeckelLab\MauticWebhookParser\Model\FieldCollection;
use JeckelLab\MauticWebhookParser\ValueObject\Field\Field;

class FieldCollectionBuilder
{
    /**
     * @var array<string, Field> $fields
     */
    private array $fields = [];

    public function reset(): self
    {
        $this->fields = [];
        return $this;
    }

    public function withField(Field $field): self
    {
        $this->fields[$field->alias()] = $field;
        return $this;
    }

    public function build(): FieldCollection
    {
        return new FieldCollection($this->fields);
    }
}
