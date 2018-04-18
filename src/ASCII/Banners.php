<?php
/**
 * This file is part of Comely Vivid Shell package.
 * https://github.com/comelyio/vivid-shell
 *
 * Copyright (c) 2018 Furqan A. Siddiqui <hello@furqansiddiqui.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code or visit following link:
 * https://github.com/comelyio/vivid-shell/blob/master/LICENSE
 */

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
    public static function Digital(string $banner): array
    {
        $words = explode(" ", $banner);
        $banner = "|" . implode("|", str_split($banner)) . "|";
        foreach ($words as $word) {
            $padding[] = str_repeat("+-", strlen($word)) . "+";
        }

        $padding = implode(" ", $padding ?? []);
        return [$padding, $banner, $padding];
    }
}