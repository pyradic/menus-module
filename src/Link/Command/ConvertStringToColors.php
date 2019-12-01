<?php

namespace Pyro\MenusModule\Link\Command;

use SSNepenthe\ColorUtils\Colors\Color;
use SSNepenthe\ColorUtils\Colors\Rgb;
use function SSNepenthe\ColorUtils\color;

class ConvertStringToColors
{
    /**
     * @var array
     */
    protected static $colorcache = [];

    /** @var string */
    protected $string;

    public function __construct(string $string)
    {
        $this->string = $string;
    }

    public function handle()
    {
        if ( ! array_key_exists($this->string, static::$colorcache)) {
            $colorCode = $this->stringToColorCode($this->string);
            $color     = color($colorCode);
            $hsl       = $color->getHsl();
            $lightness = (int)$hsl->getLightness();

            $treshold        = 30;
            $requiresDarking = $hsl->isLight(100 - $treshold);
            if ($requiresDarking) {
                $lightness -= $treshold;
                $color     = $color->with([ 'lightness' => $lightness ]);
            }

            $darker  = $color->with([ 'lightness' => $lightness - 10 ]);
            $lighter = $color->with([ 'lightness' => $lightness + 10 ]);

            static::$colorcache [ $this->string ] = compact('color', 'darker', 'lighter');
        }
        return static::$colorcache [ $this->string ];
    }

    protected function stringToColorCode($str)
    {
        $code = dechex(crc32($str));
        $code = substr($code, 0, 6);
        return '#' . strtoupper($code);
    }

    public static function returnCompletion()
    {
        $color = new Color(new Rgb(0, 0, 0));
        return [ 'color' => $color, 'darker' => $color, 'lighter' => $color ];
    }
}
