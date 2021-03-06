<?php

namespace App\Providers;

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use KodiCMS\Assets\Contracts\MetaInterface;
use Laravel\Horizon\Horizon;
use View;

class AppServiceProvider extends ServiceProvider
{
    /**
     * @param MetaInterface $meta
     */
    public function boot(MetaInterface $meta)
    {
        Schema::defaultStringLength(191);

        $this->makeMetaAttributes($meta);

        Horizon::auth(function ($request) {
            return $request->user();
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * @param MetaInterface $meta
     */
    protected function makeMetaAttributes(MetaInterface $meta): void
    {
        View::composer('layouts.app', function ($view) use ($meta) {
            $title = strip_tags($meta->getGroup('meta', 'title'));

            if (empty($title)) {
                $title = config('app.name', 'Laravel');
            } else {
                $title = $title.' - '.config('app.name', 'Laravel');
            }

            $view->meta = $meta
                ->addMeta([
                    'name' => 'csrf-token',
                    'content' => csrf_token()
                ])
                ->setTitle($title)
                ->setFavicon(asset('images/favicon.ico'))
                ->render();
        });
    }
}
