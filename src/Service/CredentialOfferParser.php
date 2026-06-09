<?php

declare(strict_types=1);

namespace OpenID4VC\OID4VCI\Service;

use OpenID4VC\OID4VCI\Exception\InvalidCredentialOffer;
use OpenID4VC\OID4VCI\Model\AuthorizationCodeGrant;
use OpenID4VC\OID4VCI\Model\CredentialOffer;
use OpenID4VC\OID4VCI\Model\CredentialOfferGrants;
use OpenID4VC\OID4VCI\Model\PreAuthorizedCodeGrant;
use OpenID4VC\OID4VCI\Model\TxCode;
use OpenID4VC\OID4VCI\Util\Json;

final class CredentialOfferParser
{
    use ParserSupport;

    /**
     * @param array<string, mixed> $query
     */
    public function parseQuery(array $query): CredentialOffer
    {
        $credentialOffer = $query['credential_offer'] ?? null;
        $credentialOfferUri = $query['credential_offer_uri'] ?? null;

        if (!is_string($credentialOffer) && !is_string($credentialOfferUri)) {
            throw new InvalidCredentialOffer('credential_offer or credential_offer_uri is required.');
        }

        if (is_string($credentialOffer) && is_string($credentialOfferUri)) {
            throw new InvalidCredentialOffer('credential_offer and credential_offer_uri must not both be present.');
        }

        if (is_string($credentialOfferUri)) {
            throw new InvalidCredentialOffer('Parsing by credential_offer_uri is not implemented by this package.');
        }

        return $this->parse($credentialOffer);
    }

    /**
     * @param array<string, mixed>|string $payload
     */
    public function parse(array|string $payload): CredentialOffer
    {
        $payload = is_string($payload) ? Json::decodeObject($payload) : $payload;

        $grantsPayload = $this->objectOrNull($payload['grants'] ?? null) ?? [];
        $authorizationCodePayload = $this->objectOrNull(
            $grantsPayload['authorization_code'] ?? null
        );
        $preAuthorizedCodePayload = $this->objectOrNull(
            $grantsPayload['urn:ietf:params:oauth:grant-type:pre-authorized_code'] ?? null
        );

        $authorizationCode = null;
        if ($authorizationCodePayload !== null) {
            $authorizationCode = new AuthorizationCodeGrant(
                issuerState: $this->optionalString($authorizationCodePayload['issuer_state'] ?? null),
                authorizationServer: $this->optionalString($authorizationCodePayload['authorization_server'] ?? null)
            );
        }

        $preAuthorizedCode = null;
        if ($preAuthorizedCodePayload !== null) {
            $txCodePayload = $this->objectOrNull($preAuthorizedCodePayload['tx_code'] ?? null);
            $txCode = null;
            if ($txCodePayload !== null) {
                $length = $txCodePayload['length'] ?? null;
                $txCode = new TxCode(
                    description: $this->optionalString($txCodePayload['description'] ?? null),
                    inputMode: $this->optionalString($txCodePayload['input_mode'] ?? null),
                    length: is_int($length) ? $length : null
                );
            }

            $preAuthorizedCode = new PreAuthorizedCodeGrant(
                preAuthorizedCode: $this->optionalString($preAuthorizedCodePayload['pre-authorized_code'] ?? null) ?? '',
                txCode: $txCode,
                authorizationServer: $this->optionalString($preAuthorizedCodePayload['authorization_server'] ?? null)
            );
        }

        return new CredentialOffer(
            credentialIssuer: $this->optionalString($payload['credential_issuer'] ?? null) ?? '',
            credentialConfigurationIds: $this->stringList($payload['credential_configuration_ids'] ?? []),
            grants: new CredentialOfferGrants($authorizationCode, $preAuthorizedCode),
            authorizationServer: $this->optionalString($payload['authorization_server'] ?? null),
            additionalParameters: $payload
        );
    }
}
