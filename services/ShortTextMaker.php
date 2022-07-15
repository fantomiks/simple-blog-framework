<?php

namespace App\Services;

class ShortTextMaker
{
    public function makeAttributesShorter(array $items, string $key, int $maxChars = 1000): array
    {
        $getter = 'get' . ucfirst($key);
        $setter = 'set' . ucfirst($key);

        foreach ($items as $item) {
            if (!empty($value = $item->$getter())) {
                $item->$setter($this->makeTextShorter($value, $maxChars));
            }
        }

        return $items;
    }

    private function makeTextShorter(?string $str, int $max): ?string
    {
        if (null === $str || strlen($str) <= $max) {
            return $str;
        }

        $str = strip_tags($str);
        $str = rtrim($str, "!,.-");
        $str = substr($str, 0, strrpos($str, ' '));

        return $str . '...';
    }
}
