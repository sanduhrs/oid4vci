<?php

declare(strict_types=1);

namespace OpenID4VC\OID4VCI\Model;

final class IssuedCredential
{
    /**
     * @param string|array<string, mixed> $credential
     * @param array<string, mixed> $additionalParameters
     */
    public function __construct(
        public readonly string|array $credential,
        public readonly array $additionalParameters = []
    ) {
    }
}
