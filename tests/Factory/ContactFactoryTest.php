<?php

/**
 * @author: Julien Mercier-Rojas <julien@jeckel-lab.fr>
 * Created at: 16/10/2023
 */

declare(strict_types=1);

namespace JeckelLab\MauticWebhookParser\Tests\Factory;

use JeckelLab\MauticWebhookParser\Factory\ContactFactory;
use JeckelLab\MauticWebhookParser\Identity\ContactId;
use JeckelLab\MauticWebhookParser\Identity\UserId;
use JeckelLab\MauticWebhookParser\Model\User;
use JeckelLab\MauticWebhookParser\ValueObject\Field\ArrayField;
use JeckelLab\MauticWebhookParser\ValueObject\Field\BoolField;
use JeckelLab\MauticWebhookParser\ValueObject\Field\DateTimeField;
use JeckelLab\MauticWebhookParser\ValueObject\Field\EmailField;
use JeckelLab\MauticWebhookParser\ValueObject\Field\IntField;
use JeckelLab\MauticWebhookParser\ValueObject\Field\LocaleField;
use JeckelLab\MauticWebhookParser\ValueObject\Field\StringField;
use JeckelLab\MauticWebhookParser\ValueObject\Locale;
use Monolog\Test\TestCase;

class ContactFactoryTest extends TestCase
{
    public function testItExtractContact(): void
    {
        /** @var string $payloadString */
        $payloadString = file_get_contents(__DIR__ . '/fixtures/contact-payload-extract.json');

        /** @var array<string, mixed> $payload */
        $payload = json_decode($payloadString, true);

        $parser = new ContactFactory();
        $contact = $parser->constructFromJson($payload);
        self::assertSame(ContactId::from(52), $contact->id);
        self::assertTrue($contact->isPublished);
        self::assertSame('2017-06-19 09:31:18', $contact->dateAdded->format('Y-m-d H:i:s'));
        self::assertSame('2017-06-20 09:31:18', $contact->dateIdentified->format('Y-m-d H:i:s'));
        self::assertNull($contact->dateModified);
        self::assertInstanceOf(User::class, $contact->owner);
        self::assertSame('admin', $contact->owner->username);
        self::assertSame('John', $contact->owner->firstName);
        self::assertSame('Doe', $contact->owner->lastName);
        self::assertSame(UserId::from(1), $contact->owner->id);
        self::assertSame(1234, $contact->points);

        self::assertCount(15, $contact->fields);
        self::assertEquals(
            [
                'address1',
                'attribution',
                'attribution_date',
                'boolean',
                'city',
                'country',
                'datetime',
                'email',
                'firstname',
                'lastname',
                'multiselect',
                'preferred_locale',
                'timezone1',
                'title',
                'zipcode'
            ],
            $contact->fields->getAliases()
        );

        $address1 = $contact->fields->get('address1');
        self::assertInstanceOf(StringField::class, $address1);
        self::assertSame('1 rue du port', $address1->value);
        /** @phpstan-ignore-next-line */
        self::assertSame('1 rue du port', $contact->address1);

        $attribution = $contact->fields->get('attribution');
        self::assertInstanceOf(IntField::class, $attribution);
        self::assertSame(32, $attribution->value);
        /** @phpstan-ignore-next-line */
        self::assertSame(32, $contact->attribution);

        $attributionDate = $contact->fields->get('attribution_date');
        self::assertInstanceOf(DateTimeField::class, $attributionDate);
        self::assertSame('2017-06-14 11:30:00', $attributionDate->value->format('Y-m-d H:i:s'));
        /** @phpstan-ignore-next-line */
        self::assertSame('2017-06-14 11:30:00', $contact->attribution_date->format('Y-m-d H:i:s'));

        $boolean = $contact->fields->get('boolean');
        self::assertInstanceOf(BoolField::class, $boolean);
        self::assertTrue($boolean->value);
        /** @phpstan-ignore-next-line */
        self::assertTrue($contact->boolean);

        $country = $contact->fields->get('country');
        self::assertInstanceOf(StringField::class, $country);
        self::assertSame('France', $country->value);
        /** @phpstan-ignore-next-line */
        self::assertSame('France', $contact->country);

        $email = $contact->fields->get('email');
        self::assertInstanceOf(EmailField::class, $email);
        self::assertEquals('john@doe.name', $email->value);
        /** @phpstan-ignore-next-line */
        self::assertEquals('john@doe.name', $contact->email);

        $multiselect = $contact->fields->get('multiselect');
        self::assertInstanceOf(ArrayField::class, $multiselect);
        self::assertEquals(['php', 'js'], $multiselect->value);
        /** @phpstan-ignore-next-line */
        self::assertEquals(['php', 'js'], $contact->multiselect);

        $preferredLocale = $contact->fields->get('preferred_locale');
        self::assertInstanceOf(LocaleField::class, $preferredLocale);
        self::assertSame(Locale::from('fr_FR'), $preferredLocale->value);
        /** @phpstan-ignore-next-line */
        self::assertSame(Locale::from('fr_FR'), $contact->preferred_locale);
    }
}
