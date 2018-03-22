<?php

namespace App\Services\TextToImage;

class Dimensions
{

    /**
     * @var int
     */
    protected $width = 600;

    /**
     * @var int
     */
    protected $innerWidth;

    /**
     * @var int
     */
    protected $padding = 20;

    /**
     * @var int
     */
    protected $offsetTop;

    /**
     * @var int
     */
    protected $offsetLeft;

    /**
     * @param int $width
     * @param int $padding
     */
    public function __construct(int $width, int $padding = 20)
    {
        $this->width = $width;
        $this->padding = $padding;
    }

    /**
     * @return int
     */
    public function width(): int
    {
        return $this->width;
    }

    /**
     * @return int
     */
    public function innerWidth(): int
    {
        return $this->innerWidth;
    }

    /**
     * @return int
     */
    public function padding(): int
    {
        return $this->padding;
    }

    /**
     * @return int
     */
    public function offsetTop(): int
    {
        return $this->offsetTop;
    }

    /**
     * @return int
     */
    public function offsetLeft(): int
    {
        return $this->offsetLeft;
    }

    /**
     * @param int $width
     * @return Dimensions
     */
    public function setWidth(int $width): self
    {
        $this->width = $width;

        return $this;
    }

    /**
     * @param int $padding
     * @return Dimensions
     */
    public function setPadding(int $padding): self
    {
        $this->padding = $padding;

        return $this;
    }

    public function calculate()
    {
        $this->innerWidth = $this->width;

        if ($this->padding) {
            $this->innerWidth -= $this->padding * 2;
            $this->offsetTop = $this->padding;
            $this->offsetLeft = $this->padding;
        }
    }
}