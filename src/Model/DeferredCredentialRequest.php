<?php

declare(strict_types=1);

namespace OpenID4VC\OID4VCI\Model;

final class DeferredCredentialRequest
{
    /**
     * @param array<string, mixed> $credentialResponseEncryption
     * @param array<string, mixed> $additionalParameters
     */
    public function __construct(
        public readonly string $transactionId,
        public readonly array $credentialResponseEncryption = [],
        public readonly array $additionalParameters = []
    ) {
    }
}
