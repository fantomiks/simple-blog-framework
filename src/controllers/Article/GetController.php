<?php

namespace App\Controllers\Article;

use App\Controllers\Controller;
use App\Repository\ArticleRepository;
use App\Service\ArticleService;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;

class GetController extends Controller
{
    public function __invoke(int $id, ArticleService $articleRepository): Response
    {
        $article = $articleRepository->getArticleById($id);

        if (null === $article) {
            throw new ResourceNotFoundException("Article #{$id} not found");
        }

        return $this->render('article', ['article' => $article]);
    }
}
