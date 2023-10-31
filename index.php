<?php
declare(strict_types=1);
require_once "vendor/autoload.php";

use Carbon\Carbon;

$loader = new \Twig\Loader\FilesystemLoader('app/View');
$twig = new \Twig\Environment($loader);
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();


$dispatcher = FastRoute\simpleDispatcher(function (FastRoute\RouteCollector $r) {
    $r->addRoute('GET', "/un/articles", ["App\Controllers\ArticleController", "index"]);
    if (stripos($_SERVER['REQUEST_URI'], "showarticle")) {
        $r->addRoute('GET', $_SERVER['REQUEST_URI'], ["App\Controllers\ArticleController", "show"]);
    }
});

$httpMethod = $_SERVER['REQUEST_METHOD'];
$uri = $_SERVER['REQUEST_URI'];

if (false !== $pos = strpos($uri, '?')) {
    $uri = substr($uri, 0, $pos);
}
$uri = rawurldecode($uri);

$routeInfo = $dispatcher->dispatch($httpMethod, $uri);
switch ($routeInfo[0]) {
    case FastRoute\Dispatcher::NOT_FOUND:
        // ... 404 Not Found
        break;
    case FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
        $allowedMethods = $routeInfo[1];
        // ... 405 Method Not Allowed
        break;
    case FastRoute\Dispatcher::FOUND:
        $vars = $routeInfo[2];
        $handler = $routeInfo[1];
        [$class, $method] = [$handler[0], $handler[1]];
        $response = (new $class)->$method();

        if ($response->getViewName() === "Articles.index") {
            echo $twig->render('view.html', ['pageTitle' => "Articles"]);
            foreach ($response->getData() as $data) {
                foreach ($data as $itemKey => $item) {
                    echo $twig->render('view.html', [
                        'articles' => [
                            [
                                "title" => $item->getTitle(),
                                "description" => Carbon::today()->format('Y-m-d'),
                                "redirect" => "showarticle" . $itemKey
                            ]
                        ]
                    ]);


                }
            }
        }
        if ($response->getViewName() === "Articles.show") {
            echo '<a href="/un/articles"><-back</a>';
            echo "<br>" . "<br>";
            echo($response->getData()[0]->getTitle());
            echo "<br>";
            echo($response->getData()[0]->getDescription());
            echo "<br>";
            if (($response->getData()[0])->getContent() != null) {
                foreach ($response->getData()[0]->getContent() as $content) {
                    echo $content;
                    echo "<br>";
                }
            }
        }
        break;
}