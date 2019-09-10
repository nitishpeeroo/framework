<?php
    namespace App\Blog\Actions;

    use App\Blog\Table\PostTable;
    use Framework\Actions\RouterAwareAction;
    use Framework\Renderer\RendererInterface;
    use Framework\Router;
    use Psr\Http\Message\ResponseInterface;
    use Psr\Http\Message\ServerRequestInterface as Request;

class AdminBlogAction
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
        if ($request->getMethod() === 'DELETE') {
            return $this->delete($request);
        }
        if (substr((string)$request->getUri(), -3) === 'new') {
            return $this->create($request);
        }
        if ($request->getAttribute('id')) {
            return  $this->edit($request);
        }
        return  $this->index($request);
    }

    public function create(Request $request)
    {

        if ($request->getMethod() == 'POST') {
            $params = $params = $this->getParams($request);
            $params = array_merge($params, [
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ]);
            $this->postTable->insert($params);
            return  $this->redirect('blog.admin.index');
        }

        return $this->renderer->render('@blog/admin/create', compact('item'));
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
        $items = $this->postTable->findPaginated(12, $p);
        return  $this->renderer->render('@blog/admin/index', compact('items'));
    }

    /**
     * @param Request $request
     *
     * @return ResponseInterface|string
     */
    public function edit(Request $request)
    {
        $item = $this->postTable->find($request->getAttribute('id'));

        if ($request->getMethod() == 'POST') {
            $params = $this->getParams($request);
            $params['updated_at'] = date('Y-m-d H:i:s');
            $this->postTable->update($item->id, $params);
            return  $this->redirect('blog.admin.index');
        }

        return $this->renderer->render('@blog/admin/edit', compact('item'));
    }

    public function delete(Request $request)
    {
        $this->postTable->delete($request->getAttribute('id'));
        return  $this->redirect('blog.admin.index');
    }

    private function getParams(Request $request)
    {
        return array_filter($request->getParsedBody(), function ($key) {
            return in_array($key, ['name', 'content', 'slug']);
        }, ARRAY_FILTER_USE_KEY);
    }
}
