<?php

/**
 * @author: Julien Mercier-Rojas <julien@jeckel-lab.fr>
 * Created at: 19/10/2023
 */

declare(strict_types=1);

namespace JeckelLab\MauticWebhookParser\Model;

use Countable;
use JeckelLab\MauticWebhookParser\ValueObject\Field\Field;

readonly class FieldCollection implements Countable
{
    /**
     * @param array<string, Field> $fields
     */
    public function __construct(private array $fields) {}

    public function get(string $name): ?Field
    {
        return $this->fields[$name] ?? null;
    }

    public function count(): int
    {
        return count($this->fields);
    }
}
