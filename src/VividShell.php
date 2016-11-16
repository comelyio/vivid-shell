<?php
declare(strict_types=1);

namespace Comely;

/**
 * Class VividShell
 * @package Comely
 */
class VividShell
{
    /**
     * @param string $string
     * @return string
     */
    public static function Prepare(string $string) : string
    {
        $prepared   =   preg_replace_callback(
            '/\{([a-z]+|\/)\}/i',
            function ($modifier) {
                switch (strtolower($modifier[1] ?? "")) {
                    // Colors
                    case "red":
                        return "\e[31m";
                    case "green":
                        return "\e[32m";
                    case "yellow":
                        return "\e[33m";
                    case "blue":
                        return "\e[34m";
                    case "magenta":
                        return "\e[35m";
                    case "gray":
                    case "grey":
                        return "\e[90m";
                    case "cyan":
                        return "\e[36m";
                    // Formats
                    case "b":
                    case "bold":
                        return "\e[1m";
                    case "u":
                    case "underline":
                        return "\e[4m";
                    // Special
                    case "blink":
                        return "\e[5m";
                    case "invert":
                        return "\e[7m";
                    // Reset
                    case "reset":
                    case "/":
                        return "\e[0m";
                    // Default
                    default:
                        return $modifier[0] ?? "";
                }
            },
            $string
        );

        return $prepared . "\e[0m";
    }

    /**
     * Prepare and print a string
     *
     * If $wait param is passed, script will sleep for given period (milliseconds)
     * If $data is passed, input string will formatted using vsprintf()
     *
     * @param string $string
     * @param int $wait Milliseconds (1000 ms = 1 second)
     * @param array|null $data
     * @param string $eol
     */
    public static function Print(string $string, int $wait = 0, array $data = null, $eol = PHP_EOL)
    {
        if(is_array($data)) {
            $string =   vsprintf($string, $data);
        }

        print self::Prepare($string) . $eol;
        self::Sleep($wait);
    }

    /**
     * @param int $milliseconds
     */
    public static function Sleep(int $milliseconds = 0)
    {
        if($milliseconds    >   0) {
            usleep(intval(($milliseconds/1000)*pow(10,6)));
        }
    }

    /**
     * @param string $word
     * @param int $times
     * @param int $wait
     * @param string $eol
     */
    public static function Repeat(string $word = ".", int $times = 3, int $wait = 300, string $eol = PHP_EOL)
    {
        for($i=0;$i<$times;$i++) {
            self::Print($word, $wait, null, $eol);
        }
    }
}