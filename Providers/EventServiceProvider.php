<?php

namespace Modules\Iwebhooks\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;
use Modules\Webhook\Listeners\GenericEventWebhooks;

class EventServiceProvider extends ServiceProvider
{
  public function boot()
  {
    parent::boot();

    Event::listen('eloquent.created: *', [GenericEventWebhooks::class, 'handle']);
    Event::listen('eloquent.updated: *', [GenericEventWebhooks::class, 'handle']);
    Event::listen('eloquent.deleted: *', [GenericEventWebhooks::class, 'handle']);
  }
}
