<?php

namespace Modules\Iwebhooks\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;
use Modules\Iwebhooks\Services\DispatchService;
use Modules\Core\Icrud\Transformers\CrudResource;

class EventServiceProvider extends ServiceProvider
{
  public function boot()
  {
    parent::boot();
    $hookRepository = app('Modules\Iwebhooks\Repositories\HookRepository');

    //Get the event hooks to listen for events
    $requestParams = array("filter" => ['type_id' => 1]);
    $hooks = $hookRepository->getItemsBy(json_decode(json_encode($requestParams)));

    //Register the listeners to hook events
    foreach ($hooks as $hook) {
      if ($hook->event_entity && $hook->event_type_id) {
        //Instance the event Name
        $eventName = $hook->eventType['value'] . ' ' . $hook->event_entity;

        // NO allow listen events to Modules\Iwebhooks\Entities\Hook to prevent nfinity loops
        if (!str_contains($eventName, 'Modules\Iwebhooks\Entities\Hook')) {
          Event::listen($eventName, function ($modelData) use ($eventName, $hook) {
            $canCallHook = true;
            //Validate if is updated event. if event is .saved but the event is from creation then no call the hook
            if (str_contains($eventName, 'eloquent.saved') && $modelData->wasRecentlyCreated) {
              $canCallHook = false;
            }
            //Call the hook
            if ($canCallHook) {
              //Call the hook and include the model data
              $hookService = new DispatchService();
              $hookService->dispatchWebhook(
                $hook->id, [],
                ['modelData' => CrudResource::transformData($modelData)->resolve()]
              );
              \Log::info("Iwedhooks:: Hook [" . $hook->title . "] called in event [" . $eventName . "]");
            }
          });
        }
      }
    }
  }
}
