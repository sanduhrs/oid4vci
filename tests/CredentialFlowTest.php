<?php

declare(strict_types=1);

namespace OpenID4VC\OID4VCI\Tests;

use OpenID4VC\OID4VCI\OID4VCI;
use PHPUnit\Framework\TestCase;

final class CredentialFlowTest extends TestCase
{
    public function testValidatesCredentialRequestAndImmediateResponse(): void
    {
        $oid4vci = new OID4VCI();
        $metadata = $oid4vci->parseCredentialIssuerMetadata([
            'credential_issuer' => 'https://issuer.example.com',
            'credential_endpoint' => 'https://issuer.example.com/credential',
            'credential_configurations_supported' => [
                'UniversityDegreeCredential' => [
                    'format' => 'jwt_vc_json',
                    'proof_types_supported' => [
                        'jwt' => [
                            'proof_signing_alg_values_supported' => ['ES256'],
                        ],
                    ],
                ],
            ],
        ]);

        $request = $oid4vci->parseCredentialRequest([
            'credential_configuration_id' => 'UniversityDegreeCredential',
            'proofs' => [
                'jwt' => ['eyJhbGciOiJFUzI1NiJ9...'],
            ],
        ]);

        $oid4vci->validateCredentialRequest($request, $metadata);

        $response = $oid4vci->parseCredentialResponse([
            'credentials' => [
                ['credential' => 'eyJhbGciOiJFUzI1NiJ9...'],
            ],
            'notification_id' => '3fwe98js',
        ]);

        $oid4vci->validateCredentialResponse($response);
        self::assertFalse($response->isDeferred());
    }

    public function testValidatesDeferredCredentialResponseAndRequest(): void
    {
        $oid4vci = new OID4VCI();

        $response = $oid4vci->parseCredentialResponse([
            'transaction_id' => '8xLOxBtZp8',
            'interval' => 3600,
        ]);
        $oid4vci->validateCredentialResponse($response);
        self::assertTrue($response->isDeferred());

        $request = $oid4vci->parseDeferredCredentialRequest([
            'transaction_id' => '8xLOxBtZp8',
        ]);
        $oid4vci->validateDeferredCredentialRequest($request);
    }
}
