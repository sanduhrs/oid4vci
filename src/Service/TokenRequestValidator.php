<?php

declare(strict_types=1);

namespace OpenID4VC\OID4VCI\Service;

use OpenID4VC\OID4VCI\Exception\InvalidTokenRequest;
use OpenID4VC\OID4VCI\Model\TokenRequest;

final class TokenRequestValidator
{
    public function validate(TokenRequest $request): void
    {
        if ($request->grantType === '') {
            throw new InvalidTokenRequest('grant_type is required.');
        }

        if ($request->grantType === 'authorization_code') {
            if ($request->code === null || $request->code === '') {
                throw new InvalidTokenRequest('code is required for authorization_code grant.');
            }
        } elseif ($request->grantType === 'urn:ietf:params:oauth:grant-type:pre-authorized_code') {
            if ($request->preAuthorizedCode === null || $request->preAuthorizedCode === '') {
                throw new InvalidTokenRequest('pre-authorized_code is required for pre-authorized_code grant.');
            }
        } else {
            throw new InvalidTokenRequest('Unsupported grant_type.');
        }

        foreach ($request->authorizationDetails as $authorizationDetail) {
            if ($authorizationDetail->type === '') {
                throw new InvalidTokenRequest('authorization_details entries must contain type.');
            }

            if ($authorizationDetail->type === 'openid_credential' && $authorizationDetail->credentialConfigurationId === null) {
                throw new InvalidTokenRequest(
                    'openid_credential authorization_details entries must include credential_configuration_id.'
                );
            }
        }
    }
}
