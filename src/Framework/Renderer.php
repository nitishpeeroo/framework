<?php
    namespace Framework;

class Renderer
{

    const   DEFAULT_NAMESPACE = '__MAIN';

    /**
     * @var array
     */
    private $paths  = [];

    /**
     * Variable Global accessible à toutes les vues
     * @var array
     */
    private $globals = [];

    /**
     * Rajout des chemins pour charger les vues
     * @param string      $namespace
     * @param string|null $path
     */
    public function addPath(string $namespace, ?string $path = null): void
    {
        if (is_null($path)) {
            $this->paths[self::DEFAULT_NAMESPACE] = $namespace;
        } else {
            $this->paths[$namespace] = $path;
        }
    }

    /**
     * Rendre une vue
     * Le chemin peut etre précisé avec des namespaces rajouté via le addPath
     * $this->render('@blog/view')
     * $this->render('view')
     * @param string $view
     * @param array  $params
     *
     * @return string
     */
    public function render(string $view, array $params = []) : string
    {

        if ($this->hasNameSpace($view)) {
            $path = $this->replaceNameSpace($view) . '.php';
        } else {
            $path = $this->paths[self::DEFAULT_NAMESPACE] . DIRECTORY_SEPARATOR . $view . '.php';
        }
        ob_start();
        $renderer = $this;
        extract($this->globals);
        extract($params);
        require($path);
        return ob_get_clean();
    }

    /**
     * Rajouter des variables global à toutes les vues
     * @param string $key
     * @param        $value
     */
    public function addGlobal(string  $key, $value) : void
    {
        $this->globals[$key] = $value;
    }

    private function hasNameSpace(string $view): bool
    {
        return $view[0] === '@';
    }

    private function getNameSpace(string $view): string
    {
        return substr($view, 1, strpos($view, '/') - 1);
    }

    private function replaceNameSpace(string $view): string
    {
        $namespace = $this->getNameSpace($view);
        return str_replace('@' . $namespace, $this->paths[$namespace], $view);
    }
}
