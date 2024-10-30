<?php

namespace App\Services\Import;

use Illuminate\Support\Facades\Http;

/**
 * Class IntegrationService
 * @package App\Services\Import
 */
class IntegrationService
{
    /**
     * @param array $requestData
     * @return array
     * @throws \Exception
     */
    public function downloadDataFromRemote(array $requestData = []): array
    {
        $endpoint = env('ONTHEIO_API_ENDPOINT', '');
        $apiKey = env('ONTHEIO_API_KEY', '');
        if (!$endpoint || !$apiKey) {
            throw new \Exception(__('integration.endpoint_error'));
        }
        if (!$requestData) {
            throw new \Exception(__('integration.request_data_empty'));
        }
        $responseData = Http::asForm()->post($endpoint, ['key' => $apiKey] + $requestData);
        if ($responseData->failed()) {
            throw new \Exception(__('integration.response_error', [
                'http_code' => $responseData->status(),
                'answer_body' => $responseData->body(),
            ]));
        }
        if ($error = $responseData->json('error')) {
            $errorMessage = is_array($error) && !empty($error['message']) ? $error['message'] : (string)$error;
            throw new \Exception(__('integration.answer_error', [
                'error_message' => $errorMessage
            ]));
        }
        return $responseData->json();
    }
}
