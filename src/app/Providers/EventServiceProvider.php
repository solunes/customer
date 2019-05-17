<?php

namespace Solunes\Customer\App\Providers;

use Illuminate\Contracts\Events\Dispatcher as DispatcherContract;
use Solunes\Master\App\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{

    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        //
    ];

    /**
     * Register any other events for your application.
     *
     * @param  \Illuminate\Contracts\Events\Dispatcher  $events
     * @return void
     */
    public function boot(DispatcherContract $events)
    {
        
        // Módulo de Proyectos
        $events->listen('eloquent.created: Solunes\Customer\App\Customer', '\Solunes\Customer\App\Listeners\CustomerCreated');
        $events->listen('eloquent.saving: Solunes\Customer\App\Customer', '\Solunes\Customer\App\Listeners\CustomerSaving');
        $events->listen('eloquent.creating: Solunes\Customer\App\CustomerActivity', '\Solunes\Customer\App\Listeners\CustomerItemCreating');
        $events->listen('eloquent.creating: Solunes\Customer\App\CustomerNote', '\Solunes\Customer\App\Listeners\CustomerItemCreating');

        parent::boot($events);
    }
}
