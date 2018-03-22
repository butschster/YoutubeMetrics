<?php

namespace App\Services\TextToImage;

class Font
{
    /**
     * @var int
     */
    protected $size;

    /**
     * @var string
     */
    protected $path;

    /**
     * @var int
     */
    protected $lineHeight;

    /**
     * @param int $size
     * @param string $path
     * @param int|null $lineHeight
     */
    public function __construct(int $size, string $path, int $lineHeight = null)
    {
        $this->size = $size;
        $this->path = $path;
        $this->lineHeight = $lineHeight;
    }

    /**
     * @return int
     */
    public function size(): int
    {
        return $this->size;
    }

    /**
     * @return string
     */
    public function path(): string
    {
        return $this->path;
    }

    /**
     * @return int
     */
    public function lineHeight(): int
    {
        if (!$this->lineHeight) {
            return $this->lineHeight = $this->size * 1.5;
        }

        return $this->lineHeight;
    }

    /**
     * @return int
     */
    public function charWidth(): int
    {
        return imagefontwidth($this->font);
    }
}