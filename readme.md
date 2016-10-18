External Artisan
================

[Forked from dosjein/external_artisan](https://github.com/dosjein/external_artisan)

Artisan the task runner in Laravel.  This library makes it 
easy to use artisan commands in your own projects.

Installation with Composer
--------------------------

```shell
curl -s http://getcomposer.org/installer | php
php composer.phar require darunada/external-artisan
```

```json
"require": {
  "darunada/external-arisan":"dev-master"
}
```

Usage
-----
####Installation
To use this library, copy the ./artisan file to your project root.  

####Usage
+ `$ php artisan list` will display a list of available commands.
+ `$ php artisan help [command]` will display help text for the command

The [Artisan Page](https://laravel.com/docs/5.3/artisan) for Laravel 5.3
may present you with some options of how to use this library.

####Creating Commands
By default I put my commands in ./commands.  You can override the 
path to commands in the artisan file.

Any available commands need to be registered with Artisan.  This
is done in `Darunada\Console\ArtisanKernel` and will load a config.php file
located in your commands folder.  

#### Service Injection
Service injection doesn't work.  Instead, a Pimple Container is passed into
the Command constructor with the things you might need.

I will add services to this list as I need them.  Or, feel free to add 
your own.  You can also instantiate them yourself inside your commands.
+ `$container['filesystem']` is an `Illuminate\Filesystem\Filesystem`
+ ... Other entries will be added as I need them

These services are provided in `\Darunada\Console\InitArtisan`

##Todo
+ Provide a database service
+ Test??