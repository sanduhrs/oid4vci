<?php

declare(strict_types=1);

namespace OpenID4VC\OID4VCI\Model;

final class CredentialOfferGrants
{
    public function __construct(
        public readonly ?AuthorizationCodeGrant $authorizationCode = null,
        public readonly ?PreAuthorizedCodeGrant $preAuthorizedCode = null
    ) {
    }
}
