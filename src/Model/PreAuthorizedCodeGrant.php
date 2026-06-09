<?php

declare(strict_types=1);

namespace OpenID4VC\OID4VCI\Model;

final class PreAuthorizedCodeGrant
{
    public function __construct(
        public readonly string $preAuthorizedCode,
        public readonly ?TxCode $txCode = null,
        public readonly ?string $authorizationServer = null
    ) {
    }
}
