<?php
    namespace Framework\Renderer;
    use Framework\Renderer\RendererInterface;
    use Twig\Environment;
    use Twig\Error\LoaderError;
    use Twig\Error\RuntimeError;
    use Twig\Error\SyntaxError;
    use Twig\Loader\FilesystemLoader;

class TwigRenderer implements RendererInterface
{

    private $twig;

    private $loader;

    public function __construct(FilesystemLoader $loader, Environment $twig)
    {
        $this->loader = $loader;
        $this->twig = $twig;
    }

    /**
     * Rajout des chemins pour charger les vues
     *
     * @param string      $namespace
     * @param string|null $path
     *
     * @throws LoaderError
     */
    public function addPath(string $namespace, ?string $path = null): void
    {
        $this->loader->addPath($path, $namespace);
    }

    /**
     * Rendre une vue
     * Le chemin peut etre précisé avec des namespaces rajouté via le addPath
     * $this->render('@blog/view')
     * $this->render('view')
     *
     * @param string $view
     * @param array  $params
     *
     * @return string
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function render(string $view, array $params = []): string
    {
        return $this->twig->render($view . '.twig', $params);
    }

    /**
     * Rajouter des variables global à toutes les vues
     *
     * @param string $key
     * @param        $value
     */
    public function addGlobal(string $key, $value): void
    {
        $this->twig->addGlobal($key, $value);
    }
}
