<?php

declare(strict_types=1);

namespace OpenID4VC\OID4VCI\Service;

use OpenID4VC\OID4VCI\Model\TokenResponse;
use OpenID4VC\OID4VCI\Util\Json;

final class TokenResponseParser
{
    use ParserSupport;

    public function __construct(
        private readonly AuthorizationDetailsParser $authorizationDetailsParser = new AuthorizationDetailsParser()
    ) {
    }

    /**
     * @param array<string, mixed>|string $payload
     */
    public function parse(array|string $payload): TokenResponse
    {
        $payload = is_string($payload) ? Json::decodeObject($payload) : $payload;
        $expiresIn = $payload['expires_in'] ?? null;

        return new TokenResponse(
            accessToken: $this->optionalString($payload['access_token'] ?? null) ?? '',
            tokenType: $this->optionalString($payload['token_type'] ?? null) ?? '',
            expiresIn: is_int($expiresIn) ? $expiresIn : null,
            refreshToken: $this->optionalString($payload['refresh_token'] ?? null),
            authorizationDetails: $this->authorizationDetailsParser->parse($payload['authorization_details'] ?? null),
            cNonce: $this->optionalString($payload['c_nonce'] ?? null),
            additionalParameters: $payload
        );
    }
}
