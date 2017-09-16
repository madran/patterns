<?php
interface Node
{
    public function getValue() :int;
}

abstract class Operation implements Node
{
    protected $left;
    protected $right;
    protected $value;
    
    public function setLeft(Node $left) :void
    {
        $this->left = $left;
    }
    
    public function setRgiht(Node $right) :void
    {
        $this->right = $right;
    }
}

class Number implements Node
{   
    private $value;
    
    public function __construct(int $value)
    {
        $this->value = $value;
    }
    
    public function getValue() :int
    {
        return $this->value;
    }
}

class Substraction extends Operation
{
    public function getValue() :int
    {
        return $this->left->getValue() - $this->right->getValue();
    }
}

class Addition extends Operation
{
    public function getValue() :int
    {
        return $this->left->getValue() + $this->right->getValue();
    }
}

$add1 = new Addition();
$add1->setLeft(new Number(12));
$add1->setRgiht(new Number(5));

$add2 = new Addition();
$add2->setLeft(new Number(4));
$add2->setRgiht(new Number(3));

$substract = new Substraction();
$substract->setLeft($add1);
$substract->setRgiht($add2);

echo '(12 + 5) - (4 + 3) = ' . $substract->getValue() . PHP_EOL;