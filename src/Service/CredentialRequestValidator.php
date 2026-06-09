<?php

declare(strict_types=1);

namespace OpenID4VC\OID4VCI\Service;

use OpenID4VC\OID4VCI\Exception\InvalidCredentialRequest;
use OpenID4VC\OID4VCI\Model\CredentialIssuerMetadata;
use OpenID4VC\OID4VCI\Model\CredentialRequest;

final class CredentialRequestValidator
{
    public function validate(
        CredentialRequest $request,
        ?CredentialIssuerMetadata $metadata = null,
        bool $requiresCredentialIdentifier = false
    ): void {
        if ($requiresCredentialIdentifier) {
            if ($request->credentialIdentifier === null || $request->credentialIdentifier === '') {
                throw new InvalidCredentialRequest('credential_identifier is required by this issuer profile.');
            }
        } else {
            if ($request->credentialConfigurationId === null || $request->credentialConfigurationId === '') {
                throw new InvalidCredentialRequest('credential_configuration_id is required.');
            }
        }

        if ($request->proofs !== null && !$request->proofs->hasAny()) {
            throw new InvalidCredentialRequest('proofs must not be empty when present.');
        }

        if ($metadata === null || $request->credentialConfigurationId === null) {
            return;
        }

        $credentialConfiguration = $metadata->credentialConfiguration($request->credentialConfigurationId);
        if ($credentialConfiguration === null) {
            throw new InvalidCredentialRequest('Unknown credential_configuration_id.');
        }

        $requiresProof = $credentialConfiguration->proofTypesSupported !== [];
        if ($requiresProof && ($request->proofs === null || !$request->proofs->hasAny())) {
            throw new InvalidCredentialRequest('proofs are required for this credential configuration.');
        }

        if ($request->proofs === null) {
            return;
        }

        foreach (array_keys($request->proofs->items) as $proofType) {
            if (!isset($credentialConfiguration->proofTypesSupported[$proofType])) {
                throw new InvalidCredentialRequest('Unsupported proof type requested: ' . $proofType);
            }
        }
    }
}
