<?php

declare(strict_types=1);

namespace OpenID4VC\OID4VCI\Service;

use OpenID4VC\OID4VCI\Exception\InvalidCredentialOffer;
use OpenID4VC\OID4VCI\Model\CredentialOffer;

final class CredentialOfferValidator
{
    public function validate(CredentialOffer $offer): void
    {
        if ($offer->credentialIssuer === '') {
            throw new InvalidCredentialOffer('credential_issuer is required.');
        }

        if (filter_var($offer->credentialIssuer, FILTER_VALIDATE_URL) === false) {
            throw new InvalidCredentialOffer('credential_issuer must be an absolute URL.');
        }

        if ($offer->credentialConfigurationIds === []) {
            throw new InvalidCredentialOffer('credential_configuration_ids must contain at least one value.');
        }

        if ($offer->grants->authorizationCode === null && $offer->grants->preAuthorizedCode === null) {
            throw new InvalidCredentialOffer('At least one grant (authorization_code or pre-authorized_code) is required.');
        }

        if ($offer->grants->preAuthorizedCode !== null) {
            if ($offer->grants->preAuthorizedCode->preAuthorizedCode === '') {
                throw new InvalidCredentialOffer('pre-authorized_code grant must contain pre-authorized_code.');
            }

            $txCode = $offer->grants->preAuthorizedCode->txCode;
            if ($txCode !== null && $txCode->length !== null && $txCode->length <= 0) {
                throw new InvalidCredentialOffer('tx_code.length must be a positive integer.');
            }
        }
    }
}
