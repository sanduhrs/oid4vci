<?php

declare(strict_types=1);

namespace OpenID4VC\OID4VCI\Service;

use OpenID4VC\OID4VCI\Model\CredentialResponse;
use OpenID4VC\OID4VCI\Model\IssuedCredential;
use OpenID4VC\OID4VCI\Util\Json;

final class CredentialResponseParser
{
    use ParserSupport;

    /**
     * @param array<string, mixed>|string $payload
     */
    public function parse(array|string $payload): CredentialResponse
    {
        $payload = is_string($payload) ? Json::decodeObject($payload) : $payload;

        $credentials = [];
        $credentialsPayload = $payload['credentials'] ?? null;
        if (is_array($credentialsPayload)) {
            foreach ($credentialsPayload as $credentialPayloadRaw) {
                $credentialPayload = $this->objectOrNull($credentialPayloadRaw);
                if ($credentialPayload === null) {
                    continue;
                }

                $credential = $credentialPayload['credential'] ?? null;
                $credentialObject = $this->objectOrNull($credential);
                if (is_string($credential)) {
                    $credentialValue = $credential;
                } elseif ($credentialObject !== null) {
                    $credentialValue = $credentialObject;
                } else {
                    continue;
                }

                $credentials[] = new IssuedCredential(
                    credential: $credentialValue,
                    additionalParameters: $credentialPayload
                );
            }
        }

        $interval = $payload['interval'] ?? null;

        return new CredentialResponse(
            credentials: $credentials,
            transactionId: $this->optionalString($payload['transaction_id'] ?? null),
            interval: is_int($interval) ? $interval : null,
            notificationId: $this->optionalString($payload['notification_id'] ?? null),
            cNonce: $this->optionalString($payload['c_nonce'] ?? null),
            additionalParameters: $payload
        );
    }
}
