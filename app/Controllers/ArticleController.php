<?php
declare(strict_types=1);

namespace App\Controllers;

use APP\Models\Article;
use APP\Response;

class ArticleController
{
    public function index(): Response
    {
        return new Response("Articles.index", [
            "articles" => [
                new Article("Title1", "Description1"),
                new Article("Title2", "Description2"),
                new Article("Title3", "Description3"),
            ]
        ]);

    }
    public function show():Response
    {
        return new Response("Articles.show",[
            "article"=>new Article("TitleABC", "DescriptionABC"),
        ]);
    }
}
