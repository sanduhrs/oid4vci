<?php

declare(strict_types=1);

namespace OpenID4VC\OID4VCI\Service;

use OpenID4VC\OID4VCI\Model\NotificationRequest;
use OpenID4VC\OID4VCI\Util\Json;

final class NotificationRequestParser
{
    use ParserSupport;

    /**
     * @param array<string, mixed>|string $payload
     */
    public function parse(array|string $payload): NotificationRequest
    {
        $payload = is_string($payload) ? Json::decodeObject($payload) : $payload;

        return new NotificationRequest(
            notificationId: $this->optionalString($payload['notification_id'] ?? null) ?? '',
            event: $this->optionalString($payload['event'] ?? null) ?? '',
            eventDescription: $this->optionalString($payload['event_description'] ?? null),
            additionalParameters: $payload
        );
    }
}
