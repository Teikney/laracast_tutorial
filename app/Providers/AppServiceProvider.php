<?php

namespace App\Providers;

use App\Models\User;
use App\Services\MailchimpNewsletter;
use App\Services\Newsletter;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use MailchimpMarketing\ApiClient;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
        if ($this->app->environment('local') && config('clockwork.enable')) {
            $this->app->register(\Clockwork\Support\Laravel\ClockworkServiceProvider::class);
        }

        app()->bind(Newsletter::class, function () {
            $client = ( new ApiClient() )->setConfig([
                'apiKey' => config('services.mailchimp.key'),
                'server' => 'us14'
            ]);

            return new MailchimpNewsletter($client);
        });

        //simple EXAMPLE of putting SOMETHING in the "toychest"
        // app()->bind(Newsletter::class, function() {
        //     return new Newsletter(new ApiClient(), 'foobar');
        // });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //Paginator::useBootstrap();
        Model::unguard();

        Gate::define('admin' , function (User $user) {
            return $user->username == "djsilva";
        });

        //refers to the usage of @admin in blade files
        Blade::if('admin', function () {
            return request()->user()?->can('admin');
        });
    }
}
