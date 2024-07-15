<?php
namespace Modules\Iwebhooks\Listeners;

use Illuminate\Support\Facades\Http;
use Modules\Iwebhooks\Entities\Hook;
use Illuminate\Support\Facades\Log;

class EventWebhooks
{
    protected $webhook;

    public function __construct(Hook $webhook)
    {
        $this->webhook = $webhook;
    }

    public function handle($event)
    {
        //Log::info('EventWebhooks handle method called', ['webhook' => $this->webhook]);

        $url = $this->webhook->url;
        $headers = $this->webhook->headers;
        $eventData = $event->getModel();

        $requestData = [
            'title' => $eventData->title,
            'slug' => $eventData->slug,
        ];

        if ($headers !== null) {
            $requestData['headers'] = $headers;
        }

        //Log::info('Sending HTTP request', ['url' => $url, 'data' => $requestData]);

        if ($this->webhook->method == 'POST') {
            Http::post($url, $requestData);
        } elseif ($this->webhook->method == 'PUT') {
            Http::put($url, $requestData);
        }

        //Log::info('HTTP request sent');
    }
}
?>