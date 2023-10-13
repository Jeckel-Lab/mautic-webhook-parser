<?php

declare(strict_types=1);

namespace JeckelLab\MauticWebhookParser\Tests;

use JeckelLab\MauticWebhookParser\Placeholder;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 *
 * @covers \JeckelLab\MauticWebhookParser\Placeholder
 */
final class PlaceholderTest extends TestCase
{
    private Placeholder $placeholder;

    protected function setUp(): void
    {
        $this->placeholder = new Placeholder('Julien Mercier-Rojas says: ');
    }

    /**
     * @test
     */
    public function testItEchoesSomething(): void
    {
        self::assertSame('Julien Mercier-Rojas says: Hello', $this->placeholder->echo('Hello'));
    }
}
