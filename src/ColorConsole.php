<?php
namespace Olive\Tools;

/**
 * customize https://github.com/kevinlebrun/colors.php/ for Olive
 * color.php license: (The MIT License) Copyright (c) 2018 Kevin Le Brun lebrun.k@gmail.com
 */
class ColorConsole
{
    public static function styles()
    {
        // italic and blink may not work depending of your terminal
        return [
          'reset' => '0',
          'bold' => '1',
          'dark' => '2',
          'italic' => '3',
          'underline' => '4',
          'blink' => '5',
          'reverse' => '7',
          'concealed' => '8',
          'default' => '39',
          'black' => '30',
          'red' => '31',
          'green' => '32',
          'yellow' => '33',
          'blue' => '34',
          'magenta' => '35',
          'cyan' => '36',
          'light_gray' => '37',
          'dark_gray' => '90',
          'light_red' => '91',
          'light_green' => '92',
          'light_yellow' => '93',
          'light_blue' => '94',
          'light_magenta' => '95',
          'light_cyan' => '96',
          'white' => '97',
          'bg_default' => '49',
          'bg_black' => '40',
          'bg_red' => '41',
          'bg_green' => '42',
          'bg_yellow' => '43',
          'bg_blue' => '44',
          'bg_magenta' => '45',
          'bg_cyan' => '46',
          'bg_light_gray' => '47',
          'bg_dark_gray' => '100',
          'bg_light_red' => '101',
          'bg_light_green' => '102',
          'bg_light_yellow' => '103',
          'bg_light_blue' => '104',
          'bg_light_magenta' => '105',
          'bg_light_cyan' => '106',
          'bg_white' => '107',
      ];
    }

    public static function render($string = '', $option = [])
    {
        if (isset($GLOBALS['OliveConsoleColor']) and $GLOBALS['OliveConsoleColor'] == false) {
            return $string;
        }
        $color = 'default';
        $background = 'default';
        $styles = [];
        if (isset($option['color'])) {
            $color = $option['color'];
        }
        if (isset($option['background'])) {
            $background = $option['background'];
        }
        if (isset($option['style'])) {
            $st = $option['style'];
            if (is_array($st)) {
                $styles = $st;
            } else {
                $styles = [$st];
            }
        }
        if (isset($option['align']) and $option['align'] == 'center') {
            $string = self::center($string);
        }
        $message = self::stylize($color, $string);
        $message = self::stylize('bg_' . $background, $message);
        foreach ($styles as $style) {
            $message = self::stylize($style, $message);
        }

        return $message;
    }

    /**
     * Returns true if the stream supports colorization.
     *
     * Colorization is disabled if not supported by the stream:
     *
     *  -  Windows without Ansicon, ConEmu or Babun
     *  -  non tty consoles
     *
     * @return bool true if the stream supports colorization, false otherwise
     *
     * @link https://github.com/symfony/Console/blob/master/Output/StreamOutput.php#L94
     * @codeCoverageIgnore
     */
    private static function shouldStylize()
    {
        if (DIRECTORY_SEPARATOR === '\\') {
            return (function_exists('sapi_windows_vt100_support')
                && @sapi_windows_vt100_support(STDOUT))
                || false !== getenv('ANSICON')
                || 'ON' === getenv('ConEmuANSI')
                || 'xterm' === getenv('TERM');
        }

        if (function_exists('stream_isatty')) {
            return @stream_isatty(STDOUT);
        }

        if (function_exists('posix_isatty')) {
            return @posix_isatty(STDOUT);
        }

        $stat = @fstat(self::stream);
        // Check if formatted mode is S_IFCHR
        return $stat ? 0020000 === ($stat['mode'] & 0170000) : false;
    }

    private static function stylize($style, $text)
    {
        if (! self::shouldStylize()) {
            return $text;
        }

        $style = strtolower($style);
        $styles = self::styles();
        if (array_key_exists($style, $styles)) {
            return self::buildEscSeq($styles[$style]) . $text . self::buildEscSeq($styles['reset']);
        }

        if (preg_match('/^((?:bg_)?)color\[([0-9]|[1-9][0-9]|1[0-9][0-9]|2[0-4][0-9]|25[0-5])\]$/', $style, $matches)) {
            $option = $matches[1] == 'bg_' ? 48 : 38;

            return self::buildEscSeq("{$option};5;{$matches[2]}") . $text . self::buildEscSeq($styles['reset']);
        }

        throw new \Exception("Invalid style $style");
    }

    private static function buildEscSeq($style)
    {
        return sprintf("\033[%sm", $style);
    }

    private static function center($text, $width = 80)
    {
        $centered = '';
        foreach (explode(PHP_EOL, $text) as $line) {
            $line = trim($line);
            $lineWidth = strlen($line) - mb_strlen($line, 'UTF-8') + $width;
            $centered .= str_pad($line, $lineWidth, ' ', STR_PAD_BOTH) . PHP_EOL;
        }

        return trim($centered, PHP_EOL);
    }
}
