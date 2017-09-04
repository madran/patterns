<?php

class Pizza
{
    private $dough = "";
    private $sauce = "";
    private $topping = "";

    public function setDough($dough)
    {
        $this->dough = $dough;
    }

    public function setSauce($sauce)
    {
        $this->sauce = $sauce;
    }

    public function setTopping($topping)
    {
        $this->topping = $topping;
    }

    public function __toString()
    {
        return "Dough: $this->dough | Suace: $this->sauce | Topping: $this->topping";
    }
}

abstract class PizzaBuilder
{
    protected $pizza;

    public function __construct()
    {
        $this->pizza = new Pizza();
    }

    abstract public function getPizza();

    public function buildDough($dough)
    {
        $this->pizza->setDough($dough);
    }

    public function buildSauce($suace)
    {
        $this->pizza->setSauce($suace);
    }

    public function buildTopping($topping)
    {
        $this->pizza->setTopping($topping);
    }
}

class HawaiianPizzaBuilder extends PizzaBuilder
{
    public function getPizza()
    {
        $this->buildDough("cross");
        $this->buildSauce("mild");
        $this->buildTopping("ham+pineapple");

        return $this->pizza;
    }
}

class SpicyPizzaBuilder extends PizzaBuilder {
    public function getPizza()
    {
        $this->buildDough("pan baked");
        $this->buildSauce("hot");
        $this->buildTopping("pepperoni+salami");

        return $this->pizza;
    }
}


$hawaiian_pizzabuilder = new HawaiianPizzaBuilder();
$spicy_pizzabuilder = new SpicyPizzaBuilder();

echo $hawaiian_pizzabuilder->getPizza() . PHP_EOL;
echo $spicy_pizzabuilder->getPizza() . PHP_EOL;
