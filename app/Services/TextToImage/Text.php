<?php

namespace App\Services\TextToImage;

use Illuminate\Support\Collection;

class Text
{
    /**
     * @var string
     */
    protected $text;

    /**
     * @var Font
     */
    protected $font;

    /**
     * @param string $text
     * @param Font $font
     */
    public function __construct(string $text, Font $font)
    {
        $this->text = $text;
        $this->font = $font;
    }

    /**
     * @return Font
     */
    public function font(): Font
    {
        return $this->font;
    }

    /**
     * @param string $text
     * @return Collection
     */
    protected function splitText(string $text): Collection
    {
        return collect(preg_split("#(?:\r)?\n#", $text, -1))->map(function (string $line) {
            return trim($line);
        });
    }

    /**
     * @param string $text
     * @return int
     */
    protected function textBoxWidth(string $text): int
    {
        $dimensions = imagettfbbox($this->font->size(), 0, $this->font->path(), $text);

        return $dimensions['2'];
    }

    /**
     * @param Dimensions $dimensions
     * @return TextOutput
     */
    public function buildTextLines(Dimensions $dimensions): TextOutput
    {
        $lines = $this->splitText($this->text);

        $imageLines = [];

        // parse as smart one, + TrueType, + dimensions, + support of any .TTF font's
        // this is slower than simple mode
        // word-wrapping here is based on $dimensions (getting of this is covered in @textBoxWidth function), with is defines real width of output text
        foreach ($lines as $line) {
            //smart-case
            // if line is not fiiting into text-box, then ...
            if ($this->textBoxWidth($line) > $dimensions->innerWidth()) {
                // words separation
                $sourceWords = preg_split('#(\s+)#', $line, -1, PREG_SPLIT_DELIM_CAPTURE);
                $words = array();

                // @too long words protection (words that is not separated with space, but they can be too long for fitting into text box)
                for ($j = 0, $wc = count($sourceWords); $j < $wc; $j++) {
                    if ($this->textBoxWidth($sourceWords[$j]) > $dimensions->innerWidth()) {
                        // slice them up, guys ...

                        // for faster definition of how much words got to be pushed into $sentence, let's define approximation based on $text_size
                        $approximate_letters_count_in_slice = floor($dimensions->innerWidth() / $this->font->size());

                        while ($sourceWords[$j]) {
                            //if cases works as swapping-case
                            $slice = mb_substr($sourceWords[$j], 0, $approximate_letters_count_in_slice, 'utf-8');
                            $sourceWords[$j] = mb_substr($sourceWords[$j], $approximate_letters_count_in_slice, null, 'utf-8');
                            if ($this->textBoxWidth($slice) > $dimensions->innerWidth()) {
                                // too much, cut ...
                                while (($this->textBoxWidth($slice.'a') > $dimensions->innerWidth()) AND ($slice) AND ($sourceWords[$j])) {
                                    $index = (mb_strlen($slice, 'utf-8') - 1);
                                    $sourceWords[$j] .= $slice[$index];//return letter
                                    $slice = mb_substr($slice, 0, -1, 'utf-8');//recreate slice
                                }
                            } else {
                                // not enought, add ...
                                while (($this->textBoxWidth($slice.'a') < $dimensions->innerWidth()) AND ($slice) AND ($sourceWords[$j])) {
                                    $index = (mb_strlen($sourceWords[$j], 'utf-8') - 1);
                                    $slice .= $sourceWords[$j][$index];//add letter
                                    $sourceWords[$j] = mb_substr($sourceWords[$j], 0, -1, 'utf-8');//cut letter
                                }
                            }
                            $words[] = $slice;
                        }
                        unset($sourceWords[$j]);
                    } else {
                        // direct shifting will break key nodes, so let's make it the old way
                        $words[] = $sourceWords[$j];
                        unset($sourceWords[$j]);
                    }
                }
                unset($sourceWords);

                // @lines array creation, this is where word-wrapping happen's exactly
                while ($words) {
                    //while there is still words left ...
                    $sentence = '';

                    // keep looping, while there is some place for more characters ...
                    while (($this->textBoxWidth($sentence) < $dimensions->innerWidth()) AND ($words)) {
                        $oldSentence = $sentence;
                        $newWord = array_shift($words);
                        $sentence .= $newWord;
                    }

                    // unshift, if overflow
                    if ($this->textBoxWidth($sentence) > $dimensions->innerWidth()) {
                        $sentence = $oldSentence;
                        array_unshift($words, $newWord);
                    }

                    // and ... append ready sentence into $lines array
                    $imageLines[] = $sentence;

                    // clean some chunk faster, odd, but who care
                    unset($sentence);
                    unset($oldSentence);
                    unset($newWord);
                }
            } else {
                // smart-case
                // and if line is fitting into text-box, then ..
                $imageLines[] = $line;
            }
        }

        return new TextOutput($this, $imageLines);
    }
}