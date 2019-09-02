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

    const DEFINITIONS = __DIR__ . DIRECTORY_SEPARATOR . 'config.php';

    /**
     * BlogModule constructor.
     *
     * @param string            $prefix
     * @param Router            $router
     * @param RendererInterface $renderer
     */
    public function __construct(string $prefix, Router $router, RendererInterface $renderer)
    {
        $renderer->addPath('blog', __DIR__ . DIRECTORY_SEPARATOR . 'views');
        $router->get($prefix, Actions\BlogAction::class, 'blog.index');
        $router->get($prefix . DIRECTORY_SEPARATOR . '{slug:[a-z\-0-9]+}', Actions\BlogAction::class, 'blog.show');
    }
}
