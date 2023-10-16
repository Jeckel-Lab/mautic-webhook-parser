<?php

/**
 * @author: Julien Mercier-Rojas <julien@jeckel-lab.fr>
 * Created at: 16/10/2023
 */

declare(strict_types=1);

namespace JeckelLab\MauticWebhookParser\Tests\Builder;

use DateTimeImmutable;
use JeckelLab\MauticWebhookParser\Builder\ContactBuilder;
use JeckelLab\MauticWebhookParser\Identity\UserId;
use JeckelLab\MauticWebhookParser\Model\User;
use PHPUnit\Framework\TestCase;

class ContactBuilderTest extends TestCase
{
    public function testFullBuildShouldReturnContact(): void
    {
        $owner = new User(UserId::from(123), null, null, 'admin');
        $dateAdded = new DateTimeImmutable();
        $dateIdentified = new DateTimeImmutable();
        $dateModified = new DateTimeImmutable();

        $builder = new ContactBuilder();
        $builder
            ->withId(123)
            ->withOwner($owner)
            ->withIsPublished(false)
            ->withPoints(456)
            ->withDates(
                $dateAdded,
                $dateIdentified,
                $dateModified
            );

        $contact = $builder->build();

        self::assertEquals(123, $contact->id->id());
        self::assertSame($owner, $contact->owner);
        self::assertFalse($contact->isPublished);
        self::assertEquals(456, $contact->points);
        self::assertSame($dateAdded, $contact->dateAdded);
        self::assertSame($dateIdentified, $contact->dateIdentified);
        self::assertSame($dateModified, $contact->dateModified);
    }
}
