<?php

namespace Chinkiver\TencentCos;

use \Illuminate\Support\ServiceProvider as BaseServiceProvider;

class ServiceProvider extends BaseServiceProvider
{
    public function register()
    {
        $this->app->singleton(CosClient::class, fn() => new CosClient(\config('filesystems.disks.cos')));
    }

    public function provides()
    {
        return [CosClient::class];
    }
}
