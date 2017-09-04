<?php
// Receiver
class Train {
    private $carriages = array();
    private $locomotive = '';

    public function __construct()
    {
        $this->locomotive = '<oo' . chr(202) . 'oo' . chr(238) . 'oo' . chr(177) . chr(177);
    }

    public function addCarriage($carriage)
    {
        array_push($this->carriages, $carriage);
    }

    public function removeCarriage()
    {
        array_pop($this->carriages);
    }

    public function __toString()
    {
        return $this->locomotive . '-' . implode('-', $this->carriages);
    }
}

// Command
class AddCarriageToTrain {
    private $train;
    private $carriage;

    public function __construct($train, $carriage)
    {
        $this->train = $train;
        $this->carriage = $carriage;
    }

    public function execute()
    {
        $this->train->addCarriage($this->carriage);
    }

    public function undo()
    {
        $this->train->removeCarriage();
    }
}

// Invoker
class TrainComposer {
    private $operations = array();

    public function addCarriage($carriage)
    {
        $carriage->execute();
        array_push($this->operations, $carriage);
    }

    public function removeCarriage()
    {
        $carriage = array_pop($this->operations);
        $carriage->undo();
    }
}

$train = new Train();

$firstCarriage = new AddCarriageToTrain($train, '###U###U###U###');
$secondCarriage = new AddCarriageToTrain($train, '###U###U###U###');
$thirdCarriage = new AddCarriageToTrain($train, '###U###U###U###');

$trainComposer = new TrainComposer();

echo 'Lokomotywa:' . PHP_EOL;
echo $train . PHP_EOL;
echo PHP_EOL;
echo 'Dodaj wagon:' . PHP_EOL;
$trainComposer->addCarriage($firstCarriage);
echo $train . PHP_EOL;
echo PHP_EOL;
echo 'Dodaj wagon:' . PHP_EOL;
$trainComposer->addCarriage($secondCarriage);
echo $train . PHP_EOL;
echo PHP_EOL;
echo 'Dodaj wagon:' . PHP_EOL;
$trainComposer->addCarriage($thirdCarriage);
echo $train . PHP_EOL;
echo PHP_EOL;
echo 'Usuń wagon:' . PHP_EOL;
$trainComposer->removeCarriage();
echo $train . PHP_EOL;
echo PHP_EOL;
echo 'Usuń wagon:' . PHP_EOL;
$trainComposer->removeCarriage();
echo $train . PHP_EOL;
echo PHP_EOL;
echo 'Usuń wagon:' . PHP_EOL;
$trainComposer->removeCarriage();
echo $train . PHP_EOL;
