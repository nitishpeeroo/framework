<?php
    namespace App\Blog;

  use App\Blog\Action\BlogAction;
  use App\Blog\Actions\AdminBlogAction;
  use Framework\Module;
  use Framework\Renderer\RendererInterface;
  use Framework\Router;
  use Psr\Container\ContainerInterface;

  /**
     * Class BlogModule
     * @package App\Blog
     */
class BlogModule extends Module
{

    const DEFINITIONS = __DIR__ . '/config.php';

    const MIGRATIONS = __DIR__ . '/db' . '/migrations';

    const SEEDS = __DIR__ . '/db' . DS  . 'seeds';

    /**
     * BlogModule constructor.
     *
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
            $router =  $container->get(Router::class);
            $container->get(RendererInterface::class)->addPath('blog', __DIR__ . '/views');
            $router->get($container->get('blog.prefix'), Actions\BlogAction::class, 'blog.index');
            $router->get($container->get('blog.prefix') . '/{slug:[a-z\-0-9]+}-{id:[0-9]+}', Actions\BlogAction::class, 'blog.show');
        if ($container->has('admin.prefix')) {
            $prefix = $container->get('admin.prefix');

            $router->crud($prefix . '/posts', AdminBlogAction::class, 'blog.admin');
        }
    }
}
