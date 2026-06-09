<?php

declare(strict_types=1);

namespace OpenID4VC\OID4VCI\Service;

use OpenID4VC\OID4VCI\Exception\InvalidCredentialResponse;
use OpenID4VC\OID4VCI\Model\CredentialResponse;

final class CredentialResponseValidator
{
    public function validate(CredentialResponse $response): void
    {
        $hasCredentials = $response->credentials !== [];
        $hasTransactionId = $response->transactionId !== null;

        if (!$hasCredentials && !$hasTransactionId) {
            throw new InvalidCredentialResponse('Credential response must contain credentials or transaction_id.');
        }

        if ($hasCredentials && $hasTransactionId) {
            throw new InvalidCredentialResponse('Credential response must not contain both credentials and transaction_id.');
        }

        if ($response->interval !== null && $response->interval <= 0) {
            throw new InvalidCredentialResponse('interval must be a positive integer when present.');
        }
    }
}
