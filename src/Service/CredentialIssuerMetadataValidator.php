<?php

declare(strict_types=1);

namespace OpenID4VC\OID4VCI\Service;

use OpenID4VC\OID4VCI\Exception\InvalidCredentialIssuerMetadata;
use OpenID4VC\OID4VCI\Model\CredentialIssuerMetadata;

final class CredentialIssuerMetadataValidator
{
    public function validate(CredentialIssuerMetadata $metadata): void
    {
        if ($metadata->credentialIssuer === '') {
            throw new InvalidCredentialIssuerMetadata('credential_issuer is required.');
        }

        $this->assertAbsoluteUrl($metadata->credentialIssuer, 'credential_issuer');
        $this->assertAbsoluteUrl($metadata->credentialEndpoint, 'credential_endpoint');

        if ($metadata->batchCredentialEndpoint !== null) {
            $this->assertAbsoluteUrl($metadata->batchCredentialEndpoint, 'batch_credential_endpoint');
        }

        if ($metadata->deferredCredentialEndpoint !== null) {
            $this->assertAbsoluteUrl($metadata->deferredCredentialEndpoint, 'deferred_credential_endpoint');
        }

        if ($metadata->nonceEndpoint !== null) {
            $this->assertAbsoluteUrl($metadata->nonceEndpoint, 'nonce_endpoint');
        }

        if ($metadata->notificationEndpoint !== null) {
            $this->assertAbsoluteUrl($metadata->notificationEndpoint, 'notification_endpoint');
        }

        if ($metadata->credentialConfigurationsSupported === []) {
            throw new InvalidCredentialIssuerMetadata('credential_configurations_supported is required.');
        }

        foreach ($metadata->credentialConfigurationsSupported as $id => $configuration) {
            if ($id === '' || $configuration->format === '') {
                throw new InvalidCredentialIssuerMetadata(
                    'Each credential configuration must have an identifier and format.'
                );
            }

            if ($configuration->cryptographicBindingMethodsSupported !== [] && $configuration->proofTypesSupported === []) {
                throw new InvalidCredentialIssuerMetadata(
                    'proof_types_supported is required when cryptographic_binding_methods_supported is present.'
                );
            }

            foreach ($configuration->proofTypesSupported as $proofTypeMetadata) {
                if ($proofTypeMetadata->proofSigningAlgValuesSupported === []) {
                    throw new InvalidCredentialIssuerMetadata(
                        'proof_signing_alg_values_supported must not be empty for each proof type.'
                    );
                }
            }
        }

        $this->validateEncryption($metadata->credentialRequestEncryption, 'credential_request_encryption');
        $this->validateEncryption($metadata->credentialResponseEncryption, 'credential_response_encryption');
    }

    private function validateEncryption(?\OpenID4VC\OID4VCI\Model\EncryptionRequirement $encryption, string $name): void
    {
        if ($encryption === null) {
            return;
        }

        if ($encryption->algValuesSupported === []) {
            throw new InvalidCredentialIssuerMetadata($name . '.alg_values_supported must not be empty.');
        }

        if ($encryption->encValuesSupported === []) {
            throw new InvalidCredentialIssuerMetadata($name . '.enc_values_supported must not be empty.');
        }
    }

    private function assertAbsoluteUrl(string $url, string $name): void
    {
        if ($url === '' || filter_var($url, FILTER_VALIDATE_URL) === false) {
            throw new InvalidCredentialIssuerMetadata($name . ' must be a valid absolute URI.');
        }
    }
}
