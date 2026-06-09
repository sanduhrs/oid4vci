<?php

declare(strict_types=1);

namespace OpenID4VC\OID4VCI\Model;

final class CredentialOffer
{
    /**
     * @param list<string> $credentialConfigurationIds
     * @param array<string, mixed> $additionalParameters
     */
    public function __construct(
        public readonly string $credentialIssuer,
        public readonly array $credentialConfigurationIds,
        public readonly CredentialOfferGrants $grants,
        public readonly ?string $authorizationServer = null,
        public readonly array $additionalParameters = []
    ) {
    }
}
