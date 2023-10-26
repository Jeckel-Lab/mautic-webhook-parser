<?php

/**
 * @author: Julien Mercier-Rojas <julien@jeckel-lab.fr>
 * Created at: 19/10/2023
 */

namespace JeckelLab\MauticWebhookParser\ValueObject\Field;

interface Field
{
    public function alias(): string;
    public function value(): mixed;
}
