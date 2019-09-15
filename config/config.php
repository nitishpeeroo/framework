<?php

    use Framework\Renderer\RendererInterface;
    use Framework\Renderer\TwigRendererFactory;
    use Framework\Router\RouterTwigExtension;
use Framework\Session\PHPSession;
use Framework\Session\SessionInterface;
use Framework\Twig\FlashExtension;
use Framework\Twig\PagerFantaExtension;
    use Framework\Twig\TextExtension;
    use Framework\Twig\TimeExtension;
    use Psr\Container\ContainerInterface;
    use Zend\Expressive\Router\RouterInterface;
use function DI\create;
use function DI\factory;
    use function DI\get;

    return [
        'database.host' => 'localhost',
        'database.username' => 'root',
        'database.password' => 'ariane',
        'database.name' => 'sixtrone',
        'views.path' => dirname(__DIR__) . '/views',
        'twig.extensions' => [
          get(RouterTwigExtension::class),
            get(PagerFantaExtension::class),
            get(TextExtension::class),
            get(TimeExtension::class),
            get(FlashExtension::class)
        ],
        SessionInterface::class => create(PHPSession::class),
        RendererInterface::class => factory(TwigRendererFactory::class),
      RouterInterface::class => DI\create(),
        \PDO::class => function(ContainerInterface $c){
        return new PDO('mysql:host=' . $c->get('database.host') .
            ';dbname=' . $c->get('database.name'),
        $c->get('database.username'),  $c->get('database.password'),
        [
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ]
        );
        }
      
    ];