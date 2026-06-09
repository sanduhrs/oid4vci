<?php

declare(strict_types=1);

namespace OpenID4VC\OID4VCI\Service;

use OpenID4VC\OID4VCI\Exception\InvalidDeferredCredentialRequest;
use OpenID4VC\OID4VCI\Model\DeferredCredentialRequest;

final class DeferredCredentialRequestValidator
{
    public function validate(DeferredCredentialRequest $request): void
    {
        if ($request->transactionId === '') {
            throw new InvalidDeferredCredentialRequest('transaction_id is required.');
        }
    }
}
