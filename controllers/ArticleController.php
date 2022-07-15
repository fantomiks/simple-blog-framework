<?php

namespace App\Controllers;

use App\Core\Database;
use App\Repositories\ArticleRepository;
use App\Services\ShortTextMaker;
use Symfony\Component\HttpFoundation\Request;

class ArticleController extends Controller
{
    protected const PER_PAGE = 3;

    private ArticleRepository $repo;
    private ShortTextMaker $textPreparationService;

    public function __construct()
    {
        //@todo use config/env to configure instances
        $dbConfig = [
            'hostname' => 'db',
            'database' => 'blog',
            'username' => 'blog',
            'password' => 'pass',
        ];

        //@todo use DI
        $this->textPreparationService = new ShortTextMaker();
        $db = new Database($dbConfig);
        $this->repo = new ArticleRepository($db);

        parent::__construct();
    }

    public function index(Request $request)
    {
        $page = $request->query->get('page', 1);

        $title = 'Articles';

        $articles = $this->textPreparationService->makeAttributesShorter(
            $this->repo->fetchAll(self::PER_PAGE, ($page-1) * self::PER_PAGE),
            'content',
            2
        );

        //@todo use Paginator class
        $pages = (int)($this->repo->totalCount() / self::PER_PAGE);

        return $this->render('articles', [
            'title' => $title,
            'articles' => $articles,

            'fromPage' => ($start = $pages - 10) < 0 ? 1 : $start,
            'toPage' => ($end = $page + 10) > $pages ? $pages : $end,
            'page' => $page,
        ]);
    }

    public function show(Request $request)
    {

        $id = (int)(substr($request->getPathInfo(), strrpos($request->getPathInfo(), '/') + 1));

        $article = $this->repo->findById($id);

        return $this->render('article', ['article' => $article]);
    }
}
