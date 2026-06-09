<?php

declare(strict_types=1);

namespace OpenID4VC\OID4VCI\Model;

final class AuthorizationCodeGrant
{
    public function __construct(
        public readonly ?string $issuerState = null,
        public readonly ?string $authorizationServer = null
    ) {
    }
}
