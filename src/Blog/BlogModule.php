<?php
    namespace App\Blog;

  use App\Blog\Action\BlogAction;
  use Framework\Module;
  use Framework\Renderer\RendererInterface;
  use Framework\Router;

    /**
     * Class BlogModule
     * @package App\Blog
     */
class BlogModule extends Module
{

    const DEFINITIONS = __DIR__ . DS . 'config.php';

    const MIGRATIONS = __DIR__ . DS . 'db' . DS . 'migrations';

    const SEEDS = __DIR__ . DS . 'db' . DS  . 'seeds';

    /**
     * BlogModule constructor.
     *
     * @param string            $prefix
     * @param Router            $router
     * @param RendererInterface $renderer
     */
    public function __construct(string $prefix, Router $router, RendererInterface $renderer)
    {
        $renderer->addPath('blog', __DIR__ . DS . 'views');
        $router->get($prefix, Actions\BlogAction::class, 'blog.index');
        $router->get($prefix . DS . '{slug:[a-z\-0-9]+}-{id:[0-9]+}', Actions\BlogAction::class, 'blog.show');
    }
}
