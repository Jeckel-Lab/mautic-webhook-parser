<?php

/**
 * @author: Julien Mercier-Rojas <julien@jeckel-lab.fr>
 * Created at: 16/10/2023
 */

namespace JeckelLab\MauticWebhookParser\Tests\Builder;

use JeckelLab\MauticWebhookParser\Builder\UserBuilder;
use JeckelLab\MauticWebhookParser\Exception\InvalidArgumentException;
use JeckelLab\MauticWebhookParser\Identity\UserId;
use JeckelLab\MauticWebhookParser\Tests\JsonHelperTrait;
use PHPUnit\Framework\TestCase;

class UserBuilderTest extends TestCase
{
    use JsonHelperTrait;

    public function testFullBuildShouldGenerateUser(): void
    {
        $user = (new UserBuilder())->withId(1)->withName('John', 'Doe')->withUsername('admin')->build();
        self::assertSame(UserId::from(1), $user->id);
        self::assertSame('John', $user->firstName);
        self::assertSame('Doe', $user->lastName);
        self::assertSame('admin', $user->username);
    }

    public function testBuildWithMinimalShouldGenerateUser(): void
    {
        $user = (new UserBuilder())->withId(1)->withUsername('admin')->build();
        self::assertSame(UserId::from(1), $user->id);
        self::assertNull($user->firstName);
        self::assertNull($user->lastName);
        self::assertSame('admin', $user->username);
    }

    public function testBuildWithoutIdShouldThrowException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Missing id');
        (new UserBuilder())->withName('John', 'Doe')->withUsername('admin')->build();
    }

    public function testBuildWithoutUsernameShouldThrowException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Missing username');
        (new UserBuilder())->withId(1)->withName('John', 'Doe')->build();
    }
}
