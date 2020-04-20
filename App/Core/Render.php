<?php
namespace App\Core;

use Twig\Environment;
use Twig\Loader\FilesystemLoader;

class Render
{
    private $twig;
    private $loader;

    public function __construct()
    {
        $loaderParams = true ? [] : ['cache' => APP_PATH . '/Views/twig-cache', 'auto_reload' => true];

        $this->loader = new FilesystemLoader(APP_PATH . '/Views/twig');
        $this->twig = new Environment($this->loader, $loaderParams);
    }

    public function render(string $view, array $parameters)
    {
        $indexFile = ['index_file' => ROOT_PATH . 'index.php'];
        $parameters = array_merge($indexFile, $parameters);

        return $this->twig->render($view.'.twig', $parameters);
    }
}
