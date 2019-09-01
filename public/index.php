<?php

    use App\Blog\BlogModule;
    use Framework\App;
    use Framework\Renderer;
    use GuzzleHttp\Psr7\ServerRequest;
    use function Http\Response\send;

    require '../vendor/autoload.php';

    $whoops = new \Whoops\Run();
    $whoops->prependHandler(new \Whoops\Handler\PrettyPageHandler());
    $whoops->register();

    $renderer = new Renderer();
    $renderer->addPath(dirname(__DIR__) . DIRECTORY_SEPARATOR . 'views');
    $app = new App([
        BlogModule::class
    ], [
        'renderer' => $renderer
    ]);

    $response = $app->run(ServerRequest::fromGlobals());
    send($response);
