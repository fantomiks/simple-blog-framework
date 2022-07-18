<?php

namespace App\Service;

use App\Model\Article;
use App\Model\User;
use App\Repository\ArticleRepository;
use App\Repository\CommentRepository;
use App\Repository\UserRepository;
use Symfony\Component\Serializer\Serializer;

class ArticleService
{
    private ArticleRepository $articleRepository;
    private UserRepository $userRepository;
    private Serializer $serializer;
    private ShortTextService $shortTextService;
    private CommentRepository $commentRepository;

    public function __construct(
        ArticleRepository $articleRepository,
        UserRepository $userRepository,
        CommentRepository $commentRepository,
        Serializer $serializer,
        ShortTextService $shortTextService
    ) {
        $this->articleRepository = $articleRepository;
        $this->userRepository = $userRepository;
        $this->commentRepository = $commentRepository;
        $this->serializer = $serializer;
        $this->shortTextService = $shortTextService;
    }

    public function getArticles(int $limit = 10, int $offset = 0): array
    {
        $articlesData = $this->articleRepository->findAll($limit, $offset);
        $totalArticles = $this->articleRepository->count();

        $articles = [];
        foreach ($articlesData as $articleData) {
            /** @var Article $article */
            $article = $this->denormalize($articleData, Article::class);
            $article->setContent($this->shortTextService->makeTextShorter($article->getContent(), 1000));

            $userData = $this->userRepository->findById($article->getAuthorId());
            $user = $this->denormalize($userData, User::class);

            $article->setUser($user);

            $article->setCommentsCount($this->commentRepository->countCommentsOnArticle($article->getId()));

            $articles[] = $article;
        }

        return [$articles, $totalArticles];
    }

    public function getArticleById(int $id): ?Article
    {
        $articleData = $this->articleRepository->findById($id);

        if (!$articleData) {
            return null;
        }

        $article = $this->denormalize($articleData, Article::class);
        $userData = $this->userRepository->findById($article->getAuthorId());
        $user = $this->denormalize($userData, User::class);

        $article->setUser($user);

        $article->setCommentsCount($this->commentRepository->countCommentsOnArticle($article->getId()));

        return $article;
    }

    private function denormalize(array $properties, string $className)
    {
        return $this->serializer->denormalize($properties, $className);
    }
}
