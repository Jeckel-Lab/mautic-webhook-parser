<?php

/**
 * @author: Julien Mercier-Rojas <julien@jeckel-lab.fr>
 * Created at: 16/10/2023
 */

declare(strict_types=1);

namespace JeckelLab\MauticWebhookParser\Factory;

use JeckelLab\MauticWebhookParser\Builder\UserBuilder;
use JeckelLab\MauticWebhookParser\Exception\InvalidArgumentException;
use JeckelLab\MauticWebhookParser\Model\User;

class UserFactory
{
    private UserBuilder $userBuilder;

    public function __construct(?UserBuilder $userBuilder = null)
    {
        $this->userBuilder = $userBuilder ?? new UserBuilder();
    }

    /**
     * @param array<string, mixed> $jsonData
     * @return User
     */
    public function constructFromJson(array $jsonData): User
    {
        if (! is_numeric($jsonData['id'])) {
            throw new InvalidArgumentException('Invalid or missing user Id');
        }
        $this->userBuilder->withId((int) $jsonData['id']);

        if (! is_string($jsonData['username'])) {
            throw new InvalidArgumentException('Invalid or missing user username');
        }
        $this->userBuilder->withUsername($jsonData['username']);

        if (is_string($jsonData['firstName']) && is_string($jsonData['lastName'])) {
            $this->userBuilder->withName($jsonData['firstName'], $jsonData['lastName']);
        }
        return $this->userBuilder->build();
    }
}
