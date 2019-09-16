<?php
    namespace App\Blog\Actions;

    use App\Blog\Table\PostTable;
    use Framework\Actions\RouterAwareAction;
    use Framework\Renderer\RendererInterface;
    use Framework\Router;
    use Framework\Session\FlashService;
    use Framework\Session\SessionInterface;
    use Framework\Validator;
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
    /**
     * @var FlashService
     */
    private $flashService;


    use RouterAwareAction;


    public function __construct(RendererInterface $renderer, Router $router, PostTable $postTable, FlashService $flashService)
    {
        $this->renderer = $renderer;
        $this->postTable = $postTable;
        $this->router = $router;
        $this->flashService = $flashService;
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
     * @return ResponseInterface|string
     */
    public function create(Request $request)
    {

        if ($request->getMethod() == 'POST') {
            $params = $params = $this->getParams($request);
            $params = array_merge($params, [
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ]);
            $validator = $this->getValidator($request);
            if ($validator->isValid()) {
                $this->postTable->insert($params);
                $this->flashService->success('L\'article à bien été crée');
                return  $this->redirect('blog.admin.index');
            }
            $item = $params;
            $errors = $validator->getErrors();
        }
        return $this->renderer->render('@blog/admin/create', compact('item', 'errors'));
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
            $validator = $this->getValidator($request);
            if ($validator->isValid()) {
                $this->postTable->update($item->id, $params);
                $this->flashService->success('L\'article à bien été modifié');
                return  $this->redirect('blog.admin.index');
            }
            $errors = $validator->getErrors();
            $params['id'] = $item->id;
            $item = $params;
        }

        return $this->renderer->render('@blog/admin/edit', compact('item', 'errors'));
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

    private function getValidator(Request $request)
    {
        return (new Validator($request->getParsedBody()))
            ->required('content', 'name', 'slug')
            ->length('content', 10)
            ->length('name', 2, 250)
            ->length('slug', 2, 50)
            ->slug('slug');
    }
}
