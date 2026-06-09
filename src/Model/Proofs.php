<?php

declare(strict_types=1);

namespace OpenID4VC\OID4VCI\Model;

final class Proofs
{
    /**
     * @param array<string, list<string|array<string, mixed>>> $items
     */
    public function __construct(
        public readonly array $items
    ) {
    }

    public function hasAny(): bool
    {
        return $this->items !== [];
    }
}
