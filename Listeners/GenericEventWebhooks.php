<?php

namespace Modules\Iwebhooks\Listeners;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Modules\Iwebhooks\Entities\Hook;

class GenericEventWebhooks
{
    protected $webhook;

    public function __construct()
    {
    }

    public function handle($event, $data)
    {
        $modelClass = get_class($data[0]);
        $webhooks = Hook::where('status', true)->get();

        foreach ($webhooks as $webhook) {
            $webhookEntity = $webhook->entity;

            if ($webhookEntity->module_name === 'AllModules' && $webhookEntity->name === 'AllEntities') {
                // Log::info('Jud webhook started:', ['webhook' => $webhook, 'model' => $modelClass]);

                $url = $webhook->url;
                $headers = $webhook->headers;
                $eventData = $data[0];

                $requestData = [
                    'title' => $eventData->title ?? '',
                    'slug' => $eventData->slug ?? '',
                ];

                if ($headers !== null) {
                    $requestData['headers'] = json_decode($headers, true);
                }

                // Log::info('Sending HTTP request', ['url' => $url, 'data' => $requestData]);
                // Descomentar para probar webhook
                if ($webhook->method == 'POST') {
                    Http::post($url, $requestData);
                } elseif ($webhook->method == 'PUT') {
                    Http::put($url, $requestData);
                }

                // Log::info('JUD HTTP request sent');
            }
        }
    }
}

?>