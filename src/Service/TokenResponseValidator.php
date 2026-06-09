<?php

declare(strict_types=1);

namespace OpenID4VC\OID4VCI\Service;

use OpenID4VC\OID4VCI\Exception\InvalidTokenResponse;
use OpenID4VC\OID4VCI\Model\TokenResponse;

final class TokenResponseValidator
{
    public function validate(TokenResponse $response): void
    {
        if ($response->accessToken === '') {
            throw new InvalidTokenResponse('access_token is required.');
        }

        if ($response->tokenType === '') {
            throw new InvalidTokenResponse('token_type is required.');
        }

        if (strcasecmp($response->tokenType, 'bearer') !== 0) {
            throw new InvalidTokenResponse('token_type must be Bearer.');
        }

        if ($response->expiresIn !== null && $response->expiresIn <= 0) {
            throw new InvalidTokenResponse('expires_in must be a positive integer when present.');
        }

        foreach ($response->authorizationDetails as $authorizationDetail) {
            if ($authorizationDetail->type === '') {
                throw new InvalidTokenResponse('authorization_details entries must contain type.');
            }
        }
    }
}
