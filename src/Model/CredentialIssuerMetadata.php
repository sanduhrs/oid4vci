<?php

declare(strict_types=1);

namespace OpenID4VC\OID4VCI\Model;

final class CredentialIssuerMetadata
{
    /**
     * @param list<string> $authorizationServers
     * @param array<string, CredentialConfiguration> $credentialConfigurationsSupported
     * @param array<string, mixed> $additionalParameters
     */
    public function __construct(
        public readonly string $credentialIssuer,
        public readonly array $authorizationServers,
        public readonly string $credentialEndpoint,
        public readonly ?string $batchCredentialEndpoint,
        public readonly ?string $deferredCredentialEndpoint,
        public readonly ?string $nonceEndpoint,
        public readonly ?string $notificationEndpoint,
        public readonly array $credentialConfigurationsSupported,
        public readonly ?EncryptionRequirement $credentialRequestEncryption = null,
        public readonly ?EncryptionRequirement $credentialResponseEncryption = null,
        public readonly array $additionalParameters = []
    ) {
    }

    public function credentialConfiguration(string $credentialConfigurationId): ?CredentialConfiguration
    {
        return $this->credentialConfigurationsSupported[$credentialConfigurationId] ?? null;
    }
}
