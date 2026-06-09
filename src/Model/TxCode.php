<?php

declare(strict_types=1);

namespace OpenID4VC\OID4VCI\Model;

final class TxCode
{
    public function __construct(
        public readonly ?string $description = null,
        public readonly ?string $inputMode = null,
        public readonly ?int $length = null
    ) {
    }
}
