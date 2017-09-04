<?php

class Mediator {
    private $collegues;

    public function synchronize($object)
    {
        $value = $object->getStatus();
        
        foreach ($this->collegues as $collegue) {
            if ($collegue != $object) {
                $collegue->setStatus($value);
            }
        }
    }

    public function addCollegue($collegue)
    {
        $collegue->setMediator($this);
        $this->collegues[] = $collegue;
    }
}

class Collegue {
    private $value = 0;
    private $mediator;

    public function update($value)
    {
        $this->value = $value;
        $this->mediator->synchronize($this);
    }

    public function setStatus($value)
    {
        $this->value = $value;
    }

    public function getStatus()
    {
        return $this->value;
    }

    public function setMediator($mediator)
    {
        $this->mediator = $mediator;
    }
}

$a = new Collegue();
$b = new Collegue();
$c = new Collegue();

$mediator = new Mediator();
$mediator->addCollegue($a);
$mediator->addCollegue($b);
$mediator->addCollegue($c);

echo 'Wartości domyślne:' . PHP_EOL;
echo 'a: ' . $a->getStatus() . PHP_EOL;
echo 'b: ' . $b->getStatus() . PHP_EOL;
echo 'c: ' . $c->getStatus() . PHP_EOL;

echo 'Ustawienie a na 1' . PHP_EOL;
$a->update(1);

echo 'Wartości po synchronizacji:' . PHP_EOL;
echo 'a: ' . $a->getStatus() . PHP_EOL;
echo 'b: ' . $b->getStatus() . PHP_EOL;
echo 'c: ' . $c->getStatus() . PHP_EOL;
