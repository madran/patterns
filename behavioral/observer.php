<?php
/*
Wzorzec observer tworzy relację między obiektami 1 do n, w ten sposób, że jak jeden obiekt zostanie zmodyfikowany (jego stan się zmieni) to wszystkie obiekty będące w nim w relacji zostaną poinformowane.
We wzorcu wyróżnione są dwa rodzaje obiektów:
*Subject - posiada metody do zarządzamia obserwatorami (dodawania i usuwania) oraz informuowania ich o zmianach swojego stanu
*Observer - obserwuje Subject, posiada do niego referencję
*/

//Subject
class Keyboard
{
    private $pressedKey = null;
    private $eventListeners = array();
    
    public function addEventListener($listener)
    {
        $listener->addsourceOfEvent($this);
        $this->eventListeners[] = $listener;
    }

    public function getKeyPressed()
    {
        return $this->pressedKey;
    }
    
    public function pressKey($key)
    {
        $this->pressedKey = $key;
        $this->notifyAllListeners();
    }

    private function notifyAllListeners()
    {
        foreach ($this->eventListeners as $listener) {
            $listener->execute();
        }
    }   
}

class EventListener
{
    private $eventSource = null;
    private $eventKey = '';

    public function __construct($eventKey)
    {
        $this->eventKey = $eventKey;
    }

    public function addsourceOfEvent($source)
    {
        $this->eventSource = $source;
    }

    public function execute()
    {
        if ($this->eventSource->getKeyPressed() === $this->eventKey) {
            echo 'Jestem użyty :D (' . $this->eventKey . ')' . PHP_EOL;
        }
    }
}

$keyboard = new Keyboard();
$eventListenerA = new EventListener('a');
$eventListenerB = new EventListener('b');

$keyboard->addEventListener($eventListenerA);
$keyboard->addEventListener($eventListenerB);

$keyboard->pressKey('b');
$keyboard->pressKey('a');
