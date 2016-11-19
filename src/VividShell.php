<?php
declare(strict_types=1);

namespace Comely;

/**
 * Class VividShell
 * @package Comely
 */
class VividShell
{
    const VERSION   =   "0.1.3";

    /**
     * @param string $string
     * @param bool $reset
     * @return string
     */
    public static function Prepare(string $string, bool $reset = true) : string
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

        if($reset) {
            $prepared   .=  "\e[0m";
        }

        return $prepared;
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
     * @param string $string
     * @param int $wait
     * @param array|null $data
     */
    public static function Inline(string $string, int $wait = 0, array $data = null)
    {
        self::Print($string, $wait, $data, "");
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
     * @param string $string
     * @param int $wait
     * @param string $style
     * @param string $eol
     */
    public static function Type(string $string, int $wait = 100, $style = "", $eol = PHP_EOL)
    {
        print self::Prepare($style, false);
        $chars  =   str_split($string);
        foreach($chars as $char) {
            print $char;
            self::Sleep($wait);
        }

        print "\e[0m" . $eol;
    }

    /**
     * @param string $char
     * @param int $count
     * @param int $wait
     * @param string $eol
     */
    public static function Repeat(string $char = ".", int $count = 3, int $wait = 200, $eol = PHP_EOL)
    {
        for($i=0;$i<$count;$i++) {
            print $char;
            self::Sleep($wait);
        }

        print $eol;
    }
}