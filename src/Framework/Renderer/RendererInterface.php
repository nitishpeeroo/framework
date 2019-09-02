<?php

    namespace Framework\Renderer;

interface RendererInterface
{
    /**
     * Rajout des chemins pour charger les vues
     *
     * @param string      $namespace
     * @param string|null $path
     */
    public function addPath(string $namespace, ?string $path = null): void;

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
     */
    public function render(string $view, array $params = []): string;

    /**
     * Rajouter des variables global à toutes les vues
     *
     * @param string $key
     * @param        $value
     */
    public function addGlobal(string $key, $value): void;
}
