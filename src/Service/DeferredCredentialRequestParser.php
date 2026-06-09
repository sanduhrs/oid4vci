<?php

declare(strict_types=1);

namespace OpenID4VC\OID4VCI\Service;

use OpenID4VC\OID4VCI\Model\DeferredCredentialRequest;
use OpenID4VC\OID4VCI\Util\Json;

final class DeferredCredentialRequestParser
{
    use ParserSupport;

    /**
     * @param array<string, mixed>|string $payload
     */
    public function parse(array|string $payload): DeferredCredentialRequest
    {
        $payload = is_string($payload) ? Json::decodeObject($payload) : $payload;

        return new DeferredCredentialRequest(
            transactionId: $this->optionalString($payload['transaction_id'] ?? null) ?? '',
            credentialResponseEncryption: $this->objectOrNull($payload['credential_response_encryption'] ?? null) ?? [],
            additionalParameters: $payload
        );
    }
}
