<?php

interface Shape
{
    public function draw();
}

class Rectangle implements Shape
{
    private $width;
    private $height;

    public function __construct($width, $height)
    {
        $this->width = $width;
        $this->height = $height;
    }

    public function draw()
    {
        return 'Rectangle - W: ' . $this->width . ' | H: ' . $this->height;
    }
}

class Circle implements Shape
{
    private $diameter;

    public function __construct($diameter)
    {
        $this->diameter = $diameter;
    }

    public function draw()
    {
        return 'Circle - D: ' . $this->diameter;
    }
}

abstract class ShapeFactory
{
    abstract public function getShape();
}

class RectangleShapeFactory
{
    public function getShape()
    {
        return new Rectangle(2, 3);
    }
}

class CircleShapeFactory
{
    public function getShape()
    {
        return new Circle(2);
    }
}

class Canvas
{
    private $shapes;

    public function createComplexShape($shapeFactory)
    {
        $this->shapes = array();
        $this->shapes[] = $shapeFactory->getShape();
        $this->shapes[] = $shapeFactory->getShape();
        $this->shapes[] = $shapeFactory->getShape();
    }

    public function draw()
    {
        foreach ($this->shapes as $shape) {
            echo $shape->draw() . PHP_EOL;
        }
    }
}

$canvas = new Canvas();
$canvas->createComplexShape(new RectangleShapeFactory());
$canvas->draw();
$canvas->createComplexShape(new CircleShapeFactory());
$canvas->draw();
