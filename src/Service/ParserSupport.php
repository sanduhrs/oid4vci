<?php

declare(strict_types=1);

namespace OpenID4VC\OID4VCI\Service;

trait ParserSupport
{
    /**
     * @param mixed $value
     * @return array<string, mixed>|null
     */
    private function objectOrNull(mixed $value): ?array
    {
        if (!is_array($value)) {
            return null;
        }

        $normalized = [];
        foreach ($value as $key => $item) {
            if (!is_string($key)) {
                return null;
            }

            $normalized[$key] = $item;
        }

        return $normalized;
    }

    /**
     * @param mixed $value
     * @return list<array<string, mixed>>
     */
    private function objectList(mixed $value): array
    {
        if (!is_array($value)) {
            return [];
        }

        $objects = [];
        foreach ($value as $item) {
            $object = $this->objectOrNull($item);
            if ($object !== null) {
                $objects[] = $object;
            }
        }

        return $objects;
    }

    /**
     * @param mixed $value
     * @return list<string>
     */
    private function stringList(mixed $value): array
    {
        if (!is_array($value)) {
            return [];
        }

        $items = [];
        foreach ($value as $item) {
            if (is_string($item) && $item !== '') {
                $items[] = $item;
            }
        }

        return $items;
    }

    private function optionalString(mixed $value): ?string
    {
        return is_string($value) ? $value : null;
    }
}
