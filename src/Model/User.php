<?php

/**
 * @author: Julien Mercier-Rojas <julien@jeckel-lab.fr>
 * Created at: 16/10/2023
 */

declare(strict_types=1);

namespace JeckelLab\MauticWebhookParser\Model;

use JeckelLab\MauticWebhookParser\Identity\UserId;

readonly class User
{
    public function __construct(
        public UserId $id,
        public ?string $firstName,
        public ?string $lastName,
        public string $username
    ) {}
}
