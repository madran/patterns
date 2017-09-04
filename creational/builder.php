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

    public function getPizza()
    {
        return $this->pizza;
    }
    
    public function createNewPizzaProduct()
    {
        $this->pizza = new Pizza();
    }

    public abstract function buildDough();
    public abstract function buildSauce();
    public abstract function buildTopping();
}

class HawaiianPizzaBuilder extends PizzaBuilder {
    public function buildDough()
    {
        $this->pizza->setDough("cross");
    }

    public function buildSauce()
    {
        $this->pizza->setSauce("mild");
    }

    public function buildTopping()
    {
        $this->pizza->setTopping("ham+pineapple");
    }
}

class SpicyPizzaBuilder extends PizzaBuilder {
    public function buildDough()
    {
        $this->pizza->setDough("pan baked");
    }

    public function buildSauce()
    {
        $this->pizza->setSauce("hot");
    }

    public function buildTopping()
    {
        $this->pizza->setTopping("pepperoni+salami");
    }
}

class Waiter {
    private $pizzaBuilder;

    public function setPizzaBuilder($pb)
    {
        $this->pizzaBuilder = $pb;
    }
  
    public function getPizza()
    {
        return $this->pizzaBuilder->getPizza();
    }

    public function constructPizza() {
        $this->pizzaBuilder->createNewPizzaProduct();
        $this->pizzaBuilder->buildDough();
        $this->pizzaBuilder->buildSauce();
        $this->pizzaBuilder->buildTopping();
    }
}


$waiter = new Waiter();
$hawaiian_pizzabuilder = new HawaiianPizzaBuilder();
$spicy_pizzabuilder = new SpicyPizzaBuilder();

$waiter->setPizzaBuilder($hawaiian_pizzabuilder);
$waiter->constructPizza();

$pizza = $waiter->getPizza();

echo $pizza . PHP_EOL;
