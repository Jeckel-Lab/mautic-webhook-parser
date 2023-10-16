<?php

/**
 * @author: Julien Mercier-Rojas <julien@jeckel-lab.fr>
 * Created at: 16/10/2023
 */

declare(strict_types=1);

namespace JeckelLab\MauticWebhookParser\Builder;

use JeckelLab\MauticWebhookParser\Exception\InvalidArgumentException;
use JeckelLab\MauticWebhookParser\Identity\UserId;
use JeckelLab\MauticWebhookParser\Model\User;

class UserBuilder
{
    private ?UserId $id = null;
    private ?string $firstName = null;
    private ?string $lastName = null;
    private ?string $username = null;

    public function __construct()
    {
        $this->reset();
    }

    public function reset(): self
    {
        $this->id = null;
        $this->firstName = null;
        $this->lastName = null;
        $this->username = null;
        return $this;
    }

    public function withId(int|UserId $id): self
    {
        $this->id = is_int($id) ? UserId::from($id) : $id;
        return $this;
    }

    public function withName(?string $firstName, ?string $lastName): self
    {
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        return $this;
    }

    public function withUsername(string $username): self
    {
        $this->username = $username;
        return $this;
    }

    public function build(): User
    {
        $user = new User(
            id: $this->id ?? throw new InvalidArgumentException('Missing id'),
            firstName: $this->firstName,
            lastName: $this->lastName,
            username: $this->username ?? throw new InvalidArgumentException('Missing username'),
        );
        $this->reset();
        return $user;
    }
}
