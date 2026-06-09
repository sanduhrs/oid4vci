<?php

declare(strict_types=1);

namespace OpenID4VC\OID4VCI\Service;

use OpenID4VC\OID4VCI\Model\CredentialConfiguration;
use OpenID4VC\OID4VCI\Model\CredentialIssuerMetadata;
use OpenID4VC\OID4VCI\Model\EncryptionRequirement;
use OpenID4VC\OID4VCI\Model\ProofTypeMetadata;
use OpenID4VC\OID4VCI\Util\Json;

final class CredentialIssuerMetadataParser
{
    use ParserSupport;

    /**
     * @param array<string, mixed>|string $payload
     */
    public function parse(array|string $payload): CredentialIssuerMetadata
    {
        $payload = is_string($payload) ? Json::decodeObject($payload) : $payload;

        $credentialConfigurations = [];
        $credentialConfigurationsPayload = $this->objectOrNull(
            $payload['credential_configurations_supported'] ?? null
        ) ?? [];

        foreach ($credentialConfigurationsPayload as $id => $configurationPayloadRaw) {
            $configurationPayload = $this->objectOrNull($configurationPayloadRaw);
            if ($configurationPayload === null) {
                continue;
            }

            $proofTypesSupported = [];
            $proofTypesPayload = $this->objectOrNull($configurationPayload['proof_types_supported'] ?? null) ?? [];
            foreach ($proofTypesPayload as $proofType => $proofTypePayloadRaw) {
                $proofTypePayload = $this->objectOrNull($proofTypePayloadRaw);
                if ($proofTypePayload === null) {
                    continue;
                }

                $keyAttestationsRequired = $this->objectOrNull($proofTypePayload['key_attestations_required'] ?? null) ?? [];

                $proofTypesSupported[$proofType] = new ProofTypeMetadata(
                    proofSigningAlgValuesSupported: $this->stringList(
                        $proofTypePayload['proof_signing_alg_values_supported'] ?? []
                    ),
                    keyAttestationsRequired: $keyAttestationsRequired,
                    additionalParameters: $proofTypePayload
                );
            }

            $formatMetadata = $configurationPayload;
            unset($formatMetadata['scope'], $formatMetadata['proof_types_supported']);
            unset($formatMetadata['cryptographic_binding_methods_supported'], $formatMetadata['display']);

            $displayList = $this->objectList($configurationPayload['display'] ?? []);

            $credentialConfigurations[$id] = new CredentialConfiguration(
                id: $id,
                format: $this->optionalString($configurationPayload['format'] ?? null) ?? '',
                scope: $this->optionalString($configurationPayload['scope'] ?? null),
                formatMetadata: $formatMetadata,
                cryptographicBindingMethodsSupported: $this->stringList(
                    $configurationPayload['cryptographic_binding_methods_supported'] ?? []
                ),
                proofTypesSupported: $proofTypesSupported,
                display: $displayList,
                additionalParameters: $configurationPayload
            );
        }

        return new CredentialIssuerMetadata(
            credentialIssuer: $this->optionalString($payload['credential_issuer'] ?? null) ?? '',
            authorizationServers: $this->stringList($payload['authorization_servers'] ?? []),
            credentialEndpoint: $this->optionalString($payload['credential_endpoint'] ?? null) ?? '',
            batchCredentialEndpoint: $this->optionalString($payload['batch_credential_endpoint'] ?? null),
            deferredCredentialEndpoint: $this->optionalString($payload['deferred_credential_endpoint'] ?? null),
            nonceEndpoint: $this->optionalString($payload['nonce_endpoint'] ?? null),
            notificationEndpoint: $this->optionalString($payload['notification_endpoint'] ?? null),
            credentialConfigurationsSupported: $credentialConfigurations,
            credentialRequestEncryption: $this->parseEncryptionRequirement(
                $this->objectOrNull($payload['credential_request_encryption'] ?? null)
            ),
            credentialResponseEncryption: $this->parseEncryptionRequirement(
                $this->objectOrNull($payload['credential_response_encryption'] ?? null)
            ),
            additionalParameters: $payload
        );
    }

    /**
     * @param array<string, mixed>|null $payload
     */
    private function parseEncryptionRequirement(?array $payload): ?EncryptionRequirement
    {
        if ($payload === null) {
            return null;
        }

        return new EncryptionRequirement(
            algValuesSupported: $this->stringList($payload['alg_values_supported'] ?? []),
            encValuesSupported: $this->stringList($payload['enc_values_supported'] ?? []),
            zipValuesSupported: $this->stringList($payload['zip_values_supported'] ?? []),
            encryptionRequired: is_bool($payload['encryption_required'] ?? null) ? $payload['encryption_required'] : false
        );
    }
}
