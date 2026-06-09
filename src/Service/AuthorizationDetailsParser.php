<?php

declare(strict_types=1);

namespace OpenID4VC\OID4VCI\Service;

use OpenID4VC\OID4VCI\Model\AuthorizationDetail;

final class AuthorizationDetailsParser
{
    use ParserSupport;

    /**
     * @param mixed $payload
     * @return list<AuthorizationDetail>
     */
    public function parse(mixed $payload): array
    {
        if (is_string($payload)) {
            $decoded = json_decode($payload, true);
            if (!is_array($decoded)) {
                return [];
            }
            $payload = $decoded;
        }

        if (!is_array($payload)) {
            return [];
        }

        $items = [];
        foreach ($payload as $rawItem) {
            $item = $this->objectOrNull($rawItem);
            if ($item === null) {
                continue;
            }

            $type = $this->optionalString($item['type'] ?? null) ?? '';
            $credentialConfigurationId = $this->optionalString($item['credential_configuration_id'] ?? null);

            $additionalFields = $item;
            unset($additionalFields['type'], $additionalFields['credential_configuration_id']);
            unset($additionalFields['credential_identifiers'], $additionalFields['locations']);

            $items[] = new AuthorizationDetail(
                type: $type,
                credentialConfigurationId: $credentialConfigurationId,
                credentialIdentifiers: $this->stringList($item['credential_identifiers'] ?? []),
                locations: $this->stringList($item['locations'] ?? []),
                additionalFields: $additionalFields
            );
        }

        return $items;
    }
}
