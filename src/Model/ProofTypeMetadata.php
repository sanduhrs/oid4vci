<?php

declare(strict_types=1);

namespace OpenID4VC\OID4VCI\Model;

final class ProofTypeMetadata
{
    /**
     * @param list<string> $proofSigningAlgValuesSupported
     * @param array<string, mixed> $keyAttestationsRequired
     * @param array<string, mixed> $additionalParameters
     */
    public function __construct(
        public readonly array $proofSigningAlgValuesSupported,
        public readonly array $keyAttestationsRequired = [],
        public readonly array $additionalParameters = []
    ) {
    }
}
