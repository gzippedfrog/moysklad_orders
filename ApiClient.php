<?php

class ApiClient
{
    function __construct(private ?string $token = null)
    {
    }

    function getToken(string $login, string $password): array|null
    {
        $ch = curl_init('https://api.moysklad.ru/api/remap/1.2/security/token');

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Authorization: Basic ' . base64_encode($login . ':' . $password),
            'Accept-Encoding: gzip',
        ]);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_ENCODING, 'gzip');

        $response = json_decode(curl_exec($ch), true);

        return $response;
    }

    function getOrders(): array
    {
        $ch = curl_init('https://api.moysklad.ru/api/remap/1.2/entity/customerorder?order=moment,desc&limit=100&expand=agent,state,rate.currency');

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Authorization: Bearer ' . $this->token,
            'Accept-Encoding: gzip',
        ]);
        curl_setopt($ch, CURLOPT_ENCODING, 'gzip');

        $response = json_decode(curl_exec($ch), true);
        return $response['rows'] ?? [];
    }

    function getStates(): array
    {
        $ch = curl_init('https://api.moysklad.ru/api/remap/1.2/entity/customerorder/metadata');

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Authorization: Bearer ' . $this->token,
            'Accept-Encoding: gzip',
        ]);
        curl_setopt($ch, CURLOPT_ENCODING, 'gzip');

        $response = json_decode(curl_exec($ch), true);
        return $response['states'] ?? [];
    }

    function updateOrderState(string $orderId, string $stateId): mixed
    {
        $states = $this->getStates();
        $states = array_filter($states, fn($state) => $state['id'] == $stateId);

        $newState = array_values($states)[0] ?? null;

        if (!$newState) {
            return false;
        }

        $ch = curl_init('https://api.moysklad.ru/api/remap/1.2/entity/customerorder/' . $orderId);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Authorization: Bearer ' . $this->token,
            'Accept-Encoding: gzip',
            'Content-Type: application/json'
        ]);
        curl_setopt($ch, CURLOPT_ENCODING, 'gzip');
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode([
            'state' => [
                'meta' => $newState['meta']
            ]
        ]));

        return json_decode(curl_exec($ch), true);
    }
}