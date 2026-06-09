<?php

declare(strict_types=1);

namespace OpenID4VC\OID4VCI\Model;

final class CredentialResponse
{
    /**
     * @param list<IssuedCredential> $credentials
     * @param array<string, mixed> $additionalParameters
     */
    public function __construct(
        public readonly array $credentials = [],
        public readonly ?string $transactionId = null,
        public readonly ?int $interval = null,
        public readonly ?string $notificationId = null,
        public readonly ?string $cNonce = null,
        public readonly array $additionalParameters = []
    ) {
    }

    public function isDeferred(): bool
    {
        return $this->transactionId !== null;
    }
}
