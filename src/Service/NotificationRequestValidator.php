<?php

declare(strict_types=1);

namespace OpenID4VC\OID4VCI\Service;

use OpenID4VC\OID4VCI\Exception\InvalidNotificationRequest;
use OpenID4VC\OID4VCI\Model\NotificationRequest;

final class NotificationRequestValidator
{
    public function validate(NotificationRequest $request): void
    {
        if ($request->notificationId === '') {
            throw new InvalidNotificationRequest('notification_id is required.');
        }

        if ($request->event === '') {
            throw new InvalidNotificationRequest('event is required.');
        }
    }
}
