<?php

declare(strict_types=1);

namespace OpenID4VC\OID4VCI\Model;

final class NotificationRequest
{
    /**
     * @param array<string, mixed> $additionalParameters
     */
    public function __construct(
        public readonly string $notificationId,
        public readonly string $event,
        public readonly ?string $eventDescription = null,
        public readonly array $additionalParameters = []
    ) {
    }
}
