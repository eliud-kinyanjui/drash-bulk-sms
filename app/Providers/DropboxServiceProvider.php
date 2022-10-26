<?php

namespace App\Providers;

use App\Adapters\AutoRefreshingDropBoxTokenService;
use Illuminate\Filesystem\FilesystemAdapter;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\ServiceProvider;
use League\Flysystem\Filesystem;
use Spatie\Dropbox\Client as DropboxClient;
use Spatie\FlysystemDropbox\DropboxAdapter;

class DropboxServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        Storage::extend('dropbox', function ($app, $config) {
            $token = new AutoRefreshingDropBoxTokenService;
            $client = new DropboxClient($token->getToken($config['key'], $config['secret'], $config['refreshToken']));
            $adapter = new DropboxAdapter($client);

            return new FilesystemAdapter(
                new Filesystem($adapter, ['case_sensitive' => false]),
                $adapter,
                $config
            );
        });
    }
}
