<?php

declare(strict_types=1);

namespace OpenID4VC\OID4VCI\Service;

use OpenID4VC\OID4VCI\Model\TokenRequest;
use OpenID4VC\OID4VCI\Util\Json;

final class TokenRequestParser
{
    use ParserSupport;

    public function __construct(
        private readonly AuthorizationDetailsParser $authorizationDetailsParser = new AuthorizationDetailsParser()
    ) {
    }

    /**
     * @param array<string, mixed>|string $payload
     */
    public function parse(array|string $payload): TokenRequest
    {
        $payload = is_string($payload) ? Json::decodeObject($payload) : $payload;

        return new TokenRequest(
            grantType: $this->optionalString($payload['grant_type'] ?? null) ?? '',
            code: $this->optionalString($payload['code'] ?? null),
            redirectUri: $this->optionalString($payload['redirect_uri'] ?? null),
            clientId: $this->optionalString($payload['client_id'] ?? null),
            preAuthorizedCode: $this->optionalString($payload['pre-authorized_code'] ?? null),
            txCode: $this->optionalString($payload['tx_code'] ?? null),
            authorizationDetails: $this->authorizationDetailsParser->parse($payload['authorization_details'] ?? null),
            additionalParameters: $payload
        );
    }
}
