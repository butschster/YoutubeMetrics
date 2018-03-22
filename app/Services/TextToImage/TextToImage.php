<?php

namespace App\Services\TextToImage;

class TextToImage
{
    /**
     * @var int
     */
    protected $dimensions;

    /**
     * @var Text[]
     */
    protected $elements = [];

    /**
     * @var Color
     */
    protected $backgroundColor ;

    /**
     * @var Color
     */
    protected $textColor;

    /**
     * @param int $width
     * @param int|null $padding
     */
    public function __construct(int $width, int $padding = null)
    {
        $this->dimensions = new Dimensions($width, $padding);

        $this->setBackgroundColor('#fff');
        $this->setTextColor('#111');
    }

    /**
     * @param Text $element
     * @return TextToImage
     */
    public function append($element): self
    {
        $this->elements[] = $element;

        return $this;
    }

    /**
     * @param string $hex
     * @return TextToImage
     */
    public function setBackgroundColor(string $hex): self
    {
        $this->backgroundColor = new Color($hex);

        return $this;
    }

    /**
     * @param string $hex
     * @return TextToImage
     */
    public function setTextColor(string $hex): self
    {
        $this->textColor = new Color($hex);

        return $this;
    }

    public function render()
    {
        $this->dimensions->calculate();

        $text = [];

        foreach ($this->elements as $element) {
            $text[] = $element->buildTextLines($this->dimensions);
        }

        $width = $this->dimensions->width();
        $height = $this->dimensions->padding() * 2;

        foreach ($text as $output) {
            $height += $output->height();
        }

        $image = imagecreate($width, $height);
        $pallete = array(
            'background' => imagecolorallocate($image, ...$this->backgroundColor->rgb()),
            'text' => imagecolorallocate($image, ...$this->textColor->rgb())
        );

        $offsetY = $this->dimensions->offsetTop();

        foreach ($text as $output) {
            foreach ($output->lines() as $line) {
                $line = trim($line);

                imagettftext(
                    $image,
                    $output->text()->font()->size(),
                    0,
                    $this->dimensions->offsetLeft(),
                    $offsetY,
                    $pallete['text'],
                    $output->text()->font()->path(),
                    $line
                );

                $offsetY += $output->text()->font()->lineHeight();
            }
        }

        header("Content-type: image/png");

        imagepng($image, null, 9);
    }
}