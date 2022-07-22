<?php

namespace App\Service;

class ShortTextService
{
    public function makeTextShorter(string $string, int $limit, string $break = ' ', string $pad = '...'): ?string
    {
        if(strlen($string) <= $limit) {
            return $string;
        }

        $string = mb_substr($string, 0, $limit);
        if(false !== ($breakpoint = mb_strrpos($string, $break))) {
            $string = mb_substr($string, 0, $breakpoint);
        }

        return $this->restoreTags($string) . $pad;
    }

    private function restoreTags(string $input): string
    {
        $opened = [];

        if(preg_match_all("/<(\/?[a-z]+)>?/i", $input, $matches)) {
            foreach($matches[1] as $tag) {
                if(preg_match("/^[a-z]+$/i", $tag, $regs)) {
                    if(strtolower($regs[0]) != 'br') {
                        $opened[] = $regs[0];
                    }
                } elseif(preg_match("/^\/([a-z]+)$/i", $tag, $regs)) {
                    $key = array_keys($opened, $regs[1]);
                    unset($opened[array_pop($key)]);
                }
            }
        }

        if($opened) {
            $tagsToClose = array_reverse($opened);
            foreach($tagsToClose as $tag) {
                $input .= "</$tag>";
            }
        }

        return $input;
    }
}
