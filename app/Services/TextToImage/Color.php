<?php

namespace App\Services\TextToImage;

class Color
{
    /**
     * @var string
     */
    protected $hex;

    /**
     * @param string $hex
     */
    public function __construct(string $hex)
    {
        $this->hex = $hex;
    }

    /**
     * @return array
     */
    public function rgb()
    {
        return $this->hex2rgb($this->hex);
    }

    // @hex2rgb converter
    protected function hex2rgb($hex)
    {
        $hex = str_replace("#", "", $hex);

        if (strlen($hex) == 3) {
            $r = hexdec(substr($hex, 0, 1).substr($hex, 0, 1));
            $g = hexdec(substr($hex, 1, 1).substr($hex, 1, 1));
            $b = hexdec(substr($hex, 2, 1).substr($hex, 2, 1));
        } else {
            $r = hexdec(substr($hex, 0, 2));
            $g = hexdec(substr($hex, 2, 2));
            $b = hexdec(substr($hex, 4, 2));
        }

        return [$r, $g, $b];
    }
}