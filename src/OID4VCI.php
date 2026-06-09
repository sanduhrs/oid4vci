<?php

declare(strict_types=1);

namespace OpenID4VC\OID4VCI;

use OpenID4VC\OID4VCI\Model\CredentialIssuerMetadata;
use OpenID4VC\OID4VCI\Model\CredentialOffer;
use OpenID4VC\OID4VCI\Model\CredentialRequest;
use OpenID4VC\OID4VCI\Model\CredentialResponse;
use OpenID4VC\OID4VCI\Model\DeferredCredentialRequest;
use OpenID4VC\OID4VCI\Model\NotificationRequest;
use OpenID4VC\OID4VCI\Model\TokenRequest;
use OpenID4VC\OID4VCI\Model\TokenResponse;
use OpenID4VC\OID4VCI\Service\CredentialIssuerMetadataParser;
use OpenID4VC\OID4VCI\Service\CredentialIssuerMetadataValidator;
use OpenID4VC\OID4VCI\Service\CredentialOfferParser;
use OpenID4VC\OID4VCI\Service\CredentialOfferValidator;
use OpenID4VC\OID4VCI\Service\CredentialRequestParser;
use OpenID4VC\OID4VCI\Service\CredentialRequestValidator;
use OpenID4VC\OID4VCI\Service\CredentialResponseParser;
use OpenID4VC\OID4VCI\Service\CredentialResponseValidator;
use OpenID4VC\OID4VCI\Service\DeferredCredentialRequestParser;
use OpenID4VC\OID4VCI\Service\DeferredCredentialRequestValidator;
use OpenID4VC\OID4VCI\Service\NotificationRequestParser;
use OpenID4VC\OID4VCI\Service\NotificationRequestValidator;
use OpenID4VC\OID4VCI\Service\TokenRequestParser;
use OpenID4VC\OID4VCI\Service\TokenRequestValidator;
use OpenID4VC\OID4VCI\Service\TokenResponseParser;
use OpenID4VC\OID4VCI\Service\TokenResponseValidator;

final class OID4VCI
{
    public function __construct(
        private readonly CredentialOfferParser $credentialOfferParser = new CredentialOfferParser(),
        private readonly CredentialOfferValidator $credentialOfferValidator = new CredentialOfferValidator(),
        private readonly CredentialIssuerMetadataParser $issuerMetadataParser = new CredentialIssuerMetadataParser(),
        private readonly CredentialIssuerMetadataValidator $issuerMetadataValidator = new CredentialIssuerMetadataValidator(),
        private readonly TokenRequestParser $tokenRequestParser = new TokenRequestParser(),
        private readonly TokenRequestValidator $tokenRequestValidator = new TokenRequestValidator(),
        private readonly TokenResponseParser $tokenResponseParser = new TokenResponseParser(),
        private readonly TokenResponseValidator $tokenResponseValidator = new TokenResponseValidator(),
        private readonly CredentialRequestParser $credentialRequestParser = new CredentialRequestParser(),
        private readonly CredentialRequestValidator $credentialRequestValidator = new CredentialRequestValidator(),
        private readonly CredentialResponseParser $credentialResponseParser = new CredentialResponseParser(),
        private readonly CredentialResponseValidator $credentialResponseValidator = new CredentialResponseValidator(),
        private readonly DeferredCredentialRequestParser $deferredRequestParser = new DeferredCredentialRequestParser(),
        private readonly DeferredCredentialRequestValidator $deferredRequestValidator = new DeferredCredentialRequestValidator(),
        private readonly NotificationRequestParser $notificationRequestParser = new NotificationRequestParser(),
        private readonly NotificationRequestValidator $notificationRequestValidator = new NotificationRequestValidator()
    ) {
    }

    /**
     * @param array<string, mixed> $query
     */
    public function parseCredentialOfferQuery(array $query): CredentialOffer
    {
        return $this->credentialOfferParser->parseQuery($query);
    }

    /**
     * @param array<string, mixed>|string $payload
     */
    public function parseCredentialOffer(array|string $payload): CredentialOffer
    {
        return $this->credentialOfferParser->parse($payload);
    }

    public function validateCredentialOffer(CredentialOffer $offer): void
    {
        $this->credentialOfferValidator->validate($offer);
    }

    /**
     * @param array<string, mixed>|string $payload
     */
    public function parseCredentialIssuerMetadata(array|string $payload): CredentialIssuerMetadata
    {
        return $this->issuerMetadataParser->parse($payload);
    }

    public function validateCredentialIssuerMetadata(CredentialIssuerMetadata $metadata): void
    {
        $this->issuerMetadataValidator->validate($metadata);
    }

    /**
     * @param array<string, mixed>|string $payload
     */
    public function parseTokenRequest(array|string $payload): TokenRequest
    {
        return $this->tokenRequestParser->parse($payload);
    }

    public function validateTokenRequest(TokenRequest $request): void
    {
        $this->tokenRequestValidator->validate($request);
    }

    /**
     * @param array<string, mixed>|string $payload
     */
    public function parseTokenResponse(array|string $payload): TokenResponse
    {
        return $this->tokenResponseParser->parse($payload);
    }

    public function validateTokenResponse(TokenResponse $response): void
    {
        $this->tokenResponseValidator->validate($response);
    }

    /**
     * @param array<string, mixed>|string $payload
     */
    public function parseCredentialRequest(array|string $payload): CredentialRequest
    {
        return $this->credentialRequestParser->parse($payload);
    }

    public function validateCredentialRequest(
        CredentialRequest $request,
        ?CredentialIssuerMetadata $metadata = null,
        bool $requiresCredentialIdentifier = false
    ): void {
        $this->credentialRequestValidator->validate($request, $metadata, $requiresCredentialIdentifier);
    }

    /**
     * @param array<string, mixed>|string $payload
     */
    public function parseCredentialResponse(array|string $payload): CredentialResponse
    {
        return $this->credentialResponseParser->parse($payload);
    }

    public function validateCredentialResponse(CredentialResponse $response): void
    {
        $this->credentialResponseValidator->validate($response);
    }

    /**
     * @param array<string, mixed>|string $payload
     */
    public function parseDeferredCredentialRequest(array|string $payload): DeferredCredentialRequest
    {
        return $this->deferredRequestParser->parse($payload);
    }

    public function validateDeferredCredentialRequest(DeferredCredentialRequest $request): void
    {
        $this->deferredRequestValidator->validate($request);
    }

    /**
     * @param array<string, mixed>|string $payload
     */
    public function parseNotificationRequest(array|string $payload): NotificationRequest
    {
        return $this->notificationRequestParser->parse($payload);
    }

    public function validateNotificationRequest(NotificationRequest $request): void
    {
        $this->notificationRequestValidator->validate($request);
    }
}
