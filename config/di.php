<?php

use App\Db\Database;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;
use Symfony\Component\Serializer\Normalizer\DenormalizableInterface;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\SerializerInterface;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

return [
    Serializer::class => function() {

        $dateCallback = function ($innerObject, $outerObject, string $attributeName, string $format = null, array $context = []) {
            $date = DateTime::createFromFormat('Y-m-d H:i:s', $innerObject);
            return $date instanceof \DateTime ? $date : '';
        };
        $defaultContext = [
            AbstractNormalizer::CALLBACKS => [
                'created_at' => $dateCallback,
                'updated_at' => $dateCallback
            ],
        ];
        $normalizers = [
            new DateTimeNormalizer(),
            new ObjectNormalizer(
                null,
                null,
                null,
                null,
                null,
                null,
                $defaultContext
            )
        ];
        return new Serializer($normalizers);
    },

    Database::class => function() {
        $config = require __DIR__ . '/database.php';
        return Database::instance($config['host'], $config['username'], $config['password'], $config['dbname']);
    },

    // Configure Twig
    Environment::class => function () {
        $loader = new FilesystemLoader(__DIR__ . '/../views');
        return new Environment($loader);
    },
];
