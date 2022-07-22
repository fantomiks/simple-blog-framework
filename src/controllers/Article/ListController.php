<?php

namespace App\Controllers\Article;

use App\Controllers\Controller;
use App\Service\ArticleService;
use App\Service\PaginationService;
use Symfony\Component\HttpFoundation\Response;

class ListController extends Controller
{
    public function __invoke(int $page, ArticleService $articleService): Response
    {
        [$articles, $totalArticles] = $articleService->getArticles(3, ($page - 1) * 3);
        $paginator = new PaginationService($page, $totalArticles);

        return $this->render('articles', [
            'articles' => $articles,
            'paginator' => $paginator,
        ]);
    }
}
