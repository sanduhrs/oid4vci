# OpenID4VC OID4VCI

Generic PHP library for implementing the core protocol building blocks of OpenID for Verifiable Credential Issuance 1.0.

## Scope

This package is designed as a reusable base for wallet and issuer integrations in PHP applications and CMS environments.
It provides:

- Credential Offer parsing and validation.
- Credential Issuer metadata parsing and structural validation.
- Token request/response and authorization details models and validation.
- Credential request/response and deferred issuance response handling.
- Notification request validation.

The package intentionally leaves transport, OAuth client/auth-server communication, cryptographic proof generation,
proof verification, and JOSE/JWE processing to host applications.

## Install

```bash
composer require openid4vc/oid4vci
```

## Quick Start

```php
<?php

declare(strict_types=1);

use OpenID4VC\OID4VCI\OID4VCI;

$oid4vci = new OID4VCI();

$offer = $oid4vci->parseCredentialOfferQuery($_GET);
$oid4vci->validateCredentialOffer($offer);

$metadata = $oid4vci->parseCredentialIssuerMetadata($issuerMetadataPayload);
$oid4vci->validateCredentialIssuerMetadata($metadata);

$credentialRequest = $oid4vci->parseCredentialRequest([
    'credential_configuration_id' => 'UniversityDegreeCredential',
    'proofs' => [
        'jwt' => ['eyJ...'],
    ],
]);
$oid4vci->validateCredentialRequest($credentialRequest, $metadata);
```

## Spec

OpenID for Verifiable Credential Issuance 1.0, Final, published 16 September 2025:
https://openid.net/specs/openid-4-verifiable-credential-issuance-1_0.html

## Spec Status

Specification coverage notes and currently missing/out-of-scope features are tracked in:
[/home/sanduhrs/Workspace/PHP/openid4vc/LIBRARY_SPEC_STATUS.md](/home/sanduhrs/Workspace/PHP/openid4vc/LIBRARY_SPEC_STATUS.md)

## Run Tests

```bash
composer test
```

## Run Test Coverage

```bash
composer test:coverage
```

## Run Style Checks

```bash
composer lint
```

## Run Static Analysis

```bash
composer analyze
```
