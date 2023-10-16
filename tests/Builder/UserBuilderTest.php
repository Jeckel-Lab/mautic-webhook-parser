<?php

/**
 * @author: Julien Mercier-Rojas <julien@jeckel-lab.fr>
 * Created at: 16/10/2023
 */

namespace JeckelLab\MauticWebhookParser\Tests\Builder;

use JeckelLab\MauticWebhookParser\Builder\UserBuilder;
use JeckelLab\MauticWebhookParser\Identity\UserId;
use JeckelLab\MauticWebhookParser\Tests\JsonHelperTrait;
use JsonException;
use PHPUnit\Framework\TestCase;

class UserBuilderTest extends TestCase
{
    use JsonHelperTrait;

    /**
     * @throws JsonException
     */
    public function testBuildFromJsonShouldGenerateUser(): void
    {
        $payload = self::getParsedDataFromJsonFixtureFile('user-payload-extract.json');
        $user = (new UserBuilder())->fromJsonArray($payload);
        self::assertSame(UserId::from(1), $user->id);
        self::assertSame('John', $user->firstName);
        self::assertSame('Doe', $user->lastName);
        self::assertSame('admin', $user->username);
    }
}
