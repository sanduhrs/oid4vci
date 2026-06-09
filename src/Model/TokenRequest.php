<?php

declare(strict_types=1);

namespace OpenID4VC\OID4VCI\Model;

final class TokenRequest
{
    /**
     * @param list<AuthorizationDetail> $authorizationDetails
     * @param array<string, mixed> $additionalParameters
     */
    public function __construct(
        public readonly string $grantType,
        public readonly ?string $code = null,
        public readonly ?string $redirectUri = null,
        public readonly ?string $clientId = null,
        public readonly ?string $preAuthorizedCode = null,
        public readonly ?string $txCode = null,
        public readonly array $authorizationDetails = [],
        public readonly array $additionalParameters = []
    ) {
    }
}
