<?php
    namespace App\Blog\Actions;

    use App\Blog\Table\PostTable;
    use Framework\Actions\RouterAwareAction;
    use Framework\Renderer\RendererInterface;
    use Framework\Router;
    use Psr\Http\Message\ResponseInterface;
    use Psr\Http\Message\ServerRequestInterface as Request;

class BlogAction
{

    /**
     * @var RendererInterface
     */
    private $renderer;

    /**
     * @var Router
     */
    private $router;
    /**
     * @var PostTable
     */
    private $postTable;

    use RouterAwareAction;


    public function __construct(RendererInterface $renderer, Router $router, PostTable $postTable)
    {
        $this->renderer = $renderer;
        $this->postTable = $postTable;
        $this->router = $router;
    }

    public function __invoke(Request $request)
    {
        if ($request->getAttribute('id')) {
            return  $this->show($request);
        }
        return  $this->index($request);
    }

    /**
     * @param Request $request
     *
     * @return string
     */
    public function index(Request $request) : string
    {
        $params = $request->getQueryParams();
        $p = (isset($params['p'])) ? (int)$params['p'] : 1;
        $posts = $this->postTable->findPaginated(12, $p);
        return  $this->renderer->render('@blog/index', compact('posts'));
    }

    /**
     * Affiche un article
     * @param Request $request
     *
     * @return ResponseInterface|string
     */
    public function show(Request $request)
    {
        $slug = $request->getAttribute('slug');
        $post = $this->postTable->find($request->getAttribute('id'));
        if ($post->slug !== $slug) {
            return $this->redirect('blog.show', [
                'slug' => $post->slug,
                'id' => $post->id
            ]);
        }

        return  $this->renderer->render('@blog/show', [
            'post' => $post
        ]);
    }
}
