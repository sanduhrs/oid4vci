<?php

declare(strict_types=1);

namespace OpenID4VC\OID4VCI\Model;

final class CredentialConfiguration
{
    /**
     * @param array<string, mixed> $formatMetadata
     * @param list<string> $cryptographicBindingMethodsSupported
     * @param array<string, ProofTypeMetadata> $proofTypesSupported
     * @param list<array<string, mixed>> $display
     * @param array<string, mixed> $additionalParameters
     */
    public function __construct(
        public readonly string $id,
        public readonly string $format,
        public readonly ?string $scope = null,
        public readonly array $formatMetadata = [],
        public readonly array $cryptographicBindingMethodsSupported = [],
        public readonly array $proofTypesSupported = [],
        public readonly array $display = [],
        public readonly array $additionalParameters = []
    ) {
    }
}
