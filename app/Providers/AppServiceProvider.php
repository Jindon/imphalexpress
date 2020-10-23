<?php

namespace App\Providers;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Routing\UrlGenerator;
use Illuminate\Support\ServiceProvider;
use Livewire\Component;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->loadHelpers();
    }

    protected function loadHelpers()
    {
        foreach (glob(__DIR__.'/../Helpers/*.php') as $filename) {
            require_once $filename;
        }
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
//    public function boot(UrlGenerator $url)
    public function boot()
    {
//        $url->forceScheme('https');

        Builder::macro('search', function($field, $string) {
            return $string ? $this->where($field, 'like', '%'.$string.'%') : $this;
        });

        Component::macro('notify', function ($message) {
            $this->dispatchBrowserEvent('notify', $message);
        });

        Builder::macro('toCsv', function () {
            $results = $this->get();

            if ($results->count() < 1) return;

            $titles = implode(',', array_keys((array) $results->first()->getAttributes()));

            $values = $results->map(function ($result) {
                return implode(',', collect($result->getAttributes())->map(function ($thing) {
                    return '"'.$thing.'"';
                })->toArray());
            });

            $values->prepend($titles);

            return $values->implode("\n");
        });
    }
}
