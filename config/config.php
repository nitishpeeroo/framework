<?php

    use Framework\Renderer\RendererInterface;
    use Framework\Renderer\TwigRendererFactory;
    use Framework\Router\RouterTwigExtension;
    use Zend\Expressive\Router\RouterInterface;
    use function DI\factory;
    use function DI\get;

    return [
        'database.host' => 'localhost',
        'database.username' => 'root',
        'database.password' => 'GrandTheftAuto93@',
        'database.name' => 'sixtrone',
        'views.path' => dirname(__DIR__) . DS . 'views',
        'twig.extensions' => [
          get(RouterTwigExtension::class)
        ],
        RendererInterface::class => factory(TwigRendererFactory::class),
      RouterInterface::class => DI\create()
      
    ];