<?php

declare(strict_types=1);

namespace OpenID4VC\OID4VCI\Tests;

use OpenID4VC\OID4VCI\OID4VCI;
use PHPUnit\Framework\TestCase;

final class TokenFlowTest extends TestCase
{
    public function testValidatesPreAuthorizedCodeTokenRequestAndResponse(): void
    {
        $oid4vci = new OID4VCI();

        $request = $oid4vci->parseTokenRequest([
            'grant_type' => 'urn:ietf:params:oauth:grant-type:pre-authorized_code',
            'pre-authorized_code' => 'SplxlOBeZQQYbYS6WxSbIA',
            'tx_code' => '493536',
            'authorization_details' => [
                [
                    'type' => 'openid_credential',
                    'credential_configuration_id' => 'UniversityDegreeCredential',
                ],
            ],
        ]);
        $oid4vci->validateTokenRequest($request);

        $response = $oid4vci->parseTokenResponse([
            'access_token' => 'eyJhbGciOiJSUzI1NiIsInR5cCI6Ikp..sHQ',
            'token_type' => 'Bearer',
            'expires_in' => 3600,
            'authorization_details' => [
                [
                    'type' => 'openid_credential',
                    'credential_configuration_id' => 'UniversityDegreeCredential',
                    'credential_identifiers' => ['CivilEngineeringDegree-2023'],
                ],
            ],
            'c_nonce' => 'nonce-1',
        ]);
        $oid4vci->validateTokenResponse($response);

        self::assertSame('Bearer', $response->tokenType);
    }
}
