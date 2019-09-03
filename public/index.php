<?php

    use App\Blog\BlogModule;
    use DI\ContainerBuilder;
    use Framework\App;
    use GuzzleHttp\Psr7\ServerRequest;
    use Whoops\Handler\PrettyPageHandler;
    use Whoops\Run;
    use function Http\Response\send;

    define(DS, DIRECTORY_SEPARATOR);
    require dirname(__DIR__) . DS . 'vendor' . DS . 'autoload.php';

    $whoops = new Run();
    $whoops->prependHandler(new PrettyPageHandler());
    $whoops->register();

    $modules  = [
        BlogModule::class
    ];

    $builder = new ContainerBuilder();
    $builder->addDefinitions(dirname(__DIR__) . DS . 'config' . DS . 'config.php');

    foreach ($modules as $module) {
        if ($module::DEFINITIONS) {
            $builder->addDefinitions($module::DEFINITIONS);
        }
    }
    $builder->addDefinitions(dirname(__DIR__) . DS . 'config.php');

    $container =  $builder->build();

    $app = new App($container, $modules);

    if (php_sapi_name() != "cli") {
        $response = $app->run(ServerRequest::fromGlobals());
        send($response);
    }
