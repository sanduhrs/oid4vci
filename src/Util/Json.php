<?php

declare(strict_types=1);

namespace OpenID4VC\OID4VCI\Util;

use JsonException;
use OpenID4VC\OID4VCI\Exception\OID4VCIException;

final class Json
{
    /**
     * @param array<string, mixed> $value
     */
    public static function encode(array $value): string
    {
        try {
            return json_encode($value, JSON_THROW_ON_ERROR | JSON_UNESCAPED_SLASHES);
        } catch (JsonException $exception) {
            throw new OID4VCIException('JSON encoding failed.', 0, $exception);
        }
    }

    /**
     * @return array<string, mixed>
     */
    public static function decodeObject(string $json): array
    {
        try {
            $decoded = json_decode($json, true, flags: JSON_THROW_ON_ERROR);
        } catch (JsonException $exception) {
            throw new OID4VCIException('JSON decoding failed.', 0, $exception);
        }

        if (!is_array($decoded)) {
            throw new OID4VCIException('JSON value must decode to an object.');
        }

        $normalized = [];
        foreach ($decoded as $key => $value) {
            if (!is_string($key)) {
                throw new OID4VCIException('JSON object keys must be strings.');
            }
            $normalized[$key] = $value;
        }

        return $normalized;
    }
}
