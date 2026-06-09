<?php

declare(strict_types=1);

namespace OpenID4VC\OID4VCI\Model;

final class AuthorizationDetail
{
    /**
     * @param list<string> $credentialIdentifiers
     * @param list<string> $locations
     * @param array<string, mixed> $additionalFields
     */
    public function __construct(
        public readonly string $type,
        public readonly ?string $credentialConfigurationId = null,
        public readonly array $credentialIdentifiers = [],
        public readonly array $locations = [],
        public readonly array $additionalFields = []
    ) {
    }
}
