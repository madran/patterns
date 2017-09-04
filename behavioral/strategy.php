<?php
class Color
{
    public $r;
    public $g;
    public $b;

    public function __construct($r, $g, $b)
    {
        $this->r = $r;
        $this->g = $g;
        $this->b = $b;
    }

    public function __toString()
    {
        return '[' . $this->r . ',' . $this->g . ',' . $this->b . ']';
    }
}

class Pixel
{
    private $row;
    private $column;
    private $color;

    public function __construct($row, $column, $color)
    {
        $this->row = $row;
        $this->column = $column;
        $this->color = $color;
    }

    public function getRow()
    {
        return $this->row;
    }

    public function getColumn()
    {
        return $this->column;
    }

    public function getColor()
    {
        return $this->color;
    }

    public function __toString()
    {
        return '(X=' . $this->column . '|' . 'Y=' . $this->row . '|' . $this->color . ')';
    }
}

class ColorPicker
{
    private $colorPickMethod;
    private $color;

    public function pickColor($image, $x, $y, $strategy = null)
    {
        if ($strategy == null) {
            return $this->color = $image->getPixel($x, $y)->getColor();
        } else {
            return $this->color = $strategy->pickColor($image, $x, $y);
        }
    }

    public function setColor($color)
    {
        $this->color = $color;
    }

    public function getColor()
    {
        return $this->color;
    }
}

class ColorPickerBlendAdjacentColors
{
    public function pickColor($image, $x, $y)
    {
        $colors = array();
        if ($image->getPixel($x, $y - 1) != null)
            $colors[] = $image->getPixel($x, $y - 1)->getColor();

        if ($image->getPixel($x, $y + 1) != null)
            $colors[] = $image->getPixel($x, $y + 1)->getColor();

        if ($image->getPixel($x - 1, $y) != null)
            $colors[] = $image->getPixel($x - 1, $y)->getColor();

        if ($image->getPixel($x + 1, $y) != null)
            $colors[] = $image->getPixel($x + 1, $y)->getColor();
        
        if ($image->getPixel($x, $y) != null)
            $colors[] = $image->getPixel($x, $y)->getColor();

        $newR = $newG = $newB = 0;

        foreach($colors as $color) {
            $newR += $color->r;
            $newG += $color->g;
            $newB += $color->b;
        }

        $count = count($colors);

        $newR = $newR / $count;
        $newG = $newG / $count;
        $newB = $newB / $count;

        return new Color(round($newR), round($newG), round($newB));
    }
}

class Image
{
    private $w = 10;
    private $h = 10;
    private $pixels;

    public function __construct()
    {
        $numberOfPixels = $this->w * $this->h;
        for ($i = 0; $i < $numberOfPixels; $i++) {
            $row = $i % $this->w;
            $column = ($i - $row) / $this->h;
            $this->pixels[] = new Pixel($row, $column, new Color(rand(0, 255), rand(0, 255), rand(0, 255)));
        }
    }

    public function getPixel($x, $y)
    {
        if (isset($this->pixels[$this->h * $y + $x])) {
            return $this->pixels[$this->h * $y + $x];
        } else {
            return null;
        }
    }

    public function getWidth()
    {
        return $this->w;
    }

    public function getHeight()
    {
        return $this->h;
    }
}

$image = new Image();
for ($y = 0; $y < $image->getHeight(); $y++) {
    for ($x = 0; $x < $image->getWidth(); $x++) {
        echo $image->getPixel($x, $y);
    }
    echo PHP_EOL;
}

$colorPicker = new ColorPicker();
echo PHP_EOL;
echo $colorPicker->pickColor($image, 2, 2);
echo PHP_EOL;
echo $colorPicker->pickColor($image, 0, 0, new ColorPickerBlendAdjacentColors());
echo PHP_EOL;
