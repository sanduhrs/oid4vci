<?php

declare(strict_types=1);

namespace OpenID4VC\OID4VCI\Tests;

use OpenID4VC\OID4VCI\Exception\InvalidCredentialOffer;
use OpenID4VC\OID4VCI\OID4VCI;
use PHPUnit\Framework\TestCase;

final class CredentialOfferTest extends TestCase
{
    public function testParsesAndValidatesPreAuthorizedOffer(): void
    {
        $oid4vci = new OID4VCI();

        $offer = $oid4vci->parseCredentialOffer([
            'credential_issuer' => 'https://issuer.example.com',
            'credential_configuration_ids' => ['UniversityDegreeCredential'],
            'grants' => [
                'urn:ietf:params:oauth:grant-type:pre-authorized_code' => [
                    'pre-authorized_code' => 'SplxlOBeZQQYbYS6WxSbIA',
                    'tx_code' => [
                        'input_mode' => 'numeric',
                        'length' => 6,
                    ],
                ],
            ],
        ]);

        $oid4vci->validateCredentialOffer($offer);
        self::assertSame('https://issuer.example.com', $offer->credentialIssuer);
    }

    public function testRejectsOfferWithoutGrant(): void
    {
        $this->expectException(InvalidCredentialOffer::class);

        $oid4vci = new OID4VCI();
        $offer = $oid4vci->parseCredentialOffer([
            'credential_issuer' => 'https://issuer.example.com',
            'credential_configuration_ids' => ['UniversityDegreeCredential'],
            'grants' => [],
        ]);

        $oid4vci->validateCredentialOffer($offer);
    }
}
