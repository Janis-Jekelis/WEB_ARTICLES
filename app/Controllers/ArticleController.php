<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Models\Article;
use App\Response;

class ArticleController
{

    public function index():Response
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
        $article="";
        if (stripos($_SERVER['REQUEST_URI'],"un/showarticle")){
            $article=str_replace("/un/showarticle","",$_SERVER['REQUEST_URI']);
        }
                  return new Response("Articles.show",[
               $this->index()->getData()["articles"][$article]
            ]);
    }
}
