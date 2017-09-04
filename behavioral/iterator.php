<?php

interface MyIterator
{
    public function first();
    public function next();
    public function isDone();
    public function current();
}

class MyArrayIterator implements MyIterator
{
    private $array;
    private $counter = 0;
    private $arraySize;

    public function __construct($array)
    {
        $this->array = $array;
        $this->arraySize = count($this->array);
    }

    public function first()
    {
        return $this->array[0];
    }

    public function next()
    {
        $this->counter++;
        if($this->isDone() == false)
            return $this->array[$this->counter];
    }

    public function current()
    {
        return $this->array[$this->counter];
    }

    public function isDone()
    {
        return ($this->arraySize == $this->counter);
    }
}

class MyArrayIteratorEvenNumbers implements MyIterator
{
    private $array;
    private $counter = 0;
    private $arraySize;

    public function __construct($array)
    {
        $this->array = $array;
        $this->arraySize = count($this->array);
    }

    public function first()
    {
        return $this->array[0];
    }

    public function next()
    {
        $this->counter++;
        if($this->isDone() == false)
            while($this->array[$this->counter] % 2 == 1) {
                $this->counter++;
            }
    }

    public function current()
    {
        while($this->array[$this->counter] % 2 == 1) {
            $this->counter++;
        }
        return $this->array[$this->counter];
    }

    public function isDone()
    {
        return ($this->arraySize == $this->counter);
    }
}

class MyListIterator implements MyIterator
{
    private $list;
    private $current;

    public function __construct($list)
    {
        $this->list = $list;
        $this->current = $list;
    }

    public function first()
    {
        return $this->list->getValue();
    }

    public function next()
    {
        $this->current = $this->current->getNextElement();
    }

    public function current()
    {
        return $this->current->getValue();
    }

    public function isDone()
    {
        return ($this->current === null);
    }
}

class MyArray
{
    private $array;

    public function __construct()
    {
        $this->add(1);
        $this->add(2);
        $this->add(3);
    }

    public function add($value)
    {
        $this->array[] = $value;
    }

    public function createIterator()
    {
        return new MyArrayIterator($this->array);
    }

    public function createIteratorEvenNumbers()
    {
        return new MyArrayIteratorEvenNumbers($this->array);
    }
}

class MyList
{
    private $list;

    public function __construct()
    {
        $this->list = $this->current = $listElement1 = new MyListElement('a');
        $listElement2 = new MyListElement('b');
        $listElement3 = new MyListElement('c');
        $listElement4 = new MyListElement('d');

        $listElement1->setNextElement($listElement2);
        $listElement2->setNextElement($listElement3);
        $listElement3->setNextElement($listElement4);
    }

    public function createIterator()
    {
        return new MyListIterator($this->list);
    }
}

class MyListElement
{
    private $value;
    private $nextElement;


    public function __construct($value)
    {
            $this->value = $value;
            $this->nextElement = null;
    }

    public function getValue()
    {
        return $this->value;
    }

    public function setValue($value)
    {
        $this->value = $value;

        return $this;
    }

    public function getNextElement()
    {
        return $this->nextElement;
    }

    public function setNextElement($nextElement)
    {
        $this->nextElement = $nextElement;

        return $this;
    }

}

class Client
{
    public function __construct()
    {
        $array = new MyArray();
        $list = new MyList();

        echo 'MyArray:' . PHP_EOL;
        $this->showCollectionItems($array->createIterator());
        
        echo PHP_EOL;

        echo 'MyList:' . PHP_EOL;
        $this->showCollectionItems($list->createIterator());
    }

    private function showCollectionItems($collection)
    {
        while($collection->isDone() == false) {
            echo $collection->current().PHP_EOL;
            $collection->next();
        }
    }
}

$client = new Client();
