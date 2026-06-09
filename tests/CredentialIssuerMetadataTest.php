<?php

declare(strict_types=1);

namespace OpenID4VC\OID4VCI\Tests;

use OpenID4VC\OID4VCI\OID4VCI;
use PHPUnit\Framework\TestCase;

final class CredentialIssuerMetadataTest extends TestCase
{
    public function testParsesAndValidatesMetadata(): void
    {
        $oid4vci = new OID4VCI();

        $metadata = $oid4vci->parseCredentialIssuerMetadata([
            'credential_issuer' => 'https://issuer.example.com',
            'credential_endpoint' => 'https://issuer.example.com/credential',
            'nonce_endpoint' => 'https://issuer.example.com/nonce',
            'credential_configurations_supported' => [
                'UniversityDegreeCredential' => [
                    'format' => 'jwt_vc_json',
                    'scope' => 'UniversityDegree',
                    'cryptographic_binding_methods_supported' => ['jwk'],
                    'proof_types_supported' => [
                        'jwt' => [
                            'proof_signing_alg_values_supported' => ['ES256'],
                        ],
                    ],
                ],
            ],
        ]);

        $oid4vci->validateCredentialIssuerMetadata($metadata);
        self::assertSame('jwt_vc_json', $metadata->credentialConfiguration('UniversityDegreeCredential')?->format);
    }
}
