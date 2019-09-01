<?php

    use App\Blog\BlogModule;
    use Framework\App;
    use GuzzleHttp\Psr7\ServerRequest;
    use function Http\Response\send;

    require '../vendor/autoload.php';

    $whoops = new \Whoops\Run();
    $whoops->prependHandler(new \Whoops\Handler\PrettyPageHandler());
    $whoops->register();

    $app = new App([
        BlogModule::class
    ]);

    $response = $app->run(ServerRequest::fromGlobals());
    send($response);
