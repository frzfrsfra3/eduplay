<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     */
    protected $listen = [
        'Illuminate\Auth\Events\Login' => [
            'App\Listeners\LogSuccessfulLogin',
        ],
        'App\Events\Publish' => [
            'App\Listeners\NewVersionPublished',
        ],
        'App\Events\AssignCompleted' => [
            'App\Listeners\EmailNotification',
        ],
        'App\Events\EnrollRequested' => [
            'App\Listeners\EnrollRequestNotification',
        ],

        'App\Events\ClassCreated' => [
            'App\Listeners\ClassCreatedListener',
        ],
        'App\Events\ExerciseSetAdded' => [
            'App\Listeners\ExerciseSetAddedListener',
        ],
        'App\Events\EnrollAcceptedRejected' => [
            'App\Listeners\EnrollAcceptedRejected',
        ],
        'App\Events\Actiontaken' => [
            'App\Listeners\ActiontakenListener',
        ],
        'App\Events\UserRegistered' => [
            'App\Listeners\UserRegisteredListener',

        ],
        'App\Events\InviteLearner' => [
            'App\Listeners\InviteLearnerPendingTask',

        ],
        'App\Events\ExerciseSetCreated' => [
            'App\Listeners\ExerciseSetCreatedListener',

        ],
        'App\Events\CompleteProfile' => [
            'App\Listeners\CompleteProfileListener',

        ],
        'App\Events\ExamAdded' => [
            'App\Listeners\ExamAddedListener',

        ],
    ];

    protected $subscribe = [
        'App\Listeners\EmailNotification',
    ];

    /**
     * Register any events for your application.
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
