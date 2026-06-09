<?php

declare(strict_types=1);

namespace OpenID4VC\OID4VCI\Model;

final class EncryptionRequirement
{
    /**
     * @param list<string> $algValuesSupported
     * @param list<string> $encValuesSupported
     * @param list<string> $zipValuesSupported
     */
    public function __construct(
        public readonly array $algValuesSupported,
        public readonly array $encValuesSupported,
        public readonly array $zipValuesSupported = [],
        public readonly bool $encryptionRequired = false
    ) {
    }
}
