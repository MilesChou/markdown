<?php

use LaravelBridge\Scratch\Application as LaravelBridge;
use MilesChou\Codegener\CodegenerServiceProvider;
use MilesChou\Schemarkdown\App;
use org\bovigo\vfs\vfsStream;

require dirname(__DIR__) . '/vendor/autoload.php';

return (function () {
    $vfs = vfsStream::setup('view');

    $container = (new LaravelBridge())
        ->setupDatabase([])
        ->setupView(dirname(__DIR__) . '/src/templates', $vfs->url())
        ->setupProvider(CodegenerServiceProvider::class)
        ->bootstrap();

    return new App($container);
})();
