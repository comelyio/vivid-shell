<?php
declare(strict_types=1);

namespace Comely\VividShell\ASCII;

/**
 * Class Banners
 * @package Comely\VividShell\ASCII
 */
class Banners
{
    /**
     * @param string $banner
     * @return array
     */
    public static function Digital(string $banner) : array
    {
        $words  =   explode(" ", $banner);
        $banner =   "|" . implode("|", str_split($banner)) . "|";
        foreach($words as $word) {
            $padding[]  =   str_repeat("+-", strlen($word)) . "+";
        }

        $padding    =   implode(" ", $padding ?? []);
        return [$padding, $banner, $padding];
    }
}