<?php

    use Framework\Renderer\RendererInterface;
    use Framework\Renderer\TwigRendererFactory;
    use Framework\Router\RouterTwigExtension;
    use Zend\Expressive\Router\RouterInterface;
    use function DI\factory;
    use function DI\get;

    return [
        'views.path' => dirname(__DIR__) . DIRECTORY_SEPARATOR . 'views',
        'twig.extensions' => [
          get(RouterTwigExtension::class)  
        ],
        RendererInterface::class => factory(TwigRendererFactory::class),
      RouterInterface::class => DI\create()
      
    ];