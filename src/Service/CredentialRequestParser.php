<?php

declare(strict_types=1);

namespace OpenID4VC\OID4VCI\Service;

use OpenID4VC\OID4VCI\Model\CredentialRequest;
use OpenID4VC\OID4VCI\Model\Proofs;
use OpenID4VC\OID4VCI\Util\Json;

final class CredentialRequestParser
{
    use ParserSupport;

    /**
     * @param array<string, mixed>|string $payload
     */
    public function parse(array|string $payload): CredentialRequest
    {
        $payload = is_string($payload) ? Json::decodeObject($payload) : $payload;

        $proofsPayload = $this->objectOrNull($payload['proofs'] ?? null);
        $proofs = null;
        if ($proofsPayload !== null) {
            $items = [];
            foreach ($proofsPayload as $proofType => $proofValuesRaw) {
                if (!is_array($proofValuesRaw)) {
                    continue;
                }

                $proofValues = [];
                foreach ($proofValuesRaw as $proofValue) {
                    $proofObject = $this->objectOrNull($proofValue);
                    if (is_string($proofValue)) {
                        $proofValues[] = $proofValue;
                    } elseif ($proofObject !== null) {
                        $proofValues[] = $proofObject;
                    }
                }

                if ($proofValues !== []) {
                    $items[$proofType] = $proofValues;
                }
            }

            $proofs = new Proofs($items);
        }

        return new CredentialRequest(
            credentialIdentifier: $this->optionalString($payload['credential_identifier'] ?? null),
            credentialConfigurationId: $this->optionalString($payload['credential_configuration_id'] ?? null),
            proofs: $proofs,
            credentialResponseEncryption: $this->objectOrNull($payload['credential_response_encryption'] ?? null) ?? [],
            additionalParameters: $payload
        );
    }
}
