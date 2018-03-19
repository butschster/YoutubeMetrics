<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use KodiCMS\Assets\Contracts\MetaInterface;
use View;

class AppServiceProvider extends ServiceProvider
{
    /**
     * @param MetaInterface $meta
     */
    public function boot(MetaInterface $meta)
    {
        $this->makeMetaAttributes($meta);
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
                    'csrf-token' => csrf_token()
                ])
                ->setTitle($title)
                ->setFavicon(asset('images/favicon.ico'))
                ->render();
        });
    }
}
