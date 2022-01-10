# Flysystem adapter for the Sciebo API
This package contains a [Flysystem v2](https://flysystem.thephpleague.com/v2/docs/) adapter for [Sciebo](https://hochschulcloud.nrw), a non-commercial file hosting service based on ownCloud provided by the universities of the state of North Rhine-Westphalia (Germany). The API is based on the WebDAV protocol.

## Installation

You can install the package via composer:

``` bash
composer require joschaefer/flysystem-sciebo
```

## Usage

### Prerequisit

First obtain credentials for accessing your Sciebo storage:
1. [Log in](https://hochschulcloud.nrw) to Sciebo
2. Click on your username in the top-right corner and go to _Settings_
3. Go to _Security_ tab
4. Enter a name for your application and hit _Create new app passcode_
5. Store the created credentials for later

### Basic usage

```php
<?php

use Joschaefer\Flysystem\Sciebo\ScieboAdapter;
use Joschaefer\Flysystem\Sciebo\ScieboClient;
use League\Flysystem\Filesystem;

include __DIR__ . '/vendor/autoload.php';

$client = new ScieboClient('rwth-aachen', 'ABC123@rwth-aachen.de', 'your-secret-app-passcode');
$adapter = new ScieboAdapter($client);
$filesystem = new Filesystem($adapter);
```

### Laravel

If you are using this adapter in a [Laravel](https://laravel.com/docs) project, add the following to _app/Providers/AppServiceProvider.php_:

```php
<?php

namespace App\Providers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\ServiceProvider;
use Joschaefer\Flysystem\Sciebo\ScieboAdapter;
use Joschaefer\Flysystem\Sciebo\ScieboClient;
use League\Flysystem\Filesystem;

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
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // ...
        
        Storage::extend('sciebo', function ($app, $config) {
            $client = new ScieboClient($config['node'], $config['username'], $config['password']);
            return new Filesystem(new ScieboAdapter($client, $config['prefix']));
        });
    }
}
```

After that you need to extend the configurations in _config/filesystems.php_ like this:

```php
<?php

return [

    // ...

    'disks' => [

        // ...

        'sciebo' => [
            'driver' => 'sciebo',
            'node' => env('SCIEBO_NODE', ''),
            'username' => env('SCIEBO_USERNAME', ''),
            'password' => env('SCIEBO_PASSWORD', ''),
            'prefix' => env('SCIEBO_PREFIX'),
        ],

    ],

    // ...

];
```

And finally add your config to your _.env_ file:

```dotenv
SCIEBO_NODE=rwth-aachen
SCIEBO_USERNAME=ABC123@rwth-aachen.de
SCIEBO_PASSWORD=your-secret-app-passcode
```

## Security

If you discover any security related issues, please email mail@johannes-schaefer.de instead of using the issue tracker.

## License

The MIT License (MIT). Please see [License File](LICENSE) for more information.
