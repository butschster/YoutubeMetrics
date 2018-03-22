<?php

namespace App\Services\TextToImage;

class TextOutput
{
    /**
     * @var Text
     */
    protected $text;

    /**
     * @var array
     */
    protected $lines;

    /**
     * @param Text $text
     * @param array $lines
     */
    public function __construct(Text $text, array $lines)
    {
        $this->text = $text;
        $this->lines = $lines;
    }

    /**
     * @return float
     */
    public function height(): float
    {
        return count($this->lines) * $this->text->font()->lineHeight();
    }

    /**
     * @return array
     */
    public function lines(): array
    {
        return $this->lines;
    }

    /**
     * @return Text
     */
    public function text(): Text
    {
        return $this->text;
    }
}