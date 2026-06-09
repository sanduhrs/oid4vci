<?php

declare(strict_types=1);

namespace OpenID4VC\OID4VCI\Model;

final class CredentialRequest
{
    /**
     * @param array<string, mixed> $credentialResponseEncryption
     * @param array<string, mixed> $additionalParameters
     */
    public function __construct(
        public readonly ?string $credentialIdentifier = null,
        public readonly ?string $credentialConfigurationId = null,
        public readonly ?Proofs $proofs = null,
        public readonly array $credentialResponseEncryption = [],
        public readonly array $additionalParameters = []
    ) {
    }
}
