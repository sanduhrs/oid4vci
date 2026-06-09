<?php

declare(strict_types=1);

namespace OpenID4VC\OID4VCI\Tests;

use OpenID4VC\OID4VCI\OID4VCI;
use PHPUnit\Framework\TestCase;

final class NotificationRequestTest extends TestCase
{
    public function testValidatesNotificationRequest(): void
    {
        $oid4vci = new OID4VCI();

        $request = $oid4vci->parseNotificationRequest([
            'notification_id' => '3fwe98js',
            'event' => 'credential_accepted',
            'event_description' => 'Credential was accepted by the wallet.',
        ]);

        $oid4vci->validateNotificationRequest($request);
        self::assertSame('credential_accepted', $request->event);
    }
}
