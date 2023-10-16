<?php

/**
 * @author: Julien Mercier-Rojas <julien@jeckel-lab.fr>
 * Created at: 16/10/2023
 */

declare(strict_types=1);

namespace JeckelLab\MauticWebhookParser\Builder;

use JeckelLab\MauticWebhookParser\Exception\LogicException;
use JeckelLab\MauticWebhookParser\Identity\UserId;
use JeckelLab\MauticWebhookParser\Model\User;

class UserBuilder
{
    /**
     * @param array<string, mixed> $data
     */
    public function fromJsonArray(array $data): User
    {
        return new User(
            id: is_int($data['id']) ? UserId::from($data['id']) : throw new LogicException(),
            firstName: is_string($data['firstName']) ? $data['firstName'] : '',
            lastName: is_string($data['lastName']) ? $data['lastName'] : '',
            username: is_string($data['username']) ? $data['username'] : throw new LogicException()
        );
    }
}
