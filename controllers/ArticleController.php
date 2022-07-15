<?php

namespace App\Controllers;

use App\Core\Database;
use App\Repositories\ArticleRepository;
use App\Services\ShortTextMaker;
use Symfony\Component\HttpFoundation\Request;

class ArticleController extends Controller
{
    protected const PER_PAGE = 3;

    public function index(Request $request)
    {
        $page = $request->query->get('page', 1);

        $title = 'Articles';

        //@todo use config/env to configure instances
        $dbConfig = [
            'hostname' => 'db',
            'database' => 'blog',
            'username' => 'blog',
            'password' => 'pass',
        ];

        //@todo use DI
        $textPreparationService = new ShortTextMaker();
        $db = new Database($dbConfig);
        $repo = new ArticleRepository($db);
        $articles = $textPreparationService->makeAttributesShorter(
            $repo->fetchAll(self::PER_PAGE, ($page-1) * self::PER_PAGE),
            'content',
        2
        );


        //@todo use Paginator class
        $pages = (int)($repo->totalCount() / self::PER_PAGE);

        return $this->render('articles', [
            'title' => $title,
            'articles' => $articles,

            'fromPage' => ($start = $pages - 10) < 0 ? 1 : $start,
            'toPage' => ($end = $page + 10) > $pages ? $pages : $end,
            'page' => $page,
        ]);
    }
}
