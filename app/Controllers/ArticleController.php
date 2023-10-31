<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Models\Article;
use App\Response;
use App\RickAndMorty;

class ArticleController
{

    public function index(): Response
    {
        $rickAndMorty = new RickAndMorty();
        return new Response("Articles.index", [
            "articles" => [
                new Article(
                    "{$rickAndMorty->getTitle()}",
                    "{$rickAndMorty->getDescription()}",
                    $rickAndMorty->getEpisodes()
                ),
                new Article("Title2", "Description2"),
                new Article("Title3", "Description3"),
            ]
        ]);
    }

    public function show(): Response
    {
        $article = "";
        if (stripos($_SERVER['REQUEST_URI'], "un/articles/showarticle")) {
            $article = str_replace("/un/articles/showarticle", "", $_SERVER['REQUEST_URI']);
        }
        return new Response("Articles.show",
            [
                $this->index()->getData()["articles"][$article]
            ]);
    }
}
