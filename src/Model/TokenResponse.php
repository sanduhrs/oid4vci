<?php

declare(strict_types=1);

namespace OpenID4VC\OID4VCI\Model;

final class TokenResponse
{
    /**
     * @param list<AuthorizationDetail> $authorizationDetails
     * @param array<string, mixed> $additionalParameters
     */
    public function __construct(
        public readonly string $accessToken,
        public readonly string $tokenType,
        public readonly ?int $expiresIn = null,
        public readonly ?string $refreshToken = null,
        public readonly array $authorizationDetails = [],
        public readonly ?string $cNonce = null,
        public readonly array $additionalParameters = []
    ) {
    }
}
